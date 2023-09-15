<?php 
/*
 * Page Template File.
 */
get_header(); ?>

<section>
	<?php if ( have_posts() ) : ?>
	 <?php while ( have_posts() ) : the_post(); ?>	 
		  <div class="container webpage-container inner-content normal_content">
				<div class="header_line col-md-12 no-padding">
							 <h1 class="home_ttl upper clearfix home_back_img woo_ttl"><?php the_title(); ?></h1>
                             <div class="breadcrumb site-breadcumb"><?php if (function_exists('custom_custom_breadcrumbs')) custom_custom_breadcrumbs(); ?></div>							 
				</div>
			   <div class="content-section cont_bot">	
					<?php the_content(); ?>
				</div>    
		  </div>	 
	 <?php endwhile; ?>
	   <?php endif; ?>
</section>
<?php get_footer(); ?>
