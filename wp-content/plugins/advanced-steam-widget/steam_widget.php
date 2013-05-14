<?php
/*Plugin Name: Advanced Steam Widget
Plugin URI: http://www.SnakeByteStudios.com/projects/apps/advanced-steam-widget/
Description: Displays Steam gaming statistics in a widget
Version: 1.0.1
Author: Snake
Author URI: http://www.SnakeByteStudios.com
*/

class AdvancedSteamWidget extends WP_Widget {
	//these are the widget-wide default settings
	private $default_settings = array(
		"title" => "Currently Playing", 
		"game_template" => '
<div class="steam-widget-game">
	<a href="%GAME_URL%"><img class="steam-widget-game-icon" src="%GAME_ICON%" /></a>
	<div class="steam-widget-game-name"><a href="%GAME_URL%" title="%GAME_NAME%">%GAME_NAME%</a></div>
	<div class="steam-widget-game-time">%GAME_HOURS_TWOWEEKS% hrs / two weeks</div>
</div>
', 
		"template" => '
<style>
.steam-widget-game {
	clear: both;
	margin-bottom: 12px;
}
.steam-widget div:nth-last-child(2) {
    margin-bottom: 0px;
}
.steam-widget-game-icon {
	border: 4px solid #CCCCCC;
	float: left;
	margin-right: 6px;
	border-radius: 2px;
}
.steam-widget-game-name, .steam-widget-game-time {
	margin: 0;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}
</style>
%GAMES_TWOWEEKS%
<div style="clear:both"></div>
', 
		"steam_id" => "", 
		"cache_interval" => 900
	);

	//constructor
	function AdvancedSteamWidget() {
		$widget_ops = array('classname' => 'advanced_steam_widget', 'description' => "Displays Steam gaming statistics");
        parent::WP_Widget(false, $name = 'Steam Widget', $widget_ops);
    }
	
