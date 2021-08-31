<?php

function cbPlugin_links($links, $file) {
	$base = plugin_basename(CODING_BLOCKS_PLUGIN_FILE);
	if ($file == $base) {

		$links[] = '<a href="https://twitter.com/ugorji_simon/" title="Follow me on Twitter"><i class="dashicons dashicons-twitter"></i></a>';
		$links[] = '<a href="https://facebook.com/Coding-Blocks-Wordpress-100835335618800/" title="Like us on Facebook"><i class="dashicons dashicons-facebook"></i></a>';
		$links[] = '<a href="https://www.linkedin.com/in/simon-ugorji-57a6a41a3/" title="Connect With Me on linkedin"><i class="dashicons dashicons-linkedin"></i></a>';
		$links[] = '<a href="https://firegist.com.ng/coding-blocks/" title="Check out our Website"><i class="dashicons dashicons-external"></i></a>';
	}
	return $links;
}

add_filter( 'plugin_row_meta','cbPlugin_links',10,2);
