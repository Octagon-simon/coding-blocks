<?php
//this file enables the shortcode to function
if (!defined('ABSPATH'))
	exit;

global $wpdb;

add_shortcode('coding-blocks', 'coding_blocks_display_content');

function coding_blocks_display_content($coding_blocks_title)
{
	global $wpdb;

	if (is_array($coding_blocks_title) && isset($coding_blocks_title['block'])) {

		$snip_title = $coding_blocks_title['block'];
		
		//get snippet data
		$snippetData = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "coding_blocks WHERE title=%s", $snip_title));

		//get configuration
		$config = get_option('coding_blocks_config') ? json_decode(get_option('coding_blocks_config')) : null;

		$linenums = ( $config->line_nums === true ) ? "linenums" : null;
		$copybtn = ( $config->copy_btn === true ) ? "true" : "false";


		if (count($snippetData) > 0) {
			//loop through results
			foreach ($snippetData as $b) {
				//if the snippet is active
				if ($b->status == 1) {
					//build template
					$temp  = '<div style="display:none" cb-copy-btn="'.$copybtn.'" id="'.$b->title.'" class="coding_blocks_temp_section" cb-code-snippet-class="'.$b->language.' '.$linenums.' '.'">'.$b->content.'</div>';

					$shortcode = do_shortcode($temp);
					return $shortcode;
				}
				else {
					return;
				}
			}
		}else {
			return;
		}
	}
}

add_filter('block_text', 'do_shortcode'); // to run shortcodes in text blocks
