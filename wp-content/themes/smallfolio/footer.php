<?php
global $options;
foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
}
?>

		<!--Footer-->
		<div id="footer">
			
			<div id="socials">
				<ul>
					
					<?php
					if ($bmb_twitter_disable == "false") { ?>
					<li><a href="https://twitter.com/<?php echo stripslashes($bmb_twitter);?>" title="Twitter"><img src="<?php bloginfo('template_directory'); ?>/images/ic_twitter.png" alt="" /></a></li>
					<?php } ?>
					
					
					<?php
					if ($bmb_facebook_disable == "false") { ?>
					<li><a href="https://facebook.com/<?php echo stripslashes($bmb_facebook);?>" title="Facebook"><img src="<?php bloginfo('template_directory'); ?>/images/ic_face.png" alt="" /></a></li>
					<?php } ?>
					
					
					<?php
					if ($bmb_rss_disable == "false") { ?>
					<li><a href="<?php bloginfo('rss_url'); ?>" title ="RSS"><img src="<?php bloginfo('template_directory'); ?>/images/ic_rss.png" alt="" /></a></li>
					<?php } ?>
					
				</ul>	
			</div>
			
			<?php echo stripslashes($bmb_footer_text_l);?>
			
		</div>
		<!--End Footer-->
	
	</div>

<?php wp_footer(); ?>
	
</body>
</html>