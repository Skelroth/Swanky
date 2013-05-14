<?php get_header(); ?>

	<!--Content-->
	<div id="main">
	
		<!--Title-->
		<div id="tagline">
			<h3>
			<?php
			$tit = the_title('','',FALSE);
			echo substr($tit, 0, 35);
			if (strlen($tit) > 35) echo " ...";
			?>
			</h3>
		</div>
		
		<!--Content left part-->
		<div id="left_sidebar">
			<?php get_sidebar(); ?>
		</div>

		<!--Content right part-->
		<div id="content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
			<?php endwhile; endif; ?>
			
			<div id="comments_wrap">
			<?php comments_template(); ?>
			</div>
			
		</div>
		

		<!--Clearboth for IE-->
		<div id="clearboth"></div>
		
	
	</div>
	
<?php get_footer(); ?>
<?php echo get_post_meta($post->ID, "Camera_Specs", true); ?>