<?php
/**
 
 * Template Name: Blog
 */
get_header(); ?>
<section class="col-md-12 no-padding clearfix">
    <div class="custom_menu_bg">       
            <div class="webpage-container container no-padding clearfix">
                <div class="custom_menu">
                     <div class="breadcrumb site-breadcumb">
                        <?php if (function_exists('custom_custom_breadcrumbs')) custom_custom_breadcrumbs(); ?>
                    </div>
                    <div class="col-md-12 no-padding">
                     <h1><?php the_title(); ?></h1>
                    </div> 
                
                </div>
            </div>
    </div> 
    <div class="container webpage-container1 no-padding clearfix">
      
    	<article class="blog-article clearfix">        
            <div id="post-<?php the_ID(); ?>" <?php post_class("col-md-9 blog-page clearfix no-padding"); ?>> 
            	<div class="blog clearfix">
					<div class="blog-data clearfix">
                    	<div class="blog-info clearfix">
                            <?php /* ?><h1><?php the_title(); ?></h1>
                            <div class="breadcrumb blog-breadcumb">
                                <?php custom_entry_meta(); ?>   
                            </div> <?php */ ?>
                        </div>
						<?php 
                        global $post;
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = array( 'post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged );
                        $wp_query = new WP_Query($args);
                        $myposts = get_posts( $args );
                        foreach( $myposts as $post ) :	setup_postdata($post); ?>
                            <article id="blog-<?php the_ID(); ?>" <?php //post_class();?> class="blog_list no-padding clearfix">                      
                                <div class="blog_content col-md-12 no-padding clearfix">
                                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="clearfix" rel="bookmark">
                                             <div class="blog-image col-md-12 no-padding clearfix">                                   
                                                   <?php the_post_thumbnail(); ?>                                    
                                             </div>
                                    </a>
                                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                                            <div class="blog_ttl col-md-12 no-padding clearfix">
                                                    <?php 
                                                    //if (strlen(get_the_title()) > 30){$list_ttl = substr(get_the_title(),0,30) .'...';}else{$list_ttl=get_the_title();}
                                                    echo get_the_title();
                                                    //echo $list_ttl;
                                                     ?>
                                            </div>
                                    </a>
                                    <?php $format = 'F j, Y'; ?>
                                    <div class="blog-date col-md-12 no-padding clearfix">
                                        <?php echo get_the_date($format); ?>
                                    </div>
                                    <div class="ent-cont col-md-12 no-padding clearfix">                                    	
                                        <div class="col-md-12 blog-content no-padding clearfix">
											<?php 
                                                $conte = get_the_content();
                                                $content_img = preg_replace("/<img[^>]+\>/i", "", $conte); 
                                                $content_fnl = strip_tags($content_img , '<div>');
                                                if (strlen($content_fnl) > 100) { $list_cnt_fnl = substr($content_fnl,0,100) .'...'; }
                                                else{$list_cnt_fnl = $content_fnl;}
                                                echo $list_cnt_fnl;
                                            ?>
                                        </div>
                                    </div>                                    
                                </div>
                               
                                <div class="read-more col-md-12 no-padding clearfix">
                                    <div class="color_txt readmore clearfix">
                                        <a href="<?php echo get_permalink( get_the_ID() )?>">Read More</a>
                                    </div>
                                    <div class="comment_blog">
                                        <a class="cnt_cmt" href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( __( 'Comment on  %s Post', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><i class="fa fa-comment"></i>
                                            <?php
                                                global $wpdb;
                                                $postID = get_the_ID();
                                                $comments = $wpdb->get_row("SELECT comment_count as count FROM wp_posts WHERE ID = '$postID'");
                                                $commentcount = $comments->count;
                                                if($commentcount == 1): $commenttext = 'comment'; endif;
                                                if($commentcount > 1 || $commentcount == 0): $commenttext = ''; endif;
                                                $fulltitle = '&nbsp;'.$commentcount;
                                                echo $fulltitle;
                                            ?>
                                        </a>
                                    </div>
                                    </div>
                            </article>
                        <?php endforeach; ?>
                        <!-- then the pagination links -->
                        <div class="navigation paging-navigation clearfix">
                            <div class="pagination">
                                <?php
                                    $big = 999999999; // need an unlikely integer	
                                    echo paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?paged=%#%',
                                    'current' => max( 1, get_query_var('paged') ),
                                    'total' => $wp_query->max_num_pages
                                    ) );
                                ?>
                            </div>
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12 sidebar_blog no-padding">
               <?php get_sidebar('blog'); ?>
            </div>   
        </article>
      
    </div>
</section>
<?php get_footer(); ?>
