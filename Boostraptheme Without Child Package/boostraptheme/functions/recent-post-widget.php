<?php
/* 
 *	custom post widget	
 */
class custom_randompostwidget extends WP_Widget
{
function custom_randompostwidget()
{
$custom_widget_ops = array('classname' => 'custom_recentpostwidget', 'description' => 'Displays a recent post with thumbnail' );
$this->WP_Widget('custom_recentpostwidget', 'Laurels Recent Post', $custom_widget_ops);
}

function form($custom_instance)
{
$custom_instance = wp_parse_args( (array) $custom_instance, array( 'title' => '' ) );
$custom_instance['title'];
if(!empty($custom_instance['post_number'])) { $custom_instance['post_number']; } 
?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'custom'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if(!empty($custom_instance['title'])) { echo $custom_instance['title']; } ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_number' ); ?>"><?php _e('Number of post to show:', 'custom'); ?></label>
            <input id="<?php echo $this->get_field_id( 'post_number' ); ?>" name="<?php echo $this->get_field_name( 'post_number' ); ?>" value="<?php if(!empty($custom_instance['post_number'])) { echo $custom_instance['post_number']; } else { echo '5'; } ?>" style="width:100%;" />
        </p>
<?php
}

function update($custom_new_instance, $custom_old_instance)
{
$custom_instance = $custom_old_instance;
$custom_instance['title'] = $custom_new_instance['title'];
$custom_instance['post_number'] = $custom_new_instance['post_number'];
return $custom_instance;
}

function widget($custom_args, $custom_instance)
{
extract($custom_args, EXTR_SKIP);

echo $before_widget;
$custom_title = empty($custom_instance['title']) ? ' ' : apply_filters('widget_title', $custom_instance['title']);

if (!empty($custom_title))
echo $before_title . $custom_title . $after_title;;

//widget code here
?>
<div class="custom-custom-widget">
<div class="main-post">
          <?php
					  $custom_args = array('posts_per_page'   => $custom_instance['post_number'],
									'orderby'          => 'post_date',
									'order'            => 'DESC',
									'post_type'        => 'post',
									'post_status'      => 'publish'
								);
					$custom_single_post = new WP_Query( $custom_args );
					while ( $custom_single_post->have_posts() ) { $custom_single_post->the_post();
			?>
			<div class="media blog-media ">	  
            <?php $custom_feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
			if($custom_feat_image!="") { ?>
					<a href="<?php echo esc_url(get_permalink());?>" title="<?php echo get_the_title(); ?>" class="pull-left"> 
						<img src="<?php echo esc_url($custom_feat_image); ?>" alt="<?php the_title(); ?>" class="media-object" />
					</a>
            <?php }else{ ?>
					<a href="<?php echo esc_url(get_permalink());?>" title="<?php echo get_the_title(); ?>"  class="pull-left"> 
						<img src="<?php echo get_template_directory_uri(); ?>/images/img-not-available.jpg" class="media-object" /> 
					</a>
            <?php } ?>
            
            <div class="media-body">
					<p class="clearfix">
						<a class="media-heading" href="<?php echo esc_url(get_permalink());?>" title="Post Page">
							<?php the_title(); ?>
						</a>
					</p>
  				   <p class="text-left clearfix">
					   <span><?php comments_number( '0', '1', '%' ); ?>   <?php _e('Comments','custom'); ?></span>
					    
				   </p>
            </div>
            </div>
          
          <?php  } ?>
        </div>
</div>
<?php	
echo $after_widget;
}
}
add_action( 'widgets_init', create_function('', 'return register_widget("custom_randompostwidget");') );
?>
