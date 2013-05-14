<?php
/*
Plugin Name: Countdown Timer (ABT)
Plugin URI: http://www.atlanticbt.com/blog/countdown-timer-in-wordpress/
Description: Provides a simple countdown timer
Version: 0.7
Author: atlanticbt, zaus
Author URI: http://atlanticbt.com
License: GPL2
Changelog:
	0.7 bugfixes, singleton, hooks
	0.6 refactored for public consumption
	0.5 split plugin from BT
*/

/**
 * Plugin wrapper
 */
class ABT_Countdown_Timer {
	
	#region ------------- singleton -----------------
	
	private static $instance;
	
	private function __construct(){ }
	
	/**
	 * Singleton
	 */
	public function &singleton(){
		if( !isset(self::$instance) ) self::$instance = new self();
		
		return self::$instance;
	}
	
	#endregion ------------- singleton -----------------
	
	
	
	/**
	 * Plugin "namespace"
	 */
	const N = 'abt_countdown_timer';
	/**
	 * Plugin title
	 */
	const T = 'Countdown Timer';
	
	/**
	 * Static "cache" of default settings
	 */
	private $defaults;
	/**
	 * Static "cache" of default settings
	 */
	private $settings;
	
	/**
	 * Get internally "cached" default settings
	 */
	public function get_defaults(){
		if( !isset( $this->defaults )) {
			$this->defaults = array(
				'target_time' => date('Y-m-d H:i:s')
				//,'format' => '<div class="date"><span class="date-week">#weeks#</span> <span class="date-month">#mon#</span>#d-sep#<span class="date-day">#mday#</span>#d-sep#<span class="date-year">#year#</span></div> <div class="time"><span class="time-hour">#hours#</span>#t-sep#<span class="time-minutes">#minutes#</span>#t-sep#<span class="time-seconds">#seconds#</span></div>'
				,'format' => '<div class="date"><span class="date-month">{l(Months)}%m</span>#d-sep#<span class="date-day">{l(Days)}%d</span>#d-sep#<span class="date-year">{l(Years)}%y</span></div> <div class="time"><span class="time-hour">{l(Hours)}%H</span>#t-sep#<span class="time-minutes">{l(Minutes)}%M</span>#t-sep#<span class="time-seconds">{l(Seconds)}%S</span></div>'
				,'date_separator' => '<span class="d-sep">/</span>'
				,'time_separator' => '<span class="t-sep">:</span>'
				, 'label_format' => '<em>%s</em> '
				, 'timezone' => 'America/New_York'	//per http://php.net/manual/en/datetime.settimezone.php
				, 'complete_text' => 'It\'s Over!'
				/*
				,'title' => 'Countdown:'
				,'link' => ''
				*/
				// ...etc
			);
		}// if not defaults set
		
		return $this->defaults;
	}//--	fn	get_defaults
	
	/**
	 * Get internally "cached" plugin settings
	 */
	public function get_settings() {
		// get from admin settings
		if( ! $this->settings )
			$this->settings = get_option( $this->fieldkey('options') );
		
		return $this->settings;
	}//--	fn	get_settings
	
	/**
	 * Load settings, register hooks
	 */
	public function init(){
		// init hooks
		#add_action('init', array(&$this, '_init'));
			
		add_shortcode( 'countdown_timer', array(&$this, 'shortcode_handler') );
		
		add_action('admin_menu', array(&$this, 'add_pages'));
	}//--	fn	init
	
	
	/**
	 * Helper: get the difference between now and the target time, for a given timezone
	 * @param array $attributes the shortcode attribute array, to be extracted into the following...
	 * @param string $target_time
	 * @param string $timezone
	 * @param string $format
	 * 
	 * @return the formatted string
	 */
	private function format_delta($attributes){
		extract($attributes);
		
		//stupid < PHP 5.3.0
		if(!function_exists('date_diff')){
			$date1 = new DateTime($target_time, new DateTimeZone($timezone));
			$date2 = new DateTime('now', new DateTimeZone($timezone));
			$formatted_time = abt_dateDiff($date2->format('U'), $date1->format('U'), $format);
			//strtotime($target_time) instead of $date1->format('U')
		}
		else {
			//get differences
				//$target_time = getdate($target_time);
			$date1 = new DateTime($target_time, new DateTimeZone($timezone));
			$interval = $date1->diff(new DateTime('now', new DateTimeZone($timezone)));
			
			$formatted_time = $interval->format($format);
		}
	
		return $formatted_time;
	}//--	fn	format_delta
	
