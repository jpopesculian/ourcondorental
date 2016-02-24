<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h1 class="page-title"><?php theme_page_title(); ?></h1>
			<?php
				$cat_ID = get_cat_id( single_cat_title("",false) );
			?>
            <div class="wrap">
                <?php include dirname(__FILE__) . '/category_sidenav.php'; ?><!-- nav.category-posts -->
                <?php include dirname(__FILE__) . '/category_posts.php'; ?><!-- .current-post -->
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>