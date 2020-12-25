<?php
/**
 * @link       https://codetot.com
 * @since      1.0.0
 *
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes/classes
 */

class Codetot_Optimization_i18n {
    /**
     * Singleton instance
     *
     * @var Codetot_Optimization_i18n
     */
    private static $instance;

    /**
     * Get singleton instance.
     *
     * @return Codetot_Optimization_i18n
     */
    public final static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'codetot-optimization',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }
}

Codetot_Optimization_i18n::instance();
