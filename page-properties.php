<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h1 class="page-title"><?php theme_page_title(); ?></h1>
			<?php include dirname(__FILE__) . '/property_cards.php'; ?><!-- .property-cards -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>