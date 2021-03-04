<?php
/**
 * @link       https://codetot.com
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @since      1.0.0
 * @author     CODE TOT JSC <dev@codetot.com>
 */

class Codetot_Optimization_Assets
{
  /**
   * Singleton instance
   *
   * @var Codetot_Optimization_Assets
   */
  private static $instance;

  /**
   * @var array
   */
  private $options;

  /**
   * Get singleton instance.
   *
   * @return Codetot_Optimization_Assets
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
    $options = get_option('ct-optimization');

    if (empty($options)) {
      return;
    }

    foreach ($options as $key => $option) {
      $key = str_replace('-', '_', $key);

      if ($option === 'yes') {
        // Convert yes/no to true/false
        $this->options[$key] = true;
      } elseif($option === 'no') {
        $this->options[$key] = false;
      } else {
        $this->options[$key] = $option;
      }
    }

    if (!empty($this->options['load_lazysizes_scripts'])) {
      add_action('wp_enqueue_scripts', array($this, 'load_lazysizes_scripts'));
    }
  }

  public function load_lazysizes_scripts() {
    // If it was loaded, skip it
    if (wp_script_is('lazysizes', 'enqueued')) {
      return;
    }

    wp_register_script('lazysizes', CODETOT_OPTIMIZATION_URL . 'assets/lazysizes.min.js', array(), '5.2.2');
    wp_enqueue_script('lazysizes');
  }
}

Codetot_Optimization_Assets::instance();
