<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" /> 
	
	<!--CSS Main-->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<?php
	global $options;
	foreach ($options as $value) {
		if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
	}?>
	
	
	
	<!--CSS Color Scheme-->
	<?php switch ($bmb_style_sheet) {
		 case "Green":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/green.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Blue":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/blue.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Red":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/red.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Orange":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/orange.css" type="text/css" media="screen" />	
	<?php break; ?>	
	<?php case "Gray":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/gray.css" type="text/css" media="screen" />	
	<?php break; ?>	
	<?php }?>


	<!--CSS Background-->
	<?php switch ($bmb_style_bg) {
		 case "Grunge":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/grunge/styles.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Wood":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/wood/styles.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Metall":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/metall/styles.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Stripes":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/stripes/styles.css" type="text/css" media="screen" />	
	<?php break; ?>	
	<?php case "Industrial 1":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/industrial1/styles.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Industrial 2":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/industrial2/styles.css" type="text/css" media="screen" />
	<?php break; ?>	
	<?php case "Dotted":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/dotted/styles.css" type="text/css" media="screen" />	
	<?php break; ?>	
	<?php case "Armor":?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/backgrounds/armor/styles.css" type="text/css" media="screen" />	
	<?php break; ?>	
	<?php }?>	
	
	
	<!--JQuery-->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery/jquery-1.4.2.min.js"></script>
	
		
	
	<!--Navigation scripts-->		 
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/superfish/superfish.js"></script>
	<script type="text/javascript">
			jQuery(function(){
			jQuery('ul.sf-menu').superfish();
			});
	</script>



	<script src="<?php bloginfo('template_directory'); ?>/js/fonts/cufon-yui.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/fonts/Bebas_400.font.js" type="text/javascript"></script>
	<script type="text/javascript">
		Cufon.replace('h1, h2, h3, h4');
	</script>
			
	
	
	<?php if ((!is_page()))  { ?>
	<!--Portfolio scripts-->			
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox-1.2.6.pack.js"></script>
	<script type="text/javascript">
			$(document).ready(function() {
				$("a.zoom2").fancybox({
					'overlayColor'		:	'#000'
				});
			});
	</script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/zoom/zoom.css" media="screen" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/zoom/zoom.js"></script>
	<?php } ?>
	
	
	<?php if (is_page_template('contact.php') ) { ?>
	<!--Contact form scripts-->	
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/contact/contact.js"></script>
	<?php } ?>
	
	
	
	<?php if (is_home() ) { ?>
		<!--Slider-->
		
		
		<?php switch ($bmb_slider) {
			 case "Nivo Slider":?>
			
			
				<!--Nivo Slider-->
				<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/sliders/nivoslider/nivo-slider.css" type="text/css" media="screen" />
				<script src="<?php bloginfo('template_directory'); ?>/js/sliders/nivoslider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
			<script type="text/javascript">
			$(window).load(function() {
				$('#slider').nivoSlider({directionNav:true});
			});
			</script>
				
			
		<?php break; ?>	
		<?php case "Coin Slider":?>	
				
				<!--Coin Slider-->
				<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/sliders/coin-slider/coin-slider.js"></script>
				<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/sliders/coin-slider/coin-slider-styles.css" type="text/css" />
				<script type="text/javascript">
					$(document).ready(function() {
						$('#coin-slider').coinslider({ width: 966, height: 260, navigation: true, delay: 3000 });
					});
				</script>
				
		<?php break; ?>
		<?php }?>
		
		<?php } ?>
		
<?php wp_head(); ?> 
</head>
<body>


	<div id="wrap">
		
	<!--Header-->
	<div id="header">
		
		
		<!--Logo-->
		<?php
		if (!is_home()): ?>
		<a href="<?php echo get_option('home'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" class="logo" alt="" /></a>
		<?php else : ?>
		<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" class="logo" alt="" />
		<?php endif ?>
		
	
		
		<!--Menu-->
		<?php if (function_exists('wp_nav_menu')) 
		
		{ wp_nav_menu( array(
			'menu_class' => 'sf-menu typeface-js',
			'fallback_cb' => 'display_home',
			'before' => '<h4>',
			'after'  => '</h4>'
		) ); } 
		
		else 
		
		{ 
		echo '<ul class="sf-menu typeface-js">';
			if(is_home()) { 
			echo '<li class="current_page_item"><h4><a href="'.get_bloginfo('url').'">Home</a></h4></li>'; }
			else {
			echo '<li><h4><a href="'.get_bloginfo('url').'">Home</a></h4></li>';
			}
				$my_pages = wp_list_pages('echo=0&title_li=');
			    $var1 = '<a';
			    $var2 = '<h4><a';
			    $var3 = '</a';
			    $var4 = '</a></h4';
			    $my_pages = str_replace($var1, $var2, $my_pages);
			    $my_pages = str_replace($var3, $var4, $my_pages);
			    echo $my_pages;
		
				
				$my_cats = wp_list_categories('echo=0&title_li=');
				$var5 = '<a';
				$var6 = '<h4><a';
				$var7 = '</a';
				$var8 = '</a></h4';
				$my_cats = str_replace($var5, $var6, $my_cats);
				$my_cats = str_replace($var7, $var8, $my_cats);
				echo $my_cats;
			
			echo '</ul>'; 
		 }
		 
		?>
		
		
		
	</div>