	function shortcode_handler( $attributes, $content=null, $code="" ) {
		
		// $attributes	::= array of attributes
		// $content ::= text within enclosing form of shortcode element
		// $code	::= the shortcode found, when == callback name
		// examples: [my-shortcode]
		//			[my-shortcode/]
		//			[my-shortcode foo='bar']
		//			[my-shortcode foo='bar'/]
		//			[my-shortcode]content[/my-shortcode]
		//			[my-shortcode foo='bar']content[/my-shortcode]
	
		//parse out options, merge with default attributes
		//$wp_abt_countdown_timer_defaults = wp_abt_countdown_timer_get_default_options();
		$attributes = shortcode_atts( $this->get_settings(), $attributes );
		
		return $this->render_countdown_timer( $attributes );
		/*
		if( $link ){
			return sprintf('<a href="%s" title="%s">%s</a>', $link, $title, $formatted_time);
		}
		
		return sprintf('<span class="countdown-title">%s</span> %s', $title, $formatted_time);
		*/
	}//--	fn	shortcode_handler
	
	/**
	 * Internal shortcode processing: actually gets the countdown timer
	 * @param array $attributes a list of attributes (as parsed from the shortcode); NOTE: you'll need to explicitly provide defaults
	 * 
	 * @return string the formatted time
	 */
	public function render_countdown_timer( $attributes ) {
		extract( $attributes );
	
		// ... do something with the $atts
		
		//format the format with separator and label_format replacements
		$attributes['original_format'] = $format;
		$format = str_replace(array('#d-sep#', '#t-sep#'), array($date_separator, $time_separator), $format);
		$format = preg_replace('/(\{l\()([\w\s]*)(\)\})/', sprintf($label_format, '$2'), $format);
		// fold the format back into attributes
		$attributes['format'] = $format; 
		
		// hook - adjust attributes used to render the countdown
		$attributes = apply_filters( $this->fieldkey('_pre_render'), $attributes );
		
		$formatted_time = $this->format_delta($attributes);
		
		//countdown over
		///TODO: check for output from date->diff
		if(!$formatted_time){
			$formatted_time = $complete_text;
		}
		
		// hook - add "before", "after"; alter rendered output
		$formatted_time = apply_filters( $this->fieldkey('_post_render'), $formatted_time, $attributes );
		
		return $formatted_time;
		
	}//--	fn	render_countdown_timer
	
	#region ------------------- Initialization and Activation Settings -----------------
	
	static function uninstall() {
		$instance = &ABT_Countdown_Timer::singleton();
		delete_option( $instance->fieldkey('options') );	//'wp_abt_countdown_timer_options'
	}
	static function activate() {
		$instance = &ABT_Countdown_Timer::singleton();
		$settings = $instance->get_settings();
		$defaults = $instance->get_defaults();
		
		$default_settings = wp_parse_args($settings, $defaults);
		add_option( $instance->fieldkey('options'), $default_settings );
	}
	
	#endregion ------------------- Initialization and Activation Settings -----------------


	#region ------------------- UI -----------------
	
	/**
	 * Create a namespaced key, for fields and slugs and stuff
	 * @param string $key the field/reference key
	 * @param string $separator {default: '_'} the separator between the namespace and key
	 * 
	 * @return string namespaced key
	 */
	public function fieldkey($key, $separator = '_'){
		return esc_attr( self::N . $separator . $key );
	}
	/**
	 * Create a namespaced field name
	 * @param string $key the field/reference key
	 * @param string $group the option name
	 * 	 * 
	 * @return string namespaced attr
	 */
	public function fieldname($key, $group){
		return $this->fieldkey("[$key]", '_' . $group);
	}//--	fn	fieldname
	
	/**
	 * Create a namespaced field id
	 * @param string $key the field/reference key
	 * @param string $group the option name
	 * 	 * 
	 * @return string namespaced attr
	 */
	public function fieldid($key, $group){
		return $this->fieldkey("-$key", '_' . $group);
	}//--	fn	fieldid
	