	//overrides parent function
	function widget($args, $instance) {
		extract($args);
		
		//see if we can use the cache or it's time to regenerate
		if ((isset($instance["cache"])) && (is_array($instance["cache"])) && (($instance["last_cached"] + $instance["cache_interval"]) > time())) {
			$steam_array = $instance["cache"];
			print "<!-- Advanced Steam Widget using cache -->";
		} else { //if we did not successfully use the cache, then regenerate
			//see if there's any id input
			$steam_id = empty($instance['steam_id']) ? 'slserpent' : $instance['steam_id'];
			
			//decide whether we're using old or new style profile url
			if (preg_match('/\A\d{17}\Z/', $steam_id)) {
				$xml_url = 'http://steamcommunity.com/profiles/' . $steam_id . '?xml=1';
			} else {
				$xml_url = 'http://steamcommunity.com/id/' . $steam_id . '?xml=1';
			}
			
			//first, make sure we have good XML from Valve
			if (($steam_xml = $this->get_xml_from_steam($xml_url)) === false) {
				//there was an error, so fallback to cache if available
				if ((isset($instance["cache"])) && (is_array($instance["cache"]))) {
					$steam_array = $instance["cache"];
					print "<!-- Steam XML failed. Advanced Steam Widget using cache -->";
				} else return;
			} else {
				//parse out some values so they're easier to store / use
				$steam_array = array();
				$steam_array['username'] = (string)$steam_xml->steamID;
				$steam_array['ID64'] = (string)$steam_xml->steamID64;
				$steam_array['avatar']['icon'] = (string)$steam_xml->avatarIcon;
				$steam_array['avatar']['medium'] = (string)$steam_xml->avatarMedium;
				$steam_array['avatar']['large'] = (string)$steam_xml->avatarFull;
				$steam_array['hours_twoweeks'] = (string)$steam_xml->hoursPlayed2Wk;
				
				if (count($steam_xml->mostPlayedGames->mostPlayedGame) > 0) {
					$k = 0;
					foreach ($steam_xml->mostPlayedGames->mostPlayedGame as $game) {
						if (strlen($game->gameName) < 1) continue;
						$steam_array['games'][$k]['name'] = (string)$game->gameName;
						$steam_array['games'][$k]['url'] = (string)$game->gameLink;
						$steam_array['games'][$k]['icon'] = (string)$game->gameIcon;
						$steam_array['games'][$k]['logo']['small'] = (string)$game->gameLogoSmall;
						$steam_array['games'][$k]['logo']['large'] = (string)$game->gameLogo;
						$steam_array['games'][$k]['hours_total'] = (string)$game->hoursOnRecord;
						$steam_array['games'][$k]['hours_twoweeks'] = (string)$game->hoursPlayed;
						//get game stats? $game->statsName
						$k++;
					}
				}
				
				//write the cache and reset timestamp
				$this->internal_update(array("cache" => $steam_array, "last_cached" => time()));
			}
		}
		
		//print the widget title before we get going
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		print $before_widget;
		if (!empty($title)) print $before_title . $title . $after_title;
		
		print '<div class="steam-widget">' . "\n";
		
		//replace template patterns with steam data
		if (count($steam_array['games']) > 0) {
			foreach ($steam_array['games'] as $game) {
				$game_output_tmp = $instance["game_template"];
				$game_output_tmp = str_ireplace("%GAME_NAME%", $game['name'], $game_output_tmp);
				$game_output_tmp = str_ireplace("%GAME_URL%", $game['url'], $game_output_tmp);
				$game_output_tmp = str_ireplace("%GAME_ICON%", $game['icon'], $game_output_tmp);
				$game_output_tmp = str_ireplace("%GAME_LOGO_SMALL%", $game['logo']['small'], $game_output_tmp);
				$game_output_tmp = str_ireplace("%GAME_LOGO%", $game['logo']['large'], $game_output_tmp);
				$game_output_tmp = str_ireplace("%GAME_HOURS_TWOWEEKS%", $game['hours_twoweeks'], $game_output_tmp);
				$game_output_tmp = str_ireplace("%GAME_HOURS_TOTAL%", $game['hours_total'], $game_output_tmp);
				$game_output .= $game_output_tmp;
			}
		} else $game_output = "No Steam games played recently";
		$output = $instance["template"];
		$output = str_ireplace("%GAMES_TWOWEEKS%", $game_output, $output);
		$output = str_ireplace("%USERNAME%", $steam_array['username'], $output);
		$output = str_ireplace("%ID64%", $steam_array['ID64'], $output);
		$output = str_ireplace("%AVATAR_ICON%", $steam_array['avatar']['icon'], $output);
		$output = str_ireplace("%AVATAR_MEDIUM%", $steam_array['avatar']['medium'], $output);
		$output = str_ireplace("%AVATAR_LARGE%", $steam_array['avatar']['large'], $output);
		$output = str_ireplace("%HOURS_TWOWEEKS%", $steam_array['hours_twoweeks'], $output);
		
		print $output;
		
		print "</div>\n";
		print $after_widget;
	}
	
