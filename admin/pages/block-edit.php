<?php 
if ( ! defined( 'ABSPATH' ) ) 
	exit;

	// QUERY USER'S THEME PREFERENCES
global $wpdb;
$cbSettingsEntries = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks_settings') ;
$linenumsTmp = intval($cbSettingsEntries[0]->line_numbers);
if ($linenumsTmp == 1) {
    $linenums = "linenums"; //Define Linenums
  
}
else {
    $linenums = ""; //Nothing
}

//DEFINE COPYBTN
$copybtnTmp = intval($cbSettingsEntries[0]->copy_btn);

if ($copybtnTmp == 1) {

    $copybtnInsert = '
    var copyBtn = document.createElement("button");
    copyBtn.setAttribute("class", "copy-button cb-theme-copy-btn");
    copyBtn.setAttribute("data-clipboard-target", "#block-'.$title.'");
    copyBtn.setAttribute("data-toggle", "tooltip");
    copyBtn.setAttribute("title", "Click to Copy");
    copyBtn.innerHTML = \'<i class="fas fa-copy"></i>\';
    ';
    $copybtnAppend = '
    codeContent.appendChild(copyBtn);
    ';
}
else {
  
    $copybtnInsert = "";
    $copybtnAppend = "";
}

$goback=1;
$coding_blocks_blockId = intval($_GET['blockId']);