	/**
	 * Add Administrator Menus
	 */
	function add_pages() {
		add_menu_page(
			self::T										// page title
			, __('Countdown', self::N)					// menu title
			, 'manage_options'							// capabilities
			, $this->fieldkey('options')					// menu slug
			, array(&$this,'options_page')				// output callback
			, plugins_url('i_admin-icon.png', __FILE__)	// icon url
			);
		add_submenu_page(
			$this->fieldkey('options')					// parent slug
			, __('Help & Support', self::N)				// page title
			, __('Help & Support', self::N)				// menu title
			, 'edit_posts'								// capabilities
			, $this->fieldkey('help')					// menu slug
			, array(&$this,'help_page')					// output callback
			);
	}//--	fn	add_pages
	
	
		
	/**
	 * Callback - show help
	 */
	function help_page() {
		include dirname(__FILE__) . '/help.php';
	}//--	fn	help_page
		
	/**
	 * Callback - generate options page HTML, save
	 */
	function options_page(){
		$this->update_options_page();
		$options = get_option( $this->fieldkey('options') );
		
		include( dirname(__FILE__) . '/options.php' );
	}//--	fn	options_page
	
	/**
	 * Parse and save settings for options page
	 */
	private function update_options_page(){
		// did we even save anything?
		$key = $this->fieldkey('options');
		
		
		if( ! isset( $_POST[ $key ]) ) return;
		
		$input = &$_POST[ $key ];	//shorthand
		
		// don't save if not valid
		if( ! check_admin_referer( $key, $this->fieldkey('options_nonce') ) ) return;
		
		// don't save if not authorized
		if( ! current_user_can('manage_options') ) return;
		
		echo '<div class="updated fade" id="message"><p>', self::T, ' Settings <strong>Updated</strong></p></div>';
		
		//decode before submitting?
		foreach(array('format', 'date_separator', 'time_separator', 'label_format') as $field){
			$input[$field] = html_entity_decode( $input[$field] );
		}
		
		//escape and add appropriate slashes
		// actually removing them, per sharethis widget example???
		foreach($input as $field => &$value){
			$value = stripslashes($value);
			$value = preg_replace("/\&amp;/", "&", $value);
			//$value = addslashes_gpc($value);
		}
		
		//echo '<pre>', print_r($_POST['wp_abt_countdown_timer_options'], true), '</pre>';
		$settings = self::get_settings();
		$new_settings = wp_parse_args($input, $settings);
		
		### pbug($settings, $input, $new_settings);
		
		update_option( $key, $new_settings);
	}//--	fn	update_options_page
	
	#endregion ------------------- UI -----------------
	

}///---	class	ABT_Countdown_Timer

// engage!
$abt_countdown_timer = &ABT_Countdown_Timer::singleton();
$abt_countdown_timer->init();


#region ------------------- Initialization and Activation Settings -----------------

register_activation_hook(__FILE__, array('ABT_Countdown_Timer', 'activate'));
register_uninstall_hook(__FILE__, array('ABT_Countdown_Timer', 'uninstall'));

#endregion ------------------- Initialization and Activation Settings -----------------
		



#region -------------- workarounds ------------------

