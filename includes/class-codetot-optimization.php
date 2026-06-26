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

    add_action('plugins_loaded', array($this, 'load_translation'));

    Codetot_Optimization_Admin::instance();

    Codetot_Optimization_Gravity_Forms::instance();
    Codetot_Optimization_Process::instance();
  }

  /**
   * Get parsed plugin options — called once per request, cached statically.
   *
   * Reads the serialized 'ct-optimization' option, converts yes/no to booleans,
   * and returns a flat array. All sub-classes use this instead of calling
   * get_option() independently.
   *
   * @since    1.4.0
   * @return   array
   */
  public static function get_options() {
    static $options = null;

    if ( $options !== null ) {
      return $options;
    }

    $raw = get_option( 'ct-optimization' );

    if ( empty( $raw ) || ! is_array( $raw ) ) {
      $options = array();
      return $options;
    }

    $parsed = array();
    foreach ( $raw as $key => $value ) {
      $key = str_replace( '-', '_', $key );

      if ( $value === 'yes' ) {
        $parsed[ $key ] = true;
      } elseif ( $value === 'no' ) {
        $parsed[ $key ] = false;
      } else {
        $parsed[ $key ] = $value;
      }
    }

    $options = $parsed;
    return $options;
  }

  /**
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codetot-optimization-process.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codetot-optimization-assets.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codetot-optimization-gravity-forms.php';

    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-codetot-optimization-admin.php';
  }

  public function load_translation() {
    load_plugin_textdomain(
      'codetot-optimization',
      false,
      CODETOT_OPTIMIZATION_PATH . 'languages/'
    );
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
