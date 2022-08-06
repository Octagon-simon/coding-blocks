<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://fb.com/simonUgorji
 * @since      1.0.0
 *
 * @package    coding_blocks
 * @subpackage coding_blocks/admin/partials
 */
if (!defined('ABSPATH'))
	exit;

global $wpdb;

$_GET = stripslashes_deep($_GET);

$cb_message = '';

//handle pagination
$pagenum = isset($_GET['pagenum']) ? intval($_GET['pagenum']) : 1;
$limit = 10;
$offset = ($pagenum - 1) * $limit;

//load all snippets
$sql = 'SELECT * FROM ' . $wpdb->prefix . 'coding_blocks LIMIT '.$limit.' OFFSET '.$offset.'';
$entries = $wpdb->get_results($sql);

$all_records = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'coding_blocks');
$total_records = ($all_records && count($all_records) > 0) ? count($all_records) : 0;

if (isset($_GET['cb_msg'])) {
	$cb_message = intval($_GET['cb_msg']);
}
/**
 * 
 * wp_nonce_url($delurl, 'delete-snippet-' . $snipId);
 * if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'delete-snippet-'.$coding_blocks_blockId )) {
 * wp_nonce_ays( 'delete-snippet-'.$coding_blocks_blockId );
 * exit;
 * }
 */
