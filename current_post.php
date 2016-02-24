<div class="post-block">
	<h2><?php echo $current_post->post_title; ?></h2>
	<div class="post-content readable-text">
        <?php echo do_shortcode($current_post->post_content); ?>
	</div>
</div>