
<?php
print "<p class='widget-line-$odd'>Methods: Customized hover text</p>";
?>

<span style='display:none;'>
	<h3>Text is applied or removed using the text() method.</h3>
	<?php print method_profile(
	'text',
	'[message]',
	array(
	'','Display text over your breed.'
	),
	actions_code('"start",
"text( %breed_name% \n Owner: %owner_name% )"'),
	'Displays the breed name and owner in hovertext.');?> 
    <?php print breedSetting(
    'Hover text color',
    '<0.3,0.9,0.5>',
    'The hover text color that shows up over your breed can be defined here in vector format ( ie <red, green, blue> ).' );?>
    <?php print breedSetting(
    'Hover text transparency',
    '1.0',    
    'The hover text transparency can have a value between 1.0 (visible) to 0.0 (invisible).'
    );?>
    <?php print breedSetting(
    'Prim to display hover text',
    '0',
    'The link number of where the hovertext should be applied. 0 = root prim'
    );?>
    <?php print breedSetting(
    'Custom loading message',
    '""',
    'You may set a custom authentication message here which will be displayed while the breed is activating. The text will be cleared once activation is completed. For example, if set to "Waking up..", the breed will display "Waking up.." in hovertext while breed is authenticating.'
    );?>
            
	<h3>Update text after regular intervals:</h3>
	<?php print actions_code('"start",
"bind(timer, 20, text)",

"text",
"text( %breed_name% \n Age: %age% )"');?>    
	<p class='description'>When touched, sets a timer to repeat every 20 seconds, each time the timer event expires, hovertext is 'updated' and re-applied.</p>

	<h3>Set text and enable timer at same time.</h3>
	<?php print actions_code('"start",
"bind(timer|toggle, 20, text)",

"text",
"text( %breed_name% \n Age: %age% )"');?>    
	<p class='description'>Same example as above, except it toggles the text immediately instead of waiting 20 seconds for the first update.</p>

	<h3>Toggle text on/off by touching breed.</h3>
	<?php print actions_code('"start",
bind(touch, owner, toggle-text)",

"toggle-text",
"filter(%Text%, enable-text)
prop(Text)
unbind(remove-text)
text()",

"enable-text",
"prop(Text,1)
bind(timer|toggle, 20, show-text, remove-text)",

"show-text",
"text( %breed_name% \n Age: %age% )"');?>  
	<p class='description'>The text is set to update regularly, if the breed is touched by the owner the text will be enabled and disabled when touched again.</p>

	<h3>Gender based text colors.</h3>
	<?php print actions_code('"start",
"toggle(%gender%-color)
bind(timer|toggle, 20, show-text)",

"Male-color",
"val(Text_Color, <0.094, 0.278, 0.905>)",

"Female-color",
"val(Text_Color, <0.721, 0.278, 0.972>)",

"show-text",
"text( %breed_name% - %gender% \n Age: %age% )"');?>   
	<p class='description'>This example sets blue text for males and pink text for females. This assumes Genders is enabled with default Gender labels (ie Male and Female).</p>
	<?php print howToIMG('<strong>Gender-based</strong> text color:','gendertext');?>
            
	<h3>Change text when dead.</h3>
	<?php print actions_code('"start",
"filter(!%Dead%,dead)
bind(timer|toggle, 20, text, remove)",

"text",
"text( %breed_name% \n Age: %age% )",

"dead",
"val(Text_Color, <1,0,0>)
unbind(remove)
text(DEAD)"');?>    
	<p class='description'>Upon death, or if breed is already dead, this example disables the text timer and sets "DEAD" in red hovertext.</p>

	<h3>Change text based on events (sleep/awake example).</h3>
	<?php print actions_code('"start",
"bind(day, SL, awake)
bind(night, SL, sleep)",

"awake",
"bind(timer|toggle, 20, text, remove)",

"sleep",
"unbind(remove)
text(zZZzz..)",

"text",
"text( %breed_name% \n Age: %age% )"');?>    
	<p class='description'>Hovertext is updated on regular intervals while awake and displays only zZZzz's while asleep.</p>
</span>