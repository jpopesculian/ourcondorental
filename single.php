<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php 
				$category = get_the_category()[0];
				$cat_ID = $category->cat_ID;
			?>
			<h1 class="page-title"><?php theme_page_title(); ?></h1>
			<?php $current_post = get_post(); ?>
            <div class="wrap">
                <?php include dirname(__FILE__) . '/single_sidenav.php'; ?><!-- nav.category-posts -->
                <?php include dirname(__FILE__) . '/current_post.php'; ?><!-- .current-post -->
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>