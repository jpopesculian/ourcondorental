<nav class="category-posts">
	<ul>
	<?php 
		$query = new WP_Query('cat='.$cat_ID);
		if ($query->have_posts()): while ($query->have_posts()): $query->the_post(); 
	?>
		<li <?php if ($current_post == $post) { echo 'class="active"'; } ?>>
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</li>
	<?php endwhile; endif; ?>
	</ul>
</nav>