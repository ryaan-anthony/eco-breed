
<?php
print "<p class='widget-line-$odd'>Methods: Giving inventory.</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Give any type of inventory', 'using a variety of delivery methods.'); ?>
       		<?php print method_profile(
			'give',
			'avatar-key, inventory',
			array(
				'avatar-key','the recipient. Most common value is an expression.',
				'inventory','any type of inventory. Must be in the breed-object\'s inventory or this method will silently fail.'
			),
			actions_code('"start",
"bind(touch,owner,touched)",

"touched",
"give(%owner_key%,notecard)"'),
			'This example binds an owner only touch event. When touched, it gives an inventory item called "notecard".',
			actions_code('"start",
"bind(touch,all,touched)",

"touched",
"prop(note,INVENTORY_NOTECARD[0])
give(%touch_key%,%note%)"'),
			'This example finds the first notecard in the breed-object\'s contents and sets the property "note". Then it gives the notecard to whoever touches the breed.',
			actions_code('"start",
"bind(listen,owner,chat_event)",

"chat_event",
"filter(%chat_msg% = /help)
give(%chat_key%,notecard)"'),
			'This example binds an owner only listen event. When the breed-object hears owner say \'/help\', it gives an inventory item called "notecard".',
			actions_code('"start",
"bind(touch,all,give-menu)",

"give-menu",
"menu(%touch_key%, Need help?, Help = give-note)",

"give-note",
"give(%touch_key%,notecard)"'),
			'This example creates a menu with a "Help" button. When selected, the breed object gives an inventory item called "notecard".'
			);?>
</span>










