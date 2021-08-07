<?php
/**
 * @link       https://codetot.com
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/admin
 * @since      1.0.0
 * @author     CODE TOT JSC <dev@codetot.com>
 */

require_once CODETOT_OPTIMIZATION_PATH . '/includes/class-codetot-admin-options-page.php';

class Codetot_Optimization_Admin
{
  /**
   * Singleton instance
   *
   * @var Codetot_Optimization_Admin
   */
  private static $instance;

  /**
   * @var Codetot_Optimization_Admin_Options_Page
   */
  private $option_page;

  /**
   * @var array
   */
  private $global_keys;

  /**
   * @var array
   */
  private $pages;

  /**
   * Get singleton instance.
   *
   * @return Codetot_Optimization_Admin
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
    $this->global_keys = $this->get_global_keys();

    $this->pages = array(
      'ct-optimization' => array(
        'page_title' => __('CT Optimization', 'codetot-optimization'),
        'sections' => array(
          'global' => array(
            'title' => __('Global Settings', 'codetot-optimization'),
            'text' => '',
            'fields' => $this->generate_global_options()
          ),
          'advanced' => array(
            'title' => __('Advanced Settings', 'codetot-optimization'),
            'text' => '',
            'fields' => $this->get_advanced_options()
          ),
          'plugins' => array(
            'title' => __('Plugin Settings', 'codetot-optimization'),
            'text' => '',
            'fields' => $this->get_plugin_options()
          ),
        )
      )
    );

    $this->option_page = new Codetot_Optimization_Admin_Options_Page($this->pages);

    // Notice about PHP version.
    if (version_compare(PHP_VERSION, '7.0', '<')) {
      $this->option_page->submit_error(sprintf(__('%s: Please consider upgrade your PHP Version to 7.3.', 'codetot-optimization'), __('CT Optimization', 'codetot-optimization')));
    }
  }

  /**
   * @return array
   */
  public function get_global_keys()
  {
    return [
      'disable_gutenberg_block_editor' => __('Gutenberg Block Editor', 'codetot-optimization'),
      'disable_gutenberg_widgets' => __('Gutenberg Widgets', 'codetot-optimization'),
      'disable_emoji' => __('Emoji', 'codetot-optimization'),
      'hide_wordpress_version' => __('WordPress Version', 'codetot-optimization'),
      'disable_oembed' => __('oEmbed', 'codetot-optimization'),
      'disable_xmlrpc' => __('XMLRPC', 'codetot-optimization'),
      'disable_heartbeat' => __('Heartbeat', 'codetot-optimization'),
      'disable_comments' => __('Comments', 'codetot-optimization'),
      'disable_ping' => __('Ping', 'codetot-optimization'),
      'disable_feed' => __('Feed', 'codetot-optimization'),
      'disable_shortlink' => __('Shortlink', 'codetot-optimization'),
      'disable_wlw_manifest' => __('WLW Manifest', 'codetot-optimization'),
      'disable_inline_comment_style' => __('Inline Comment Style', 'codetot-optimization')
    ];
  }

  /**
   * @return array
   */
  public function generate_global_options()
  {
    $fields = array();

    foreach ($this->global_keys as $key => $option) {
      $title = sprintf(__('Disable %s', 'codetot-optimization'), $option);
      if (strpos($key, 'enable_') === 0) {
        $title = sprintf(__('Enable %s', 'codetot-optimization'), $option);
      }

      if (strpos($key, 'hide_') === 0) {
        $title = sprintf(__('Hide %s', 'codetot-optimization'), $option);
      }

      $fields[$key] = array(
        'title' => $title,
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      );
    }

    return $fields;
  }


  public function get_advanced_options()
  {
    return array(
      'enable_compress_html' => array(
        'title' => __('Compress HTML', 'codetot-optimization'),
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      ),
      'enable_cdn_domain' => array(
        'title' => __('Enable CDN Domain', 'codetot-optimization'),
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      ),
      'cdn_domain' => array(
        'title' => __('CDN Domain', 'codetot-optimization'),
        'type' => 'text',
        'placeholder' => sprintf(__('Example: %s', 'codetot-optimization'), 'cdn.example.com')
      )
    );
  }

  public function get_plugin_options() {
    return array(
      'disable_gravity_forms_style' => array(
        'title' => __('Disable Gravity Forms Default Styles', 'codetot-optimization'),
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      ),
      'hide_gravity_forms_menus' => array(
        'title' => __('Hide Gravity Forms Menus', 'codetot-optimization'),
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      ),
      'load_gravity_forms_footer' => array(
        'title' => __('Load Gravity Forms in Footer', 'codetot-optimization'),
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      ),
      'load_lazysizes_scripts' => array(
        'title' => __('Load Lazysizes scripts', 'codetot-optimization'),
        'type' => 'radio',
        'value' => 'no',
        'choices' => array(
          'yes' => __('Yes', 'codetot-optimization'),
          'no' => __('No', 'codetot-optimization')
        )
      )
    );
  }
}
