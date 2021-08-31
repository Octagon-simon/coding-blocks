<?php
if ( ! defined( 'ABSPATH' ) ) 
exit;

// QUERY USER'S THEME PREFERENCES
global $wpdb;

$cbSettingsEntries = $wpdb->get_results("SELECT * FROM " .$wpdb->prefix. "coding_blocks_settings LIMIT 1") ;

$linenumsTmp = intval($cbSettingsEntries[0]->line_numbers);
if ($linenumsTmp == 1) {
    $linenums = "linenums"; //Define Linenums
  
}
else {
    $linenums = ""; //Nothing
}

//DEFINE COPYBTN
$copybtnTmp = intval($cbSettingsEntries[0]->copy_btn);


//CHECK IF METHOD IS POST
if(isset($_POST) && isset($_POST['addSettings'])){

//DEFINE VARIABLES
$line_numbers =  intval($_POST['line-numbers']);
$theme = sanitize_text_field($_POST['theme']); 
$copy_btn =  intval($_POST['copy-btn']);
//Check if Settings is present in DB
$entries = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'coding_blocks_settings') ;

if(count($entries)== 1) {
    
//UPDATE DB
$settings_Id = intval($entries[0]->id);
  $add_settings= $wpdb->update($wpdb->prefix.'coding_blocks_settings',
			 array(
                'line_numbers'     => $line_numbers,
                'theme'   =>$theme,
                'copy_btn' => $copy_btn
			 ),
			  array(
			  	'id'=>$settings_Id
			  )
			);
                 
        }

 elseif (count($entries)== 0) {

//INSERT DATA TO DB

  $add_settings=  $wpdb->insert($wpdb->prefix.'coding_blocks_settings', 
   
    array( 
        'line_numbers'     => $line_numbers,
        'theme'   =>$theme,
        'copy_btn' => $copy_btn
    ),
    array(
    	'%d',
    	'%s',
      '%d'
    )
    
);

}

//Check if Changes were saved successfully

if ($add_settings) {
        
    echo '
    <div  class="wrap" style="margin-bottom: 20px;">
        <div class="notification is-success">
<p><i class="fas fa-code"></i>&nbsp;Changes Applied Successfully</p>
        </div>
</div>
'; 

} 
else {
echo '
    <div  class="wrap" style="margin-bottom: 20px;">
        <div class="notification is-danger">
<p><i class="fas fa-times-circle"></i>&nbsp;Oops! An Error Occured and we couldn\'t Apply your Changes</p>
        </div>
</div>
'; 
}//END OF INSERT SUCCESS MESSAGE

}


