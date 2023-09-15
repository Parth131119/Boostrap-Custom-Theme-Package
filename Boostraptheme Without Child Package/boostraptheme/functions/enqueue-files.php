<?php 
/*
 * custom Enqueue css and js files
*/
function custom_enqueue()
{
	wp_enqueue_style( 'custom-lato', custom_font_url(), array(), null );
	wp_enqueue_style('custom-bootstrap-min',get_template_directory_uri().'/css/bootstrap.min.css',array());
	wp_enqueue_style('custom-font-awesome',get_template_directory_uri().'/css/font-awesome.css',array());
	wp_enqueue_style('custom-custom',get_template_directory_uri().'/css/custom.css',array());
   	wp_enqueue_style('style',get_stylesheet_uri(),array());
	wp_enqueue_style('custom-media',get_template_directory_uri().'/css/media.css',array());
	
	wp_enqueue_script('custom-bootstrap-min-js',get_template_directory_uri().'/js/bootstrap.min.js',array('jquery'));
	if(is_page_template('page-template/home-page.php')){
		wp_enqueue_script('custom-owl-carousel-min-js',get_template_directory_uri().'/js/owl.carousel.min.js',array('jquery'));
		wp_enqueue_style('custom-owl-carousel-css',get_template_directory_uri().'/css/owl.carousel.css',array());
            wp_enqueue_script('custom-default-js',get_template_directory_uri().'/js/default.js',array('jquery'));
	}

	if ( is_singular() ) wp_enqueue_script( "comment-reply" ); 
}
add_action('wp_enqueue_scripts', 'custom_enqueue');	
