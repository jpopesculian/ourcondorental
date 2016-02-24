<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="hero-unit" role="banner">
				<div class="content">
					<h1><?php echo get_option('home_hook'); ?></h1>
					<h2><?php echo get_option('home_subhook'); ?></h2>
                    <a onclick="scrollToProperties()" class="rounded pop-out button">
						Explore Now!
					</a>
				</div>
			</div><!-- #masthead -->
            <div id="home-property-cards">
                <?php include dirname(__FILE__) . '/property_cards.php'; ?><!-- .property-cards -->
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