if (isset($_POST) && isset($_POST['cbSyncBlock'])){

$Syncentries= $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'coding_blocks', OBJECT_K);

 foreach($Syncentries as $Syncentry){
  
$cb_blockId = ($Syncentry->id);
$cb_blockTitle = ($Syncentry->title);
$cb_blockLang = ($Syncentry->language);
$cb_blockContent = ($Syncentry->content);

if ($copybtnTmp == 1) {

$copybtnInsert = '
var copyBtn = document.createElement("button");
copyBtn.setAttribute("class", "copy-button cb-theme-copy-btn");
copyBtn.setAttribute("data-clipboard-target", "#block-'.$cb_blockTitle.'");
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

$cb_blockLoader = '

<div lang="'.$cb_blockLang.'" id="coding_blocks_'.$cb_blockTitle.'" style="display:none">'.$cb_blockContent.'</div>

<div id="coding_blocks_preview_'.$cb_blockTitle.'"> </div>

<script id="coding_blocks_loader_'.$cb_blockTitle.'">
document.addEventListener("DOMContentLoaded", function() {

//CREATING THE PREVIEW BOX ---------- STEP 2
var container = document.querySelector("#coding_blocks_preview_'.$cb_blockTitle.'");

var code = document.createElement("div");
code.setAttribute("class", "code");

var codeContent = document.createElement("div");
codeContent.setAttribute("class", "code-content");

//GET THE DIV CONTENT TO BE PRETTIFIED 
var raw = document.querySelector("#coding_blocks_'.$cb_blockTitle.'");
var rawLang = raw.getAttribute("lang");

//SET THE LANGUAGE AND CLASS OF PRE ELEMENT
var codebox = document.createElement("pre");
codebox.setAttribute("id", "block-'.$cb_blockTitle.'")
codebox.setAttribute("class", rawLang+" "+"prettyprint"+" "+"'.$linenums.'");

var blockId = "'.$cb_blockTitle.'";

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

document.querySelector("#coding_blocks_'.$cb_blockTitle.'").style.display="none";

PR.prettyPrint();

//DESTROY LOADER SCRIPTS

document.querySelector("#coding_blocks_'.$cb_blockTitle.'").remove();
document.querySelector("#coding_blocks_loader_'.$cb_blockTitle.'").remove();

})
</script> 
';

 $sync_block_settings = $wpdb->update($wpdb->prefix.'coding_blocks', 
          array('loader' => $cb_blockLoader,), 
          array('id' => $cb_blockId,)
);
if ( false === $sync_block_settings ) {
    $sync_upd_msg += -1;
    //ERROR OCCURED
} else {
    $sync_upd_msg += +1;
    //No error
}
}

//Check if Changes were saved successfully

if ($sync_upd_msg) {
    
echo '
<div  class="wrap" style="margin-bottom: 20px;">
  <div class="notification is-success">
<p><i class="fas fa-check-circle"></i>&nbsp;Sync was Successful! Total Affected Blocks are <strong>'.$sync_upd_msg.'</strong></p>
  </div>
</div>
'; 

} 
else {
echo '
<div  class="wrap" style="margin-bottom: 20px;">
  <div class="notification is-danger">
<p><i class="fas fa-times-circle"></i>&nbsp;Oops! An irrecoverable FATAL Error has occured</p>
  </div>
</div>
'; 
}
}
?>

   <!--Tabular layout for settings -->
<form method="POST">
<table class="table is-bordered is-striped cb-table" style="width:100%">
<tr>
<td>
<i class="fas fa-sort-numeric-up has-text-info"></i> &nbsp; Line Numbers

</td>
<td>
  <div class="field">
        <select class="form-control input" name="line-numbers" style="max-width:200px">
                                                      
             <option value="1">Enable</option>
             <option value="0">Disable</option>
         </select>
  </div>
      

</td>

</tr>
<tr>
<td>
<i class="fas fa-copy has-text-warning"></i> &nbsp; Copy button

</td>
<td>
  <div class="field">
        <select class="form-control input" name="copy-btn" style="max-width:200px">
                                                      
             <option value="1">Enable</option>
             <option value="0">Disable</option>
         </select>
  </div>
      

</td>

</tr>
<tr>
<td>
<i class="fas fa-drafting-compass has-text-primary"></i> &nbsp; Theme

</td>
<td>

  <div class="field">
        <select onchange="cbCheckModeSwitch()" id="cb_theme" class="form-control input" name="theme" style="max-width:200px">
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
       
  </div>
       
  

</td>

</tr>

<tr>
<td>
  
</td>
<td>
<button name="addSettings" class="button is-info is-outlined is-fullwidth" type="submit">Apply Changes</button>
</td>
</tr>
<tr style="background-color:#ddd">
    <td>
&nbsp;
    </td>
    <td>
        &nbsp;
    </td>
</tr>
<tr>
<td>
<i class="fas fa-sync has-text-danger"></i> &nbsp; Sync Blocks
<br>
<small>This will update all <strong>saved code snippets</strong> making them reflect the <em>current Plugin settings.</em></small> 
</td>
<td>
<button type="submit" onclick="this.classList.toggle('is-loading')" class="button is-danger " name="cbSyncBlock" style="max-width:200px"><i class="fas fa-cog"></i>&nbsp;Sync Now</button>
</td>
</tr>
</table></form>