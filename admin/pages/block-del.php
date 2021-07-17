<?php
ob_start();
if ( ! defined( 'ABSPATH' ) ) 
	exit;
global $wpdb;

$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$coding_blocks_blockId = intval($_GET['blockId']);
$cb_pageno = intval($_GET['pageno']);
if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'cb-del_'.$coding_blocks_blockId )) {
	wp_nonce_ays( 'cb-del_'.$coding_blocks_blockId );
	exit;
} 
else {
	if($coding_blocks_blockId=="" || !is_numeric($coding_blocks_blockId)){

//CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {
    echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure')."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure')));

}
//END OF CHECK
	
	}
	$cb_blockCount = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE id=%d LIMIT 0,1',$coding_blocks_blockId )) ;
	if($cb_blockCount==0){

//CHECK IF HEADERS ARE SENT ALREADY
if (headers_sent()) {
    echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=2')."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=2')));

}
//END OF CHECK

	}else{
		$wpdb->query($wpdb->prepare( 'DELETE FROM  '.$wpdb->prefix.'coding_blocks WHERE id=%d',$coding_blocks_blockId));
		
		//CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {
    echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=3&pagenum='.$cb_pageno)."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=3&pagenum="'.$cb_pageno)));

}
//END OF CHECK
	}
}
ob_end_flush();