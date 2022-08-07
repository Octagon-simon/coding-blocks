<?php
if (!defined('ABSPATH'))
  
exit;

global $wpdb;

// QUERY USER'S THEME PREFERENCES
$query_block_settings = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "coding_blocks_settings LIMIT 1");

//previous settings
$old_copy_btn = intval($query_block_settings[0]->copy_btn);
$old_theme = esc_sql($query_block_settings[0]->theme);
$old_linenums = intval($query_block_settings[0]->line_numbers);

//CHECK IF METHOD IS POST
if (isset($_POST) && isset($_POST['line-numbers']) && isset($_POST['copy-btn']) && isset($_POST['theme'])) {

  //Declare variables 
  $new_linenums = intval($_POST['line-numbers']);  
  $new_theme = sanitize_text_field($_POST['theme']);
  $new_copy_btn = intval($_POST['copy-btn']);  

  if($old_copy_btn == $new_copy_btn && 
      $old_linenums == $new_linenums && 
      $old_theme == $new_theme){
        echo '
        <div class="notification is-danger mb-3">
          <p class="font-1 has-text-centered">The Options you\'re trying to save, exists already!</p>
        </div>
    ';
  }else{
    //Check if Settings is present in DB  
    $entries = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'coding_blocks_settings');
  
    if (count($entries) == 1) {
    //update table
    $settings_Id = intval($entries[0]->id);
    $add_settings = $wpdb->update($wpdb->prefix . 'coding_blocks_settings',
      array(
      'line_numbers' => $new_linenums,
      'theme' => $new_theme,
      'copy_btn' => $new_copy_btn
    ),
      array(
      'id' => $settings_Id
    ));
    } elseif (count($entries) == 0) {
    //create settings table
    $add_settings = $wpdb->insert($wpdb->prefix . 'coding_blocks_settings',
      array(
      'line_numbers' => $new_linenums,
      'theme' => $new_theme,
      'copy_btn' => $new_copy_btn
    ),
      array(
      '%d',
      '%s',
      '%d'
    ));
    }
    //Check if Changes were saved successfully
    if ($add_settings) {
    echo '
        <div class="notification is-success mb-3">
          <p class="font-1 has-text-centered">Your Changes were saved</p>
        </div>
    ';
    } else {
    //this line also executes when record exists already and nothing was saved
    echo '
      <div class="notification is-danger mb-3">
        <p class="font-1 has-text-centered">Oops! An Error Occured and we couldn\'t save your Changes</p>
      </div>
    ';
    } 
  }
}


?>
<div class="wrap" id="coding-blocks">

    <div class="notification is-info is-light mb-3">
        <p class="m-0 font-1">If you're <b>unsure</b> about a theme, head over to the <a href="<?php echo admin_url('admin.php?page=coding-blocks-preview') ?>">Theme preview page</a> to test it out.</p>
    </div>
    <!--Tabular layout for settings -->
    <form method="POST">
        <table class="table is-bordered is-striped cb-table" style="width:100%">
            <tr>
                <td>
                    Line Numbers
                </td>
                <td>
                    <div class="field">
                        <select id="cb_linenums" class="form-control input" name="line-numbers" style="max-width:200px">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Copy button
                </td>
                <td>
                    <div class="field">
                        <select id="cb_copybtn" class="form-control input" name="copy-btn" style="max-width:200px">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Select Theme
                </td>
                <td>
                    <div class="field">
                        <select id="cb_theme" class="form-control input" name="theme" style="max-width:200px">
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
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button style="max-width:200px" class="button btn-cb-outline is-outlined is-fullwidth"
                        type="submit">Apply
                        changes</button>
                </td>
            </tr>
        </table>
    </form>

</div>
<script>
jQuery(document).ready(function($) {
    $('#cb_linenums').val('<?php echo $old_linenums; ?>');
    $('#cb_theme').val('<?php echo $old_theme; ?>');
    $('#cb_copybtn').val('<?php echo $old_copy_btn; ?>');
});
</script>