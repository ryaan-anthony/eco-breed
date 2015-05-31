
<?php
print "<p class='widget-line-$odd'>Methods: How to move, wander, come, and follow.</p>";
?>

<span style='display:none;'>
        	<?php print wtheadline('Movement is created using the <strong>move()</strong> method', 'which accepts 12 pre-defined physical and non-physical movement behaviors and dozens of filters and settings to allow you to simulate a variety of animal/object types. The movement protocol is simple, once triggered the object will attempt to move to that position. You may stop the movement at any time during its execution or re-route to another position. You may also supply AVOID_* flags (avoid objects, avatars, water, other breeds, and disallow crossing into other parcels or regions) which keeps the breed-object from moving to a position if there are obstacles or hazards in between it\'s current position and the destination.');?>
      	
	       	<?php print method_profile(
			'move',
			'[ position [ , offset [ , type [ , speed [ , callback [ , flags [ , callback ] ] ] ] ] ] ]',
			array(
				'position','a pre-defined vector, or an expression which defines the target position.',
				'offset','a pre-defined vector offset which may include the \'r\' or \'i\' modifier, an expression, or a comination of these.',
				'type','is an attribute which determines the type of movement:'.big_code('
float	: Similar to a duck swimming on the surface of the water.
fly	: Bird or other flying animal.
hop	: Bunny or other hopping land animal.
hover	: Dragon fly or a slow flying/hovering animal.
jump	: Kangaroo or other jumping land animal.
nonphys : Smooth nonphysical movement for primsets up to 256 prims.
nonphysUp:Same as "nonphys" but the breed points to the destination.
run	: Fast land animal.
setpos	: Incremental non-physical movement.
swim	: Swims under the water, similar to a marine animal.
walk	: Average land animal.
warp	: Immediately move anywhere within a region.'),
				'speed',"a speed modifier : float value or 'slow', 'normal', 'fast' which uses the speed value from the settings script.".big_code('slow	=  0.5 x pre-defined speed
normal	=  1.0 x pre-defined speed
fast	=  1.5 x pre-defined speed'),
				'callback','the event toggled when the object reaches it\'s destination.',
				'flags','these flags define what obstacles and hazards to avoid. You can apply just one, or multiples using the vertical bar \'|\' as a separator.'.big_code('-1 = ALL_FLAGS : Set all flags.
 0 = AVOID_REGION_CROSSING : Avoid crossing into another region.
 1 = AVOID_PARCEL_CROSSING : Avoid crossing into another parcel.
 2 = AVOID_WATER : Avoid moving to a position that is over water.
 3 = AVOID_OBJECTS : Avoid moving where nonphysical objects are in the way.
 4 = AVOID_AVATARS : Avoid moving where avatars are in the way.
 5 = AVOID_BREEDS : Avoid moving where physical objects are in the way.
 6 = AVOID_LAND : Avoid moving where land/raised terrain is in the way.
 7 = AVOID_PHANTOM : Avoid moving where phantom objects are in the way.
 8 = AVOID_SLOPES : Avoid ground slopes lower than value set in breed settings.
 9 = AVOID_NO_ACCESS : Avoid parcels where scripts or object entry is disabled.'),
				'callback','the 2nd callback is the event which is toggled if an avoid-flag is triggered'
			)
			);?>
 
            <h2 align='center'>move() caveats:</h2>
            <p class='description sit'>&bull; AVOID_WATER and AVOID_SLOPES flags may toggle a false positive if the breed object is on floor prims or in a skybox.</p>
            <p class='description hang sit'>&bull; A blank move() method will stop current movement and disable the objects physics.</p>
            <p class='description hang'>&bull; The main/root prim must be upright and facing EAST at ZERO_ROTATION.</p>
            
        	<h2 align='center'>Move to the owner.</h2>
        	<?php print actions_code('"start",
"move(%owner_pos%)"');?>
			<p class='description'>With no movement type defined, the object uses nonphysical movement to reach it's destination. And without an offset, the object attempts to reach the center of your avatar which is returned by the %owner_pos% expression.</p>
            
        	<h2 align='center'>Walk to the owner</h2>
        	<?php print actions_code('"start",
"bind(touch, owner, come)",

"come",
"move(%owner_pos%,<0,0,0>,walk)"');?>
			<p class='description'>When the breed is touched by the owner, the breed walks to the owner's position.</p>
            
        	<h2 align='center'>Handling arrival.</h2>
        	<?php print actions_code('"start",
"bind(touch, owner, come)",

"come",
"move(%owner_pos%,<0,0,0>,walk,normal,arrived)",

"arrived",
"say(Hello, %owner%!)"');?>
			<p class='description'>When the breed is touched by the owner, the breed walks to the owner's position and greets them upon arrival.</p>
            
        	<h2 align='center'>Basic wander.</h2>
        	<?php print actions_code('"start", 
"bind(timer|toggle, 15, wander)",

"wander",
"move(%action_pos%, <10i,10i,0>, walk)"');?>
			<p class='description'>Walks around a 20 sq. meter area around the action object, receiving a random position every 15 seconds.</p>
            
        	<h2 align='center'>Follow toucher.</h2>
        	<?php print actions_code('"start", 
"bind(touch, all, start-follow)",

"start-follow",
"bind(timer|toggle, 5, follow, stop)
 bind(timer, 60, timeout, stop)",
 
"timeout",
"unbind(stop)
 move(%action_pos%, <0,0,0>, walk)",

"follow",
"move(%touch_pos%, <0,0,0>, walk)"');?>
			<p class='description'>Follows the person who touches it for 60 seconds then times out and returns home.</p>
            
        	<h2 align='center'>Go home.</h2>
            <?php print method_profile(
			'sethome',
			'[ position ]',
			array(
				'','To save a position vector as the objects \'home\' position, call the sethome() method with a valid vector position, or blank to save it\'s current position. You can access this value later by using the %home% expression.'
			),
			actions_code('"start", 
"sethome()
bind(touch,owner,msg_home)",

"msg_home",
"say(My home is: %home%)"'),
			'The above example saves the objects home vector on start and sets an owner-only touch event. When touched, it will say the object\'s home vector in local chat.',
			actions_code('"start", 
"bind(touch, owner, menu)",

"menu",
"menu(%owner_key%, Set home or send home:, Set Home = set, Go Home = go)",

"set",
"sethome()
 ownersay(Home saved here: %home%)",

"go",
"move(%home%, null, walk)"'),
			'This example gives the owner the ability to set the home via menu and also tell the breed to go to the home position.'
			);?>
       
        	<h2 align='center'>Avoiding Obstacles and Hazards</h2>
    		<?php print wtheadline('Avoid obstacles', 'during any type of movement sequence using AVOID flags paired with a custom callback to allow error handling. Whether to retry another position or to change methods, AVOID flags add awareness to breed movement behavior.'); ?>

      		<?php print videolink('Avoid obstacles and hazards', 'bgLAqhmhoq0');?>
        
        	<h2 align='center'>Smart wander.</h2>
        	<?php print actions_code('"start", 
"bind(timer|toggle, 10, wander)",

"wander",
"move(%action_pos%, <10i,10i,0>, walk, slow, null, 3|4, avoid)",

"avoid", 
"toggle(wander)"');?>
			<p class='description'>This example sets a timer for 10 seconds. Each time the timer expires, the breed object walks slowly toward the destination position. The avoid flags AVOID_OBJECTS and AVOID_AVATARS are set, and if either flag is triggered the resulting callback re-toggles the 'wander' event.</p>
            
        	<h2 align='center'>Toggle smart wander.</h2>
        	<?php print actions_code('"start", 
"bind(touch, owner, menu)",

"menu",
"menu(%owner_key%, Example Menu:, Wander %Status% = %Status%)",

"ON",
"prop(Status,OFF)
 bind(timer|toggle, 10, wander, stop)",

"OFF",
"prop(Status,ON)
 unbind(stop)
 move()",

"wander",
"move(%action_pos%, <10i,10i,0>, walk, slow, null, 3|4, avoid)",

"avoid", 
"toggle(wander)"');?>
			<p class='description'>On/Off button for smart wander in an owner-only menu. This example requires the property "Status" to be defined as "ON" in the 'Create/Modify Globals' section of your breed settings page. </p>
        	
</span>