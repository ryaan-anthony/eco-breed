
<?php
print "<p class='widget-line-$odd'>Methods: Enable/disable events</p>";
?>

<span style='display:none;'>
    	<?php print wtheadline('Disable/enable user-created or native events', 'by using the on() and off() methods.'); ?>

        	<?php print method_profile(
			'off',
			'event',
			array(
				'','To disable native or user-defined events and callbacks supply the event/callback name as the only value. Null (blank) values will be ignored.'
			),
			actions_code('"start",
"off(dead)"'),
			'This example disables the native "dead" event, the method string response will be ignored.'
			);?>
            <?php print method_profile(
			'on',
			'event',
			array(
				'','To re-enable native or user-defined events and callbacks supply the event/callback name as the only value. Null (blank) values will re-enable all previously disabled events. By default, all events are enabled and must be disabled prior to calling this method for it to have any effect.'
			),
			actions_code('"start",
"off(dead)
 bind(touch, owner, enable)",

"enable",
"on(dead)"'),
			'This example disables the "dead" event and then is re-enabled when touched by the owner.'
			);?>
</span>