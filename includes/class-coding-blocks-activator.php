<?php

/**
 * Fired during plugin activation
 *
 * @link       https://fb.com/simon.ugorji.106
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
class Coding_Blocks_Activator
{

  /**
   * Short Description. (use period)
   *
   * Long Description.
   *
   * @since    1.0.0
   */
  public static function activate()
  {

    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // set the default character set and collation for the table
    $charset_collate = $wpdb->get_charset_collate();

    //check if db exists
    $checkTable = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "coding_blocks"));
    
    $db_error;

    //check if loader column exists
    //it should return empty if it doesnt exist or an array of data
    $checkLoader = $wpdb->get_results($wpdb->prepare("SELECT loader FROM " . $wpdb->prefix . "coding_blocks"));

    //if database exists
    if (count($checkTable) > 0) {
      //check if loader column exists
      if (count($checkLoader) > 0) {
        $sql = "ALTER TABLE `{$wpdb->base_prefix}coding_blocks` DROP COLUMN loader";
        //execute changes
        if($wpdb->query($sql) === false){
          $db_error = (!empty($wpdb->last_error)) ? $wpdb->last_error : null;
        }
      }    
    } else {
      //create first table
      $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}coding_blocks` (
        id int NOT NULL AUTO_INCREMENT,
        language varchar(50) NOT NULL,
        title varchar(1000) NOT NULL,
        content longtext NOT NULL,
        short_code varchar(2000) NOT NULL,
        status int NOT NULL,
        PRIMARY KEY (id)
        ) $charset_collate;";

        //execute changes
        dbDelta($sql);
    }

    //settings db has been removed from version 1.1.0 upwards
    $settingsDB = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "coding_blocks_settings"));
    
    if(count($settingsDB) > 0){
      /* DELETE TABLE */
	    $wpdb->query('DROP TABLE ' . $wpdb->prefix . 'coding_blocks_settings');
    }
  }

}