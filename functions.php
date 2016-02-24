<?php

add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
  	register_nav_menus(
  		array(
  		  'menu_slug' => 'Menu Name',
  		)
  	);
}

add_action('admin_menu', 'theme_menu');
function theme_menu() {
	add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'theme_options');
	add_action( 'admin_init', 'register_theme_settings' );
}

function register_theme_settings() {
	// home header
	register_setting( 'theme_options_group', 'home_hook' );
	register_setting( 'theme_options_group', 'home_subhook' );
    // contact page
    register_setting( 'theme_options_group', 'contact_phone_home' );
    register_setting( 'theme_options_group', 'contact_phone_cell' );
    register_setting( 'theme_options_group', 'contact_email' );
	// property cards
	for ($i=0; $i < 4; $i++) {
		register_setting( 'theme_options_group', 'property_'.$i.'_name' );
		register_setting( 'theme_options_group', 'property_'.$i.'_loc' );
		register_setting( 'theme_options_group', 'property_'.$i.'_descr' );
        register_setting( 'theme_options_group', 'property_'.$i.'_page' );
        register_setting( 'theme_options_group', 'property_'.$i.'_listing' );
    }
}

function theme_options() {
	if ( !current_user_can( 'edit_theme_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include dirname(__FILE__) . '/options.php';
}

function theme_page_title() {
	echo "<span>";
	if (is_single()) {
		global $category;
		echo $category->cat_name;
	} else if (is_category()) {
		echo single_cat_title();
	} else {
		echo get_the_title();
	}
	echo "</span>";
}

function category_section_id() {
    global $post;
    echo 'section-'.$post->post_name;
}

function create_phone_link($nbr) {
    $href = 'tel:'.preg_replace('/(\s|\(|\)|-)/', '', $nbr);
    echo '<a href="'.$href.'" class="phone-nbr">'.$nbr.'</a>';
}

function create_email_link($email) {
    $href = 'mailto:'.$email;
    echo '<a href="'.$href.'" class="email">'.$email.'</a>';
}

function custom_shortcode( $content ) {

    global $post;

    wp_register_script( 'google-maps-api', 'http://maps.google.com/maps/api/js?sensor=false' );

    // Make sure the post has a gallery in it
    if( ! has_shortcode( $post->post_content, 'gallery' ) )
        return do_shortcode($content);

    return make_gallery($content);

}

function make_gallery($content) {
    global $post;

    include 'gallery_base_files.php';

    $gallery = '<div class="gallery" itemscope itemtype="http://schema.org/ImageGallery">';

    $gallery_script = '<script>';
    $gallery_script.= 'var pswpElement = document.querySelectorAll(".pswp")[0];';

    // BUILD GALLERY ITEMS
    $gallery_script.= "var gallery_items = [";

    // get gallery ids
    $post_gallery = get_post_gallery( $post, false );
    $gallery_ids = array_map('intval', explode(',', $post_gallery['ids']) );

    foreach ($gallery_ids as $id) {
        // get thumbnail and full size image
        $thumb_image = wp_get_attachment_image_src($id, 'thumbnail');
        $full_image = wp_get_attachment_image_src($id, 'full');

        // get metadata
        $image_post = get_post($id);
        $image_meta =  array(
            'alt' => get_post_meta( $image_post->ID, '_wp_attachment_image_alt', true ),
            'caption' => $image_post->post_excerpt,
            'description' => $image_post->post_content,
            'title' => $image_post->post_title
        );

        // build script object
        $gallery_script.= '{';
        $gallery_script.=      'src: "'.$full_image[0].'",';
        $gallery_script.=      'msrc: "'.$thumb_image[0].'",';
        $gallery_script.=      'w: '.$full_image[1].',';
        $gallery_script.=      'h: '.$full_image[2].',';
        $gallery_script.=      'title: "'.$image_meta['caption'].'",';
        $gallery_script.= '},';

        // build thumbnail link
        $gallery.= '<figure itemscope itemtype="http://schema.org/ImageObject">';
        $gallery.=      '<a href="'.$full_image[0].'" itemprop="contentUrl" data-size="'.$full_image[1].'x'.$full_image[2].'">';
        $gallery.=          '<img src="'.$thumb_image[0].'" itemprop="thumbnail" alt="'.$image_meta['alt'].'" />';
        $gallery.=      '</a>';
        $gallery.=      '<figcaption itemprop="caption description">'.$image_meta['caption'].'</figcaption>';
        $gallery.= '</figure>';
    }

    $gallery_script .= '];';
    // END BUILD GALLERY ITEMS

    $gallery_script.= '</script>';
    $gallery.= '</div>';

    $gallery.= $gallery_script;

    // replace gallery shortcode with content
    $content = preg_replace('/\[gallery ids="(\d|,)*"\]/', $gallery, $content);

    return $content;
}

?>
