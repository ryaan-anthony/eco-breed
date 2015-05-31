
<?php
print "<p class='widget-line-$odd'>Menus with custom buttons and input fields</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Menus and user input', 'are the most common ways to allow breed objects to interact with other avatars. This section covers the various ways to create menus and text input boxes.'); ?>
   
        	
       		<?php print method_profile(
			'menu',
			'avatar-key, message [ , button=callback [ , button=callback ... ] ]',
			array(
				'','This easy to use dialog menu allows you to toggle a callback for each menu button and also return the results to the expressions: <strong>%chatid% %chatname% %chatmsg% %chatpos%.</strong>',
				'<br>avatar-key','the avatar\'s key for who gets the menu, most common value would be an <a show=\'expressions\'>expression</a>.',
				'message','the message supplied in the dialog.',
				'button','You may supply up to 12 buttons per menu() method, if no buttons are supplied, the dialog will not trigger a callback and simply supply an \'OK\' button. If you want additional menus, use a <strong>button</strong> to toggle a <strong>callback</strong> to another menu.',
				'callback','Each button requires a callback separated by an equals character \' = \' using this format: button=callback.'
			),
			actions_code('"start", 
"menu(%ownerkey%, Say or shout?, Say=saymsg, Shout=shoutmsg)",

"saymsg", 
"say(Success!)",

"shoutmsg", 
"shout(Success!)"'),
			'This example would display a popup menu for the owner. If the owner selects \'Say\' the response callback will say \'Success!\' in local chat. If the owner selects \'Shout\' the response callback will shout \'Success!\' in local chat. If ignored, no callbacks are toggled.'
			);?>
       		<?php print method_profile(
			'textbox',
			'avatar-key, message, callback',
			array(
				'','This easy to use textbox input allows you to toggle a callback and return the input results to the expressions: <strong>%chatid% %chatname% %chatmsg% %chatpos%.</strong>',
				'avatar-key','the avatar\'s key for who gets the textbox, most common value would be an expression.',
				'message','the message supplied in the textbox.'
			),
			actions_code('"start", 
"textbox(%ownerkey%, Change my name , Change_Name)",

"Change_Name", 
"val(MyName,%chatmsg%)
say(My name is now %MyName%)"'),
			'This example would display a popup menu with a text input for the owner. The owner can set the breeds name, clicking "Send" will trigger the callback "Change Name" which uses the response to set the MyName value (breed\'s name) with the %chatmsg% expression (which contains the user input from the textbox). It then displays a message in chat with the updated name.'
			);?>
            
            
        	<h3>Combine menu and textbox.</h3>
        	<?php print actions_code('"start",
"bind(touch, owner, menu)
 toggle(text)", 

"text",
"text( / %MyTitle% / %MyName% )",

"menu",
"menu(%ownerkey%, Example Menu:, Text Color=input-color, Name=input-name, Title=input-title )",

"input-title",
"textbox(%ownerkey%, Set the breed\'s title:, set-title)",

"set-title",
"prop(MyTitle,%chatmsg%)
 toggle(text)",

"input-name",
"textbox(%ownerkey%, Set the breed name:, set-name)",

"set-name",
"val(MyName,%chatmsg%)
 toggle(text)",

"input-color",
"textbox(%ownerkey%, Set the text color:, set-color)",

"set-color",
"val(Text_Color,%chatmsg%)
 toggle(text)"');?>    
            <p class='description'>This example sets an owner-only touch which gives the owner a menu with 3 options "Text Color", "Name", and "Title". All three buttons give the owner a text input box. After defining the value, the hovertext is updated to show the results.</p>
            
        	<h3>Owner/Public menus</h3>
        	<?php print actions_code('"start",
"bind(touch, owner, owner-menu)
 bind(touch, notowner, public-menu)",

"owner-menu",
"menu(%ownerkey%, Owner Menu:, Info = basic, Advanced = advanced)",

"public-menu",
"menu(%touchkey%, Public Menu:, Info = basic)",

"basic",
"say(Hello %toucher%, my name is %MyName%. I\'m %MyAge% years old./ My parents are %MyParents%./)",

"advanced",
"ownersay( Breed Info:
Species: %MySpecies%
Name: %MyName%
Age: %MyAge%
Gender: %MyGender%
Generation: %MyGeneration%
/Parents: %MyParents%/
/Skin: %MySkins%/
/Partner: %MyPartner%/
)"
');?>    
            <p class='description'>Create seperate binds for 'owner' and 'notowner' which are linked to seperate menus with different options.</p>
                        
        	<h3>Sub menus.</h3>
        	<?php print actions_code('"start",
"bind(touch, owner, menu)",

"menu",
"menu(%ownerkey%, Main Menu:, Option 1 = one,  Option 2 = two,  Sub Menu = sub )",

"sub",
"menu(%ownerkey%, Sub Menu:, Option 3 = three,  Option 4 = four )",

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
"menu(%ownerkey%, Timer Control Menu:, Timer %timer%=%timer%)",

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
        	<?php print big_code('Globals = ["timer", "on"];', 'breed');?>    
            <p class='description'>Create an ON/OFF toggle button for a timer event. Useful for toggling looping events such as wandering, following, or other behaviors.</p>            
        	         
            
</span>