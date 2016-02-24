<nav class="category-posts" id="sliding-nav">
	<ul>
	<?php 
		$query = new WP_Query('cat='.$cat_ID);
		if ($query->have_posts()): while ($query->have_posts()): $query->the_post(); 
	?>
		<li <?php if ($current_post == $post) { echo 'class="active"'; } ?>>
			<a href="#<?php category_section_id(); ?>">
				<?php echo $post->post_title; ?>
			</a>
		</li>
	<?php endwhile; endif; ?>
	</ul>
</nav>