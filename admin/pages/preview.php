<h3 class="title is-3 has-text-centered">PREVIEW</h3>
<div class="columns">
    <div class="column is-12">
        <div class="notification is-info is-light">
            <p><i class="fas fa-info-circle"></i>&nbsp;<strong>Heads Up!</strong> 
        Changes made here are not saved, All Themes are Beautiful! 
        </p>
        </div>
    </div>

</div>

<div class="columns">
    <div class="column is-12">
        <!--config-->
        <div class="field">
            
            <label class="checkbox"><input type="checkbox" id="inp_linenums">Line Numbers</label>
</div>  
<div class="field">
          
            <label class="checkbox"><input type="checkbox" id="inp_copybtn">Copy Button</label>
</div>  
    </div>
</div>
<hr class="mt-2" style="background:#ddd">
<div class="columns">
    <div class="column is-6">
        <!--code box -->
        
  <div class="field">
  <label class="label">Select Theme</label>
  <div class="control has-icons-left">
  <div class="select is-fullwidth">
        <select id="inp_theme" class="form-control input" name="theme" style="max-width:200px">
               <option value="atelier-cave-dark">Atelier Cave (Dark Mode)</option>
               <option value="atelier-cave-light">Atelier Cave (Light Mode)</option>
               <option value="atelier-dune-dark">Atelier Dune (Dark Mode)</option>
               <option value="atelier-dune-light">Atelier Dune (Light Mode)</option>
               <option value="atelier-estuary-dark">Atelier Estuary (Dark Mode)</option>
               <option value="atelier-estuary-light">Atelier Estuary (Light Mode)</option>
               <option value="atelier-forest-dark">Atelier Forest (Dark Mode)</option>
               <option value="atelier-forest-light">Atelier Forest (Light Mode)</option>
               <option value="atelier-heath-dark">Atelier Heath (Dark Mode)</option>
               <option value="atelier-heath-light">Atelier Heath (Light Mode)</option>
               <option value="atelier-lakeside-dark">Atelier Lakeside (Dark Mode)</option>
               <option value="atelier-lakeside-light">Atelier Lakeside (Light Mode)</option>
               <option value="atelier-plateau-dark">Atelier Plateau (Dark Mode)</option>
               <option value="atelier-plateau-light">Atelier Plateau (Light Mode)</option>
               <option value="atelier-savanna-dark">Atelier Savanna (Dark Mode)</option>
               <option value="atelier-savanna-light">Atelier Savanna (Light Mode)</option>
               <option value="atelier-seaside-dark">Atelier Seaside (Dark Mode)</option>
               <option value="atelier-seaside-light">Atelier Seaside (Light Mode)</option>
               <option value="atelier-sulphurpool-dark">Atelier Sulphurpool (Dark Mode)</option>
             <option value="atelier-sulphurpool-light">Atelier Sulphurpool (Light Mode)</option>
              <option value="desert">Desert</option>  
             <option value="github">GitHub </option>
             <option value="github-v2">GitHub V2</option>  
             <option value="hemisu-dark" is="mode-switch">Hemisu (Dark Mode)</option>
             <option value="hemisu-light" is="mode-switch">Hemisu (Light Mode)</option>
             <option value="sons-of-obsidian">Sons-of-Obisidian</option>
             <option value="sunburst">Sunburst</option>
             <option value="tomorrow">Tomorrow</option>
             <option value="tomorrow-night">Tomorrow Night</option>
                     <option value="tomorrow-night-blue">Tomorrow Night Blue</option>
                     <option value="tomorrow-night-bright">Tomorrow Night Bright</option>
                     <option value="tomorrow-night-eighties">Tomorrow Night Eighties</option>
                     <option value="tranquil-heart">Tranquil Heart</option>
                     <option value="vibrant-ink">Vibrant Ink</option>
       
         </select>
         <div class="icon is-small is-left">
        <i class="fas fa-drafting-compass"></i>
    </div>
</div>
</div>
       
  </div>
        <div class="field mb-2" style="margin-bottom: 20px;">
	<label class="label">Select Language</label>
	 <div class="control has-icons-left">
  <div class="select is-fullwidth">
<select id="inp_lang" required="" style="max-width:200px">
	<option value="">Choose Language</option>
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
</div>

<div class="field" style="display: flex;
    justify-content: space-between;
    margin-top: 20px;">

<button class="button is-warning" onclick="cbBuildPreview()" type="button">PREVIEW&nbsp;<i class="fas fa-eye"></i></button>
	</div>
    </div>
    <div class="column is-6 z-depth-1 is-align-self-center">
        <!--preview-->
        <div id="preview_section" class="code">

    <div class="code-content">
        <!--COPY BUTTON-->
        <button id="btn_copybtn" class="cb-theme-copy-btn"  style="display:none"><i class="fas fa-copy"></i></button>


<pre id="code_box" class="prettyprint lang-php linenums">
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
<script>
    window.onload=()=>{}
        

function cbBuildPreview() {
//DEFINE VARS
var inpLineNums = document.querySelector('#inp_linenums');
var inpCopyBtn = document.querySelector('#inp_copybtn');
var inpTheme = document.querySelector('#inp_theme').value;
var inpLang = document.querySelector('#inp_lang').value;
var inpCode = document.querySelector('#inp_code').value;
var btnCopyBtn = document.querySelector('#btn_copybtn');

var previewBox = document.querySelector('pre');

var lineNums = "x";
var copyBtn = false;

//CHECK IF INPUTS ARE CHECKED
if (!inpLang) {
  inpLang = "x";
}

if (inpLineNums.checked == true) {
 lineNums = "linenums";
}

if (inpCopyBtn.checked == true) {
     copyBtn = true;
}

//APPEND THEME FILE
if (document.querySelector('#cb_preview_theme_file')){
document.querySelector('#cb_preview_theme_file').remove();
}

if (document.querySelector('#coding-blocks-theme-css')) {
  document.querySelector('#coding-blocks-theme-css').remove();  
}
var Theme = document.createElement("link");
Theme.setAttribute('href', '../wp-content/plugins/coding-blocks/admin/lib/themes/'+inpTheme+'.css')
Theme.setAttribute('rel', 'stylesheet');
Theme.setAttribute('id', 'cb_preview_theme_file');
document.head.appendChild(Theme);

//BUILD PREVIEW BOX
if (copyBtn == true) {
    btnCopyBtn.style.display="block";
} else {
    btnCopyBtn.style.display="none";
}
previewBox.innerHTML="";
previewBox.removeAttribute('class');
previewBox.setAttribute('class', 'prettyprint');
previewBox.classList.add(inpLang);
previewBox.classList.add(lineNums);


// ENCODE TO HTML ENTITY
var encodedStr = inpCode.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
       return '&#'+i.charCodeAt(0)+';';
    });
 //STORE ENCODED TEXT TO A VARIABLE
 var finalCode = encodedStr.replace(/&/gim, '&amp;');

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
console.log(text);
// EMBED DECODED TEXT INTO THE CODE-BOX
previewBox.innerHTML= text;

PR.prettyPrint();

}



    

</script>