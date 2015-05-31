
<?php
print "<p class='widget-line-$odd'>Customize your breed's hover text</p>";
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
"text( %MyName% \n Age: %MyAge% )"'),
			'Displays the name and age in hovertext.'
			);?> 
            
        	<h3>Update text after regular intervals:</h3>
        	<?php print actions_code('"start",
"bind(timer, 20, text)",

"text",
"text( %MyName% \n Age: %MyAge% )"');?>    
            <p class='description'>Sets a timer to repeat every 20 seconds, each time the timer event expires, hovertext is 'updated'/re-applied.</p>
            
        	<h3>Set text and enable timer at same time.</h3>
        	<?php print actions_code('"start",
"bind(timer|toggle, 20, text)",

"text",
"text( %MyName% \n Age: %MyAge% )"');?>    
            <p class='description'>Same example as above, except it toggles the text immediately instead of waiting 20 seconds for the first update.</p>
            
        	<h3>Toggle text on/off by touching breed.</h3>
        	<?php print actions_code('"start",
"bind(timer|toggle, 20, show-text, remove-text)
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
"text( %MyName% \n Age: %MyAge% )"');?>  
			<?php print big_code('Globals = ["Text", 1];','breed');?>  
            <p class='description'>The text is set to update regularly, if the breed is touched by the owner the text will be disabled and re-enable when touched again. The property "Text" is set in the globals list since our example has Text enabled by default.</p>
            
        	<h3>Gender based text colors.</h3>
        	<?php print actions_code('"start",
"toggle(%MyGender%-color)
bind(timer|toggle, 20, show-text)",

"Male-color",
"val(Text_Color, <0.094, 0.278, 0.905>)",

"Female-color",
"val(Text_Color, <0.721, 0.278, 0.972>)",

"show-text",
"text( %MyName% - %MyGender% \n Age: %MyAge% )"');?>   
            <p class='description'>This example sets blue text for males and pink text for females. This assumes Genders is enabled with default Gender labels (ie Male and Female).</p>
   			<?php print howToIMG('<strong>Gender-based</strong> text color:','gendertext');?>
                        
        	<h3>Change text when dead.</h3>
        	<?php print actions_code('"start",
"filter(!%Dead%,dead)
bind(timer|toggle, 20, text, remove)",

"text",
"text( %MyName% \n Age: %MyAge% )",

"dead",
"val(Text_Color, <1,0,0>)
 unbind(remove)
 text(DEAD)"');?>    
            <p class='description'>Upon death, or if breed is already dead, this example disables the text timer and sets "DEAD" in red hovertext.</p>
            
        	<h3>Temporary pregnancy text.</h3>
        	<?php print actions_code('"start",
"bind(timer|toggle, 20, text)",

"text",
"text( / Pregnant: %Pregnant% \n / %MyName% \n Age: %MyAge% )"');?>    
            <p class='description'>Sections of the text can include text-breaks '/' (forward slashes) which indicate that the section of text within cannot contain an Undefined value or it will be removed. Multiple instances of text-breaks can be used. This example will display "Pregnant: [time until birth], Name, and Age" while pregnant and otherwise displays only the name and age.</p>
            
            
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
"text( %MyName% \n Age: %MyAge% )"');?>    
            <p class='description'>Hovertext is updated on regular intervals while awake and displays only zZZzz's while asleep.</p>
            </span>