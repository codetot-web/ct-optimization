<?php
/**
 * @link       https://codetot.com
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @since      1.0.1
 * @author     CODE TOT JSC <dev@codetot.com>
 */

class Codetot_Optimization_Html_Compression
{
  /**
   * Singleton instance
   *
   * @var Codetot_Optimization_Html_Compression
   */
  private static $instance;

  /**
   * @var array
   */
  private $options;

  /**
   * @var bool
   */
  protected $compress_css = true;
  /**
   * @var bool
   */
  protected $compress_js = true;
  /**
   * @var bool
   */
  protected $info_comment = true;
  /**
   * @var bool
   */
  protected $remove_comments = true;

  /**
   * @var string
   */
  protected $html;

  /**
   * Get singleton instance.
   *
   * @return Codetot_Optimization_Html_Compression
   */
  public final static function instance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function __construct()
  {
    $this->options = get_option('ct-optimization');

    if (!empty($this->options['compress_html']) && $this->options['compress_html'] === 'yes') {
      add_action('get_header', array($this, 'compress_start'));
    }
  }

  public function build($html) {
    if (!empty($html))
    {
      return $this->parse_html($html);
    }
  }

  public function parse_html($html)
  {
    $this->html = $this->minify_html($html);

    if ($this->info_comment)
    {
      $this->html .= "\n" . $this->load_stats($html, $this->html);
    }

    return $this->html;
  }

  protected function remove_whitespace($str)
  {
    $str = str_replace("\t", ' ', $str);
    $str = str_replace("\n",  '', $str);
    $str = str_replace("\r",  '', $str);

    while (stristr($str, '  '))
    {
      $str = str_replace('  ', ' ', $str);
    }

    return $str;
  }

  public function compress_start() {
    ob_start(array($this, 'compress_end'));
  }

  public function compress_end($html) {
    return $this->build($html);
  }

  protected function load_stats($raw, $compressed)
  {
    $raw = strlen($raw);
    $compressed = strlen($compressed);

    $savings = ($raw-$compressed) / $raw * 100;

    $savings = round($savings, 2);

    return '<!-- Minified by CodeTot Optimization, size saved '.$savings.'%. From '.$raw.' bytes, now '.$compressed.' bytes-->';
  }

  /**
   * @param $html
   * @return string
   */
  protected function minify_html($html) {
    $pattern = '/<(?<script>script) . *?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
    preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
    $overriding = false;
    $raw_tag = false;
    // Variable reused for output
    $html = '';
    foreach ($matches as $token)
    {
      $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;

      $content = $token[0];

      if (is_null($tag))
      {
        if ( !empty($token['script']) )
        {
          $strip = $this->compress_js;
        }
        else if ( !empty($token['style']) )
        {
          $strip = $this->compress_css;
        }
        else if ($content == '<!--wp-html-compression no compression-->')
        {
          $overriding = !$overriding;

          // Don't print the comment
          continue;
        }
        else if ($this->remove_comments)
        {
          if (!$overriding && $raw_tag != 'textarea')
          {
            // Remove any HTML comments, except MSIE conditional comments
            $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
          }
        }
      }
      else
      {
        if ($tag == 'pre' || $tag == 'textarea')
        {
          $raw_tag = $tag;
        }
        else if ($tag == '/pre' || $tag == '/textarea')
        {
          $raw_tag = false;
        }
        else
        {
          if ($raw_tag || $overriding)
          {
            $strip = false;
          }
          else
          {
            $strip = true;

            // Remove any empty attributes, except:
            // action, alt, content, src
            $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);

            // Remove any space before the end of self-closing XHTML tags
            // JavaScript excluded
            $content = str_replace(' />', '/>', $content);
          }
        }
      }

      if ($strip)
      {
        $content = $this->remove_whitespace($content);
      }

      $html .= $content;
    }

    return $html;
  }
}
