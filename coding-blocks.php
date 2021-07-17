<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://fb.com/simon.ugorji.7
 * @since             1.0.0
 * @package           Coding_Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       Coding Blocks
 * Plugin URI:        https://firegist.com.ng/coding-blocks/
 * Description:       Coding Blocks Allows you to create reusable and attractive code snippets with ease
 * Version:           1.0.0
 * Author:            Simon Ugorji
 * Author URI:        https://fb.com/simon.ugorji.7
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       coding-blocks
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CODING_BLOCKS_VERSION', '1.0.0' );
define('CODING_BLOCKS_PLUGIN_FILE',__FILE__);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-coding-blocks-activator.php
 */
function activate_coding_blocks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-coding-blocks-activator.php';
	Coding_Blocks_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-coding-blocks-deactivator.php
 */
function deactivate_coding_blocks() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-coding-blocks-deactivator.php';
	Coding_Blocks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_coding_blocks' );
register_deactivation_hook( __FILE__, 'deactivate_coding_blocks' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-coding-blocks.php';

/*REQUIRE SHORT CODE HANDLER */
 require( dirname( __FILE__ ) . '/shortcode-handler.php' );

/*REQUIRE FUNCTION FILE*/
 require( dirname( __FILE__ ) . '/coding-block-functions.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_coding_blocks() {

	$plugin = new Coding_Blocks();
	$plugin->run();

}
run_coding_blocks();
