<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="hero-unit" role="banner">
				<div class="content">
					<h1><?php echo get_option('home_hook'); ?></h1>
					<h2><?php echo get_option('home_subhook'); ?></h2>
					<a href="<?php echo get_permalink(9); ?>" class="rounded pop-out button">
						Inquire Today!
					</a>
				</div>
			</div><!-- #masthead -->
			<?php include dirname(__FILE__) . '/property_cards.php'; ?><!-- .property-cards -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>