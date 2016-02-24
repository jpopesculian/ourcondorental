<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h1 class="page-title"><?php theme_page_title(); ?></h1>
            <div class="wrap readable-text">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php echo custom_shortcode($post->post_content); ?>
                <?php endwhile; endif; ?>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>