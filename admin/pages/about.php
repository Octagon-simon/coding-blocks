<?php
$plugin_data = get_plugin_data( __FILE__);
$plugin_version = $plugin_data['Version'];
?>
<div class="wrap" style="background-color: #fff;">
<h3 align="center" class="title is-3">ABOUT OUR PLUGIN &nbsp;<span style="font-size: 35px;" class="dashicons dashicons-shortcode has-text-danger"></span></h3>
<hr>
<div class="columns">
<div class="column is-12">
<section>
	<article>
<p style="font-size: 15px;">We are on a Mission to make code snippets easier and more attractive for you to embed and reuse on multiple pages.</p>
<p style="font-size: 15px;">This Plugin can be seen as an extension of <strong>Google Prettify</strong> made available for wordpress sites.</p>
<p style="font-size: 15px;">Currently we have about .<strong>6 Languages</strong> and <strong>1 default theme (Night Glory + Sunburst).</strong></p>
	</article>
</section>
	</div>


</div>

<div class="columns">
<div class="column is-12">
<hr>
<div class="cb_vid_section">
<iframe width="560" height="315" src="https://www.youtube.com/embed/fNMQpVflLjo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<div class="cb_youtube_tutorial">
    <a href="https://www.youtube.com/watch?v=fNMQpVflLjo" class="button is-danger">Watch Tutorial&nbsp;<i class="fas fa-play"></i></a>
</div>

</div>


</div>

<hr>
<div class="columns">
<div class="column is-6 z-depth-1">
<a href="<?php echo admin_url('admin.php?page=coding-blocks-block-insert'); ?>" class="button is-primary is-fullwidth">Insert Code&nbsp;<i class="fas fa-code"></i></a>
<a href="<?php echo admin_url('admin.php?page=coding-blocks-block-configure'); ?>" class="button is-primary is-outlined is-fullwidth" style="margin-top:10px">Configure&nbsp;<i class="fas fa-cog"></i></a>
</div>
<div class="column is-6 is-align-self-center">
<p style="font-size: 15px;">Visit any of the links to start using <strong>Coding Blocks</strong> </p>

</div>
</div>
<hr>
<div align="center">

<h6 class="title is-6" style="margin-top:5px">CURRENT VERSION</h6>

<button class="button is-primary"><?php echo(CODING_BLOCKS_VERSION) ?></button>

</div>
</div>