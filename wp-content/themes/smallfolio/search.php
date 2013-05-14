<?php get_header(); ?>

	
	<!--Content-->
	<div id="main">
	
		<div id="tagline">
			<h3>Search results</h3>
		</div>
		
		
		<!--Content left part-->
		<div id="left_sidebar">
			<?php get_sidebar(); ?>
		</div>
		
		
		<!--Content right part-->
		<div id="content_blog">
			
			
			<div id="blog_items">
				<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				
					<div class="blog_item">
							<h3><a href="<?php the_permalink() ?>" rel="bookmark"  class="myclass typeface-js" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							  <?php the_excerpt() ?>
					</div>
				
				<?php endwhile; ?>
				<br/>
				<div id="footer_nav"><?php posts_nav_link(' &nbsp;&nbsp;&nbsp;&nbsp; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?></div>
				
				<?php else : ?>
				<div id="content_2">
					Nothing found.
				</div>	
				<?php endif; ?>
				</div>
			
			</div>
												
		</div>

<?php get_footer(); ?>