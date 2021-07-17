<?php
if ( ! defined( 'ABSPATH' ) ) 
    exit;
//CHECK IF REQUIRED FIELDS ARE MET
if(isset($_POST) && isset($_POST['insertBlock']) && isset($_POST['title']) && isset($_POST['content'])){

//DEFINE VARIABLES
$title = sanitize_title_with_dashes($_POST['title']);

$content = str_replace('\\', '', $_POST['content']); //STORE ALREADY ENCODED HTML

$shortcode = '[coding-blocks block="'.$title.'"]';

$language = sanitize_text_field($_POST['language']);
    
$PrettifyCssFile = plugin_dir_url( __FILE__ ).'../css/coding-blocks-admin.css';
$PrettifyJsFile = plugin_dir_url( __FILE__ ).'../prettify/run_prettify.js?autoload=true&skin=sunburst';
$DecodeEntityJsFile = plugin_dir_url( __FILE__ ).'../js/decode_entity.js';
$ClipboardJsFile = plugin_dir_url( __FILE__ ).'../js/clipboard.js';
$CopyButtonJsFile = plugin_dir_url( __FILE__ ).'../js/copy-button.js';
$CopyButtonCssFile = plugin_dir_url( __FILE__ ).'../css/copy-button.css';

$loader = '

   <!--LOAD STYLESHEETS AND JS FILES -->

   <!--FontAwesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>


    <link href="'.$PrettifyCssFile.'" rel="stylesheet"/>
    <script src="'.$PrettifyJsFile.'"></script>
     <script src="'.$ClipboardJsFile.'"></script>
    <script src="'.$DecodeEntityJsFile.'"></script>

<div lang="'.$language.'" id="coding_blocks_'.$title.'" style="display:none">
'.$content.'
</div>

<div id="coding_blocks_preview_'.$title.'"> </div>

<script>

<!-- ADD COPY FEATURE -->
 var x = document.querySelectorAll(\'#copy-btn-css-file\'); //CHECK FOR CSS FILE
var y = document.querySelectorAll(\'#copy-btn-js-file\'); //CHECK FOR JS FILE

    if (y.length == 0) {
var cbscript = document.createElement("script");
cbscript.setAttribute("id", "copy-btn-js-file");
cbscript.setAttribute("src", "'.$CopyButtonJsFile.'");

document.head.appendChild(cbscript);
}


else {
    // DO NOTHING
}

 if (x.length == 0) {
var cbstyle = document.createElement("link");
cbstyle.setAttribute("id", "copy-btn-css-file");
cbstyle.setAttribute("rel", "stylesheet");
cbstyle.setAttribute("href", "'.$CopyButtonCssFile.'");

document.head.appendChild(cbstyle);
}


else {
    // DO NOTHING
}

document.addEventListener("DOMContentLoaded", function() {

//CREATING THE PREVIEW BOX ---------- STEP 2
var container = document.querySelector("#coding_blocks_preview_'.$title.'");

var code = document.createElement("div");
code.setAttribute("class", "code");

var codeHeader = document.createElement("div");
codeHeader.setAttribute("class", "code-header");

//GET THE DIV CONTENT TO BE PRETTIFIED 
var raw = document.querySelector("#coding_blocks_'.$title.'");
var rawLang = raw.getAttribute("lang");

//SET THE LANGUAGE AND CLASS OF PRE ELEMENT
var codebox = document.createElement("pre");
codebox.setAttribute("id", "block-'.$title.'")
codebox.setAttribute("class", rawLang+" prettyprint");

//PRO

var blockId = "'.$title.'";

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

document.querySelector("#coding_blocks_'.$title.'").style.display="none";

PR.prettyPrint();

})
</script>

<!-- ADD COPY FEATURE -->
<link href="'.$CopyButtonCssFile.'" rel="stylesheet"/>
    ';


//Check if Code title is present in DB
global $wpdb;
   $entries = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE title=%s' ,$title)) ;

                    if($entries > 0) {
                       
                       echo '
<div class="notification is-danger" style="margin-top:10px; margin-bottom:10px; max-width:500px">
<p> <i class="fas fa-times-circle"></i>&nbsp;A Code Block with this Title Exists Already!</p>
</div>

                       ';
                   }

 else {
//If Code title isn't present in DB, DO THESE

//INSERT DATA TO DB
global $wpdb;
  $add_block=  $wpdb->insert($wpdb->prefix.'coding_blocks', 
   
    array( 
        'title'     => $title,
        'loader'   =>$loader,
        'language' => $language,
        'content'    => $content,
        'short_code' => $shortcode,
        'status'   => 1,
    ),
    array(
    	'%s',
    	'%s',
    	'%s',
    	'%s',
    	'%s',
    	'%d',
    )
    
);

//CHECK IF INSERT WAS SUCCESSFUL
 if ($add_block) {
        
    echo '
    <div  class="wrap" style="max-width: 500px; margin-bottom: 20px;">
        <div class="notification is-success">
<p><i class="fas fa-code"></i>&nbsp;Code Saved Successfully</p>
        </div>
</div>
'; 

} //END OF INSERT SUCCESS MESSGAE
else {
echo '
    <div  class="wrap" style="max-width: 500px; margin-bottom: 20px;">
        <div class="notification is-danger">
<p><i class="fas fa-times-circle"></i>&nbsp;Oops! An Error Occured and we couldn\'t save the code</p>
        </div>
</div>
'; 
}


 }//END OF ELSE


}//END OF REQUIRED FIELDS CHECK
?>
<!DOCTYPE html>
<html>

<body>

  <h3 align="center" class="title is-3">NEW CODE SNIPPET</h3> 
                <hr> 
<div class="columns wrap" style="background-color: #fff;">
  
<div class="column is-6">
<form method="POST">

<div class="field">
                            <label class="label">Title</label>
                            <p class="control has-icons-left has-icons-right">
                                <input id="inp_title" name="title" class="input" type="text" placeholder="Enter Code Title" required="" >
                                <span class="icon is-small is-left">
                                    <i class="fas fa-font"></i>
                                </span>

                            </p>
                        </div>
                       


<div class="field mb-2" style="margin-bottom: 20px;">
	<label class="label">Select Language</label>
	 <div class="control has-icons-left">
  <div class="select is-fullwidth is-rounded">
<select id="inp_language" required="" onchanged="resetStyle()" name="language">
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
<div class="field mt-2" style="margin-top: 20px;">
	<label class="label">Code</label>
<textarea id="inp_code" placeholder="TYPE IN CODE HERE ..." spellcheck="false" class="textarea" style="height:200px"></textarea>

	<textarea id="main_content" class="textarea" name="content" style="position: fixed;left: 500%;"></textarea>

</div>

<div class="field" style="display: flex;
    justify-content: space-between;
    margin-top: 20px;">

<button class="button is-warning" id="load_preview" type="button">PREVIEW&nbsp;<i class="fas fa-eye"></i></button>
<button id="btn_submit"  class="button is-primary" name="insertBlock" style="display: none !important;" disabled>SAVE&nbsp;<i class="fas fa-code"></i></button>
	</div>
</form>


</div>
<div class="column is-6 z-depth-1 is-align-self-center">
<div id="preview_section" class="code">
    <div class="code-header">

    </div>

    <div class="code-content">
<pre id="code_box" class="prettyprint lang-php">
&#60;?php
echo "This is Your Preview Box";
?&#62;

&#60;!-- THIS IS YOUR PREVIEW BOX --&#62;

&#60;script&#62;
alert('This is Your Preview Box');
&#60;script&#62;
</pre>
    </div>
</div>

</div>

</div>

<script>

jQuery( document ).ready( function( $ ) {



$('#load_preview').on('click', function(){


	//SET LANGUAGE TO CODE SECTION
var language = $('#inp_language').val();

var codeBox = document.querySelector('#code_box');
//REMOOVE PRETTIFIED CLASS
codeBox.classList.remove('prettyprinted');
//REMOVE ANY LANGUAGE CLASS THAT MIGHT BE PRESENT
codeBox.classList.remove('lang-html');
codeBox.classList.remove('lang-css');
codeBox.classList.remove('lang-php');
codeBox.classList.remove('lang-sql');
codeBox.classList.remove('lang-vb');
codeBox.classList.remove('lang-vbs');
codeBox.classList.remove('lang-basic');
//RESET THE CODEBOX
codeBox.innerHTML = "";
//ADD THE LANGUAGE
codeBox.classList.add(language);

// ENCODE TO HTML ENTITY
 var encodedStr = $('#inp_code').val().replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
       return '&#'+i.charCodeAt(0)+';';
    });
 //STORE ENCODED TEXT TO A VARIABLE
 var finalCode = encodedStr.replace(/&/gim, '&amp;');

 //EMBED ENCODED TEXT TO TEXTAREA READY FOR SUBMIT
document.querySelector('#main_content').value = finalCode;

//ENABLE THE SUBMIT BUTTON
document.querySelector('#btn_submit').style.display="block";
document.querySelector('#btn_submit').removeAttribute('disabled');

    //$(codeBox).text(finalCode);
   // document.querySelector('#code_box').innerHTML=encodedStr.replace(/&/gim, '&amp;');
 

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

//DECODE THE TEXT IN THE VARIABLE
var text = decodeEntities(finalCode);

// EMBED DECODED TEXT INTO THE CODE-BOX
$(codeBox).html(text);

//LOAD PRETTIFIER
PR.prettyPrint();


});

})





</script>
</body>
</html>

