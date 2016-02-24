<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<header id="top-bar">
		<a id="logo" role="logo"
			href="<?php echo esc_url( home_url( '/' ) ); ?>"
			rel="home">
			<?php bloginfo( 'name' ); ?>
		</a><!-- #logo -->

		<nav id="main-navigation" role="navigation">
			<!-- <button class="menu-toggle">toggle</button> -->
			<?php wp_nav_menu( array( 
				'theme_location' => 'primary',
				'menu' => 'Main Menu'
			) ); ?>
		</nav><!-- #main-navigation -->
        <a id="nav-toggle" href="#"><span>Menu</span></a>
	</header><!-- #top-bar -->

	<div id="content" class="site-content">