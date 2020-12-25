<?php
/**
 * @link       https://codetot.com
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @since      1.0.0
 * @author     CODE TOT JSC <dev@codetot.com>
 */
class Codetot_Optimization {
  /**
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * @since    1.0.0
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;

  /**
   * @since    1.0.0
   */
  public function __construct() {
    if ( defined( 'CODETOT_OPTIMIZATION_VERSION' ) ) {
      $this->version = CODETOT_OPTIMIZATION_VERSION;
    } else {
      $this->version = '1.0.0';
    }
    $this->plugin_name = 'codetot-optimization';

    $this->load_dependencies();
    Codetot_Optimization_Admin::instance();
    Codetot_Optimization_i18n::instance();
    Codetot_Optimization_Process::instance();
    Codetot_Optimization_Html_Optimization::instance();
  }

  /**
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codetot-optimization-i18n.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codetot-optimization-process.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-codetot-optimization-admin.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codetot-optimization-html-compression.php';
  }

  /**
   * @since     1.0.0
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since     1.0.0
   * @return    string    The version number of the plugin.
   */
  public function get_version() {
    return $this->version;
  }

}
