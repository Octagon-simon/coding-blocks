<?php

if (!defined('ABSPATH'))
    exit;

// QUERY USER'S THEME PREFERENCES
global $wpdb;

$snipId = intval($_GET['snipId']);

//store error/success message
$snip_msg = '';
if (isset($_GET['snip_msg'])) {
    $snip_msg = intval($_GET['snip_msg']);
}

if ($snip_msg == 1) {

?>
<div class="cb_msg_notice_area_style1" id="cb_msg_notice_area">
    Code Snippet successfully updated.&nbsp;&nbsp;&nbsp;<span id="cb_msg_notice_area_dismiss">Dismiss</span>
</div>
<?php
}

//go back to snippets page
$goback = admin_url('admin.php?page=coding-blocks-snippets');

if (isset($_POST) && isset($_POST['snipUpdate'])) {
    //sanitize title
    $snipTitle = sanitize_title_with_dashes(str_replace(' ', '', str_replace('-', '', $_POST['snipTitle'])));

    //store encoded html
    $snipCode = str_replace('\\', '', $_POST['content']);
    $snipStatus = intval($_POST['snipStatus']);

    $snipLang = sanitize_text_field($_POST['snipLanguage']);

    if ($snipTitle && $snipCode && $snipStatus && $snipLang) {
        //check if title contains alpha numeric characters
        if (ctype_alnum(str_replace('-', '', $snipTitle))) {
            //check if another snippet is using the title
            $snippetsCount = $wpdb->query($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'coding_blocks WHERE id!=%d AND title=%s LIMIT 0,1', $snipId, $snipTitle));

            if ($snippetsCount == 0) {
                //set the shortcode
                $snipShortCode = '[coding-blocks block="' . $snipTitle . '"]';

                //update table
                $wpdb->update($wpdb->prefix . 'coding_blocks',
                    array(
                    'title' => $snipTitle,
                    'language' => $snipLang,
                    'status' => $snipStatus,
                    'content' => $snipCode,
                    'short_code' => $snipShortCode,
                    ), array('id' => $snipId));

                print('
                    <div class="notification is-success mt-5 mb-5">
                    <p class="font-1 m-0 has-text-centered">Your Changes were Saved </p>
                    </div>');
                print("
                    <script>
                    window.location.href=\"$goback\";
                    </script>
                    ");
            }
            else {
                ?>
<div class="notification is-danger" id="cb_msg_notice_area">
    A snippet with this title exists already. &nbsp;&nbsp;&nbsp;
</div>
<?php
            }
        } else {
            ?>
<div class="notification is-danger" id="cb_msg_notice_area">
    Snippet's title can have only alphabets, numbers or hyphen.
</div>
<?php
        }
    } else {
        ?>
<div class="notification is-warning" id="cb_msg_notice_area">
    You must fill all mandatory fields. &nbsp;&nbsp;&nbsp;
</div>
<?php
    }
}

//retrieve snippet's data using the ID from the get request
$snipData = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'coding_blocks WHERE id=%d LIMIT 0,1', $snipId))[0];

?>


<div class="wrap" id="coding-blocks">
    <div class="container py-4 px-4">
        <h4 class="title is-4 mb-4"> EDIT CODE SNIPPET </h4>
        <form method="POST" class="new-snippet-form">
            <input type="hidden" id="snipId" name="snipId"
                value="<?php (isset($_POST['snipId'])) ? print(esc_attr($_POST['snipId'])) : print(esc_attr($snipData->id));?>">

            <div class="field mb-2">
                <label class="label">Snippet Title</label>
                <input id="inp_title" name="snipTitle" class="input" type="text" placeholder="Enter Snippet's Title"
                    required=""
                    value="<?php (isset($_POST['snipTitle'])) ? print(esc_attr($_POST['snipTitle'])) : print(esc_attr($snipData->title)); ?>">
            </div>

            <div class="field mb-2">
                <label class="label">Select status</label>
                <div class="select is-fullwidth">
                    <select required="" name="snipStatus" id="snipStatus">
                        <option value="1">Active </option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="field mb-3">
                <label class="label">Select language</label>
                <div class="select is-fullwidth">
                    <select id="inp_language" required="" onchanged="resetStyle()" name="snipLanguage">
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

            <div class="field">
                <label class="label">Type in the Code</label>
                <textarea oninput="encode()" onchanged="encode()" onupdated="encode()" id="blockContent"
                    spellcheck="false" placeholder="Modify this Block" class="textarea" rows="6"
                    required="required"><?php (isset($_POST['content'])) ? print(esc_textarea($_POST['content'])) : print(esc_textarea($snipData->content));?></textarea>
                <textarea id="main_content" class="textarea" name="content"
                    style="position: fixed;left: 500%;"></textarea>
            </div>

            <div class="field">
                <button id="btn_submit" name="snipUpdate" style="display:none;" disabled="disabled"
                    class="button is-info is-fullwidth" type="submit">Update snippet</button>
                <button class="button is-danger is-fullwidth is-outlined mt-2" type="button" name="back"
                    onclick="window.location.href='<?php print($goback); ?>'">Cancel action</button>
            </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
    //set language
    $('#inp_language').val('<?php echo $snipData->language; ?>');

    //set status
    $('#snipStatus').val('<?php echo $snipData->status; ?>');

    //decode it twice
    let i = 1;
    while (i <= 2) {
        let text = cb__Decode__Entities($('#blockContent').val());
        text.replace(/\\/g, "\\\\");

        //embed decoded text to code box
        $('#blockContent').val(text);
        i++;
    }
});


// ENCODE TO HTML ENTITY
function encode() {
    const encodedStr = document.querySelector('#blockContent').value.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
        return '&#' + i.charCodeAt(0) + ';';
    });
    //STORE ENCODED TEXT TO A VARIABLE
    const finalCode = encodedStr.replace(/&/gim, '&amp;');

    //EMBED ENCODED TEXT TO TEXTAREA READY FOR SUBMIT
    document.querySelector('#main_content').value = finalCode;

    //ENABLE THE SUBMIT BUTTON
    document.querySelector('#btn_submit').style.display = "block";
    document.querySelector('#btn_submit').removeAttribute('disabled');
}
</script>