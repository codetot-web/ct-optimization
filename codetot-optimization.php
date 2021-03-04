<?php
/**
 * @link              https://codetot.com
 * @since             1.0.0
 * @package           Codetot_Optimization
 *
 * @wordpress-plugin
 * Plugin Name:       CT Optimization
 * Plugin URI:        https://codetot.com
 * Description:       Provides settings for enable/disable WordPress core features and some tweaks for ACF, Gravity Forms, such like Enable CDN, Lazyload assets.
 * Version:           1.0.9
 * Author:            CODE TOT JSC
 * Author URI:        https://codetot.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codetot-optimization
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CODETOT_OPTIMIZATION_VERSION', '1.0.9' );
define( 'CODETOT_OPTIMIZATION_PATH', plugin_dir_path(__FILE__) );
define( 'CODETOT_OPTIMIZATION_URL', plugin_dir_url(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-codetot-optimization-activator.php
 */
function activate_codetot_optimization() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-codetot-optimization-activator.php';
	Codetot_Optimization_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-codetot-optimization-deactivator.php
 */
function deactivate_codetot_optimization() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-codetot-optimization-deactivator.php';
	Codetot_Optimization_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_codetot_optimization' );
register_deactivation_hook( __FILE__, 'deactivate_codetot_optimization' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-codetot-optimization.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_codetot_optimization() {
	return new Codetot_Optimization();
}

run_codetot_optimization();
