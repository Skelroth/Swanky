<?php
global $options;
foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}?>


<?php get_header(); ?>
<div id="main">
	
	
	<div id="showcase">
	
	
	<?php switch ($bmb_slider) {
	case  "Nivo Slider":?>
		
		<!--Nivo Slider-->
			
		<div id="slider">
			<?php
			query_posts('showposts=20');
			if (have_posts()) : while (have_posts()) : the_post();
			$showcase_image = get_post_meta($post->ID, 'indexpic', $single = true);
			if (!empty($showcase_image)) {
			?>
			<img src="<?php echo $showcase_image; ?>" class="sliderimg" alt="" />
			<?php } ?>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
	
	
	
		<?php break; ?>	
		<?php case "Coin Slider":?>
		
		<!--Coin Slider-->
		
		<div id="coin-slider">
			<?php
			query_posts('showposts=20');
			if (have_posts()) : while (have_posts()) : the_post();
			$showcase_image = get_post_meta($post->ID, 'indexpic', $single = true);
			if (!empty($showcase_image)) {
			?>
			<img src="<?php echo $showcase_image; ?>" class="sliderimg" alt="" />
			<?php } ?>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>
				
		<?php break; ?>
		<?php }?>
	
	</div>
	
	
	<!--Tagline-->
	
	<div id="tagline">
		<h4><?php echo stripslashes($bmb_tagline);?></h4>
	</div>
	
	
	<!--3 Columns-->
	
	<div id="index_articles">
		<ul>
			<li>
			
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar("Mainpage Left") ) : else : ?>
			Widget "Mainpage left" goes here
			<?php endif; ?>
			</li>
			
			
			<li>
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar("Mainpage Middle") ) : else : ?>
			Widget "Mainpage middle" goes here
			<?php endif; ?>
			</li>
			
			
			<li class="right">
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar("Mainpage Right") ) : else : ?>
			Widget "Mainpage right" goes here
			<?php endif; ?>
			
			
			</li>
		</ul>
	</div>

	
</div>

<?php get_footer(); ?>