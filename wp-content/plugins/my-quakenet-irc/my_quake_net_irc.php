<?php
/*
Plugin Name: My QuakeNet IRC
Plugin URI: http://kwark.allwebtuts.net
Description:  My QuakeNet IRC chat plugin for Wordpress. Add multiple zones for your QuakeNet IRC chat in posts or pages.
Author: Laurent (KwarK) Bertrand
Version: 1.0.3
Author URI: http://kwark.allwebtuts.net
*/

/*  
	Copyright 2011  Laurent (KwarK) Bertrand  (email : kwark@allwebtuts.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// disallow direct access to file
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	wp_die(__('Sorry, but you cannot access this page directly.', 'livetv'));
}

$irc_dir = dirname( plugin_basename( __FILE__ ) );

// Enable internationalisation
load_plugin_textdomain( 'kw-irc', true, $irc_dir . '/langue/' );


//Create menu
add_action('admin_menu', 'kw_irc_menu');

function kw_irc_menu()
{
	add_menu_page('QuakeNet IRC', 'QuakeNet IRC', 'manage_options', 'my_quake_net_irc.php');
	add_submenu_page('my_quake_net_irc.php', 'QuakeNet IRC', __('QuakeNet IRC', 'kw-irc'), 'manage_options', 'my_quake_net_irc.php', 'kw_do_page_irc_options');
}


//Enqueue & register frontend script/css
if(!is_admin())
{
	wp_register_script( 'statement', plugins_url('js/statement.js', __FILE__));
	wp_register_style( 'style', plugins_url('css/style.css', __FILE__));
	wp_enqueue_style( 'style', plugins_url('css/style.css', __FILE__));
	wp_enqueue_script( 'statement', plugins_url('js/statement.js', __FILE__));
}


// Enqueue admin css
if(is_admin())
{
    wp_register_style('irc_admin_css', plugins_url('css/admin.css', __FILE__));
    wp_enqueue_style('irc_admin_css');
}
	

//Multi function shortcode
add_shortcode( 'quake', 'irc_quakenet_shortcode' );
add_shortcode( 'quakenet', 'irc_quakenet_shortcode' ); //Deprecated

function irc_quakenet_shortcode( $atts, $content = null )
{
	extract( shortcode_atts( array(
	'channels' => get_option("new_irc"),
	'autofill' => get_option("irc_auto_fill_name"),
	'prompt' => get_option("irc_prompt_connect"),
	'width' => '600',
	'height' => '400',
	'message' => '',
	'status' => 'public',
	'button' => 'no'
	), $atts ) );
	  
	$channels = trim($channels);
	$width = trim($width);
	$height = trim($height);
	$status = trim($status);
	$message = trim($message);
	$button = trim($button);
	$autofill = trim($autofill);
	$prompt = trim($prompt);

	if ($status == 'user only' && is_user_logged_in() || $status == 'public')
	{
		if(current_user_can('level_0'))
		{
			
			if($autofill == 'yes')
			{
				global $current_user;
				get_currentuserinfo();
				$username = '&nick='.$current_user->display_name.'';
			}
			
			if($prompt == 'yes')
			{
				$prompt_connect = '&prompt=1';
			}
		}
		
		if($button == 'yes' || is_page('forum'))
		{
			$irc_pre = '<a style="font-size:11px;" href="javascript:visibilite(\'quake\');" title="Quakenet irc"><b>IRC</b></a>';
			$id = 'id="quake"';
			$hide = 'display:none;';
		}
		return ''.$irc_pre.'<div '.$id.' class="kwrap" style="width:'.$width.'px;height:'.$height.'px;'.$hide.'"><div class="kcontent" style="width:'.$width.'px;height:'.$height.'px"><iframe src="http://webchat.quakenet.org/?channels='.$channels.'&uio=d4'.$username.''.$prompt_connect.'" width="'.$width.'" height="'.$height.'"></iframe></div></div>';
	}
	else
	{
		return ''.$message.'';
	}
}


// Remove all settings on uninstall hook
function irc_page_delete_defaut_settings()
{
	global $wpdb;
	
	$settings = array(
		'kw_special_width3',
		'kw_special_width2',
		'kw_special_width1',
		'kw_use_shortcode_no_sidebar',
		'kw_use_shortcode',
		'kw_use_forum',
		'new_irc'
	);

	foreach ($settings as $v)
	{
		delete_option( ''.$v.'' );
	}
}
register_uninstall_hook(__FILE__, 'irc_page_delete_defaut_settings');


// Remove all settings on activation hook for deprecated options
function irc_page_del_defaut_settings()
{
	global $wpdb;
	
	$settings = array(
		'kw_special_width3',
		'kw_special_width2',
		'kw_special_width1',
		'kw_use_shortcode_no_sidebar',
		'kw_use_shortcode',
		'kw_use_forum'
	);

	foreach ($settings as $v)
	{
		delete_option( ''.$v.'' );
	}
	$new_irc = get_option("new_irc");
	
	if($new_irc)
	{
		//meta characters to escape # ! ^ $ ( ) [ ] { } ? + * . \ |
		$temp = preg_match('#(channels=)?([^&]+)#', $new_irc, $matches);
		
		if($temp)
		{
			$update = $matches[2];
			update_option('new_irc', ''.$update.'');
		}
	}
}
register_activation_hook(__FILE__, 'irc_page_del_defaut_settings');

/*update_option('new_irc', 'channels=votre-channel&uio=OT1');*/