//handle bulk actions
if (isset($_POST['cb_bulk_actions'])) {
	//retrieve the bulk action selected by the user
	$cb_bulk_actions = intval($_POST['cb_bulk_actions']); 
	//array of checked IDs
	$cb_block_ids = $_POST['cb_block_ids'];
	
	//if no snippet was checked
	if (empty($cb_block_ids)) {
		if (headers_sent()) {
			echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=8&pagenum=' . $pagenum) . "';
			</script>");
			exit();				
		}else {
			exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=8&pagenum=' . $pagenum)));
		}	
	}
	
	//handle bulk-delete
	if ($cb_bulk_actions == 2) 
	{
		foreach ($cb_block_ids as $cb_blockId) {
			$wpdb->query($wpdb->prepare('DELETE FROM  ' . $wpdb->prefix . 'coding_blocks  WHERE id=%d', $cb_blockId));
		}

		if (headers_sent()) {
			echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=3&pagenum=' . $pagenum) . "';</script>");
			exit();				
		}else {
			exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=3&pagenum=' . $pagenum)));
		}
		//handle bulk-Deactivate
	} elseif ($cb_bulk_actions == 0){
		foreach ($cb_block_ids as $cb_blockId){
			$wpdb->update($wpdb->prefix . 'coding_blocks', array('status' => 2), array('id' => $cb_blockId));
		}
		if (headers_sent()) {
			echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=4&pagenum=' . $pagenum) . "';
			</script>");
			exit();				
		}else {
			exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=4&pagenum=' . $pagenum)));
		}
		//handle bulk-activate
	} elseif ($cb_bulk_actions == 1){
		foreach ($cb_block_ids as $cb_blockId){
			$wpdb->update($wpdb->prefix . 'coding_blocks', array('status' => 1), array('id' => $cb_blockId));
		}
		if (headers_sent()) {
			echo("<script>location.href = '" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=4&pagenum=' . $pagenum) . "';
			</script>");
			exit();	
		}else {
			exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=4&pagenum=' . $pagenum)));
		}
	}
		//handle no action selected
	elseif ($cb_bulk_actions == -1){	
		if (headers_sent()) {
			echo("<script>location.href ='" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=7&pagenum=' . $pagenum) . "';
			</script>");
			exit();
		}else {
			exit(header("Location:" . admin_url('admin.php?page=coding-blocks-snippets&cb_msg=7&pagenum=' . $pagenum)));
		}
	}
}

//check if user is searching for snippet
if (isset($_POST) && isset($_POST['search']) && !empty($_POST['search'])) {
	$snipName = esc_sql(sanitize_text_field($_POST['search']));
    $offset = 0;
    $pagenum = 1;
	//reassign entries
	$sql = 'SELECT * FROM ' . $wpdb->prefix . 'coding_blocks WHERE title LIKE \'%' . $snipName . '%\' LIMIT '.$limit.' OFFSET '.$offset.'';
	$entries = $wpdb->get_results($sql);

}

// output error message

if ($cb_message == 1) {
?>
<div class="notification is-success" id="cb_msg_notice_area">
    Code Snippet successfully added.&nbsp;&nbsp;&nbsp;<span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if ($cb_message == 2) {

?>
<div class="notification is-danger" id="cb_msg_notice_area">
    Code Snippet not found.&nbsp;&nbsp;&nbsp;<span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if ($cb_message == 3) {

?>
<div class="notification is-success" id="cb_msg_notice_area">
    Snippet successfully deleted.&nbsp;&nbsp;&nbsp;<span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if ($cb_message == 4) {

?>
<div class="notification is-success" id="cb_msg_notice_area">
    Status was changed successfully&nbsp;&nbsp;&nbsp;<span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if ($cb_message == 5) {

?>
<div class="notification is-success" id="cb_msg_notice_area">
    Code Snippet was updated successfully.&nbsp;&nbsp;&nbsp;<span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if ($cb_message == 7) 
{
?>
<div class="notification is-success" id="cb_msg_notice_area">
    Nothing happened because you didn't select a bulk action.&nbsp;&nbsp;&nbsp;
    <span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if ($cb_message == 8) 
{
?>
<div class="notification is-success" id="cb_msg_notice_area">
    Please select at least one snippet to perform this action.&nbsp;&nbsp;&nbsp;
    <span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
?>
<div class="wrap" id="coding-blocks">
    <div class="container py-4 px-4">
        <h3 class="title is-4 mb-4">MANAGE CODE SNIPPETS</h3>
        <form id="form_search" method="post">
            <div class="notification is-primary is-light mb-3">
            <p class="font-1 m-0">To <b>search for a snippet,</b> enter the snippet's title and click on the search button.
            </p>
        </div>
            <section class="is-flex">
                <div class="w-80">
                    <input required aria-required type="search" class="border-0 input radius-0" name="search"
                        value="<?php (isset($search_name)) ? print(esc_attr($search_name)) : ''?>"
                        placeholder="Search for a saved snippet">
                </div>
                <div class="w-20">
                    <button class="button btn-cb is-fullwidth radius-0">Search</button>
                </div>
            </section>
        </form>

        <form method="post" class="mt-4">
            <div style="overflow-x: scroll !important;">
                <table class="w-100 table is-bordered is-striped">
                    <thead>
                        <tr>
                            <th scope="col" width="3%"><input type="checkbox" id="chkAllSnippets"></th>
                            <th scope="col">Block Name</th>
                            <th scope="col">Short Code</th>
                            <th scope="col">Status</th>
                            <th scope="col" colspan="3" style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="m-0 has-text-right has-text-danger" style="font-weight:bold">
                                <?php
			if($_POST['search']){
		?>
                                <?php (count($entries) == 1) ? print(count($entries)." snippet found") : print(count($entries)." snippets found"); ?>
                                <?php
			}else{
				?>
                                <?php ($total_records == 1) ? print($total_records." snippet") : print($total_records." snippets"); ?>
                                <?php
			}
		?>
                            </td>
                        </tr>
                        <?php
						//check if there are snippets
						if (count($entries) > 0) {
							foreach ($entries as $entry) {
								$snipId = intval($entry->id);
						?>
                        <tr>
                            <td>
                                <input type="checkbox" class="chk" value="<?php echo $snipId; ?>" name="cb_block_ids[]"
                                    id="cb_block_ids">
                            </td>
                            <td><?php echo esc_html($entry->title); ?></td>
                            <td id="<?php echo 'coding_blocks_' . esc_html($entry->id); ?>">
                                <?php 
								($entry->status == 2) ? print('Not Available') : print(esc_html($entry->short_code));
							?>
                            </td>
                            <td class="has-text-centered">
                                <?php 
								($entry->status == 1) ? print("<span class='tag is-success '>Active</span>") : print("<span class='tag is-danger'>Inactive</span>");
							?>
                            </td>

                            <!--COPY BUTTON-->
                            <td style="text-align: center;">
                                <button type="button"
                                    onclick="window.navigator.clipboard.writeText(document.getElementById('<?php print('coding_blocks_' . $snipId); ?>').innerHTML.trim());alert('Snippet\'s shortcode has been copied!\n\nPlace the shortcode in your wordpress post.')"
                                    title="Copy shortcode" class="button is-primary is-light">Copy</button>
                            </td>

                            <!--EDIT BUTTON -->
                            <td style="text-align: center;">
                                <a title="Edit this snippet" class="button is-info is-light"
                                    href='<?php echo admin_url('admin.php?page=coding-blocks-snippets&action=edit-snippet&snipId=' . $snipId . '&pageno=' . $pagenum); ?>'>Edit</a>
                            </td>
                            <!--DELETE BUTTON -->
                            <?php $delurl = admin_url('admin.php?page=coding-blocks-snippets&action=delete-snippet&snipId=' . $snipId . '&pageno=' . $pagenum); 
                        
                        ?>
                            <td style="text-align: center;"><a class="button is-danger is-light"
                                    title="Delete this snippet"
                                    href='<?php echo wp_nonce_url($delurl, 'delete-snippet-' . $snipId); ?>'
                                    onclick="javascript: return confirm('Are you sure that you wish to delete this code snippet?');">Delete
                                </a></td>
                        </tr>
                        <?php
		$count++;
	}
}
else { ?>
                        <tr>
                            <td colspan="6" align="center">No Code Snippets Found</td>
                        </tr>
                        <?php
}?>
                    </tbody>
                </table>
            </div>
            <?php
            //count results if search item exists
            $total = (isset($_POST) && (isset($_POST['search'])) && !empty($_POST['search'])) ? count($entries) : $wpdb->get_var("SELECT COUNT(`id`) FROM " . $wpdb->prefix . "coding_blocks");
            $num_of_pages = ceil($total / $limit);
            $page_links = paginate_links(array(
                'base' => add_query_arg('pagenum', '%#%'),
                'format' => '',
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'total' => $num_of_pages,
                'current' => $pagenum
            ));
            if ($page_links) {
                echo '<div class="tablenav" style="width:99%">
                    <div id="coding-blocks-pag-section" class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div>
                </div>';
            }
        ?>
            <section class="mt-5">
                <p class="font-1 mb-2">With selected: </p>
                <select name="cb_bulk_actions" style="height: 40px;width: 200px;">
                    <option value="-1">Bulk Actions</option>
                    <option value="0">Deactivate</option>
                    <option value="1">Activate</option>
                    <option value="2">Delete</option>
                </select>
                <button type="submit" class="button is-primary">Apply</button>
            </section>
        </form>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
    //add button class to the paginate elements and reset their heights
    document.querySelectorAll('.page-numbers').forEach(
        pn => {
            //check if its the one for coding blocks
            if (pn.parentElement.id == 'coding-blocks-pag-section') {
                //reset heights
                //pn.style.height = 0;
                //pn.style.lineHeight = 0;
                pn.style.verticalAlign = "middle";
                //pn.style.margin = 0;
                //pn.style.padding = 0;
                //check if current class is contained
                if (pn.classList.contains('current')) {
                    pn.classList.add('button');
                    pn.classList.add('disabled');
                } else {
                    pn.classList.add('button');
                }
            }
        }
    )
    $('#cb_msg_notice_area').animate({
        opacity: 'show',
        height: 'show'
    }, 500);

    $('#cb_msg_notice_area_dismiss').click(function() {
        $('#cb_msg_notice_area').animate({
            opacity: 'hide',
            height: 'hide'
        }, 500);

    });

    $("#chkAllSnippets").click(function() {
        $(".chk").prop("checked", $("#chkAllSnippets").prop("checked"));
    });
})
</script>