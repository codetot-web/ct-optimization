<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codetot.com
 * @since      1.0.0
 *
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @author     CODE TOT JSC <dev@codetot.com>
 */
class Codetot_Optimization_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    // Ensure default comment/ping statuses are set once on activation,
    // not on every admin page load.
    if ( ! get_option( 'ct_optimization_activation_flushed', false ) ) {
      update_option( 'default_ping_status', 'closed' );
      update_option( 'default_comment_status', 'closed' );
      update_option( 'ct_optimization_activation_flushed', true );
    }
	}

}
