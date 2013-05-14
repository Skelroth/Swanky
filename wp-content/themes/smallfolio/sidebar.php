<!--Subpages-->											
<?php
if((!$post->post_parent) AND (is_page())){
	$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
}else{
	if($post->ancestors)
	{
		$ancestors = end($post->ancestors);
		$children = wp_list_pages("title_li=&child_of=".$ancestors."&echo=0");
	}
}
if ($children) { ?>
	<h3></h3>
	<ul id="biglinks">
		<?php echo $children; ?>
	</ul><br/><br/>
<?php } ?>
					
					
<!--Widgets-->
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
<?php endif; ?>										

						
