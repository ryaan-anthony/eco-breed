
<?php
print "<p class='widget-line-$odd'>Methods: Rezzing objects.</p>";
?>

<span style='display:none;'>

    	<?php print wtheadline('Rez inventory objects', 'in place, at an offset, with an on_rez start_param, or with a force at a target vector.'); ?>
  
        	<?php print method_profile(
			'rez',
			'inventory [ , offset [ , start_param [ , force [ , target [ , fail-callback ] ] ] ] ]',
			array(
				'inventory','name of the object, must be within the contents of the breed object or the fail-callback will be triggered and the rezzing will fail.',
				'offset','a vector <x, y, z> offset to rez the object up to 10 meters away from the breed-object.',
				'start_param','the integer supplied to the on_rez event within any scripts in the rezzed objects contents. This is most commonly used for creating rezzables that activate with a secure start_param value.',
				'force','a float/integer value to rez the object with a force similiar to a gun. A rez() with a force value will \'shoot\' the prim forwards, supply a negative value to \'shoot\' backwards.',
				'target','a target position; the breed-object will turn towards this vector before rezzing the prim.',
				'fail-callback','if the offset is an invalid vector position or the inventory object is missing, this callback is triggered.'
			),
			actions_code('"start", 
"rez(Object)"'),
			'This example rezzes a prim named \'Object\' as the breed-objects current position.',
			actions_code('"start", 
"bind(touch,owner,shoot_prim)",

"shoot_prim",
"rez(Object, <0,0,0.5>, 0, 10, %ownerpos%)"'),
			'This example binds an owner-only touch event which, when touched, the breed-object shoots an inventory_object named \'Object\' with a force of 10 towards the owner. For this method to work, the breed-object must contain a physical prim named \'Object\'. If the object is not physical, it will not have gun-like behavior.',
			actions_code('"start", 
"bind(touch,owner,rez)",

"rez",
"prop(random, INVENTORY_OBJECT[r])
rez(%random%)"'),
			'This example rezzes a random object from the contents each time it\'s touched by the owner.'
			);?>
            

</span>