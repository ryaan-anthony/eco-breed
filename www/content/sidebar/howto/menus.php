
<?php
print "<p class='widget-line-$odd'>Methods: Menus with custom buttons and input boxes.</p>";
?>

<span style='display:none;'>
	<?php print wtheadline('Menus and user input', 'are the most common ways to allow breed objects to interact with other avatars. This section covers the various ways to create menus and text input boxes.'); ?>

	<?php print method_profile(
'menu',
'avatar-key, message [ , button=callback ... ]',
array(
'','This easy to use dialog menu allows you to toggle a callback for each menu button and also return the results to the expressions: <strong>%chat_key% %chat_name% %chat_msg% %chat_pos%.</strong>',
'<br>avatar-key','the avatar\'s key for who gets the menu, most common value would be an expression.',
'message','the message supplied in the dialog.',
'button','You may supply up to 12 buttons per menu() method, if no buttons are supplied, the dialog will not trigger a callback and simply supply an \'OK\' button. If you want additional menus, use a <strong>button</strong> to toggle a <strong>callback</strong> to another menu.',
'callback','Each button requires a callback separated by an equals character \' = \' using this format: button=callback.'
),
actions_code('"start", 
"menu(%owner_key%, Say or shout?, Say=saymsg, Shout=shoutmsg)",

"saymsg", 
"say(Success!)",

"shoutmsg", 
"shout(Success!)"'),
'This example would display a popup menu for the owner. If the owner selects \'Say\' the response callback will say \'Success!\' in local chat. If the owner selects \'Shout\' the response callback will shout \'Success!\' in local chat. If ignored, no callbacks are toggled.');?>
	<?php print method_profile(
'textbox',
'avatar-key, message, callback',
array(
'','This easy to use textbox input allows you to toggle a callback and return the input results to the expressions: <strong>%chat_key% %chat_name% %chat_msg% %chat_pos%.</strong>',
'avatar-key','the avatar\'s key for who gets the textbox, most common value would be an expression.',
'message','the message supplied in the textbox.'
),
actions_code('"start", 
"textbox(%owner_key%, Change my name , Change_Name)",

"Change_Name", 
"val(breed_name,%chat_msg%)
say(My name is now %breed_name%)"'),
'This example would display a popup menu with a text input for the owner. The owner can set the breeds name, clicking "Send" will trigger the callback "Change Name" which uses the response to set the breed_name value (breed\'s name) with the %chat_msg% expression (which contains the user input from the textbox). It then displays a message in chat with the updated name.');?>

	<h3>Combine menu and textbox.</h3>
	<?php print actions_code('"start",
"bind(touch, owner, menu)
toggle(text)", 

"text",
"text( { %MyTitle% } %breed_name% )",

"menu",
"menu(%owner_key%, Example Menu:, Text Color=input-color, Name=input-name, Title=input-title )",

"input-title",
"textbox(%owner_key%, Set the breed\'s title:, set-title)",

"set-title",
"prop(MyTitle,%chat_msg%)
toggle(text)",

"input-name",
"textbox(%owner_key%, Set the breed name:, set-name)",

"set-name",
"val(breed_name,%chat_msg%)
toggle(text)",

"input-color",
"textbox(%owner_key%, Set the text color:, set-color)",

"set-color",
"val(Text_Color,%chat_msg%)
toggle(text)"');?>    
	<p class='description'>This example sets an owner-only touch which gives the owner a menu with 3 options "Text Color", "Name", and "Title". All three buttons give the owner a text input box. After defining the value, the hovertext is updated to show the results.</p>

	<h3>Owner/Public menus</h3>
	<?php print actions_code('"start",
"bind(touch, owner, owner-menu)
bind(touch, notowner, public-menu)",

"owner-menu",
"menu(%owner_key%, Owner Menu:, Info = basic, Advanced = advanced)",

"public-menu",
"menu(%touch_key%, Public Menu:, Info = basic)",

"basic",
"say(Hello %touch_name%, my name is %breed_name%. I\'m %age% years old.{ My parents are %parents%.})",

"advanced",
"ownersay( Breed Info:
Species: %species_name%
Name: %breed_name%
Age: %age%
Gender: %gender%
Generation: %generation%
{Parents: %parents%}
{Skin: %skins_active%}
{Partner: %partner%}
)"
');?>    
	<p class='description'>Create seperate binds for 'owner' and 'notowner' which are linked to seperate menus with different options.</p>
	
	<h3>Sub menus.</h3>
	<?php print actions_code('"start",
"bind(touch, owner, menu)",

"menu",
"menu(%owner_key%, Main Menu:, Option 1 = one,  Option 2 = two,  Sub Menu = sub )",

"sub",
"menu(%owner_key%, Sub Menu:, Option 3 = three,  Option 4 = four )",

"one",
"say(%this%)",

"two",
"say(%this%)",

"three",
"say(%this%)",

"four",
"say(%this%)"');?>    
	<p class='description'>Easily create sub-menus by using a callback button to open up new menus.</p>

	<h3>Dynamic toggle buttons and callbacks.</h3>
	<?php print actions_code('"start",
"bind(touch, owner, menu)",

"menu",
"menu(%owner_key%, Timer Control Menu:, Timer %timer%=%timer%)",

"on",
"say(Timer is %this%)
bind(timer, 15, event, handle)
prop(timer, off)",

"off",
"say(Timer is %this%)
unbind(handle)
prop(timer, on)",

"event",
"say(Timer expired.)"');?>   
	<p class='description'>Create an ON/OFF toggle button for a timer event. Useful for toggling looping events such as wandering, following, or other behaviors. Define "timer" as "on" in the Create/Modify globals section of the breed settings.</p>

</span>