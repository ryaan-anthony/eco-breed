
<?php
print "<p class='widget-line-$odd'>Delete/Destroy Dead Breeds.</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Delete/destroy dead breeds','after they either die from old age or hunger. Simply use the die() method to remove the breed from the grid.');?>
        <div style='padding:0 20px;'>       
			<?php print method_profile(
			'die',
			'null',
			array(
				'','This method destroys the object. Be very careful!'
			),
			actions_code('"dead", 
"die()"'),
			'This example is the most common use for the die() method, placed within the native "dead" event. This allows you to control populations and unauthorized copies.'
			);?>	
 		</div>
</span>