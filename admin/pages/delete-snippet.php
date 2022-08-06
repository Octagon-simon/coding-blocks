<?php
//this script deletes a code snippet
if (!defined('ABSPATH'))
	exit;

global $wpdb;

$snipId = intval($_GET['snipId']);
$cb_pageno = intval($_GET['pageno']);

if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'delete-snippet-' . $snipId)) {
	wp_nonce_ays('delete-snippet-' . $snipId);
	exit;
}

if (!$snipId) {
	if (headers_sent()) {
		echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets') . "';</script>");
		exit;
	}
	else {
		exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets')));
	}
}

$snipCount = $wpdb->query($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'coding_blocks WHERE id=%d LIMIT 0,1', $snipId));

//check if snippets exist in db
if ($snipCount == 0) {
	if (headers_sent()) {
		echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=2') . "';
		</script>");
		exit();
	}
	else {
		exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=2')));
	}
//snippets exist, proceed to deleting the specified snippet ID
} else {
	$wpdb->query($wpdb->prepare('DELETE FROM  ' . $wpdb->prefix . 'coding_blocks WHERE id=%d', $snipId));

	//CHECK IF HEADERS ARE SENT ALREADY
	if (headers_sent()) {
		echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=3&pagenum=' . $cb_pageno) . "';
		</script>");
		exit();	
	} else {
		exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=3&pagenum="' . $cb_pageno)));
	}
}