
<?php
print "<p class='widget-line-$odd'>Action Setup: Utilizing the native events.</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('Native events','are reserved \'event\' names which are toggled automatically at the end of a core event or when specific conditions are met.'); ?>    
 
            <div class='entry sub-pad'>
            	<?php print actions_comment('When a breed or action is rezzed, a','"start"','event is toggled.');?>
            	<?php print actions_code('"start", 
"say(Hello, %owner_name%!)"');?>
            </div>          
            <div class='entry sub-pad'>
            	<?php print actions_comment('Each time the breed completes a','"growth"',' stage, this event is toggled.');?>
            	<?php print actions_code('"growth", 
"say(%breed_name% has %Growth_Stages% remaining!)"');?>
            </div>          
            <div class='entry sub-pad'>
            	<?php print actions_comment('When the breed eats ','"food"',', this event is toggled.');?>
            	<?php print actions_code('"food", 
"say(%breed_name% just ate. [Health: %hunger%])"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('If the mother becomes ','"pregnant"',', this event is raised prior to "birth".');?>
            	<?php print actions_code('"pregnant", 
"say(%breed_name% is going to have a baby in %pregnant%.)"');?>
            </div>   
            <div class='entry sub-pad'>
            	<?php print actions_comment('If a breed gives ','"birth"',', this event is toggled for the mother.');?>
            	<?php print actions_code('"birth", 
"say(%breed_name% just gave birth.)"');?>
            </div>        
            <div class='entry sub-pad'>
            	<?php print actions_comment('If death occurs from age, hunger, or other causes, the ','"dead"',' event is called.');?>
            	<?php print actions_code('"dead", 
"say(Goodbye, %owner_name%!)" ');?>
            </div>    
</span>