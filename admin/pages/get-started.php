

<div class="wrap" style="background-color:#fff">
<h3 align="center" class="title is-3">GET STARTED&nbsp;<span style="font-size: 35px;" class="dashicons dashicons-shortcode has-text-danger"></span></h3>
<p align="center" class="is-5">Easily Store and Manage Re-usable code snippets</p>
<hr>

<div class="columns">
	<div class="column is-6 is-align-self-center" align="center">
    
    <i class="fas fa-code fa-6x has-text-primary"></i>
    
</div>
<div class="column is-6 p-3">
<h5 align="center" class="title is-5 has-text-primary">INSERT CODE SNIPPET</h5>
<h6 align="center" class="subtitle">Just A Small Info</h6>
<hr>
<article style="padding:5px">
<ol>
<li>Head Over to <strong>Insert Code</strong> page to Add a New Code Snippet.</li>
<li>On the page, add a title for the new snippet.</li>
<li>Select the Language you're working with.</li>
<li>Type in the code in the code box and when you're done, click on <strong>Preview.</strong></li>
<li>Click on <strong>Save</strong> to save your code snippet.</li>
</ol>		
</article>

</div>

</div>
<hr>
<div class="columns">
	
<div class="column is-6 p-3">
<h5 align="center" class="title is-5 has-text-danger">CONFIGURE CODE SNIPPET</h5>
<h6 align="center" class="subtitle">Another Tiny Info</h6>
<hr>
<article style="padding:5px">
<ol>
<li>Head Over to <strong>Configure Code</strong> page to Modify An Already Existing Code Snippet.</li>
<li>On the page, you can change the title for the snippet.</li>
<li>Change the Language you're working with.</li>
<li>Modify the code in the code box and when you're done, click on <strong>Update.</strong></li>
<li>Click on Copy button at the right to Copy the shortcode for the snippet</li>
<li>In any of your posts, place the copied shortcode and you're ready to go </li>
<li>You can also <strong>Delete the snippet</strong> or perform some bulk actions on it.</li>
</ol>		
</article>

</div>
<div class="column is-6 is-align-self-center" align="center">
    
    <i class="fas fa-cog fa-6x has-text-danger"></i>
    
</div>
</div>
<div class="columns">
<div class="column is-12 p-3 z-depth-1">
	<h4 align="center" class="title is-4">YOUR CODE PREVIEW</h4>
	<hr>
	<p style="font-size: 18px;">This is how your code box will look like and the inner styling will change Automatically depending on the <strong>language</strong> you're working on. The sample code below is <strong>PHP language</strong></p>
	<p style="font-size: 18px;">	You can visit the About Page to Watch a YouTube Video of how to use our Plugin </p>
<div id="preview_section" class="code" style="margin-top:10px">
    <div class="code-header">

    </div>

    <div class="code-content">
<pre id="code_box" class="prettyprint lang-php">
&#60;?php
function cbSamplepreviewOne(){

//SAMPLE CODE :)

$mysqli = new mysqli("localhost","my_user","my_password","my_db");
$preview =$mysqli -> query ("SELECT * FROM WORDPRESS_PLUGINS_DIRECTORY WHERE PLUGIN_TITLE = Coding Blocks OR PLUGIN_SLUG = coding-blocks");
$count = $preview->num_rows;
$mysqli -> close();

return $count; // When called the Response should be ONLY ONE RECORD FOUND LOL!
}
?&#62;



</pre>
    </div>
</div>

</div>

	</div>
</div>