<?php

if (!defined('ABSPATH'))
    exit;

global $wpdb;

//Get user's config options
$config = json_decode(get_option('coding_blocks_config'));

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['config']) && !empty($_POST['config'])) {
    //if config is not empty// use std class array access method    
    if (!empty($config)) {
        //check for line numbers
        if(isset($_POST['line_nums']) && !empty($_POST['line_nums'])){
            $config->line_nums = true;
        }else{
            $config->line_nums = false;
        }
        //check for copy button
        if(isset($_POST['copy_btn']) && !empty($_POST['copy_btn'])){
            $config->copy_btn = true;
        }else{
            $config->copy_btn = false;
        }
        //check for line numbers
        if(isset($_POST['theme']) && !empty($_POST['theme'])){
            $config->theme = sanitize_text_field($_POST['theme']);
        }else{
            $config->theme = "sunburst";
        }
    }else {
        //create new config
        $config = [];    
        //check for line numbers
        if(isset($_POST['line_nums']) && !empty($_POST['line_nums'])){
            $config['line_nums'] = true;
        }else{
            $config['line_nums'] = false;
        }
        //check for copy button
        if(isset($_POST['copy_btn']) && !empty($_POST['copy_btn'])){
            $config['copy_btn'] = true;
        }else{
            $config['copy_btn'] = false;
        }
        //check for line numbers
        if(isset($_POST['theme']) && !empty($_POST['theme'])){
            $config['theme'] = sanitize_text_field($_POST['theme']);
        }else{
            $config['theme'] = "sunburst";
        }
    }
    update_option('coding_blocks_config', json_encode($config));
    $success = true;
    $success_msg = "Configuration options updated successfully!";
}
?>
<div class="wrap" id="coding-blocks">
    <?php
if ($success) {
    echo '<div class="coding-blocks-alert success mb-3 mt-3" style="max-width: 500px;">
                <p class="m-0" style="font-size:1rem">' . $success_msg . '</p></div>';
}
?>
    <section class="coding-blocks-section">
        <h4 class="title is-5 mb-3 mt-0">CONFIGURATION OPTIONS</h4>
        <div class="coding-blocks-alert info mb-3">
            <p class="m-0 font-1">Remember to preview your theme at the <a
                    href="<?php echo esc_url(admin_url('admin.php?page=coding-blocks-preview')) ?>" style="text-decoration: underline !important;">Theme preview
                    page</a> before using it.
            </p>
        </div>
        <form method="POST">
            <input type="hidden" name="config" value="1">
            <div class="mb-3 font-1">
                <input id="chk_linenums" class="chk-add-fields" name="line_nums" type="checkbox" class="coding-blocks-input"
                    value="1">&nbsp;Include Line Numbers
            </div>
            <div class="mb-3 font-1">
                <input id="chk_copybtn" class="chk-add-fields" name="copy_btn" type="checkbox" class="coding-blocks-input"
                    value="1">&nbsp;Include Copy Button
            </div>
            <div class="mb-3 font-1">
                <label class="label">Select Theme</label>
                <select id="inp_theme" class="coding-blocks-input" name="theme" style="max-width:200px">
                    <option value="">Select One</option>
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
                    <option value="pinky-night">Pinky Night</option>
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
            </div>
            <div class="">
                <button class="coding-blocks-btn">Apply changes</button>
            </div>
        </form>
    </section>
</div>
<?php if (!empty($config)) {?>
    <script>
        jQuery(document).ready(function($) {
            <?php if($config->line_nums === true){ ?>
                document.querySelector('#chk_linenums').checked = true;
            <?php } ?>
            <?php if($config->copy_btn === true){ ?>
                document.querySelector('#chk_copybtn').checked = true;
            <?php } ?>
            <?php if(!empty($config->theme)){ ?>
                $('#inp_theme').val("<?= $config->theme ?>");
            <?php } ?>
        })
    </script>
    <?php 
    }
    ?>
