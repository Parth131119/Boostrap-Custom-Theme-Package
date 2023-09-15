<?php 
/*
 * thumbnail list
*/ 

/**
 * Add default menu style if menu is not set from the backend.
 */
function custom_add_menuid ($page_markup) {
preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $custom_matches);   
$custom_divclass = '';
if(!empty($custom_matches)) { $custom_divclass = $custom_matches[1]; }
$custom_toreplace = array('<div class="'.$custom_divclass.' pull-right-res">', '</div>');
$custom_replace = array('<div class="collapse navbar-collapse nav_coll main-menu-ul no-padding">', '</div>');
$custom_new_markup = str_replace($custom_toreplace,$custom_replace, $page_markup);
$custom_new_markup= preg_replace('/<ul/', '<ul', $custom_new_markup);
return $custom_new_markup; }
add_filter('wp_page_menu', 'custom_add_menuid');

/*
 * custom Set up post entry meta.
 *
 * Meta information for current post: categories, tags, permalink, author, and date.
 */
function custom_entry_meta() {

	$custom_category_list = get_the_category_list() ?  ' '. get_the_category_list(', ').' ' :'';

	$custom_tag_list = get_the_tag_list( __('Tags: ',', ',' ','custom'));

	$custom_date = sprintf( '<time datetime="%3$s">%4$s</time>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$custom_author = sprintf( '<a href="%1$s" title="%2$s" >%3$s</a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'custom' ), get_the_author() ) ),
		get_the_author()
	);

	if ( $custom_tag_list ) {
		$custom_utility_text = __( 'Posted in : %1$s  on %3$s by : %4$s %2$s Comments: '.get_comments_number(), 'custom' );
	} elseif ( $custom_category_list ) {
		$custom_utility_text = __( 'Posted in : %1$s  on %3$s by : %4$s  %2$s Comments: '.get_comments_number(), 'custom'  );
	} else {
		$custom_utility_text = __( 'Posted on : %3$s by : %4$s  %2$s Comments: '.get_comments_number(), 'custom' );
	}

	

	printf(
		$custom_utility_text,
		$custom_category_list,
		$custom_tag_list,
		$custom_date,
		$custom_author
	);
}

if ( ! function_exists( 'custom_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own custom_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function custom_comment( $comment, $custom_args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
  <p>
    <?php _e( 'Pingback:', 'custom' ); ?>
    <?php comment_author_link(); ?>
    <?php edit_comment_link( __( '(Edit)', 'custom' ), '<span class="edit-link">', '</span>' ); ?>
  </p>
</li>
<?php
			break;
		default :
		if($comment->comment_approved==1)
		{
		global $post; 
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
<article id="comment-<?php comment_ID(); ?>" class="comment col-md-12 no-padding">
		<div class="comments-box">                    	
			<div class="media comment-media"> 
				 <figure class="avtar"> <a href="#" class="pull-left" >
							<?php echo get_avatar( get_the_author_meta(), '80'); ?></a> 
				</figure>
				<div class="custom-comment-name txt-holder">
					  <?php
							printf( '<b class="fn">%1$s'.'</b>',
								get_comment_author_link(),
								( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author ', 'custom' ) . '</span>' : '' 
							); 
						?>
				</div>
				<div class="media-body"> 
					<span class="color_txt">
						<?php
                    echo '<a href="#" class="reply pull-right">'.comment_reply_link( array_merge( $custom_args, array( 'reply_text' => __( 'Reply', 'custom' ), 'after' => '', 'depth' => $depth, 'max_depth' => $custom_args['max_depth'] ) ) ).'</a>';
                     ?>
					</span>
					<span><?php echo get_comment_date('M j, Y \a\t g:i a'); ?> </span>
				</div>
				<?php  comment_text(); ?>
			</div>  
        </div>
</article>                    
<!-- #comment-## -->
<?php
		}
		break;
	endswitch; // end comment_type check
}
endif;
 

function custom_read_more() {
return '  <a href="'. get_permalink( get_the_ID() ) . '" class="color_txt readmore" >'. __('READ MORE','custom'). '</a>';
}
add_filter( 'excerpt_more', 'custom_read_more' ); 


/**length post text**/
function custom_custer_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_custer_excerpt_length', 999 );