if( ! function_exists( 'abt_dateDiff' ) ) :
function abt_dateDiff($timestamp1, $timestamp2, $format = false){
	
	$date1 = getdate($timestamp1);
	$date2 = getdate($timestamp2);
	$diff = getdate($timestamp2);
	
	//find the differences between the two
	foreach($diff as $aspect => &$value){
		$value -= $date1[$aspect];
		
	}
	
	#echo 'before - ', print_r($diff, true);
	
	//if the event is past (total seconds difference < 0), return false
	if($diff[0] < 0) return 0;
	
	//now adjust for negative numbers
	if( $diff['seconds'] < 0 ){
		$diff['seconds'] += 60;
		$diff['minutes']--;
	}
	//now adjust for negative numbers
	if( $diff['minutes'] < 0 ){
		$diff['minutes'] += 60;
		$diff['hours']--;
	}
	//now adjust for negative numbers
	if( $diff['hours'] < 0 ){
		$diff['hours'] += 24;
		$diff['mday']--;
	}
	//now adjust for negative numbers; special for days!
	if( $diff['mday'] < 0 ){
		$diff['mday'] += cal_days_in_month(CAL_GREGORIAN, $date1['mon'], $date1['year']);
		$diff['mon']--;
	}
	//now adjust for negative numbers
	if( $diff['mon'] < 0 ){
		$diff['mon'] += 12;
		$diff['year']--;
	}
	//now adjust for negative numbers
	if( $diff['year'] < 0 ){
		$diff['year'] = 0;	//whoops// return 'WTF?';
	}
	elseif( !isset($diff['year']) ) {
		$diff['year'] = 0;
	}
	
	### pbug( $format, $diff );
	
	//return formatted, or just the diff
	if($format){
		return str_replace(
			array(
				'%y'
				,'%m'
				,'%d'
				,'%H'
				,'%M'
				,'%S'
			)
			,array(
				$diff['year']
				, $diff['mon']
				, $diff['mday']
				, $diff['hours']
				, $diff['minutes']
				, $diff['seconds']
			)
			, $format
		);
	}
	return $diff;
	
	
	
	
	// @deprecated!
	
	// adjust the time for each aspect
	/*
	$timeAdjust = sprintf("%d years %d days %d hours %d minutes %d seconds"
			, $diff['years']
			, $diff['yday']
			, $diff['hours']
			, $diff['minutes']
			, $diff['seconds']
		);
	
	$diffTime = strtotime( $timeAdjust, $timestamp1 );
	*/
	
	$timeAdjust = sprintf("%d years"
			, $diff['years']
		);
	$diffTime = strtotime( $timeAdjust, $timestamp1 );

	$timeAdjust = sprintf("%d years %d days %d hours %d minutes %d seconds"
			, $diff['years']
			, $diff['yday']
			, $diff['hours']
			, $diff['minutes']
			, $diff['seconds']
		);
	$diffTime = strtotime( $timeAdjust, $diffTime );
	
	
	$formatted = strftime($format, $diffTime);
	
	print_r(array(
		'format' => $format
		, 'd1' => $date1
		, 'd2'=> $date2
		, 'diff'=> $diff
		, 'adjust' => $timeAdjust
		, 'diffTime' => $diffTime
		, 'formatted' => $formatted
	));
	return strftime($format, $diffTime);
}//--	fn	abt_dateDiff
endif;	//func_exists

if( ! function_exists( 'abt_dateDiff2' ) ) :
/**
 * Get the difference between 2 dates
 * @param $startDate timestamp or string
 * @param $endDate timestamp or string
 * @param $format strftime format string
 */
function abt_dateDiff2($startDate, $endDate, $format = false) {
	
	if(!is_numeric($startDate)) $startDate = strtotime($startDate);
	if(!is_numeric($endDate)) $endDate = strtotime($endDate);
	
	if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate)
	return false;
	
	$years = date('Y', $endDate) - date('Y', $startDate);
	
	$endMonth = date('m', $endDate);
	$startMonth = date('m', $startDate);
	   
	// Calculate months
	$months = $endMonth - $startMonth;
	if ($months <= 0)  {
		$months += 12;
		$years--;
	}
	if ($years < 0) return false;
	
// Calculate the days
	
                        $offsets = array();
                        if ($years > 0)
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years');
                        if ($months > 0)
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months');
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

                        $days = $endDate - strtotime($offsets, $startDate);
                        $days = date('z', $days);
	echo $months, '|', strtotime($offsets, $startDate), '--', $endDate, '|', $offsets, '|', $days, '<br/>';
	
	$hours = date('H', $days);
	$minutes = date('i', $days);
	$seconds = date('s', $days);
	
	print_r(array($years, $months, $days, $hours, $minutes));
	
	//return formatted response
	if($format){
		return str_replace(
			array(
				'%y'
				,'%m'
				,'%d'
				,'%H'
				,'%M'
				,'%S'
			)
			,array(
				$years
				, $months
				, $days
				, $hours
				, $minutes
				, $seconds
			)
			, $format
		);
	}
	
	//return the array
	return array(
		'y' => $years
		, 'm' => $months
		, 'd' => $days
		, 'h' => $hours
		, 'm' => $minutes
		, 's' => $seconds
	);
}//--	fn	abt_dateDiff2
endif;

#endregion -------------- workarounds ------------------