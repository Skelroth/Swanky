<?php get_header(); ?>


	<?php
	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}?>
	
	
	<!--Content-->
	<div id="main">
		
		<div id="tagline">
			<h3><?php the_title(); ?></h3>
		</div>
		
			
		<!--Breadcrumbs-->
		<div id="breadcrumbs">
			<?php if (is_page() && !is_front_page()) {
			   echo '<a href="'.get_bloginfo('url').'">Home</a>';
			   $post_ancestors = get_post_ancestors($post);
			   if ($post_ancestors) {
			      $post_ancestors = array_reverse($post_ancestors);
			      foreach ($post_ancestors as $crumb)
			          echo ' - <a href="'.get_permalink($crumb).'">'.get_the_title($crumb).'</a>';
			   }
			   echo ' - '.get_the_title().' ';
			   }
			?>
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
		</div>
		
	</div>

<?php get_footer(); ?>