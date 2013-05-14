<?php get_header(); ?>

	<!--Theme options script-->
	<?php
	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}?>
	
	<!--Content-->
	<div id="main">
	
		<!--Title-->
		<div id="tagline">
			<h3>Page not found (404 error)</h3>
		</div>
		
		
		<!--Content right part-->
		<div id="left_sidebar">
			<?php get_sidebar(); ?>
		</div>
		
		
		<!--Content left part-->
		<div id="content">
			<h3>The page you are looking for can not be found.</h3>
			Please try one of the main navigation links.
		</div>
		
		
		<!--Clearboth for IE-->
		<div id="clearboth"></div>
													
	</div>

<?php get_footer(); ?>