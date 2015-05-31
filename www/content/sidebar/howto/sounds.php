
<?php
print "<p class='widget-line-$odd'>Methods: Playing sounds.</p>";
?>

<span style='display:none;'>


    	<?php print wtheadline('Trigger or loop sounds', 'during events or to signal activity.'); ?>

        	<?php print method_profile(
			'sound',
			'[ sound [ , loop ] ]',
			array(
				"sound","name or uuid of the sound; if name is used, it must be within the contents of the breed object or this method will silently fail. To get the uuid of the sound, right-click the sound file from your inventory and select 'Copy Asset UUID'.",
				"loop","set to ' 1 ' to loop the sound. Once loop is enabled, use a blank sound() method to stop it."
			),
			actions_code('"start",
"bind(touch,all,play-sound)",

"play-sound",
"sound(sound_file)"'),
			"This example plays a sound file named 'sound_file' when touched by an avatar.",
			actions_code('"start",
"sound(sound_file, 1)
bind(touch,all,stop_sound)",

"stop_sound",
"sound()
say(Sound Stopped)"'),
			"This example loops a sound file named 'sound_file' over and over until touched by an avatar.",
			actions_code('"start",
"bind(timer, 20r, random-sound)",

"random-sound",
"prop(random, Sounds[r])
sound(%random%)"').big_code('Globals = ["Sounds", "Sound1|Sound2|Sound3|Sound4|Sound5"];','breed'),
			"This example requires inventory sound files OR uuids defined in the Globals list separated by a vertical bar '|'. In this example 'Sound1', 'Sound2', .. etc. are the sound files required. Once every timer cycle, (0 to 20 seconds) which includes the 'r' modifier to indicate random, a random sound is selected using the prop() method and played once using the sound() method.",
			actions_code('"start",
"bind(moving, null, moving)
 bind(stopped, null, stopped)
 bind(timer|toggle, 20, wander)",

"wander",
"move(%action_pos%, <5i,5i,0>, walk)",

"moving",
"sound(moving,1)",

"stopped",
"sound()"'),
			"This example loops a sound file named 'moving' while the breed is moving, then stops the loop when the breed stops moving."
			);?>
            

</span>