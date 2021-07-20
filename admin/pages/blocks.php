<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://fb.com/simon.ugorji.7
 * @since      1.0.0
 *
 * @package    coding_blocks
 * @subpackage coding_blocks/admin/partials
 */
if ( ! defined( 'ABSPATH' ) ) 
	exit;
global $wpdb;
    $_GET = stripslashes_deep($_GET);
    $cb_message = $search_name_db=$search_name='';
   
    if(isset($_GET['cb_msg'])){
        $cb_message = intval($_GET['cb_msg']);
    }
    if($_POST)
     {
         if(isset($_POST['search']))
         {
            if(!isset($_REQUEST['_wpnonce'])||!wp_verify_nonce($_REQUEST['_wpnonce'],'block-search-') ){
                wp_nonce_ays( 'block-search-' );
                exit;
            }
         }
        
        if (isset($_POST['apply_cb_bulk_actions'])) //Check if submit button is clicked
        {

        	if(!isset($_REQUEST['_wpnonce'])||!wp_verify_nonce($_REQUEST['_wpnonce'],'block-bulk-actions-') ){
                 wp_nonce_ays( 'block-bulk-actions-' );
                 exit;
             }

            if (isset($_POST['cb_bulk_actions'])){
                $cb_bulk_actions=intval($_POST['cb_bulk_actions']); //SANITIZE OUTPUT
                if (isset($_POST['cb_block_ids']))
                    $cb_block_ids = $_POST['cb_block_ids']; //Array of Checked ID's
                    $cb_pageno = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
                    
                    if (empty($cb_block_ids))
                    {
                      

//CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {

   echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=8&pagenum='.$cb_pageno)."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=8&pagenum='.$cb_pageno)));

}
//END OF CHECK




                    }
                    if ($cb_bulk_actions==2)//bulk-delete
                    {
                        foreach ($cb_block_ids as $cb_blockId)
                        {
                            $wpdb->query($wpdb->prepare( 'DELETE FROM  '.$wpdb->prefix.'coding_blocks  WHERE id=%d',$cb_blockId)) ;
                        }
                    

//CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {

   echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=3&pagenum='.$cb_pageno)."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=3&pagenum='.$cb_pageno)));

}
//END OF CHECK

                    }
                    elseif ($cb_bulk_actions==0)//bulk-Deactivate
                    {
                        foreach ($cb_block_ids as $cb_blockId)
                            $wpdb->update($wpdb->prefix.'coding_blocks', array('status'=>2), array('id'=>$cb_blockId));
                         //CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {

   echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=4&pagenum='.$cb_pageno)."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=4&pagenum='.$cb_pageno)));

}
//END OF CHECK
                    }
                    elseif ($cb_bulk_actions==1)//bulk-activate
                    {
                        foreach ($cb_block_ids as $cb_blockId)
                            $wpdb->update($wpdb->prefix.'coding_blocks', array('status'=>1), array('id'=>$cb_blockId));

       //CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {

   echo("<script>location.href = '".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=4&pagenum='.$cb_pageno)."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=4&pagenum='.$cb_pageno)));

}
//END OF CHECK
                    }
                    elseif ($cb_bulk_actions==-1)//no action selected
                    {
//CHECK IF HEADERS ARE SENT ALREADY
		if (headers_sent()) {
   echo("<script>location.href ='".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=7&pagenum='.$cb_pageno)."';
   	</script>");
   exit();
}
else{
  exit(header("Location:".admin_url('admin.php?page=coding-blocks-block-configure&cb_msg=7&pagenum='.$cb_pageno)));

}
//END OF CHECK

                    }
            }
            
        }

        
    }

		       
	
	// SUCCESS / ERROR MESSAGES



 if($cb_message == 1){
        ?>
<div class="notification is-success" id="cb_msg_notice_area">
Code Block successfully added.&nbsp;&nbsp;&nbsp;<span
id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($cb_message == 2){

	?>
<div class="notification is-danger" id="cb_msg_notice_area">
Code Block not found.&nbsp;&nbsp;&nbsp;<span
id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($cb_message == 3){

	?>
<div class="notification is-success" id="cb_msg_notice_area">
Code Block successfully deleted.&nbsp;&nbsp;&nbsp;<span
id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($cb_message == 4){

	?>
<div class="notification is-success" id="cb_msg_notice_area">
Code Block status successfully changed.&nbsp;&nbsp;&nbsp;<span
id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($cb_message == 5){

	?>
<div class="notification is-success" id="cb_msg_notice_area">
Code Block successfully updated.&nbsp;&nbsp;&nbsp;<span
id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
if($cb_message == 7)
{
?>
 <div class="notification is-success" id="cb_msg_notice_area">
		Please select an action to apply.&nbsp;&nbsp;&nbsp;
		<span id="cb_msg_notice_area_dismiss">Dismiss</span>
 </div>
<?php 
}
if($cb_message == 8)
{
	?>
	<div class="notification is-success" id="cb_msg_notice_area">
		Please select at least one Code Block to perform this action.&nbsp;&nbsp;&nbsp;
		<span id="cb_msg_notice_area_dismiss">Dismiss</span>
	</div>
<?php
}
?>



<div class="wrap" style="height: 100%; min-height: 100%;">

					 <h3 align="center" class="title is-3">MODIFY YOUR CODE BLOCKS</h3> 
		        <hr> 		

<div class="notification is-danger" style="margin-bottom: 15px;">
<p><i class="fas fa-exclamation-circle"></i>&nbsp;<b>Hey!</b> Do not Modify your Database Columns directly. <b>This can break your code block</b></p>
</div>

	<div class="cb-configure-header">	

<div>
<form name="manage_snippets" action="" method="post">
<?php wp_nonce_field('block-search-');?>
<fieldset style="width: 99%; padding: 10px 0px;">
	<p>Search</p>
<table style="width:100%;">
 <tr>
<td>
<input style="border-radius: 0px;box-shadow: 0px 0px 5px #ddd; height: auto;" type="search" class="input" name="snippet_name" value= "<?php if(isset($search_name)){echo esc_attr($search_name);}?>"  placeholder="Search for Saved Code Snippet" >
</td>
<td>
<button style="width:-webkit-fill-available;" type="submit" class="button is-primary" name="search"><i class="fas fa-search"></i>&nbsp;Search</button>
</td>				                 	
</tr>
</table>
	          			
</form>		
		</div>
		    

			<div class="wrap">	

	<form method="post">
		<?php wp_nonce_field( 'block-bulk-actions-');?>
		
			<?php 
			global $wpdb;
			$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
			$limit = 7;			
			$offset = ( $pagenum - 1 ) * $limit;
			if(isset($_POST['snippet_name']))
			{
			$search_name=sanitize_text_field($_POST['snippet_name']); //SANITIZE INPUT
			$search_name_db=esc_sql($search_name);
    		        }

			$entries = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."coding_blocks WHERE title like '%".$search_name_db."%'"." LIMIT $offset,$limit" );

			?>
			
			
		
<span style="padding-left: 6px;color:#21759B;">With Selected : </span>
 <select name="cb_bulk_actions" id="cb_bulk_actions" style="width:130px;height:29px;">
	<option value="-1">Bulk Actions</option>
	<option value="0">Deactivate</option>
	<option value="1">Activate</option>
	<option value="2">Delete</option>
</select>
<input type="submit" title="Apply" name="apply_cb_bulk_actions" value="Apply" style="color:#21759B;cursor:pointer;padding: 5px;background:linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;border: 2px solid #DFDFDF;">
<br>

<!--TOTAL NUMBER OF BLOCKS -->
<button class="button is-info" style="margin-top:5px"><?php echo esc_sql(count($entries))." Total Blocks";?> </button>

<div style="overflow-x: scroll !important;">
         <table class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none; margin-top:5px ;">
				<thead>
					<tr>
				<th scope="col" width="3%"><input type="checkbox" id="chkAllSnippets" /></th>
						<th scope="col" >Block Name</th>
						<th scope="col" >Short Code</th>
						<th scope="col" >Status</th>
						<th scope="col" colspan="3" style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					if( count($entries)>0 ) {
					   
						foreach( $entries as $entry ) {
							$class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
							$blockId=intval($entry->id);
							?>
					<tr <?php echo $class; ?>>
					<td style="vertical-align: middle !important;padding-left: 18px;">
					<input type="checkbox" class="chk" value="<?php echo $blockId; ?>" name="cb_block_ids[]" id="cb_block_ids" />
					</td>
						<td id="coding_blocks_table"><?php 
						echo esc_html($entry->title);
						?></td>
						<td id="<?php 
						echo 'coding_blocks_' .esc_html($entry->id);
						?>"><?php 
						if($entry->status == 2){echo 'NA';}
						else
						echo esc_html($entry->short_code);
						?></td>
						<td id="coding_blocks_table">
							<?php 
								if($entry->status == 2){
									echo "Inactive";	
								}elseif ($entry->status == 1){
								echo "Active";	
								}
							
							?>
						</td>
						
	<!--COPY BUTTON-->

						<td style="text-align: center;">
							<a data-clipboard-target="<?php echo '#coding_blocks_'.$entry->id.''?>" data-toggle="tooltip" title="click to copy" class="copy-button tag button is-success is-outlined"
							href='#'><i class="fas fa-copy "></i>
						</a>
						</td>		
								
	<!--EDIT BUTTON -->

						<td style="text-align: center;"><a class="tag button is-info is-outlined"
							href='<?php echo admin_url('admin.php?page=coding-blocks-block-configure&action=block-edit&blockId='.$blockId.'&pageno='.$pagenum); ?>'><i data-toggle="tooltip" title="Edit This Block" class="fas fa-pencil-alt"></i>
						</a>
						</td>
	<!--DELETE BUTTON -->

		<?php $delurl = admin_url('admin.php?page=coding-blocks-block-configure&action=block-del&blockId='.$blockId.'&pageno='.$pagenum);?>
						<td style="text-align: center;" ><a class="tag button is-danger is-outlined" data-toggle="tooltip" title="Delete this Block"
							href='<?php echo wp_nonce_url($delurl,'block-del-'.$blockId); ?>'
							onclick="javascript: return confirm('Please click \'OK\' to confirm ');"><i class="fas fa-trash-alt"></i>
						</a></td>
					</tr>
					<?php
					$count++;
						}
					} else { ?>
					<tr>
						<td colspan="6" align="center" >No Code Blocks Found</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
</div>
			
			<?php
			$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM ".$wpdb->prefix."coding_blocks" );
			$num_of_pages = ceil( $total / $limit );

			$page_links = paginate_links( array(
					'base' => add_query_arg( 'pagenum','%#%'),
				    'format' => '',
				    'prev_text' =>  '&laquo;',
				    'next_text' =>  '&raquo;',
				    'total' => $num_of_pages,
				    'current' => $pagenum
			) );

			if ( $page_links ) {
				echo '<div class="tablenav" style="width:99%"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
			}

			?>
			</form>		
</div>
</fieldset>	
</div>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
		  	$(document).ready(function() {
		$('#cb_msg_notice_area').animate({
			opacity : 'show',
			height : 'show'
		}, 500);

		$('#cb_msg_notice_area_dismiss').click(function() {
			$('#cb_msg_notice_area').animate({
				opacity : 'hide',
				height : 'hide'
			}, 500);

		});

	});
		  	$(document).ready(function(){
	$("#chkAllSnippets").click(function(){
		$(".chk").prop("checked",$("#chkAllSnippets").prop("checked"));
    }); 
});
		  })
</script>