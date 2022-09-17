<?php
if (!defined('ABSPATH'))
	exit;
/**
 * Fired during plugin deactivation
 *
 * @link       https://fb.com/simon.ugorji.106
 * @since      1.0.0
 *
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Coding_Blocks
 * @subpackage Coding_Blocks/includes
 * @author     Simon Ugorji <ugorji757@gmail.com>
 */
class Coding_Blocks_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		global $wpdb; /* DEACTIVATE ALL SHORTCODES*/
		$results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "coding_blocks");
		if (count($results) > 0) {
			foreach ($results as $result) {
				$blockId = intval($result->id);
				$wpdb->update($wpdb->prefix . 'coding_blocks', array('status' => 2), array('id' => $blockId));
			}
		}
	}
}