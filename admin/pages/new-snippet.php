<?php
if ( ! defined( 'ABSPATH' ) ) 
    exit;

// QUERY USER'S THEME PREFERENCES
global $wpdb;
$entries = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks_settings');
$linenums = "";
$linenumsTmp = intval($entries[0]->line_numbers);

if ($linenumsTmp == 1) {
    $linenums = "linenums"; //Define Linenums
}
//if user wants a copy button
$copybtnTmp = intval($entries[0]->copy_btn);
$copybtn = '<p class="cb-copy-btn">Copy</p>'; 

//CHECK IF REQUIRED FIELDS ARE MET
if(isset($_POST) && isset($_POST['title']) && isset($_POST['content'])){

    //DEFINE VARIABLES
    $title = sanitize_title_with_dashes($_POST['title']);
    $content = str_replace('\\', '', $_POST['content']); //STORE ALREADY ENCODED HTML
    $shortcode = '[coding-blocks block="'.$title.'"]';
    $language = sanitize_text_field($_POST['language']);

    //Check if Code title is present in DB
    $entries = $wpdb->query($wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks WHERE title=%s', $title)) ;

    if($entries > 0) {
        print('<div class="notification is-danger m-2 mb-5">
        <p class="m-0 has-text-centered font-1"> A Code Snippet with this <b>title</b> exists already!</p>
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
            print('<div class="notification is-success m-2 mb-5">
                <p class="m-0 has-text-centered font-1">New Snippet was created successfully</p>
                </div>
            '); 
        } else {
            print('<div class="notification is-danger m-2 mb-5">
                <p class="m-0 has-text-centered font-1">Oops! An unknown error prevented us from creating your snippet</p>
            </div>
            '); 
        }
    }
}//end of post request
?>

<div class="wrap" id="coding-blocks">
    <div class="container py-4 px-4">
        <h3 class="title is-4 has-text-left">CREATE NEW SNIPPET</h3>
        <form id="form_new_snippet" method="POST">
            <div class="field">
                <label class="label">Title</label>
                <input id="inp_title" name="title" class="input" type="text" placeholder="Enter Snippet's Title"
                    required="">
            </div>
            <div class="field mb-2" style="margin-bottom: 20px;">
                <label class="label">Select Language</label>
                <div class="select is-fullwidth">
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
                </div>
            </div>
            <div class="field mt-2" style="margin-top: 20px;">
                <label class="label">Code</label>
                <textarea id="inp_code" placeholder="TYPE IN THE CODE ..." spellcheck="false" class="textarea"
                    style="height:200px" required=""></textarea>
                <textarea id="main_content" class="textarea" name="content"
                    style="position: fixed;left: 500%;"></textarea>
            </div>
            <div class="field" style="display: flex;justify-content: space-between;margin-top: 20px;">
                <button class="button is-info" id="btn_load_preview" type="button">PREVIEW</button>
            </div>
        </form>
    </div>
    <div class="modal" id="modal_preview_snippet">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="card box">
                <div class="media">
                    <div class="media-content">
                        <div class="content mb-0">
                            <div id="code-box" class="coding-blocks-code"
                                style="max-width: 500px;margin: auto auto 1.5rem;">
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
                                <div class="coding-blocks-code-content">
                                    <pre id="pre_code_box" class="prettyprint lang-php <?php echo $linenums ?>"></pre>
                                </div>
                            </div>
                            <p class="mt-4 mb-2 has-text-centered title is-5">Is it looking good? 🙂</p>
                            <div class="is-flex">
                                <div class="column has-text-left">
                                    <button class="button btn-cb-outline close-modal">No, Cancel</button>
                                </div>
                                <div class="column has-text-right">
                                    <button class="button btn-cb" form="form_new_snippet">Yes, Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="modal-close is-large" aria-label="close"></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
    const formElem = document.querySelector('#form_new_snippet');

    let cb = new CodingBlocksCore();
    cb.adjustColor();

    //hide modal on click
    $('button.modal-close, button.close-modal').on('click', function() {
        cb.hideModal('modal_preview_snippet');
    });
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
                //show the modal
                cb.showModal('modal_preview_snippet');
            }
        } else {
            formElem.reportValidity();
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