//Admin page options
function kw_do_page_irc_options()
{
	if(isset($_POST['submitted'])&& $_POST['submitted'] == "yes")
	{
		update_option('new_irc', stripslashes($_POST['new_irc']));
		update_option('irc_auto_fill_name', stripslashes($_POST['irc_auto_fill_name']));
		update_option('irc_prompt_connect', stripslashes($_POST['irc_prompt_connect']));
		
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>"; _e("Option saved", "kw-irc" ); echo "</strong></p></div>";
	}
	?>
<div class="wrap">
<div id="theme-options-wrap">
  <div class="icon32" id="icon-tools"><br />
  </div>
  <h2>My QuakeNet irc</h2>
    <form method="post" name="kw_irc_admin">
      <p class="submit">
      <input type="submit" name="options_submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
    </p>
      <table class="widefat options" style="width: 650px">
      <th colspan="2" class="dashboard-widget-title"><?php _e("Main channel IRC configuration", "kw-irc" ) ?></th>
         <tr valign="top">
         <td scope="row"><label>
            <?php _e('channel Name', 'kw-irc'); ?>
          </label></td>
        <td  class="irc-admin-td"><input type="text" style="width:250px;"  maxlength="200" name="new_irc" value="<?php echo get_option("new_irc"); ?>" />
        <span class="irc_help" title="<?php _e("Choose the channelName of your choice for your main IRC channel. Shortcode to diplay in a page [quake] is sufficient", "kw-irc" ); ?>"></span><br />
          </td>
      </tr>
       <tr valign="top">
         <td scope="row"><label>
            <?php _e('AutoFill UserName', 'kw-irc'); ?>
          </label></td>
        <td  class="irc-admin-td"> <?php $temp = get_option('irc_auto_fill_name'); ?>
         <input type="radio" name="irc_auto_fill_name" id="irc_auto_fill_name" value="yes" <?php if($temp == 'yes'){echo 'checked="checked"';} ?> /> yes <input type="radio" name="irc_auto_fill_name" id="irc_auto_fill_name" value="no" <?php if($temp == 'no'){echo 'checked="checked"';} ?> /> no
        <span class="irc_help" title="<?php _e("Select yes to AutoFill the input UserName. Work only for connected user to your site and with the display_name from wordpress.", "kw-irc" ); ?>"></span><br />
          </td>
      </tr>
      <tr valign="top">
         <td scope="row"><label>
            <?php _e('Choice UserName', 'kw-irc'); ?>
          </label></td>
        <td  class="irc-admin-td"> <?php $temp = get_option('irc_prompt_connect'); ?>
          <input type="radio" name="irc_prompt_connect" id="irc_prompt_connect" value="yes" <?php if($temp == 'yes'){echo 'checked="checked"';} ?> /> yes <input type="radio" name="irc_prompt_connect" id="irc_prompt_connect" value="no" <?php if($temp == 'no'){echo 'checked="checked"';} ?> /> no
        <span class="irc_help" title="<?php _e("Leave the choice for connectedUser on your site to choose another nickname if AutoFill is enable.", "kw-irc" ); ?>"></span><br />
          </td>
      </tr>
       </table>
       <br />
       <table class="widefat options" style="width: 650px">
      <th colspan="2" class="dashboard-widget-title"><?php _e("Shortcode example", "kw-irc" ) ?></th>
         <tr valign="top">
         <td scope="row"><label>
            <?php _e('[quake]', 'kw-irc'); ?>
          </label></td>
        <td  class="irc-admin-td"><input type="text" style="width:250px;"  maxlength="250" name="shortcode_irc" disabled="disabled" value="[quake channels=&quot;channelName&quot;]" />
        <span class="irc_help" title="<?php _e('May take optional parameters width (expressed in pixel), height (expressed in pixel), status (may take parameters public or user only), message (your special message if status is defined on user only), button (may take parameters yes or no, button is the option to display a link show/hide for forum or other integration)', 'kw-irc' ); ?>"></span><br />
          </td>
      </tr>
       </table>
       <br />
       <table class="widefat options" style="width: 650px">
      <th colspan="2" class="dashboard-widget-title"><?php _e("Forum plugin example", "kw-irc" ) ?></th>
         <tr valign="top">
         <td scope="row"><label>
            <?php _e('code', 'kw-irc'); ?>
          </label></td>
        <td  class="irc-admin-td"><input type="text" style="width:250px;" maxlength="250" name="shortcode_irc" disabled="disabled" value="<?php echo '&lt;?php echo do_shortcode(\'[quake channels=&quot;channelName&quot; width=&quot;600&quot; height=&quot;400&quot; status=&quot;user only&quot; message=&quot;Please connect to view our IRC&quot; button=&quot;yes&quot;]\'); ?&gt;'; ?>" />
        <span class="irc_help" title="<?php _e('Copy/past this part in your template file or php file to use one main irc on a forum plugin like simple press', 'kw-irc' ); ?>"></span><br />
          </td>
      </tr>
       </table>
     <p class="submit">
      <input name="submitted" type="hidden" value="yes" />
      <input type="submit" name="options_submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
    </p>
    </form>
</div>
</div>
<?php } //END Options page
?>