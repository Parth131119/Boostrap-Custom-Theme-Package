<?php
/*
 * Theme function file.
 */
if ( ! function_exists( 'custom_setup' ) ) :
function custom_setup() {
	
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 770;
	}
	/*
	 * Make custom theme available for translation.
	 */
	load_theme_textdomain( 'custom', get_template_directory() . '/languages' );
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', custom_font_url() ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'custom-full-width', 1038, 576, true );
	add_image_size( 'custom-home-thumbnail-image', 311, 186, true );
	add_image_size( 'custom-home-latestpost-thumbnails',130,80, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Header Menu', 'custom' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid html5shiv.
	 */
	add_theme_support( 'html5shiv', array(
		'search-form', 'comment-form', 'comment-list',
	) );
	add_theme_support( 'custom-background', apply_filters( 'custom_custom_background_args', array(
	'default-color' => 'f5f5f5',
	) ) );
	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'custom_get_featured_posts',
		'max_posts' => 6,
	) );
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}

endif; // custom_setup
add_action( 'after_setup_theme', 'custom_setup' );

/*
 * Register Lato Google font for custom.
 */
function custom_font_url() {
	$custom_font_url = '';

	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'custom' ) ) {
		$custom_font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}

	return $custom_font_url;
}

/*
 * Function for custom theme title.
 */
function custom_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$custom_site_description = get_bloginfo( 'description', 'display' );
	if ( $custom_site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $custom_site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'custom' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'custom_wp_title', 10, 2 );

/*
 * Register widget areas.
 */
function custom_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Area One', 'custom' ),
		'id'            => 'footer-1',
		'description'   => __( 'Footer Area One that appears on the right.', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="no-padding text-left">',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Area Two', 'custom' ),
		'id'            => 'footer-2',
		'description'   => __( 'Footer Area Two that appears on the center.', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="no-padding text-left">',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Area Three', 'custom' ),
		'id'            => 'footer-3',
		'description'   => __( 'Footer Area Three that appears on the left.', 'custom' ),
		'before_widget' => '<aside id="%1$s" class="widget footer-widget no-padding %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="no-padding text-left">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'custom_widgets_init' );


add_filter( 'comment_form_default_fields', 'custom_comment_placeholders' );
/**
 * Change default fields, add placeholder and change type attributes.
 *
 * @param  array $fields
 * @return array
 */
function custom_comment_placeholders( $fields )
{
    $fields['author'] = str_replace(
        '<input',
        '<input placeholder="'
        /* Replace 'theme_text_domain' with your theme’s text domain.
         * I use _x() here to make your translators life easier. :)
         * See http://codex.wordpress.org/Function_Reference/_x
         */
            . _x(
                'First Name',
                'comment form placeholder',
                'custom'
                )
            . '"',
        $fields['author']
    );
    $fields['email'] = str_replace(
        '<input',
        '<input id="email" name="email" type="text" placeholder="'
            . _x(
                'Email Id',
                'comment form placeholder',
                'custom'
                )
            . '"',
        $fields['email']
        
    );
    return $fields;
}
add_filter( 'comment_form_defaults', 'custom_textarea_insert' );
function custom_textarea_insert( $fields )
{
        $fields['comment_field'] = str_replace(
            '</textarea>',
            ''. _x(
                'Comment',
                'comment form placeholder',
                'custom'
                )
            . ''. '</textarea>',
            $fields['comment_field']
        );
    return $fields;
}

// add ie conditional html5 shim to header
function custom_add_ie_html5_shim () {
	echo '<!--[if lt IE 9]>';
	echo '<script src="' . get_template_directory_uri() . '/js/html5shiv.js"></script>';
	echo '<![endif]-->';
}
add_action('wp_head', 'custom_add_ie_html5_shim'); 


/*** Enqueue css and js files ***/
require get_template_directory() . '/functions/enqueue-files.php';

/*** Theme Default Setup ***/
require get_template_directory() . '/functions/theme-default-setup.php';

/*** Theme Option ***/
require get_template_directory() . '/theme-options/customthemes.php';

/*** Breadcrumbs ***/
require get_template_directory() . '/functions/breadcrumbs.php';

/************ Widget For Subscribe ***********/
require get_template_directory() . '/functions/recent-post-widget.php';

/*** TGM ***/
require get_template_directory() . '/functions/tgm-plugins.php';
