<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://fb.com/simon.ugorji.106
 * @since             1.0.0
 * @package           Coding_Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       Coding Blocks
 * Plugin URI:        https://wordpress.org/plugins/coding-blocks
 * Description:       Coding Blocks allows you to create reusable and attractive code snippets that can be embedded into your WordPress posts.
 * Version:           1.1.0
 * Author:            Simon Ugorji
 * Author URI:        https://fb.com/simon.ugorji.106
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       coding-blocks
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CODING_BLOCKS_VERSION', '1.1.0');
define('CODING_BLOCKS_PLUGIN_FILE', __FILE__);

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-coding-blocks-activator.php
 */
function activate_coding_blocks()
{
	update_option('coding_blocks_version', CODING_BLOCKS_VERSION);
	require_once plugin_dir_path(__FILE__) . 'includes/class-coding-blocks-activator.php';
	Coding_Blocks_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-coding-blocks-deactivator.php
 */
function deactivate_coding_blocks()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-coding-blocks-deactivator.php';
	Coding_Blocks_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_coding_blocks');
register_deactivation_hook(__FILE__, 'deactivate_coding_blocks');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-coding-blocks.php';

/*REQUIRE SHORT CODE HANDLER */
require(dirname(__FILE__) . '/shortcode-handler.php');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_coding_blocks()
{

	$plugin = new Coding_Blocks();
	$plugin->run();

}
run_coding_blocks();


/* * * PLUGIN UPDATE PROCESS * */

/*check if version matches with the one in DB, if not, call  the plugin activation function which will update the DB */
function coding_blocks_plugin_check_version()
{
	if (CODING_BLOCKS_VERSION !== get_option('coding_blocks_version')) {
		activate_coding_blocks();
	}
}

add_action('plugins_loaded', 'coding_blocks_plugin_check_version');

function cbPlugin_links($links, $file) {
	$base = plugin_basename(CODING_BLOCKS_PLUGIN_FILE);
	if ($file == $base) {
		$links[] = '<a href="https://twitter.com/ugorji_simon/" title="Follow me on Twitter"><i class="dashicons dashicons-twitter"></i></a>';
		$links[] = '<a href="https://fb.com/simon.ugorji.106" title="Follow me on Facebook"><i class="dashicons dashicons-facebook"></i></a>';
		$links[] = '<a href="https://www.linkedin.com/in/simon-ugorji-57a6a41a3/" title="Connect With Me on linkedin"><i class="dashicons dashicons-linkedin"></i></a>';
		$links[] = '<a href="https://www.paypal.com/donate/?hosted_button_id=ZYK9PQ8UFRTA4" title="Donate"><i class="dashicons dashicons-coffee"></i></a>'; //add donate button
	}
	return $links;
}

add_filter( 'plugin_row_meta','cbPlugin_links',10,2);