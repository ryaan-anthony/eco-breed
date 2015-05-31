
<?php
print "<p class='widget-line-$odd'>Settings: Movement Configurations</p>";
?>

<span style='display:none;'>

<?php print wtheadline('Movement behavior', 'can be fine tuned to suit your needs. Many of the configurations deal with speed, timing, force, and friction which help determine the behavior of the physical or non-physical breed object.'); ?>

        	<h2 align='center'>Movement Essentials</h2>
        	<?php print breedSetting(
		'Frequency of move attempts in seconds',
		'1.2',
		'This value sets the frequency of move attempts in seconds. For each move attempt, the breed will rotate and move towards the destination vector based on the movement behavior defined.'
		);?>
        	<?php print breedSetting(
		'Max attempts to reach it\'s destination',
		'-1',
		'The maximum number of attempts the breed can use to reach it\'s destination for each movement request. If the limit has been reached, the breed calls the arrived callback (if defined) for the move() method. You may set this to \'-1\' to allow an unlimited number of movement attempts for it to reach it\'s destination.'
		);?>
        	<?php print breedSetting(
		'Distance in meters from target destination',
		'2.0',
		'This value defines the distance in meters for how close a breed must be to it\'s target destination before calling the arrived callback.'
		);?>

        	<h2 align='center'>Restrictions</h2>
        	<?php print breedSetting(
		'Use legacy prim system',
		'YES',
		'To use the \'nonphys\' and \'nonphysUp\' movement behaviors, which rely on llSetKeyframedMotion() to provide smooth non-physical movement, Legacy Prims must be disabled otherwise attempts to use these behaviors result in the default \'setpos\' movement. Set to NO for mesh support.'
		);?>
        	<?php print breedSetting(
		'Remain physical after physical movement',
		'NO',
		'This value defines the physics status after a physical movement. If NO, the physics are disabled after movement. If true, the breed object remains physical.'
		);?>
        	<?php print breedSetting(
		'Finish move before accepting new move requests',
		'NO',
		'In order to ensure breeds finish their move to their destination vector before accepting new move requests, set this value to YES. It will ignore new requests until the destination has been reached. Otherwise set this to NO to allow the movement to be interupted and redirected to a new destination or with new movement behavior.'
		);?>
        	<?php print breedSetting(
		'Allow breed to drift beyond it\'s destination',
		'NO',
		'This filter determines if a breed can move beyond it\'s destination if it arrives or comes within the margin of error (Target_Dist_Min) between movements as defined by the Move_Timer. The distance to the destination vector is checked twice during movement cycles, once as soon as the cycle occurs, and a second time when the movement occurs. This value, when enabled, blocks the first filter which results in an unconstrained movement towards the destination vector and is vital for a smooth transition between multiple destination vectors. When set to YES, the breed will more seamlessly glide through assigned destinations; <strong>less precise, more smooth.</strong>'
		);?>
        	<?php print breedSetting(
		'Each move attempt will trigger a synced animation',
		'NO',
		'If an animation is linked to the move() type, the animation is triggered once when movement begins (good for animations that are set to repeat) and stops the animation when the move() is completed. If this value is set to YES, each move attempt will trigger the animation.'
		);?>

        	<h2 align='center'>Fine Tuning</h2>
        	<?php print breedSetting(
		'Turning Speed',
		'0.2',
		'The strength of the turning behavior is represented by efficiency and time. A lower efficiency value indicates a stronger turn, while a higher value will result in a more realistic and slightly more rounded turn. If the value is too high, the breed may not reach it\'s rotational target by the time it reaches it\'s linear destination, thus causing it to circle around the destination position endlessly.'
		);?>
        	<?php print breedSetting(
		'Turning Time',
		'0.2',
		'The time in seconds it takes the breed to reach it\'s rotational target based on the efficiency of the turn and the speed of the Move Timer and forward velocity.');?>
        	<?php print breedSetting(
		'Prim Material',
		'FLESH',
		'The object\'s "prim material" is how the physics engine determines how the physical object reacts to other primsets, avatars, and terrain. <br>OPTIONS: Stone, Metal, Glass, Wood, Flesh, Plastic, Rubber');?>
        	<?php print breedSetting(
		'Ground Friction',
		'0.2',
		'Friction applied to "walk" and "run" movement types.<br>  0.0 = Full Friction | >0.0 = Less Friction');?>
        	<?php print breedSetting(
		'Slope Offset',
		'0.5',
		'This offset gives you control over the AVOID_SLOPES flag for the move() method. This flag only detects inclines that are greater than the breed-object\'s geometric center plus this offset. If the incline is greater than this height, the breed will not attempt to move to that destination, instead calling the avoid callback defined within the method, otherwise silently fails.');?>
        	<?php print breedSetting(
		'Water Timeout',
		'5',
		'This value is only used with the \'swim\' movement behavior which acts as an occurance counter that counts the number of move attempts (defined by the frequency of the Move Timer) while the breed is out of the water. In plain english, this value multiplied by the Move Timer is the time in seconds the breed is allowed to be out of the water before \'water_end\' event is raised. If the throttle is not reached before being resubmerged, the throttle count is reset.');?>

        	<h2 align='center'>Under the Hood</h2>
        	<?php print breedSetting(
		'Speed : setpos',
		'0.7',
		'This is the default movement behavior for undefined or unrecognized movement attributes. This is non-physical, incremental movement defined not by speed but in distance the breed travels per each increment, no further than 10 meters. For long, rapid re-positioning, use \'warp\'. To define how fast the increments occur, set the Move Timer. This movement type is 2 dimensional meaning it doesn\'t go up or down, but parallel to it\'s starting vertical position despite it\'s environment.',
		'',
		''
		);?>
        	<?php print breedSetting(
		'Speed : nonphys',
		'3.5',
		'This is a non-physical movement type which uses llSetKeyframedMotion() to provide a smooth move behavior. This value is the time in seconds for the breed to reach it\'s destination, thus a lower value equals faster movement. Requires Legacy Prims to be disabled.',
		'',
		''
		);?>
        	<?php print breedSetting(
		'Speed : nonphysUp',
		'3.5',
		'This is a similar movement behavior to \'nonphys\' but allows the breed to look up/down towards it\'s destination where \'nonphys\' points forwards at all times.',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : walk',
		'4',
		'The \'walk\' is the default ground movement behavior which responds to physical gravity of the object\'s mass, a higher speed will be required for larger breeds, especially when traversing rough terrain or steep inclines.',
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : walk',
		'0.8',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : run',
		'8',
		'The \'run\' movement behavior is the same as \'walk\' but gives an alternately faster movement without having to define a speed value in the move() method.',
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : run',
		'0.8',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : hop',
		'8',
		'The \'hop\' movement behavior moves at half speed/distance as \'walk\' with same speed value but pushes the breed vertically at full speed creating a hopping behavior which moves full force upwards and half force forwards.',
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : hop',
		'0.0',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : jump',
		'15',
		'The \'jump\' movement behavior is the same as \'hop\' but gives an alternately faster movement without having to define a speed value in the move() method.',
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : jump',
		'0.0',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : swim',
		'5',
		"The 'swim' movement type is an underwater swimming behavior influenced strictly by region water, when the surface of the water is breached the buoyancy is decreased, thus applying additional gravity to keep it in the water. The recovery time between breach and re-submergence is defined by Move Timer. When a breach occurs, a counter tracks the number of cycles based on Move Timer, when those cycles reach or exceed the 'thottle_water_start' condition, the 'water_end' event is raised, thus allowing for alternate functionality for dealing with being out of the water. Once this event is raised, if the breed is resubmerged, the 'water_start' event is raised and the throttle cycles are reset. Additional events 'water' and 'land' exist for non-swim related environmental conditions, however the natived 'water_start' and 'water_end' with throttles are more suited for the 'swim' movement type.",
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : swim',
		'0.0',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : hover',
		'2',
		"The 'hover' movement type is a three dimensional motion useful as a slower version of 'fly' with the same gravity and angular behavior.",
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : hover',
		'0.0',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : fly',
		'5.5',
		"The 'fly' movement behavior is the same as 'hover' but gives an alternately faster movement without having to define a speed value in the move() method.",
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : fly',
		'0.0',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>

        	<?php print breedSetting(
		'Speed : float',
		'3.5',
		"The 'float' movement behaves like a boat, where it floats on the surface of the water. It has a hover height equal to the height of the linkset's geometric center. The behavior will limit the breed from being submerged in the water, and is useful for forcing breeds to tread water when a 'water' event is raised to keep them from sinking. This motion type is effective on land but with slightly different angular behavior than a 'walk' movement type.",
		'',
		''
		);?>
        	<?php print breedSetting(
		'Gravity : float',
		'0.0',
		'Additional gravity modifier applied to this behavior. ',
		'',
		''
		);?>
</span>