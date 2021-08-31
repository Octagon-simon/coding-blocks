<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://fb.com/simon.ugorji.7
 * @since      1.0.0
 *
 * @package    Coding_Blocks
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function coding_blocks_uninstall(){

global $wpdb;

/*DELETE TABLE*/

$wpdb->query("DROP TABLE ".$wpdb->prefix."coding_blocks");
$wpdb->query("DROP TABLE ".$wpdb->prefix."coding_blocks_settings");

}
register_uninstall_hook( CODING_BLOCKS_PLUGIN_FILE, 'coding_blocks_uninstall' );