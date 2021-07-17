<?php 
if ( ! defined( 'ABSPATH' ) ) 
	exit;

global $wpdb;
$goback=1;
$coding_blocks_blockId = intval($_GET['blockId']);

$block_message = '';
if(isset($_GET['gmas_msg'])){
	$block_message = intval($_GET['gmas_msg']);
}
if($block_message == 1){

	?>
<div class="cb_msg_notice_area_style1" id="cb_msg_notice_area">
Code Block successfully updated.&nbsp;&nbsp;&nbsp;<span
id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php
}

if($_GET['goback'])
    $goback= intval($_GET['goback']);

    
$coding_blocks_blockId = intval($_GET['blockId']);
if(isset($_POST) && isset($_POST['updateSubmit'])){
	if (!isset($_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'ihs-edit_'.$coding_blocks_blockId )) {
	wp_nonce_ays( 'ihs-edit_'.$coding_blocks_blockId );
	exit;
	} 
	$goback=intval($_POST['goback']);
	$goback++;

	$_POST = stripslashes_deep($_POST);
	$_POST = xyz_trim_deep($_POST);
	
	
	
	//DEFINE VARIABLES FROM POST
	$temp_coding_blocks_block_title = str_replace(' ', '', $_POST['blockTitle']);
	$temp_coding_blocks_block_title = str_replace('-', '', $temp_coding_blocks_block_title);
	
$PrettifyCssFile = plugin_dir_url( __FILE__ ).'../css/coding-blocks-admin.css';
$PrettifyJsFile = plugin_dir_url( __FILE__ ).'../prettify/run_prettify.js?autoload=true&skin=sunburst';
$DecodeEntityJsFile = plugin_dir_url( __FILE__ ).'../js/decode_entity.js';
$ClipboardJsFile = plugin_dir_url( __FILE__ ).'../js/clipboard.js';
$CopyButtonJsFile = plugin_dir_url( __FILE__ ).'../js/copy-button.js';
$CopyButtonCssFile = plugin_dir_url( __FILE__ ).'../css/copy-button.css';

	$coding_blocks_block_title = sanitize_title_with_dashes($_POST['blockTitle']); //SANITIZE TITLE

	$coding_blocks_block_content = str_replace('\\', '', $_POST['content']); //STORE ALREADY ENCODED HTML
    $coding_blocks_block_status = intval($_POST['blockStatus']);//CHECK FOR NUMBERS

	$coding_blocks_block_language = sanitize_text_field($_POST['blockLanguage']); //SANITIZE TEXT FIELD
    $coding_blocks_loader = '

   <!--LOAD STYLESHEETS AND JS FILES -->

   <!--FontAwesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>


    <link href="'.esc_url($PrettifyCssFile).'" rel="stylesheet"/>
    <script src="'.esc_url($PrettifyJsFile).'"></script>
     <script src="'.esc_url($ClipboardJsFile).'"></script>
    <script src="'.esc_url($DecodeEntityJsFile).'"></script>

<div lang="'.$coding_blocks_block_language.'" id="coding_blocks_'.$coding_blocks_block_title.'" style="display:none">
'.$coding_blocks_block_content.'
</div>

<div id="coding_blocks_preview_'.$coding_blocks_block_title.'"> </div>

<script>
<!-- ADD COPY FEATURE -->
 var x = document.querySelectorAll(\'#copy-btn-css-file\'); //CHECK FOR CSS FILE
var y = document.querySelectorAll(\'#copy-btn-js-file\'); //CHECK FOR JS FILE

    if (y.length == 0) {
var cbscript = document.createElement("script");
cbscript.setAttribute("id", "copy-btn-js-file");
cbscript.setAttribute("src", "'.esc_url($CopyButtonJsFile).'");

document.head.appendChild(cbscript);
}


else {
    // DO NOTHING
}

 if (x.length == 0) {
var cbstyle = document.createElement("link");
cbstyle.setAttribute("id", "copy-btn-css-file");
cbstyle.setAttribute("rel", "stylesheet");
cbstyle.setAttribute("href", "'.esc_url($CopyButtonCssFile).'");

document.head.appendChild(cbstyle);
}


else {
    // DO NOTHING
}


document.addEventListener("DOMContentLoaded", function() {

//CREATING THE PREVIEW BOX ---------- STEP 2
var container = document.querySelector("#coding_blocks_preview_'.$coding_blocks_block_title.'");

var code = document.createElement("div");
code.setAttribute("class", "code");

var codeHeader = document.createElement("div");
codeHeader.setAttribute("class", "code-header");

//GET THE DIV CONTENT TO BE PRETTIFIED 
var raw = document.querySelector("#coding_blocks_'.$coding_blocks_block_title.'");
var rawLang = raw.getAttribute("lang");

//SET THE LANGUAGE AND CLASS OF PRE ELEMENT
var codebox = document.createElement("pre");
codebox.setAttribute("id", "block-'.$coding_blocks_block_title.'")
codebox.setAttribute("class", rawLang+" prettyprint");

//PRO

var blockId = "'.$coding_blocks_block_title.'";

//Older browser support of replaceAll function in blockId.replaceAll("-", " ")

blockId = blockId.replace(/-/g, \' \');

var codeboxTitle = document.createElement("span");
codeboxTitle.setAttribute("class", "code-box-title");
codeboxTitle.innerHTML= blockId;
codeHeader.appendChild(codeboxTitle);

//END OF PRO

//GET THE INNERHTML OF THE DIV CONTENT TO BE PRETTIFIED
var rawText = raw.innerHTML;

//DECODE RAW TEXT
var text = decodeEntities(rawText);

// EMBED DECODED TEXT INTO THE CODE-BOX
codebox.innerHTML = text;

code.appendChild(codeHeader);
code.appendChild(codebox);

container.appendChild(code);

document.querySelector("#coding_blocks_'.$coding_blocks_block_title.'").style.display="none";

PR.prettyPrint();

})
</script>
    ';



	if($coding_blocks_block_title != "" && $coding_blocks_block_content != "" && $coding_blocks_block_status != "" && $coding_blocks_block_language != ""){
		
		if(ctype_alnum($temp_coding_blocks_block_title))
		{
		$block_count = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE id!=%d AND title=%s LIMIT 0,1',$coding_blocks_blockId,$coding_blocks_block_title)) ;
		
		if($block_count == 0){

			//SET THE SHORTCODE
$coding_blocks_shortcode = '[coding-blocks block="'.$coding_blocks_block_title.'"]';
			

			//PERFORM DB UPDATE
			$wpdb->update($wpdb->prefix.'coding_blocks',
			 array(
			 	'title'=>$coding_blocks_block_title,
			 	'loader' =>$coding_blocks_loader,
			 	'language' => $coding_blocks_block_language,
			 	'status' => $coding_blocks_block_status,
			 	'content'=>$coding_blocks_block_content,
			 	'short_code'=>$coding_blocks_shortcode,
			 ),
			  array(
			  	'id'=>$coding_blocks_blockId
			  )
			);
			
			 echo '
<div class="notification is-success" style="margin-top:10px; margin-bottom:10px">
<p> <i class="fas fa-code"></i>&nbsp;Your Changes were Saved </p>
</div>

                       ';
	
		}
		else{
			?>
			<div class="notification is-danger" id="cb_msg_notice_area">
			Code block already exists. &nbsp;&nbsp;&nbsp;
			</div>
			<?php	
	
		}
		}
		else
		{
			?>
		<div class="notification is-danger" id="cb_msg_notice_area">
		Coding Block title can have only alphabets,numbers or hyphen.
		</div>
		<?php
		
		}
		
	
	}else{
?>		
		<div class="notification is-warning" id="cb_msg_notice_area">
			Fill all mandatory fields. &nbsp;&nbsp;&nbsp;
		</div>
<?php 
		}

	
}

global $wpdb;


$blockDetails = $wpdb->get_results($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE id=%d LIMIT 0,1',$coding_blocks_blockId )) ;
$blockDetails = $blockDetails[0];

?>

<div >
	<fieldset
		style="width: 99%; border: 1px solid #F7F7F7; padding: 10px 0px;">
		<h3 style="text-align: center;" class="title is-3">
			EDIT CODE SNIPPET
		</h3>
		<hr>
		<form name="frmmainForm" id="frmmainForm" method="post">
			<?php wp_nonce_field( 'ihs-edit_'.$coding_blocks_blockId ); ?>
			
			<input type="hidden" id="blockId" name="blockId"
				value="<?php if(isset($_POST['blockId'])){ echo esc_attr($_POST['blockId']);}else{ echo esc_attr($blockDetails->id); }?>">
			<div>
			<input type="hidden"  name="goback" value= <?php echo $goback;?>>
				<table
					style="width: 99%; background-color: #F9F9F9; border: 1px solid #E4E4E4; border-width: 1px;margin: 0 auto">
					<tr><td><br/>
					<div id="shortCode"></div>
					<br/></td></tr>

					<!--TITLE -->
					<tr valign="top">
						<td style="border-bottom: none;width:20%;">&nbsp;&nbsp;&nbsp;Block Name&nbsp;<font color="red">*</font></td>
						<td style="border-bottom: none;width:1px;">&nbsp;:&nbsp;</td>
						<td><input style="width:80%;"
							type="text" name="blockTitle" id="blockTitle"
							value="<?php if(isset($_POST['blockTitle'])){ echo esc_attr($_POST['blockTitle']);}else{ echo esc_attr($blockDetails->title); }?>"></td>
					</tr>

					<!--LANGUAGE -->
					<tr valign="top">
						<td style="border-bottom: none;width:20%;">&nbsp;&nbsp;&nbsp;Language&nbsp;<font color="red">*</font></td>
						<td style="border-bottom: none;width:1px;">&nbsp;:&nbsp;</td>
						<td>

<div class="field mb-2" style="width:80%; margin-top: 10px;">
	 <div class="control has-icons-left">
  <div class="select is-fullwidth is-rounded">
<select required="" name="blockLanguage" id="blockLanguage">
	<option value="">Choose A Language</option>
<option value="lang-html">HTML </option>	
<option value="lang-css">CSS </option>
<option value="lang-php">PHP </option>
<option value="lang-sql">SQL </option>
<option value="lang-vb lang-vbs">VISUAL BASIC </option>
<option value="lang-basic">BASIC </option>                                  
            </select>
            <div class="icon is-small is-left">
        <i class="fas fa-magic"></i>
    </div>
     </div>
 </div>
</div>

						</td>
					</tr>

                    <!--STATUS -->
					<tr valign="top">
						<td style="border-bottom: none;width:20%;">&nbsp;&nbsp;&nbsp;Status&nbsp;<font color="red">*</font></td>
						<td style="border-bottom: none;width:1px;">&nbsp;:&nbsp;</td>
						<td>
<div class="field mb-2" style="width:80%">
	 <div class="control has-icons-left">
  <div class="select is-fullwidth is-rounded">
<select required="" name="blockStatus" id="blockStatus">
<option value="1">Active </option>	
<option value="0">Inactive</option>
                              
            </select>
            <div class="icon is-small is-left">
        <i class="fas fa-magic"></i>
    </div>
     </div>
 </div>
</div>

						</td>
					</tr>


					<tr>
						<td style="border-bottom: none;width:20%; ">&nbsp;&nbsp;&nbsp;Snippet Code &nbsp;<font color="red">*</font></td>
						<td style="border-bottom: none;width:1px;">&nbsp;:&nbsp;</td>
						<td >
<textarea oninput="encode()" onchanged="encode()" onupdated="encode()" id="blockContent" spellcheck="false" style="width: 80%;height: 500px;color: #fff;background-color: #151d00;" value="<?php if(isset($_POST['content'])){ echo esc_textarea($_POST['content']);}else{ echo esc_textarea($blockDetails->content); }?>"><?php if(isset($_POST['content'])){ echo esc_textarea($_POST['content']);}else{ echo esc_textarea($blockDetails->content); }?></textarea>


									
	<textarea id="main_content" class="textarea" name="content" style="position: fixed;left: 500%;"></textarea>
						</td>
					</tr>				

				<tr>
				  <td></td>
                    		    <td>
					       
			                
							<input class="button is-warning" style="cursor: pointer;line-height:normal;margin-right:5px"
							type="button" name="back"   onclick=" window.history.go(-<?php echo $goback;?>);" value="back" >
						</td>
					<td><input id="btn_submit" disabled class="button is-primary" style="cursor: pointer; line-height:normal" type="submit" name="updateSubmit" value="Update" style="display:none;"></td>
					
				</tr>
				<tr><td><br/></td></tr>
				</table>
			</div>

		</form>
	</fieldset>

</div>

<script type="text/javascript">

	document.addEventListener("DOMContentLoaded", decode());


// ENCODE TO HTML ENTITY
function encode() {
 var encodedStr = document.querySelector('#blockContent').value.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
       return '&#'+i.charCodeAt(0)+';';
    });
 //STORE ENCODED TEXT TO A VARIABLE
 var finalCode = encodedStr.replace(/&/gim, '&amp;');

 //EMBED ENCODED TEXT TO TEXTAREA READY FOR SUBMIT
document.querySelector('#main_content').value = finalCode;

//ENABLE THE SUBMIT BUTTON
document.querySelector('#btn_submit').style.display="block";
document.querySelector('#btn_submit').removeAttribute('disabled');
}



//DECODE THE HTML ENTITY TO READABLE FORMAT
function decode() {

// THIS FUNCTION WILL DECODE IT TWICE BECAUSE OF '&AMP' TAG
	for  (var i = 0; i < 2; i++){
//DECODE HTML ENTITY
var decodeEntities = (function() {
  // this prevents any overhead from creating the object each time
  var element = document.createElement('div');

  function decodeHTMLEntities (str) {
    if(str && typeof str === 'string') {
      // strip script/html tags
      str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
      str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
      element.innerHTML = str;
      str = element.textContent;
      element.textContent = '';
    }

    return str;
  }

  return decodeHTMLEntities;
})();
code = document.querySelector('#blockContent').value;
//DECODE THE TEXT IN THE VARIABLE
var text = decodeEntities(code);
text.replace(/\\/g, "\\\\");
// EMBED DECODED TEXT INTO THE CODE-BOX
document.querySelector('#blockContent').value=text;
console.log(text);
}
}

</script>
