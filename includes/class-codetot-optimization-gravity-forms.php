<?php
/**
 * @link       https://codetot.com
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @since      1.0.0
 * @author     CODE TOT JSC <dev@codetot.com>
 */

class Codetot_Optimization_Gravity_Forms
{
  /**
   * Singleton instance
   *
   * @var Codetot_Optimization_Gravity_Forms
   */
  private static $instance;

  /**
   * @var array
   */
  private $options;

  /**
   * Get singleton instance.
   *
   * @return Codetot_Optimization_Gravity_Forms
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

    if (!empty($options['disable-gravity-forms-default-styles'])) {
      add_action('gform_enqueue_scripts', array($this, 'disable_gravity_forms_styles'));
    }

    if (!empty($options['hide-gravity-forms-menus'])) {
      add_action('admin_menu', array($this, 'remove_pages'), 999);
    }

    if (!empty($options['load-gravity-forms-in-footer'])) {
      add_filter('gform_init_scripts_footer', '__return_true');
      add_filter('gform_cdata_open', array($this, 'wrap_gform_cdata_open'), 1);
      add_filter('gform_cdata_close', array($this, 'wrap_gform_cdata_close'), 99);
    }
  }

  public function disable_gravity_forms_styles() {
    wp_dequeue_style( 'gforms_css' );
    wp_dequeue_style( 'gforms_reset_css' );
    wp_dequeue_style( 'gforms_formsmain_css' );
    wp_dequeue_style( 'gforms_ready_class_css' );
    wp_dequeue_style( 'gforms_browsers_css' );
  }

  public function remove_pages()
  {
    remove_submenu_page('gf_edit_forms', 'gf_addons');
    remove_submenu_page('gf_edit_forms', 'gf_help');
    remove_submenu_page('gf_edit_forms', 'gf_system_status');
  }

  public function wrap_gform_cdata_open($content = '')
  {
    if (!$this->do_wrap_gform_cdata()) {
      return $content;
    }
    $content = 'document.addEventListener( "DOMContentLoaded", function() { ' . $content;
    return $content;
  }

  public function wrap_gform_cdata_close($content = '')
  {
    if (!$this->do_wrap_gform_cdata()) {
      return $content;
    }
    $content .= ' }, false );';
    return $content;
  }

  public function do_wrap_gform_cdata()
  {
    if (
      is_admin()
      || (defined('DOING_AJAX') && DOING_AJAX)
      || isset($_POST['gform_ajax'])
      || isset($_GET['gf_page']) // Admin page (eg. form preview).
      || doing_action('wp_footer')
      || did_action('wp_footer')
    ) {
      return false;
    }
    return true;
  }
}

