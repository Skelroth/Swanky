<div class="wrap">

<em class="warning">Please localize!</em>

<dl>

	<dt id="usage"><h3>Usage (Shortcode)</h3></dt>
	<dd>
		<p>Use shortcode with the format:</p>
		<pre>
<?php
$pre = <<<PRE
[countdown_timer
	target_time="2012-05-05 14:03:00"
	complete_text="It's Done!"
	format= {CUSTOM HTML FORMAT - SEE BELOW}
	date_separator='<span class="d-sep">/</span>'
	time_separator='<span class="t-sep">:</span>'
	label_format="<em>%s</em>"
	timezone="America/New_York"
	]
PRE;
echo htmlspecialchars($pre); ?>
		</pre>
		<p>where format is <a href="#format">explained below</a>.  Read more information <a href="http://php.net/manual/en/datetime.settimezone.php">about the timezones</a>.</p>
		<p><em>Please note:</em> these inline options are entirely optional, and if not provided will use the defaults as specified in the admin options.</p>
	</dd>

	<dt id="developer"><h3>Developer Hooks</h3></dt>
	<dd>
		<p>The following filters are provided to adjust both the attributes (before rendering) and the format (after rendering).</p>

		<p>You would use them like:</p>
<pre class="php">
add_filter( '<?php echo $this->fieldkey('_pre_render'); ?>', 'my_countdown_prerender' );
function my_countdown_prerender($attributes) { ... }
</pre>

<pre class="php">
add_filter( '<?php echo $this->fieldkey('_post_render'); ?>', 'my_countdown_postrender' );
function my_countdown_postrender($output, $attributes) { ... }
</pre>

		<p>This is how they're used in the plugin:</p>
<pre class="php">
// hook - adjust attributes used to render the countdown
$attributes = apply_filters( '<?php echo $this->fieldkey('_pre_render'); ?>', $attributes );
</pre>
		
<pre class="php">
// hook - add "before", "after"; alter rendered output
$formatted_time = apply_filters( '<?php echo $this->fieldkey('_post_render'); ?>', $formatted_time, $attributes );
</pre>
	</dd>

	<dt id="title"><h3>Title &amp; Link</h3></dt>
	<dd>
		<p>Title: helpful display text when hovering over countdown timer.</p>
		<p>Link: optional link when clicking countdown timer.</p>
		<p><em>Note:</em> you can easily add these by wrapping the shortcode within additional styling.</p>
	</dd>
	
	<dt id="timezone"><h3>Timezones</h3></dt>
	<dd>
		<p>See <a href="http://php.net/manual/en/datetime.settimezone.php">http://php.net/manual/en/datetime.settimezone.php</a> for more details on PHP DateTime timezone object.</p>
		<p>Also refer to the list at <a href="http://us.php.net/manual/en/class.datetimezone.php">http://us.php.net/manual/en/class.datetimezone.php</a></p>
		
		<p>Typically you would enter as <code>America/New_York</code> for Eastern Standard Time.</p>
	</dd>

	<dt id="target_time"><h3>Target Time</h3></dt>
	<dd>
		<p>Compares given time against <code>DateTime('now')</code>.</p>
		<p>See <a href="http://www.php.net/manual/en/datetime.construct.php">http://www.php.net/manual/en/datetime.construct.php</a> for examples of how format should appear.</p>
	</dd>


	<dt id="format"><h3>Output Format</h3></dt>
	<dd>
		<p>HTML wrapper for response fields.</p>
		<p>Use &quot;Label Format Function&quot; <code>{l(LABEL_TEXT)}</code> to use localization translations of <em>LABEL_TEXT</em>.</p>
		<p>Use placeholders for date and time separators, <code>#d-sep</code> and <code>#t-sep</code>, respectively.
		<p>See time format patterns from <code>strftime</code> at <a href="http://php.net/manual/en/function.strftime.php">http://php.net/manual/en/function.strftime.php</a>.</p>
		<div>
			<strong>Default:</strong>
			<pre>
			<?php
			$example = <<<OUTPUT

<div class="date">
	<span class="date-month">{l(M)}%m</span>#d-sep#
	<span class="date-day">{l(D)}%d</span>#d-sep#
	<span class="date-year">{l(Years)}%Y</span>
</div>
<div class="time">
	<span class="time-hour">{l(Hours)}%H</span>#t-sep#
	<span class="time-minutes">{l(Minutes)}%M</span>#t-sep#
	<span class="time-seconds">{l(Seconds)}%S</span>
</div>
OUTPUT;
			echo htmlspecialchars($example);
			?>
			</pre>
		</div>
	</dd>


	<dt id="date_separator"><h3>Date Separator</h3></dt>
	<dd>
		<p>Character or HTML block between Date items, like Month, Year, Day.</p>
		<p>See <a href="http://www.php.net/manual/en/datetime.construct.php">http://www.php.net/manual/en/datetime.construct.php</a> for examples of how format should appear.</p>
		<div>
			<strong>Default:</strong>
			<pre><?php echo htmlspecialchars('<span class="d-sep">/</span>'); ?></pre>
		</div>
	</dd>

	<dt id="time_separator"><h3>Time Separator</h3></dt>
	<dd>
		<p>Character or HTML block between Time items, like Hour, Minute, Second.</p>
		<p>See <a href="http://www.php.net/manual/en/datetime.construct.php">http://www.php.net/manual/en/datetime.construct.php</a> for examples of how format should appear.</p>
		<div>
			<strong>Default:</strong>
			<pre><?php echo htmlspecialchars('<span class="t-sep">:</span>'); ?></pre>
		</div>
	</dd>
	
	<dt id="label_format"><h3>Interval Label</h3></dt>
	<dd>
		<p>Character or HTML block format string for interval (like Month, Hour, etc).</p>
		<p>Uses <code>sprintf()</code>, so use <code>%s</code> for value placeholder.</p>
		<div>
			<strong>Default:</strong>
			<pre><?php echo htmlspecialchars('<em>%s</em> '); ?></pre>
		</div>
	</dd>
	
</dl>

</div>