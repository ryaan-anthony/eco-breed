
<?php
print "<p class='widget-line-$odd'>Methods: Pausing events or activities</p>";
?>

<span style='display:none;'>
    	<?php print wtheadline('To add a delay or pause', 'to event flow or other functionality, use the pause() method.'); ?>

        	<?php print method_profile(
			'pause',
			'time',
			array(
				'time','delay in seconds.',
				'\'r\' modifier','can be used for a random time between 0.0 and <strong>num</strong>.'
			),
			actions_code('"start", 
"say(Pausing for 5 seconds..)
pause(5)
"say(Pause expired.)"'),
			'This example first says a message in local chat, pauses for 5 seconds, then displays another message in local chat.',
			actions_code('"start", 
"say(Pausing for 5 to 10 seconds..)
pause(5)
pause(5r)
"say(Pause expired.)"'),
			'This example first says a message in local chat, pauses for 5 seconds, then pauses for a random time between 0.0 to 5.0 seconds, then displays another message in local chat.'
			);?>
			<p class='sub-in sit'>Add or set these values from the <strong>breed.settings</strong> script:</p>
	        <?php print breedSetting(
		'Pause_Anims',
		'TRUE',
		'Allow ANIMATIONS to be paused by the pause() method?'
		);?>
	        <?php print breedSetting(
		'Pause_Move',
		'TRUE',
		'Allow MOVEMENT to be paused by the pause() method (does not pause \'nonphys\')?'
		);?>
	        <?php print breedSetting(
		'Pause_Core',
		'TRUE',
		'Allow CORE EVENTS (breeding/ageing/hunger/growth) to be paused by the pause() method?'
		);?>
	        <?php print breedSetting(
		'Pause_Action',
		'TRUE',
		'Allow ACTIONS to be paused by the pause() method?'
		);?>
		
</span>