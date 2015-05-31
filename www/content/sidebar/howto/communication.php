
<?php
print "<p class='widget-line-$odd'>Methods: Messages and alerts</p>";
?>

<span style='display:none;'>
	<?php print wtheadline('Messages','can be created and displayed using various built-in methods. Global values can be inserted into these message strings and segments of text can be hidden based on pre-defined conditions using <strong>text breaks</strong>.'); ?>
      
    <?php print method_profile(
    'say',
    'message',
    array(
    '','Local chat message that is displayed to a 20 meter radius from the breed-object.'
    ),
    actions_code('"start",
    "say(Hello world, my owner is %owner_name%)"'),
    'This example would say "Hello world, my owner is Dev Khaos" in local chat'
    );?>
    <?php print method_profile(
    'shout',
    'message',
    array(
    '','Local chat message that is displayed to a 100 meter radius from the breed-object.'
    ),
    actions_code('"start",
    "shout(Hello world, my owner is %owner_name%)"'),
    'This example would shout "Hello world, my owner is Dev Khaos" in local chat'
    );?>    
    <?php print method_profile(
    'whisper',
    'message',
    array(
    '','Local chat message that is displayed to a 10 meter radius from the breed-object.'
    ),
    actions_code('"start",
    "whisper(Hello world, my owner is %owner_name%)"'),
    'This example would whisper "Hello world, my owner is Dev Khaos" in local chat'
    );?>    
    <?php print method_profile(
    'ownersay',
    'message',
    array(
    '','Owner-only chat message. Messages will not be sent if owner is offline.'
    ),
    actions_code('"start",
    "ownersay(Hello world, my owner is %owner_name%)"'),
    'This example would say "Hello world, my owner is Dev Khaos" in global chat to just the owner.'
    );?>    
    <?php print method_profile(
    'message',
    'avatar-key, message',
    array(
    'avatar-key','the avatar\'s key for who gets the private message, most common value would be an <a show="expressions">expression</a>.'
    ),
    actions_code('"start",
    "message(%owner_key%, Hello! My name is %breed_name%.)"'),
    'This example would send an instant message: "Hello! My name is Eco-Breed" to the owner.'
    );?>       	
    

    
</span>