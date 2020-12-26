<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codetot.com
 * @since      1.0.0
 *
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/includes
 * @author     CODE TOT JSC <dev@codetot.com>
 */
class Codetot_Optimization_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	  add_action('init', function() {
      delete_option('ct-optimization');
    });
	}

}
