<?php 
if ( ! defined( 'ABSPATH' ) ) 
	exit;
	
global $wpdb;

add_shortcode('coding-blocks','coding_blocks_display_content');		

function coding_blocks_display_content($coding_blocks_title){
	global $wpdb;
	
	if(is_array($coding_blocks_title)&& isset($coding_blocks_title['block'])){
	   
		$block_name = $coding_blocks_title['block'];
		
		$query = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."coding_blocks WHERE title=%s" ,$block_name));
		
		if(count($query)>0){
			
			foreach ($query as $blockdetails){


			if($blockdetails->status==1){
				
				$shortcode1 = do_shortcode($blockdetails->loader);
			

return $shortcode1;

		}
			else {
				return '';
				break;
			}


			}
			
		}



		else{

			return '';		
		}
		
	}
}


add_filter('block_text', 'do_shortcode'); // to run shortcodes in text blocks