$block_message = '';
if(isset($_GET['gmas_msg'])){
	$block_message = intval($_GET['block_msg']);
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
if(isset($_POST) && isset($_POST['blockUpdate'])){
	if (!isset($_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'block_update_'.$coding_blocks_blockId )) {
	wp_nonce_ays( 'block_update_'.$coding_blocks_blockId );
	exit;
	} 
	$goback=intval($_POST['goback']);
	$goback++;
	
	//DEFINE VARIABLES FROM POST
	$temp_coding_blocks_block_title = str_replace(' ', '', $_POST['blockTitle']);
	$temp_coding_blocks_block_title = str_replace('-', '', $temp_coding_blocks_block_title);

	$coding_blocks_block_title = sanitize_title_with_dashes($_POST['blockTitle']); //SANITIZE TITLE

	$coding_blocks_block_content = str_replace('\\', '', $_POST['content']); //STORE ALREADY ENCODED HTML
    $coding_blocks_block_status = intval($_POST['blockStatus']);//CHECK FOR NUMBERS

	$coding_blocks_block_language = sanitize_text_field($_POST['blockLanguage']); //SANITIZE TEXT FIELD
    $coding_blocks_loader = '
<div lang="'.$coding_blocks_block_language.'" id="coding_blocks_'.$coding_blocks_block_title.'" style="display:none">'.$coding_blocks_block_content.'</div>

<div id="coding_blocks_preview_'.$coding_blocks_block_title.'"> </div>


<script id="coding_blocks_loader_'.$coding_blocks_block_title.'">

document.addEventListener("DOMContentLoaded", function() {

//CREATING THE PREVIEW BOX ---------- STEP 2
var container = document.querySelector("#coding_blocks_preview_'.$coding_blocks_block_title.'");

var code = document.createElement("div");
code.setAttribute("class", "code");

var codeContent = document.createElement("div");
codeContent.setAttribute("class", "code-content");

//GET THE DIV CONTENT TO BE PRETTIFIED 
var raw = document.querySelector("#coding_blocks_'.$coding_blocks_block_title.'");
var rawLang = raw.getAttribute("lang");

//SET THE LANGUAGE AND CLASS OF PRE ELEMENT
var codebox = document.createElement("pre");
codebox.setAttribute("id", "block-'.$coding_blocks_block_title.'")
codebox.setAttribute("class", rawLang+" "+"prettyprint"+" "+"'.$linenums.'");

var blockId = "'.$coding_blocks_block_title.'";

//Older browser support of replaceAll function in blockId.replaceAll("-", " ")

blockId = blockId.replace(/-/g, \' \');

//BEGINNING OF COPY BUTTON

'.$copybtnInsert.'

//GET THE INNERHTML OF THE DIV CONTENT TO BE PRETTIFIED
var rawText = raw.innerHTML;

//DECODE RAW TEXT
var text = decodeEntities(rawText);

// EMBED DECODED TEXT INTO THE CODE-BOX
codebox.innerHTML = text;

//COPY BTN IF ENABLED

'.$copybtnAppend.'

codeContent.appendChild(codebox);
code.appendChild(codeContent);
container.appendChild(code);

document.querySelector("#coding_blocks_'.$coding_blocks_block_title.'").style.display="none";

PR.prettyPrint();

//DESTROY LOADER SCRIPTS

document.querySelector("#coding_blocks_'.$coding_blocks_block_title.'").remove();
document.querySelector("#coding_blocks_loader_'.$coding_blocks_block_title.'").remove();

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
</div>'
;

echo "
<script>
setTimeout(function(){
window.history.go(-$goback);
	}, 10);
</script>
";
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

$blockDetails = $wpdb->get_results($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE id=%d LIMIT 0,1',$coding_blocks_blockId )) ;
$blockDetails = $blockDetails[0];

?>



<div>
<div class="columns">
<div class="column is-12">
<fieldset>
		<h3 class="title is-3 has-text-centered">
			EDIT CODE BLOCK
		</h3>

<form method="POST" class="block-insert-form">

<?php wp_nonce_field( 'block_update_'.$coding_blocks_blockId ); ?>
<input type="hidden" id="blockId" name="blockId" value="<?php if(isset($_POST['blockId'])){ echo esc_attr($_POST['blockId']);}else{ echo esc_attr($blockDetails->id); }?>">
<input type="hidden"  name="goback" value= <?php echo $goback;?>>

<div class="field mb-2">
 <label class="label">Title</label>
 <p class="control has-icons-left has-icons-right">
<input id="inp_title" name="blockTitle" class="input" type="text" placeholder="Enter Code Title" required="" value="<?php if(isset($_POST['blockTitle'])){ echo esc_attr($_POST['blockTitle']);}else{ echo esc_attr($blockDetails->title); }?>">
  <span class="icon is-small is-left">
                                    <i class="fas fa-font"></i>
  </span>

      </p>
   </div>
                       
   <div class="field mb-2">
   <label class="label">Status</label>
	 <div class="control has-icons-left">
  <div class="select is-fullwidth">
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

<div class="field mb-2" style="margin-bottom: 20px;">
	<label class="label">Select Language</label>
	 <div class="control has-icons-left">
  <div class="select is-fullwidth">
<select id="inp_language" required="" onchanged="resetStyle()" name="blockLanguage">
	<option value="">Choose A Language</option>
    <optgroup label="Bash and shell languages">
      <option value="lang-bash">Bourne Again Shell</option>
      <option value="lang-bsh">Bourne Shell</option>
      <option value="lang-csh">C Shell </option>
      <option value="lang-sh">Shell </option> 
    </optgroup>
    <optgroup label="C, C++, C#">
    <option value="lang-c">C</option>
      <option value="lang-cpp">C++</option>
      <option value="lang-cs">C# </option>
    </optgroup>
    <optgroup label="Coffee Script, Regex">
    <option value="lang-coffee">Coffee Script</option>
    <option value="lang-regex">Regex</option>
    </optgroup>
    <optgroup label="HTML, CSS, PHP, SQL">
<option value="lang-html">HTML </option>	
<option value="lang-css">CSS </option>
<option value="lang-php">PHP </option>
<option value="lang-sql">SQL </option>
    </optgroup>
    <optgroup label="Java, JavaScript, JSON, Kotlin">
    <option value="lang-java">JAVA</option>
    <option value="lang-js">JS</option>
    <option value="lang-json">JSON</option>
    <option value="lang-kotlin">Kotlin</option>
</optgroup>
<optgroup label="Pearl, Python, Ruby">
    <option value="lang-pl">Pearl</option>
    <option value="lang-py">Python</option>
     <option value="lang-rb">Ruby</option>
</optgroup>
<optgroup label="XML, XSL">
<option value="lang-xml">XML</option>
<option value="lang-xsl">XSL</option>
</optgroup>
<optgroup label="Apollo, Clojure, Dart, Delphi">
<option value="lang-apollo">Apollo</option>
<option value="lang-cl">Clojure</option>
<option value="lang-dart">Dart</option>
<option value="lang-pascal">Pascal</option>
</optgroup>
<optgroup label="Elixir, Erlang, Go, Haskell">
<option value="lang-exs">Elixir</option>
<option value="lang-erl">Erlang</option>
<option value="lang-go">Go</option>
<option value="lang-hs">Haskell</option>
</optgroup>
<optgroup label="LaTeX and TeX">
<option value="lang-latex">Latex</option>
<option value="lang-tex">Tex</option>
</optgroup>

<optgroup label="Lisp, Scheme and Racket">
<option value="lang-lsp">Lisp</option>
<option value="lang-scm">Scheme</option>
<option value="lang-rkt">Racket</option>
</optgroup>

<optgroup label="LLVM, Logtalk, Lua, Makefile">
<option value="lang-llvm">LLVM</option>
<option value="lang-logtalk">Logtalk</option>
<option value="lang-lua">Lua</option>
<option value="lang-mk">Makefile</option>
</optgroup>

<optgroup label="VISUAL BASIC, BASIC">
<option value="lang-vb">VISUAL BASIC </option>
<option value="lang-basic">BASIC </option>   
</optgroup>     
<optgroup label="Yaml, Protocol Buffers, MathLab">
<option value="lang-yml">YML </option>
<option value="lang-proto">Proto </option>  
<option value="lang-mathlab">MathLab </option>   
</optgroup>                              
            </select>
            <div class="icon is-small is-left">
        <i class="fas fa-magic"></i>
    </div>
     </div>
 </div>
</div>


<div class="field">
  <label class="label">Code Block</label>
    <textarea oninput="encode()" onchanged="encode()" onupdated="encode()" id="blockContent" spellcheck="false" placeholder="Modify this Block" class="textarea" rows="6" required="required"><?php if(isset($_POST['content'])){ echo esc_textarea($_POST['content']);}else{ echo esc_textarea($blockDetails->content); }?></textarea>
	<textarea id="main_content" class="textarea" name="content" style="position: fixed;left: 500%;"></textarea>
</div>

 <div class="field">
	 <button id="btn_submit" name="blockUpdate" style="display:none;" disabled="disabled" class="button is-info is-fullwidth" type="submit"><i class="fas fa-arrow-circle-up"></i>&nbsp;UPDATE</button>
<button  class="button is-danger is-fullwidth is-outlined mt-2" type="button" name="back" onclick=" window.history.go(-<?php echo $goback;?>);"><i class="fas fa-arrow-circle-left"></i>&nbsp;CANCEL</button>
	</div>

</fieldset>
</div>

</div>




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
