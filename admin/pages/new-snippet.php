<?php

if ( ! defined( 'ABSPATH' ) ) 
    exit;

global $wpdb;

//Get configuration options
$config = get_option('coding_blocks_config') ? json_decode(get_option('coding_blocks_config')) : null;

//line numbers
$linenums = ($config->line_nums === true) ? "linenums" : null;
//copy button
$copybtn = ($config->copy_btn === true) ? '<p class="cb-copy-btn">Copy</p>' : null;

//CHECK IF REQUIRED FIELDS ARE MET
if(isset($_POST) && isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['content']) && !empty($_POST['content'])){

    //DEFINE VARIABLES
    $title = sanitize_title_with_dashes($_POST['title']);
    $content = str_replace('\\', '', $_POST['content']); //STORE ALREADY ENCODED HTML
    $shortcode = '[coding-blocks block="'.$title.'"]';
    $language = sanitize_text_field($_POST['language']);

    //Check if Code title is present in DB
    $entries = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE title=%s', $title)) ;

    if($entries > 0) {
        print('<div class="coding-blocks-alert danger mb-3 mt-5">
        <p class="m-0 text-center font-1"> A Snippet with this <b>title</b> exists already!</p>
        </div>');
    }else {
        //title doesnt exist, so insert data
        $add_block =  $wpdb->insert($wpdb->prefix.'coding_blocks', 
            array( 
                'title' => $title,
                'language' => $language,
                'content' => $content,
                'short_code' => $shortcode,
                'status' => 1
            ),array('%s','%s','%s','%s','%d')
        );

        //check if snippet was saved
        if ($add_block) {
            print('<div class="coding-blocks-alert success mb-3 mt-5">
                <p class="m-0 text-center font-1">Snippet was saved successfully</p>
                </div>
            '); 
        } else {
            print('<div class="coding-blocks-alert danger mb-3 mt-5">
                <p class="m-0 text-center font-1">Oops! An error prevented us from saving your snippet</p>
            </div>
            '); 
        }
    }
}//end of post request
?>

<div class="wrap" id="coding-blocks">
    <section class="coding-blocks-section">
        <h3 class="title is-4 mt-0 mb-3">CREATE NEW SNIPPET</h3>
        <form id="form_new_snippet" method="POST" class="mb-3" style="max-width:500px">
            <div class="mb-3">
                <label class="label">Title</label>
                <input id="inp_title" name="title" class="coding-blocks-input w-100" type="text"
                    placeholder="Enter Snippet's Title" required="">
            </div>
            <div class="mb-3">
                <label class="label">Select Language</label>
                <select id="inp_language" class="coding-blocks-input w-100" required="" onchanged="resetStyle()"
                    name="language">
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
            </div>
            <div class="mb-3">
                <label class="label">Code</label>
                <textarea id="inp_code" placeholder="TYPE IN THE CODE ..." spellcheck="false"
                    class="coding-blocks-input w-100" style="height:200px" required=""></textarea>
                <textarea id="main_content" class="textarea" name="content"
                    style="position: fixed;left: 500%;"></textarea>
            </div>
            <div>
                <button class="coding-blocks-btn" id="btn_load_preview" type="button">PREVIEW</button>
            </div>
        </form>
        <section>
            <div id="code-box" class="coding-blocks-code" style="max-width: 500px;margin: auto auto 1.5rem;">
                <div class="coding-blocks-code-header">
                    <div class="coding-blocks-code-header-first">
                        <p class="cb-round-fancy cb-round-danger"></p>
                        <p class="cb-round-fancy cb-round-warning"></p>
                        <p class="cb-round-fancy cb-round-primary"></p>
                    </div>
                    <div class="coding-blocks-code-header-last">
                        <?php echo $copybtn; ?>
                    </div>
                </div>
                <div class="coding-blocks-code-content mb-3">
                    <pre id="pre_code_box"
                        class="prettyprint lang-php <?php echo $linenums ?>">const sum = ( (a, b) => {<br>    return (a + b);<br>})(10, 10)</pre>
                </div>
                <button id="btn_save_snippet" class="coding-blocks-btn" form="form_new_snippet"
                    style="display:none;">Save Snippet</button>
            </div>
        </section>
    </section>
</div>
<script>
jQuery(document).ready(function($) {
    const formElem = document.querySelector('#form_new_snippet');

    let cb = new CodingBlocksCore();
    cb.adjustColor();

    $('#btn_load_preview').on('click', function() {
        //SET LANGUAGE TO CODE SECTION
        const language = $('#inp_language').val();
        const codeBox = $('#pre_code_box')[0];
        //REMOVE PRETTIFIED CLASS
        codeBox.classList.remove('prettyprinted');
        //REMOVE ANY LANGUAGE CLASS THAT MIGHT BE PRESENT
        $(codeBox).removeAttr('class');
        //RESET THE CODEBOX
        $(codeBox).html = "";
        //RESET THE ATTRIBUTE AND SET UP THE CLASS
        $(codeBox).attr('class', language + ' ' + 'prettyprint' + ' ' +
            '<?php echo $linenums ?>');

        // ENCODE TO HTML ENTITY
        const encodedStr = $('#inp_code').val().replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
            return '&#' + i.charCodeAt(0) + ';';
        });
        //STORE ENCODED TEXT TO A VARIABLE
        const finalCode = encodedStr.replace(/&/gim, '&amp;');

        //EMBED ENCODED TEXT TO TEXTAREA READY FOR SUBMIT
        $('#main_content').val(finalCode);

        // EMBED DECODED TEXT INTO THE CODE-BOX
        $(codeBox).html(cb__Decode__Entities(finalCode));

        //LOAD PRETTIFIER
        PR.prettyPrint();

        if (formElem.checkValidity()) {
            if ($('#inp_code').val().trim() && language) {
                $('#btn_save_snippet').show();
            } else {
                $('#btn_save_snippet').hide();
            }
        } else {
            formElem.reportValidity();
            $('#btn_save_snippet').hide();
        }

    });
    $('.cb-copy-btn').on('click', function(e) {
        let preId = this.getAttribute('cb-copy-snippet');
        const toCopy = document.querySelector('pre#pre_code_box').innerText.trim();
        if (toCopy.length !== 0) {
            window.navigator.clipboard.writeText(toCopy)
                .then(() => {
                    alert("Code snippet has been copied");
                })
                .catch(() => {
                    alert("Oops! an error is preventing you from copying this snippet 😢");
                });
        }
        //prevent parent elements from receiving event
        e.stopPropagation();
    });
})
</script>