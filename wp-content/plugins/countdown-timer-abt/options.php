<?php
/**
 * Shorthand for outputting a field
 * @param string $type the input type (text, radio - simple stuff)
 * @param string $label the human-readable field label
 * @param string $name the unique field name/id
 * @param variable $value the field default value
 */
function abt_input_helper_text(&$self, $type, $label, $name, $value, $description = false){
	?>
		<div class="field">
			<label for="<?php echo $self->fieldid($name, 'options') ?>"><?= _e($label, ABT_Countdown_Timer::N) ?></label>
			<input type="<?= $type ?>" name="<?php echo $self->fieldname($name, 'options') ?>" id="<?php echo $self->fieldid($name, 'options') ?>" value="<?= htmlentities2(stripslashes($value)) ?>" />
			<?php if($description) { ?><em class="description"><?= __($description, ABT_Countdown_Timer::N) ?></em><?php } //if $description ?>
		</div>
	<?php
}//--	fn	...text
/**
 * Shorthand for outputting a field
 * @param string $type the input type (text, radio - simple stuff)
 * @param string $label the human-readable field label
 * @param string $name the unique field name/id
 * @param variable $value the field default value
 */
function abt_input_helper_textarea(&$self, $class = '', $label, $name, $value, $description = false){
	?>
		<div class="field">
			<label for="<?php echo $self->fieldid($name, 'options') ?>"><?= _e($label, ABT_Countdown_Timer::N) ?></label>
			<textarea <?php if($class){?> class="<?= $class ?>"<?php } ?> name="<?php echo $self->fieldname($name, 'options') ?>" id="<?php echo $self->fieldid($name, 'options') ?>"><?= htmlentities2(stripslashes($value)) ?></textarea>
			<?php if($description) { ?><em class="description"><?= __($description, ABT_Countdown_Timer::N) ?></em><?php } //if $description ?>
		</div>
	<?php
}//--	fn	...textarea



?>
<div class="wrap" id="poststuff">
	<h2>Plugin Options</h2>
	<form method="post" action="">
	
	<div class="metabox-holder">
		<div class="postbox">
			
			<h3 class="handle"><?= _e('Date and Time', ABT_Countdown_Timer::N) ?></h3>
			<div class="inside fs-wrap"><fieldset>
				<?php $currTime = new DateTime('now', new DateTimeZone($options['timezone'])); ?>
				<?php abt_input_helper_text($this, 'text', 'Timezone', 'timezone', $options['timezone'], 'Enter your timezone, like &quot;America/New_York&quot;.'); ?>
				<?php abt_input_helper_text($this, 'text', 'Target Time', 'target_time', $options['target_time'], 'Enter the date/time to countdown to, like &quot;20XX-MM-DD HH:mm:ss&quot;.  Current server time for timezone is: '.$currTime->format('r') ); ?>
			
			</fieldset></div>
		</div>
	</div>
	
	<?php /* 
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="handle"><?= _e('Title and Link', 'wp_abt_countdown_timer') ?></h3>
			<div class="inside fs-wrap"><fieldset>
				
				<?php abt_input_helper_textarea($this, 'text', 'Title', 'title', $options['title'], 'Some extra descriptive text.'); ?>
				<?php abt_input_helper_text($this, 'text', 'Link', 'link', $options['link'], 'Optional target to click on countdown timer.'); ?>
			
			</fieldset></div>
		</div>
	</div>
	*/ ?>
	
	<div class="metabox-holder">
		<div class="postbox">
			<h3 class="handle"><?= _e('Appearance', ABT_Countdown_Timer::N) ?></h3>
			<div class="inside fs-wrap"><fieldset>
				
				<?php abt_input_helper_textarea($this, 'text widefat', 'Output Format', 'format', $options['format'], 'Give the HTML code in which to wrap the output.  See Help for more details.'); ?>
				<?php abt_input_helper_textarea($this, 'text widefat', 'Date Separator', 'date_separator', $options['date_separator'], 'HTML code for date separator character.'); ?>
				<?php abt_input_helper_textarea($this, 'text widefat', 'Time Separator', 'time_separator', $options['time_separator'], 'HTML code for time separator character.'); ?>
				<?php abt_input_helper_textarea($this, 'text widefat', 'Label Format', 'label_format', $options['label_format'], 'HTML wrapper for interval label -- use <code>%s</code> as text placeholder.'); ?>
				<?php abt_input_helper_textarea($this, 'text widefat', 'Completed Text', 'complete_text', $options['complete_text'], 'What to display when countdown reaches 0.'); ?>
			
			</fieldset></div>
		</div>
	</div>

	<div class="buttons">
		<?php
		/* $options = get_option( $this->fieldkey('options') ); */
		wp_nonce_field( $this->fieldkey('options'), $this->fieldkey('options_nonce') );
		?>
		<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
	</div>
	

	</form>
</div>
<?php
return;