	//overrides parent function
	//shows the widget settings fields in the widget editor page
	function form($instance) {
		$instance = wp_parse_args((array) $instance, $this->default_settings);
		$title = strip_tags($instance['title']);
		$game_template = format_to_edit($instance['game_template']);
		$template = format_to_edit($instance['template']);
		$steam_id = esc_attr($instance['steam_id']);
		$cache_interval = $instance['cache_interval'];
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('steam_id'); ?>"><?php _e('Steam ID:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('steam_id'); ?>" name="<?php echo $this->get_field_name('steam_id'); ?>" type="text" value="<?php echo $steam_id; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('cache_interval'); ?>"><?php _e('Cache Interval (sec):'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('cache_interval'); ?>" name="<?php echo $this->get_field_name('cache_interval'); ?>" type="text" value="<?php echo $cache_interval; ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('game_template'); ?>"><?php _e('Game Template:'); ?></label> 
			<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('game_template'); ?>" name="<?php echo $this->get_field_name('game_template'); ?>"><?php echo $game_template; ?></textarea>
		</p>
		<div><a href="javascript:void(0)" onclick="document.getElementById('<?php echo $this->get_field_id('game_template'); ?>-patterns').style.display = 'block'; this.style.display = 'none';">Show Patterns</a></div>
		<div id="<?php echo $this->get_field_id('game_template'); ?>-patterns" style="display: none;">
		%GAME_NAME%<br />
		%GAME_URL%<br />
		%GAME_ICON%<br />
		%GAME_LOGO_SMALL%<br />
		%GAME_LOGO%<br />
		%GAME_HOURS_TWOWEEKS%<br />
		%GAME_HOURS_TOTAL%<br />
		</div>
		<p style="margin-top: 1em;"><label for="<?php echo $this->get_field_id('template'); ?>"><?php _e('Main Template:'); ?></label> 
			<textarea class="widefat" rows="8" cols="20" id="<?php echo $this->get_field_id('template'); ?>" name="<?php echo $this->get_field_name('template'); ?>"><?php echo $template; ?></textarea>
		</p>
		<div><a href="javascript:void(0)" onclick="document.getElementById('<?php echo $this->get_field_id('template'); ?>-patterns').style.display = 'block'; this.style.display = 'none';">Show Patterns</a></div>
		<div id="<?php echo $this->get_field_id('template'); ?>-patterns" style="display: none;">
		%GAMES_TWOWEEKS%<br />
		%HOURS_TWOWEEKS%<br />
		%USERNAME%<br />
		%ID64%<br />
		%AVATAR_ICON%<br />
		%AVATAR_MEDIUM%<br />
		%AVATAR_LARGE%<br />
		</div>

		<?php
	}
	
	//overrides parent function
	//saves settings for this widget's instance
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		if (isset($new_instance['title'])) $instance['title'] = empty($new_instance['title']) ? $this->default_settings['title'] : strip_tags($new_instance['title']);
		if (isset($new_instance['steam_id'])) $instance['steam_id'] = $new_instance['steam_id'];
		if (!empty($new_instance['cache_interval'])) $instance['cache_interval'] = $this->get_int_option($new_instance['cache_interval'], $this->default_settings['cache_interval'], 0, 86400);
		if (isset($new_instance['game_template'])) $instance['game_template'] = empty($new_instance['game_template']) ? $this->default_settings['game_template'] : $new_instance['game_template'];
		if (isset($new_instance['template'])) $instance['template'] = empty($new_instance['template']) ? $this->default_settings['template'] : $new_instance['template'];
		
		if (isset($new_instance['last_cached'])) $instance['last_cached'] = $new_instance['last_cached'];
		if (isset($new_instance['cache'])) $instance['cache'] = $new_instance['cache'];

		return $instance;
	}
	
	//new function to save this instance's data when not in widget editor
	private function internal_update($instance) {
		//get all instances of this widget
		$all_instances = $this->get_settings();
		
		//get our current instance
		$old_instance = isset($all_instances[$this->number]) ? $all_instances[$this->number] : array();
		
		//call the overriding update function on this instance
		$instance = $this->update($instance, $old_instance);

		//if we got something back, plug it back into the array of all instances
		if ($instance !== false) $all_instances[$this->number] = $instance;

		//and save all instances of this widget
		$this->save_settings($all_instances);
	}
	
	private function get_int_option($request_opt, $default_opt = 0, $min_val = NULL, $max_val = NULL) {
		if ((isset($request_opt)) && (is_numeric($request_opt))) {
			if ((!is_null($min_val)) && ($request_opt < $min_val)) return $min_val;
			if ((!is_null($max_val)) && ($request_opt > $max_val)) return $max_val;
			return $request_opt;
		} else {
			return $default_opt;
		}
	}
	
	private function get_xml_from_steam($xml_url) {
		//prefer curl, so we can set a timeout
		if (function_exists("curl_init")) {
			$ch = curl_init($xml_url);
		    curl_setopt_array($ch, array( 
		        CURLOPT_RETURNTRANSFER => true, 
		        CURLOPT_HEADER => false,
		        CURLOPT_FOLLOWLOCATION => true,
		        CURLOPT_ENCODING => "",
		        CURLOPT_AUTOREFERER => true,
		        CURLOPT_CONNECTTIMEOUT => 5,
		        CURLOPT_TIMEOUT => 5,
		        CURLOPT_MAXREDIRS => 2,
		        CURLOPT_SSL_VERIFYHOST => 0,
		        CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_FRESH_CONNECT => true
			));
		    $content = curl_exec($ch);
			$err = curl_errno($ch);
			curl_close($ch);
			
			//see if there were no errors
		    if ($err == 0) {
				if (($steam_xml = @simplexml_load_string($content)) === false) return false; else return $steam_xml;
			}
		}
		
		//fallback to simple xml remote open
		if (($steam_xml = @simplexml_load_file($xml_url)) === false) return false; else return $steam_xml;
	}
}

function AdvancedSteamWidget_register() {
	register_widget('AdvancedSteamWidget');
}
add_action( 'widgets_init', 'AdvancedSteamWidget_register' );