<?php
/**
 * @link       https://codetot.com
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @since      1.0.0
 * @author     CODE TOT JSC <dev@codetot.com>
 */

class Codetot_Optimization_Process
{
  /**
   * Singleton instance
   *
   * @var Codetot_Optimization_Process
   */
  private static $instance;

  /**
   * @var array
   */
  private $options;

  /**
   * @var string
   */
  private $site_domain;
  /**
   * @var string
   */
  private $cdn_domain;

  /**
   * @var bool
   */
  private $enable_cdn;

  /**
   * Get singleton instance.
   *
   * @return Codetot_Optimization_Process
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

    // Global Settings
    add_action('init', array($this, 'check_gutenberg'));
    add_action('init', array($this, 'check_emoji'));
    add_action('init', array($this, 'check_generator_tag'));
    add_action('init', array($this, 'check_oembed'));
    add_action('init', array($this, 'check_xmlrpc'));
    add_action('init', array($this, 'check_ping'));
    add_action('init', array($this, 'check_heartbeat'));
    add_action('init', array($this, 'check_comments'));
    add_action('init', array($this, 'check_feed'));
    add_action('init', array($this, 'check_short_link'));
    add_action('init', array($this, 'check_manifest'));
    add_action('init', array($this, 'check_comment_style'));

    // Advanced Settings
    add_action('init', array($this, 'check_cdn'));
  }

  public function check_gutenberg()
  {
    if (!empty($this->options['disable_gutenberg_block_editor'])) {
      add_action('use_block_editor_for_post', '__return_false');
      add_action('wp_enqueue_scripts', array($this, 'disable_wp_block_assets'), 100);

      remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );

      remove_action( 'admin_menu', 'gutenberg_menu' );
      remove_action( 'admin_init', 'gutenberg_redirect_demo' );

      // Gutenberg 5.3+
      remove_action( 'wp_enqueue_scripts', 'gutenberg_register_scripts_and_styles' );
      remove_action( 'admin_enqueue_scripts', 'gutenberg_register_scripts_and_styles' );
      remove_action( 'admin_notices', 'gutenberg_wordpress_version_notice' );
      remove_action( 'rest_api_init', 'gutenberg_register_rest_widget_updater_routes' );
      remove_action( 'admin_print_styles', 'gutenberg_block_editor_admin_print_styles' );
      remove_action( 'admin_print_scripts', 'gutenberg_block_editor_admin_print_scripts' );
      remove_action( 'admin_print_footer_scripts', 'gutenberg_block_editor_admin_print_footer_scripts' );
      remove_action( 'admin_footer', 'gutenberg_block_editor_admin_footer' );
      remove_action( 'admin_enqueue_scripts', 'gutenberg_widgets_init' );
      remove_action( 'admin_notices', 'gutenberg_build_files_notice' );

      remove_filter( 'load_script_translation_file', 'gutenberg_override_translation_file' );
      remove_filter( 'block_editor_settings', 'gutenberg_extend_block_editor_styles' );
      remove_filter( 'default_content', 'gutenberg_default_demo_content' );
      remove_filter( 'default_title', 'gutenberg_default_demo_title' );
      remove_filter( 'block_editor_settings', 'gutenberg_legacy_widget_settings' );
      remove_filter( 'rest_request_after_callbacks', 'gutenberg_filter_oembed_result' );

      // Previously used, compat for older Gutenberg versions.
      remove_filter( 'wp_refresh_nonces', 'gutenberg_add_rest_nonce_to_heartbeat_response_headers' );
      remove_filter( 'get_edit_post_link', 'gutenberg_revisions_link_to_editor' );
      remove_filter( 'wp_prepare_revision_for_js', 'gutenberg_revisions_restore' );

      remove_action( 'rest_api_init', 'gutenberg_register_rest_routes' );
      remove_action( 'rest_api_init', 'gutenberg_add_taxonomy_visibility_field' );
      remove_filter( 'registered_post_type', 'gutenberg_register_post_prepare_functions' );

      remove_action( 'do_meta_boxes', 'gutenberg_meta_box_save' );
      remove_action( 'submitpost_box', 'gutenberg_intercept_meta_box_render' );
      remove_action( 'submitpage_box', 'gutenberg_intercept_meta_box_render' );
      remove_action( 'edit_page_form', 'gutenberg_intercept_meta_box_render' );
      remove_action( 'edit_form_advanced', 'gutenberg_intercept_meta_box_render' );
      remove_filter( 'redirect_post_location', 'gutenberg_meta_box_save_redirect' );
      remove_filter( 'filter_gutenberg_meta_boxes', 'gutenberg_filter_meta_boxes' );

      remove_filter( 'body_class', 'gutenberg_add_responsive_body_class' );
      remove_filter( 'admin_url', 'gutenberg_modify_add_new_button_url' ); // old
      remove_action( 'admin_enqueue_scripts', 'gutenberg_check_if_classic_needs_warning_about_blocks' );
      remove_filter( 'register_post_type_args', 'gutenberg_filter_post_type_labels' );
    }
  }

  public function disable_wp_block_assets() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
  }

  public function check_emoji()
  {
    if (!empty($this->options['disable_emoji'])) {
      remove_action('wp_head', 'print_emoji_detection_script', 7);
      remove_action('admin_print_scripts', 'print_emoji_detection_script');
      remove_action('admin_print_styles', 'print_emoji_styles');
      remove_action('wp_print_styles', 'print_emoji_styles');
      remove_filter('the_content_feed', 'wp_staticize_emoji');
      remove_filter('comment_text_rss', 'wp_staticize_emoji');
      remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

      /**
       * Removes Emoji from the TinyMCE Editor
       *
       * @param array $plugins The plugins hooked onto the TinyMCE Editor
       */
      add_action('tiny_mce_plugins', function ($plugins) {
        if (!is_array($plugins)) {
          return array();
        }
        return array_diff($plugins, array('wpemoji'));
      }, 10, 1);
    }
  }

  public function check_generator_tag()
  {
    if (!empty($this->options['hide_wordpress_version'])) {
      remove_action('wp_head', 'wp_generator');
      add_action('the_generator', '__return_null');
    }
  }

  public function check_oembed()
  {
    if (!empty($this->options['disable_oembed'])) {
      add_action('wp_enqueue_scripts', function () {
        wp_deregister_script('wp-embed');
      }, 100);

      add_action('init', function () {

        // Removes the oEmbed JavaScript.
        remove_action('wp_head', 'wp_oembed_add_host_js');

        // Removes the oEmbed discovery links.
        remove_action('wp_head', 'wp_oembed_add_discovery_links');

        // Remove the oEmbed route for the REST API epoint.
        remove_action('rest_api_init', 'wp_oembed_register_route');

        // Disables oEmbed auto discovery.
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

        // Turn off oEmbed auto discovery.
        add_action('embed_oembed_discover', '__return_false');

      });
    }
  }

  public function check_xmlrpc()
  {
    if (!empty($this->options['disable_xmlrpc'])) {
      if (is_admin()) {
        update_option('default_ping_status', 'closed'); // Might do something else here to reduce our queries
      }

      add_action('xmlrpc_enabled', '__return_false');
      add_action('pre_update_option_enable_xmlrpc', '__return_false');
      add_action('pre_option_enable_xmlrpc', '__return_zero');

      /**
       * Unsets xmlrpc headers
       *
       * @param array $headers The array of wp headers
       */
      add_action('wp_headers', function ($headers) {
        if (isset($headers['X-Pingback'])) {
          unset($headers['X-Pingback']);
        }
        return $headers;
      }, 10, 1);

      /**
       * Unsets xmlr methods for pingbacks
       *
       * @param array $methods The array of xmlrpc methods
       */
      add_action('xmlrpc_methods', function ($methods) {
        unset($methods['pingback.ping']);
        unset($methods['pingback.extensions.getPingbacks']);
        return $methods;
      }, 10, 1);
    }
  }

  public function check_comments()
  {
    if (!empty($this->options['disable_comments'])) {
      // by default, comments are closed.
      if (is_admin()) {
        update_option('default_comment_status', 'closed');
      }

      // Closes plugins
      add_action('comments_open', '__return_false', 20, 2);
      add_action('pings_open', '__return_false', 20, 2);

      // Disables admin support for post types and menus
      add_action('admin_init', function () {
        $post_types = get_post_types();
        foreach ($post_types as $post_type) {
          if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
          }
        }
      });

      // Removes menu in left dashboard meun
      add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
      });

      // Removes comment menu from admin bar
      add_action('wp_before_admin_bar_render', function () {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
      });
    }
  }

  public function check_feed()
  {
    if (!empty($this->options['disable_feed'])) {
      remove_action('wp_head', 'feed_links_extra', 3);
      remove_action('wp_head', 'feed_links', 2);
      add_action('do_feed', array($this, 'disableFeedsHook'), 1);
      add_action('do_feed_rdf', array($this, 'disableFeedsHook'), 1);
      add_action('do_feed_rss', array($this, 'disableFeedsHook'), 1);
      add_action('do_feed_rss2', array($this, 'disableFeedsHook'), 1);
      add_action('do_feed_atom', array($this, 'disableFeedsHook'), 1);
    }
  }

  public function check_heartbeat()
  {
    if (!empty($this->options['disable_heartbeat'])) {
      add_action('admin_enqueue_scripts', function () {
        wp_deregister_script('heartbeat');
      });
    }
  }

  public function check_ping()
  {
    if (!empty($this->options['disable_ping'])) {
      remove_action('wp_head', 'rsd_link');
    }
  }

  public function check_short_link()
  {
    if (!empty($this->options['disable_shortlink'])) {
      remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    }
  }

  public function check_manifest()
  {
    if (!empty($this->options['disable_manifest'])) {
      remove_action('wp_head', 'wlwmanifest_link');
    }
  }

  public function check_comment_style()
  {
    if (!empty($this->options['disable_inline_comment_style'])) {
      add_action('widgets_init', function () {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
      });
    }
  }

  public function check_cdn()
  {
    $this->site_domain = $this->get_domain_from_url();
    $this->enable_cdn = isset($this->options['enable_cdn_domain']) && $this->options['enable_cdn_domain'];
    $this->cdn_domain = !empty($this->options['cdn_domain']) ? $this->options['cdn_domain'] : '';

    if (!empty($this->site_domain) && !empty($this->cdn_domain) && $this->site_domain !== $this->cdn_domain && $this->enable_cdn) {
      // Support for ACF plugin
      if (function_exists('get_field')) {
        add_filter('acf/format_value/type=image', array($this, 'acf_format_cdn_url_value'), 10, 3);
        add_filter('acf/format_value/type=file', array($this, 'acf_format_cdn_url_value'), 10, 3);
      }

      add_filter('wp_get_attachment_url', array($this, 'cdn_attachments_urls'), 10, 2);
      add_filter('wp_calculate_image_srcset', array($this, 'calculate_image_srcset'));
      add_filter('wp_get_attachment_image_srcset', array($this, 'cdn_attachment_srcset_filter'));
    }
  }

  /**
   * Add CDN Support for ACF fields
   * @param string $url
   * @return mixed
   */
  public function get_domain_from_url($url = '')
  {
    if (empty($url)) {
      $url = get_site_url(null, '', null);
    }
    $url_path = parse_url($url);

    return $url_path['host'];
  }

  /**
   * @param $value
   * @param $post_id
   * @param $field
   * @return array|string|string[]
   */
  public function acf_format_cdn_url_value($value, $post_id, $field)
  {
    if (is_array($value)) {
      $value['url'] = str_replace($this->site_domain . '/wp-content/uploads', $this->cdn_domain . '/wp-content/uploads', $value['url']);
      if (isset($value['sizes']) && !empty($value['sizes'])) {
        foreach ($value['sizes'] as $key => $size) {
          $value['sizes'][$key] = str_replace($this->site_domain . '/wp-content/uploads', $this->cdn_domain . '/wp-content/uploads', $size);
        }
      }
    } else {
      $value = str_replace($this->site_domain . '/wp-content/uploads', $this->cdn_domain . '/wp-content/uploads', $value);
    }

    return $value;
  }

  /**
   * @param $url
   * @param $post_id
   * @return string|string[]
   */
  public function cdn_attachments_urls($url, $post_id)
  {
    return str_replace($this->site_domain . '/wp-content/uploads', $this->cdn_domain . '/wp-content/uploads', $url);
  }

  /**
   * @param $attr
   * @return mixed
   */
  public function cdn_attachment_srcset_filter($attr)
  {
    if (!empty($attr['srcset'])) {
      $attr_srcset = $attr['srcset'];
      $attr['srcset'] = str_replace($this->site_domain . '/wp-content/uploads', $this->cdn_domain . '/wp-content/uploads', $attr_srcset);
    }

    return $attr;
  }

  /**
   * @param $sources
   * @return mixed
   */
  public function calculate_image_srcset($sources)
  {
    foreach ($sources as &$source) {
      $source['url'] = str_replace($this->site_domain . '/wp-content/uploads', $this->cdn_domain . '/wp-content/uploads', $source['url']);
    }
    return $sources;
  }
}
