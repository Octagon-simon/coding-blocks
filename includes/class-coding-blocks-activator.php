<?php

/**
 * Fired during plugin activation
 *
 * @link       https://fb.com/simon.ugorji.7
 * @since      1.0.0
 *
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/includes
 * @author     Simon Ugorji <ugorji757@gmail.com>
 */
class Coding_Blocks_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {


/*
*************************************
CREATE CODING BLOCKS TABLE
*************************************
*/ 
  global $wpdb;
  // set the default character set and collation for the table
  $charset_collate = $wpdb->get_charset_collate();
  // Check that the table does not already exist before continuing
  $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}coding_blocks` (
  id int NOT NULL AUTO_INCREMENT,
  loader longtext NOT NULL,
  language varchar(50) NOT NULL,
  title varchar(1000) NOT NULL,
  content longtext NOT NULL,
  short_code varchar(2000) NOT NULL,
  status int NOT NULL,
  PRIMARY KEY (id)
  ) $charset_collate;";
  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta( $sql );
  $is_error = empty( $wpdb->last_error );
  return $is_error;

	}

}
