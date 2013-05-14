<?php get_header(); ?>


<!--Theme options script-->
<?php
global $options;
foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}?>




	<!--Content-->
	<div id="main">
	
	<div id="tagline">
		<h3 class="myclass typeface-js">
		<?php if (!have_posts()): ?>
		Page not found
		<?else: ?>
		<?php single_cat_title(); ?>
		<?php endif; ?>
		</h3>
	</div>
			

	
			
	
	<?php if (is_category($bmb_portfolio_id) || in_category($bmb_portfolio_id))  { ?>
	<!--If Portfolio page-->
			
		<!--Portfolio series-->
		<div id="content_portfolio">
		
			<ul class="gallery">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
				<li class="zoom">
					<div><a href="<?php echo get_post_meta($post->ID, "port_big", true);?>" class="thumb zoom2" rel="group"><img src="<?php echo get_post_meta($post->ID, "port_small", true);?>" alt="" /></a></div>
					<h2><?php the_title(); ?></h2>
				</li>
				<?php endwhile; else: ?>  
				
				<li>
					<h2>Woops...</h2>  
					<p>Sorry, no posts we're found.</p>  
				</li>
				
			<?php endif; ?>
			</ul>
			
			<div id="footer_nav"><?php posts_nav_link(' &nbsp;&nbsp;&nbsp;&nbsp; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?></div>
			
		</div>
			
		
			
		
	    <? } else { ?>
		
		<!--Content left part-->
		<div id="left_sidebar">
			<?php get_sidebar(); ?>
		</div>
		

		<!--Content right part-->
		<div id="content_blog">
			
			<!--Blog items-->
						<div id="blog_items">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<div class="blog_item">
									
								<?php if ( has_post_thumbnail() ) { ?>
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a>
								<?php } ?>
								
								
								<div class="blog_item_text">
									<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
									<div class="storycontent">
										<?php the_excerpt(); ?>
									</div>
			
									<div class="blog_meta">
										<?php the_time('F jS, Y') ?> | <?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
									</div>
								</div>
									
								<div class="clearboth"></div>
							</div>
						
							<?php comments_template(); // Get wp-comments.php template ?>
							<?php endwhile; else: ?>
							<p><?php _e('<h2>Sorry, no posts matched your criteria</h2>You might try to use our Site search <br>or try to browse the site with the main navigation menu'); ?></p>
							<?php endif; ?>
							<br />
							<div id="footer_nav"><?php posts_nav_link(' &nbsp;&nbsp;&nbsp;&nbsp; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?></div>
						</div>
			
				
		</div>
		
		
		<!--Clearboth for IE-->
		<div id="clearboth"></div>
				
		<?php } ?>
			
	</div>
	<!--End Content-->

<?php get_footer(); ?>