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

		$block_name = $coding_blocks_title['block'];
		
		//get snippet data
		$querySnippetData = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "coding_blocks WHERE title=%s", $block_name));
		//get settings
		$querySnippetSettings = $wpdb->get_results("SELECT * FROM " .$wpdb->prefix. "coding_blocks_settings LIMIT 1");

		$linenums = "";
		$copybtn = "";
		if(count($querySnippetSettings) !== 0){
			$linenums = ($querySnippetSettings[0] -> line_numbers == 1) ? "linenums" : null;
			$copybtn = ($querySnippetSettings[0] -> copy_btn == 1) ? "true" : "false";
		}

		if (count($querySnippetData) > 0) {
			//loop through results
			foreach ($querySnippetData as $b) {
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
