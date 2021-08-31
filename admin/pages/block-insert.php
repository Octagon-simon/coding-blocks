<?php
if ( ! defined( 'ABSPATH' ) ) 
    exit;

/*
 * 
 * 
PREVIEW MODE SECTION
 *
 * 
*/

// QUERY USER'S THEME PREFERENCES
global $wpdb;
$entries = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks_settings') ;
$linenumsTmp = intval($entries[0]->line_numbers);
if ($linenumsTmp == 1) {
    $linenums = "linenums"; //Define Linenums
  
}
else {
    $linenums = ""; //Nothing
}

//DEFINE COPYBTN
$copybtnTmp = intval($entries[0]->copy_btn);
if ($copybtnTmp == 1) {
    $copybtn = '<button class="cb-theme-copy-btn" ><i class="fas fa-copy"></i></button>'; 
}
else {
    $copybtn = ""; //Nothing
   
}


/*
 * 
 * 
POST SECTION
 *
 * 
*/


//CHECK IF REQUIRED FIELDS ARE MET
if(isset($_POST) && isset($_POST['insertBlock']) && isset($_POST['title']) && isset($_POST['content'])){

//DEFINE VARIABLES
$title = sanitize_title_with_dashes($_POST['title']);

$content = str_replace('\\', '', $_POST['content']); //STORE ALREADY ENCODED HTML

$shortcode = '[coding-blocks block="'.$title.'"]';

$language = sanitize_text_field($_POST['language']);
   
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


$loader = '
<div lang="'.$language.'" id="coding_blocks_'.$title.'" style="display:none">'.$content.'</div>

<div id="coding_blocks_preview_'.$title.'"> </div>

<script id="coding_blocks_loader_'.$title.'">

document.addEventListener("DOMContentLoaded", function() {

//CREATING THE PREVIEW BOX ---------- STEP 2
var container = document.querySelector("#coding_blocks_preview_'.$title.'");

var code = document.createElement("div");
code.setAttribute("class", "code");

var codeContent = document.createElement("div");
codeContent.setAttribute("class", "code-content");

//GET THE DIV CONTENT TO BE PRETTIFIED 
var raw = document.querySelector("#coding_blocks_'.$title.'");
var rawLang = raw.getAttribute("lang");

//SET THE LANGUAGE AND CLASS OF PRE ELEMENT
var codebox = document.createElement("pre");
codebox.setAttribute("id", "block-'.$title.'")
codebox.setAttribute("class", rawLang+" "+"prettyprint"+" "+"'.$linenums.'");

var blockId = "'.$title.'";

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

document.querySelector("#coding_blocks_'.$title.'").style.display="none";

PR.prettyPrint();

//DESTROY LOADER SCRIPTS

document.querySelector("#coding_blocks_'.$title.'").remove();
document.querySelector("#coding_blocks_loader_'.$title.'").remove();

})
</script>

    ';


//Check if Code title is present in DB
global $wpdb;
   $entries = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE title=%s' ,$title)) ;

                    if($entries > 0) {
                       
                       echo '
<div class="notification is-danger" style="margin-top:10px; margin-bottom:10px;">
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
    <div  class="wrap" style="margin-bottom: 20px;">
        <div class="notification is-success">
<p><i class="fas fa-code"></i>&nbsp;Code Saved Successfully</p>
        </div>
</div>
'; 

} //END OF INSERT SUCCESS MESSGAE
else {
echo '
    <div  class="wrap" style="margin-bottom: 20px;">
        <div class="notification is-danger">
<p><i class="fas fa-times-circle"></i>&nbsp;Oops! An Error Occured and we couldn\'t save the code</p>
        </div>
</div>
'; 
}


 }//END OF ELSE


}//END OF REQUIRED FIELDS CHECK
?>


 <div class="wrap" style="margin:0px">
<div align="center" class="mt-3">
<h3 align="center" class="title is-3">NEW CODE SNIPPET</h3> 
    <hr style="
    border: 1px solid #00d1b7;
    width: 150px;
">
</div>
<div class="columns" >  
<div class="column is-6">
<form method="POST" class="block-insert-form">

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
<div class="field mt-2" style="margin-top: 20px;">
	<label class="label">Code</label>
<textarea id="inp_code" placeholder="TYPE IN CODE HERE ..." spellcheck="false" class="textarea" style="height:200px"></textarea>

	<textarea id="main_content" class="textarea" name="content" style="position: fixed;left: 500%;"></textarea>

</div>

<div class="field" style="display: flex;
    justify-content: space-between;
    margin-top: 20px;">

<button class="button is-warning" id="load_preview" type="button">PREVIEW&nbsp;<i class="fas fa-eye"></i></button>
<button id="btn_submit"  class="button is-primary" name="insertBlock" style="display: none !important;" disabled="disabled">SAVE&nbsp;<i class="fas fa-code"></i></button>
	</div>
</form>


</div>
<div class="column is-6 z-depth-1 is-align-self-center" style="padding: 1rem;">
<div id="preview_section" class="code">
    <div class="code-header">

    </div>

    <div class="code-content">
        <!--COPY BUTTON-->
    <?php echo $copybtn; ?>
<pre id="code_box" class="prettyprint lang-php <?php echo $linenums ?>">
&#60;?php

echo "This is Your Preview Box";

// THIS IS YOUR PREVIEW BOX 

print "Type in a code, select the language and click on preview";

// Still Don't Understand?

function cbMakeHumanUnderstand() {
    $msg = "It's just a Preview Box :)";
    return $msg;
}

// Don't worry, this function will Help you

cbMakeHumanUnderstand();

?&gt;
</pre>
    </div>
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
codeBox.removeAttribute('class');
//RESET THE CODEBOX
codeBox.innerHTML = "";
//RESET THE ATTRIBUTE AND SET UP THE CLASS
codeBox.setAttribute('class', language+' '+'prettyprint'+' '+'<?php echo $linenums ?>');

// ENCODE TO HTML ENTITY
 var encodedStr = $('#inp_code').val().replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
       return '&#'+i.charCodeAt(0)+';';
    });
 //STORE ENCODED TEXT TO A VARIABLE
 var finalCode = encodedStr.replace(/&/gim, '&amp;');

 //EMBED ENCODED TEXT TO TEXTAREA READY FOR SUBMIT
document.querySelector('#main_content').value = finalCode;

//ENABLE THE SUBMIT BUTTON
document.querySelector('#btn_submit').removeAttribute('disabled');
document.querySelector('#btn_submit').style.display="block";


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