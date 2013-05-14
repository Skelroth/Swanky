<?php 
$themename = "Smallfolio";
$shortname = "bmb";
$options = array (
array( "name" => "General Settings",
	"type" => "sub-title"),
array( "name" => "Color Scheme",
	"desc" => "Select the Color Scheme you would like to use",
	"id" => $shortname."_style_sheet",
	"type" => "select",
	"options" => array("Green", "Blue", "Red", "Orange", "Gray"), 
	"std" => "Green"),
array( "name" => "Background",
	"desc" => "Select the Background you would like to use",
	"id" => $shortname."_style_bg",
	"type" => "select",
	"options" => array("Grunge", "Wood", "Metall", "Stripes", "Industrial 1", "Industrial 2", "Dotted", "Armor"), 
	"std" => "Grunge"),	
array( "name" => "Portfolio ID",
	"desc" => "Type here the ID of your Portfolio Category",
	"id" => $shortname."_portfolio_id",
	"type" => "text",
	"std" => "x"),
array( "name" => "Main Page Settings",
	"type" => "sub-title"),
array( "name" => "Showcase Slider",
	"desc" => "Select the Showcase Slider for the Mainpage",
	"id" => $shortname."_slider",
	"type" => "select",
	"options" => array("Nivo Slider", "Coin Slider"), 
	"std" => "Nivo Slider"),
array( "name" => "Tagline",
	"desc" => "Type here the tagline for Mainpage",
	"id" => $shortname."_tagline",
	"type" => "textarea",
	"std" => "Change this text from admin - appearance - smallfolio options"),	
array( "name" => "Footer Settings",
	"type" => "sub-title"),
array( "name" => "Footer text",
	"desc" => "Type here your footer text (copyright for example)",
	"id" => $shortname."_footer_text_l",
	"type" => "textarea",
	"std" => "&copy; 2010 Smallfolio - Wordpress Theme"),
array(  "name" => "Disable Twitter Icon?",
        "desc" => "Check this box if you would like to DISABLE the Twitter Icon.",
        "id" => $shortname."_twitter_disable",
        "type" => "checkbox",
        "std" => "false"),
array(  "name" => "Disable Facebook Icon?",
        "desc" => "Check this box if you would like to DISABLE the Facebook Icon.",
        "id" => $shortname."_facebook_disable",
        "type" => "checkbox",
        "std" => "false"),
array(  "name" => "Disable RSS Icon?",
        "desc" => "Check this box if you would like to DISABLE the RSS Icon.",
        "id" => $shortname."_rss_disable",
        "type" => "checkbox",
        "std" => "false"),	        	        	
array( "name" => "Twitter name",
	"desc" => "Type here your Twitter account name",
	"id" => $shortname."_twitter",
	"type" => "text",
	"std" => "Twitter_name"),	
array( "name" => "Facebook name",
	"desc" => "Type here your Facebook account name",
	"id" => $shortname."_facebook",
	"type" => "text",
	"std" => "Facebook_name"),		
);
?>
<?php
function mytheme_add_admin() {
global $themename, $shortname, $options;
if ( $_GET['page'] == basename(__FILE__) ) {
if ( 'save' == $_REQUEST['action'] ) {
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
header("Location: themes.php?page=functions.php&saved=true");
die;
} else if( 'reset' == $_REQUEST['action'] ) {
foreach ($options as $value) {
delete_option( $value['id'] ); }
header("Location: themes.php?page=functions.php&reset=true");
die;
}
}
add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
function mytheme_admin() {
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
<div class="wrap">
<h2><?php echo $themename; ?> Settings</h2>
<form method="post">
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
case "open":
?>
<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">
<?php break;
case "close":
?>
</table><br />
<?php break;
case "title":
?>
<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
<td valign="top" colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
</tr>
<!--custom-->
<?php break; 
case "sub-title":
?>
<h3 style="margin-top:40px; font-size:18px"><?php echo $value['name']; ?></h3> 
<!--end-of-custom-->
<?php
break;
case 'select':
?>
<tr>
<td>
<table style="margin-bottom:20px">
<tr>
<td valign="top" width="110"><strong><?php echo $value['name']; ?></strong></td>
<td><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
<td valign="top">&nbsp;<small><?php echo $value['desc']; ?></small></td>
</tr>
</table>
</td>
</tr>
<?php break;
case 'text':
?>
<tr>
<td>
<table style="margin-bottom:20px">
<tr>
<td valign="top" width="110"><strong><?php echo $value['name']; ?></strong></td>
<td><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo $value['std']; } ?>" /></td>
<td valign="top">&nbsp;<small><?php echo $value['desc']; ?></small></td>
</tr>
</table>
</td>
</tr>
<?php
break;
case 'textarea':
?>
<tr>
<td>
<table style="margin-bottom:20px">
<tr>
<td valign="top" width="110"><strong><?php echo $value['name']; ?></strong></td>
<td><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo $value['std']; } ?></textarea></td>
<td valign="top">&nbsp;<small><?php echo $value['desc']; ?></small></td>
</tr>
</table>
</td>
</tr>
<?php
break;

case "checkbox":
?>
<tr>
<td>
<table style="margin-bottom:20px">
<tr>
<td valign="top" width="110"><strong><?php echo $value['name']; ?></strong></td>
<td><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
            <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
</td>
<td><small><?php echo $value['desc']; ?></small></td>
</tr>
</table>
</td>
</tr>
<?php break;
}
}
?>
<p class="submit">
<input class="button-primary" name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input class="button-primary" name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<img src="http://bloglinez.com/909.jpg">
<?php
}
add_action('admin_menu', 'mytheme_add_admin');




if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Sidebar',
'before_widget' => '',
'after_widget' => '<br/><br/>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Mainpage left',
'before_widget' => '',
'after_widget' => '<br/><br/>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Mainpage middle',
'before_widget' => '',
'after_widget' => '<br/><br/>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Mainpage Right',
'before_widget' => '',
'after_widget' => '<br/><br/>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));






add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(150, 100, true);




if ( function_exists('register_nav_menus') )

register_nav_menus( array(
	'primary' => __( 'Primary Navigation' ),
) );

function my_wp_nav_menu_args( $args = '' )
{
	$args['container'] = false;
	return $args;
} 

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );



function display_home() {
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







function custom_comment($comment, $args, $depth) {  
$GLOBALS['comment'] = $comment; ?>  
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID( ); ?>">  
<div id="comment-<?php comment_ID( ); ?>" class="vcard">  
<b><?php comment_author_link() ?></b>:  
<?php if ($comment->comment_approved == '0') : ?>  
<span class="waitmoderation"><small>Your comment is awaiting moderation.</small></span>  
<?php endif; ?>
 <?php comment_text() ?>
 <small class="commentmetadata">  
 <?php comment_date('d.m.Y') ?>, <?php comment_time() ?> <?php if (function_exists('comment_subscription_status')) { if (comment_subscription_status()) { echo '<small>(subscribed to comments)</small>'; } } ?> <?php edit_comment_link('Edit','| ',''); ?></small>  
<?php echo comment_reply_link(array('before' => '<div class="reply">', 'after' => '</div>', 'reply_text' => 'Reply', 'depth' => $depth, 'max_depth' => $args['max_depth'] ));  ?>  
</div>  
<?php } ?>