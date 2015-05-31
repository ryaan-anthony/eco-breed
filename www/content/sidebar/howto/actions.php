
<?php
print "<p class='widget-line-$odd'>Action Setup: Breakdown of the Actions</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('Actions','are defined in the \'Action Settings\' section of your account page. This is where additional functionality is defined is created by combining an "event" identifier with a string of "methods". Events <a style=\'color:red;\'>can not</a> be listed twice in the same script.'); ?>  
       		<?php print actions_comment('Use the following','','format:');?>
       		<?php print actions_code('"event 1", 
"method()",

"event 2", 
"method()"');?>
       		<?php print actions_comment('Also ','','acceptable:');?>
       		<?php print actions_code('"event-3",
"method()
method(value)
method(value, value)",

"event_4",
"method(value) method(value, value)"');?>
        	<p class='sub-in'>Spaces, tabs, and other whitespace <strong>will be removed</strong> during processing.</p>
        	<p class='sub-in'>If the page displays an error when saving, it's usually because <strong>this list was improperly formatted.</strong></p>
</span>


