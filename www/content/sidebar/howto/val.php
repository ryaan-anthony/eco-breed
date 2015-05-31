

<?php
print "<p class='widget-line-$odd'>Methods: Modify global states and values.</p>";
?>

<span style='display:none;'>
 <?php print wtheadline('The val() method', 'allows you to change a variety global settings during event flow. You can change multiple settings at the same time by listing each setting/value pair in succession.'); ?>
        	<?php print method_profile(
			'val',
			'setting, value [ , setting, value ... ]',
			array(
				'setting','a recognized global value listed on the attributes page.',
				'value','a static value or an expression.'
			),
			actions_code('"start", 
"bind(touch, owner, menu)",

"menu",
"menu(%owner_key%, Enable or disable breeding?, Enable = enable, Disable = disable)",

"disable",
"val(Breed_Time,0)
say(Breeding disabled.)",

"enable",
"val(Breed_Time,5)
say(Breeding cycle set at 5 minutes.)"'),
			"When touched by the owner, a menu is created with enable/disable buttons which result in breeding being enabled or disabled.",
			actions_code('"start", 
"bind(timer,60,breed_status)",

"breed_status",
"filter(%Happiness%>50, disable_breed, !%enabled)
val(Breed_Time,60)
prop(enabled,true)",

"disable_breed",
"val(Breed_Time,0)
prop(enabled)"'),
			"The above example checks the breed's happiness level every 60 seconds, and \"Happiness\" must be previously set using the prop() method. If \"Happiness\" is greater than 50, the filter is passed and the val() method sets the Breed_Time attribute to every 60 minutes. If the filter is not passed, it stops the current method string and calls back to the \"disable_breed\" event which turns Breed_Time to 0 minutes, disabling breeding completely."
			);?>
			<p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>BREEDING</p>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Breed_Time</p>
            <span><p class='description'>The breed time determines how how often the breed object would either look for a mate or start the birth sequence. This value is time in minutes where '0' disables breeding. Similar to the lifespan year, the breeding cycle is checked every 60 seconds to determine if the cycle has expired. If multiple 'cycles' have passed since the last time it was checked, the breed will only call one breeding cycle.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Breed_Failed_Odds</p>
            <span><p class='description'>This value defines a random odds for a failed birth. The higher the odds value, the more likely of a failed birth. Set this value to 0 to disable failed births.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Litter_Min</p>
            <span><p class='description'>This value sets the minimum number of breeds per of litter.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Litter_Max</p>
            <span><p class='description'>This value sets the maximum number of breeds per of litter. A random number of breeds are selected between min and max to create a litter.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Litter_Rare</p>
            <span><p class='description'>With this value enabled, larger litters become more rare than smaller litters.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Litters</p>
            <span><p class='description'>This value defines the maximum number of litters the breed will have throughout it's lifespan. Unless the min/max litter size are the same, there is no way to limit the number of total breeds, however you can limit the number of breeds born per action object, otherwise set a static min/max litter size and limit the litters here. You can set this value to '-1' for unlimited litters.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Breed_Age_Min</p>
            <span><p class='description'>This is the minimum childbearing age. The breeds will neither select a mate nor breed prior to reaching this age.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Breed_Age_Max</p>
            <span><p class='description'>This is the maximum childbearing age, after this age the breed will no longer mate or give birth. If the breed is pregnant prior to passing it's maximum age, the breed will give birth but will not continue to mate or breed in subsequent breeding cycles. Set this value to '-1'  for no maximum age limit.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Partner_Timeout</p>
            <span><p class='description'>How many breed cycles must pass without it's partner before becoming available to other partners. The Keep_Partners value must be enabled for this timeout to be effective. Setting this value to '0' disables the timeout, effectively forcing partnering for life unless otherwise controled by the val() <a show='methods'>method</a>. This value must be greater than '1' since one breed cycle will always occur while with a partner, the most immediate would be '2' which would indicate that the breed has missed one breed cycle without it's mate which will not happen unless the pregnancy timeout extends beyond the average breed cycle. Be sure to calculate the pregnancy time as part of the time one breed may be without it's partner.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Pregnancy_Timeout</p>
            <span><p class='description'>The pregnancy timeout is a time in minutes between breeding and birth. This will delay breeding cycles if the times overlap. Setting this value to '0' results in instant birth upon breeding. You can access the time remaining using the <a show='expressions'>expression</a> %Pregnant% which returns a time formatted string such as "3 minutes 42 seconds".</p></span>
            </div>

            <p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>HUNGER</p>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Hunger_Min</p>
            <span><p class='description'>This value indicates the minimum food units the breed will consume per hunger cycle, if available. Any food objects with less food units than this value will be ignored. Similarly, if the food quality is too high for the amount needed by the breed, the food source will be ignored. The food's point value is determined by the food units multiplied by the food quality. So if the food quality is 10, one unit is worth 10 food points. If the breed's minimum intake is set to 5, with a food quality of 10, the breed will need a hunger percent of 50 or less in order to consume any food.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Hunger_Max</p>
            <span><p class='description'>This value indicates the maximum food units the breed will consume per hunger cycle, if available. This determines the range of the breed's appetite. The breed can only consume so much volume per hunger cycle, but the nutritional value can differ as determined by the individual food sources. As mentioned with Hunger_Min, if the food quality is too high for the amount needed by the breed, the food source will be ignored. The food's point value is determined by the food units multiplied by the food quality. So if the food quality is 10, one unit is worth 10 food points.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Starvation_Odds</p>
            <span><p class='description'>This value defines the odds of death below the Starvation_Threshold. If you set this value as '0' the breed will always die from hunger, if you set it to '-1' the bred will never die from hunger. The higher the odds value, the less likely the breed will die from hunger. When death occurs, the 'dead' event is raised and aging, breeding, hunger, and growth is haulted. Action classes, including prim animations and movement, will continue to run but can be disabled within the 'dead' event.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Starvation_Threshold</p>
            <span><p class='description'>If the hunger Starvation_Odds have been set, this value defines the minimum hunger percentage threshold. If the threshold is breached and the odds result in favor of death, the object will trigger 'dead' event.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Hunger_Odds</p>
            <span><p class='description'>The odds of the breed skipping a meal. If a meal is skipped, the breed still suffers a hunger point reduction based on the Percent_Lost setting. Set to '0' to always eat.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Hunger_Time</p>
            <span><p class='description'>This value determines how often to check for food objects in minutes. The breed will select one food source that has enough food units to meet the minimal requirements for consumption. When the food is consumed, the breed's hunger points increase to a maximum of 100. Set this value to '0' to disable hunger. Similar to the lifespan year, the hunger cycle is checked every 60 seconds to determine if the cycle has expired. If multiple 'cycles' have passed since the last time it was checked, the breed will only call one hunger cycle.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Percent_Lost</p>
            <span><p class='description'>This value defines the amount of hunger points lost each hunger cycle whether the consumption odds skip the hunger cycle or not.</p></span>
            </div>

            <p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>GROWTH</p>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Growth_Scale</p>
            <span><p class='description'>This value is the growth scale that is applied during each growth stage. This value must be greater than '1.0' for increasing the size, where 1.0 equals 100% of current size and 1.2 equals 120% of current size. This value can also be less than 1.0 for objects that shrink throughout it's lifespan. As with increasing sizes, the prim animations and sit/camera positions are also adjusted for shrinking primsets. Use this value with caution, as primsets will not allow growth to occur if any one prim is larger than 64 meters or smaller than 0.01 meters.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Growth_Stages</p>
            <span><p class='description'>Growth is a core function that resizes and repositions all prims in a linkset. This results in a scaled breed based on the Growth_Scale and it's previous scale. This value defines the growth increments or how many growth cycles you wish to occur throughout it's lifespan. Set this value to '0' to disable growth. When a breed is rebuilt, it will return to it's last known growth timer, scale, and stage. Prim animations will also be scaled according to the last known growth scale, and you may also allow the sit and camera positions to be adjusted along with growth to accomidate the new size. However, the avatar must be reseated for the new sit and camera positions to take affect if the avatar is seated on the breed during a growth stage.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Growth_Odds</p>
            <span><p class='description'>This value defines the odds of skipping a growth stage. When a growth cycle expires, this value helps randomly determine if the cycle should get skipped. If a cycle is skipped, a growth stage is subtracted and no growth occurs. Set this value to '0' to never skip a growth stage. Setting the value to '1' would be a 50/50 chance, and the higher the number, the more likely the growth stage will be skipped.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Growth_Timescale</p>
            <span><p class='description'>This is the length of time in minutes between each growth cycle. Similar to the lifespan year, the growth cycle is checked every 60 seconds to determine if the cycle has expired. If multiple 'cycles' have passed since the last time it was checked, the breed will only call one growth cycle.</p></span>
            </div>

            <p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>LIFESPAN</p>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Lifespan</p>
            <span><p class='description'>Lifespan is part of the core functionality which defines the aging of breeds. Breeding also relies on the age of the breed, so unless a minimum breeding age is set as 0 lifespan must be enabled to allow breeding to occur.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Age_Min</p>
            <span><p class='description'>This is the minimum age the breed must reach before possible death from 'old age'. After the breed reaches this age, it's survival is based on the Survival_Odds. Once the breed reaches it's maximum age, if defined, the breed will immediately die.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Age_Max</p>
            <span><p class='description'>This is the maximum age the breed can reach before death from 'old age'. After the breed reaches this age, it's survival is no longer based on the Survival_Odds, the breed will immediately die which causes hunger, aging, breeding, and growth to stop. Action methods including movement and prim animations will continue unless stopped within the native 'dead' event. This value can be set to '-1' to allow it to continue aging indefinitely.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Survival_Odds</p>
            <span><p class='description'>The odds of death once the breed is within the min and max lifespan age. Set this value to '0' for instant death once it reaches it's minimum age, or '-1' to allow it to continue until it's maximum age. If both this value and max age is set to '-1' the breed will age indefinitely. Otherwise set a survival odds where the higher the number, the less chance of death. This value no longer affects survival once the breed reaches it's maximum age if set.</p></span>
            </div>

            <p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>MOVEMENT</p>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Move_Attempts</p>
            <span><p class='description'>This occurance counter counts the number of attempts the breed has used, with move cycles defined by the Move_Timer, to reach it's destination vector. If the maximum Move_Attempts have been used, the breed calls the arrived callback. You may set this to '-1' to allow an unlimited number of movement attempts for it to reach it's destination.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Move_Timer</p>
            <span><p class='description'>This value sets the frequency of move attempts in seconds. For each move attempt, the breed will rotate and move towards the destination vector based on the movement behavior defined.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />Turning_Speed</p>
            <span><p class='description'>The strength of the turning behavior is represented by efficiency and time. A lower efficiency value indicates a stronger turn, while a higher value will result in a more realistic and slightly more rounded turn. If the value is too high, the breed may not reach it's rotational target by the time it reaches it's linear destination, thus causing it to circle around the destination position endlessly.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />Turning_Time</p>
            <span><p class='description'>The time in seconds it takes the breed to reach it's rotational target based on the efficiency of the turn and the speed of the Move_Timer and forward velocity.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />Slope_Offset</p>
            <span><p class='description'>This offset gives you control over the AVOID_SLOPES flag for the move() method. This flag only detects inclines that are greater than the breed-object's geometric center plus this offset. If the incline is greater than this height, the breed will not attempt to move to that destination, instead calling the avoid callback defined within the method, otherwise silently fails.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Finish_Move</p>
            <span><p class='description'>In order to ensure breeds finish their move to their destination vector before accepting new move requests, set this value to TRUE. It will ignore new requests until the destination has been reached. Otherwise set this to FALSE to allow the movement to be interupted and redirected to a new destination or with new movement behavior. This value can be changed with the val() method to allow some movement events to be uninterupted, such as to send the breed to a static position, or otherwise allow to be interupted, such as for a wandering type of behavior.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />Target_Dist_Min</p>
            <span><p class='description'>This value defines the distance in meters for how close a breed must be to it's target destination before calling the arrived callback. This value is checked during every movement cycle defined by the Move_Timer, so if the Move_Timer is too long, the breed may pass the destination position before checking it's distance. The only exception being non-physical movement which goes directly to the destination, where physical movement rotates and moves towards the destination. If the speed is too great combined with a short target distance, the target destination may be passed as well. The right combination of movement speed and distance filter will provide the desired actuation of movement. Conversely, if the speed is slow and the distance is too far, the breed may always stop too soon. This distance value should be considered the margin of error for physics-based movement towards a destination vector.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Allow_Drift</p>
            <span><p class='description'>This filter determines if a breed can move beyond it's destination if it arrives or comes within the margin of error (Target_Dist_Min) between movements as defined by the Move_Timer. The distance to the destination vector is checked twice during movement cycles, once as soon as the cycle occurs, and a second time when the movement occurs. This value, when enabled, blocks the first filter which results in an unconstrained movement towards the destination vector and is vital for a smooth transition between multiple destination vectors.</p></span>
            </div>
            
            <p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>BREED VALUES</p>
            <div class='expand entry'>
            <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />Dead</p>
            <span><p class='description'>Setting this value to '0' triggers the native 'dead' event and effectively disables all core functionality. Setting the value back to '1' re-enables the core functionality and toggles the 'start' event.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />breed_name</p>
            <span><p class='description'>breed object's name </p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />MyPartner</p>
            <span><p class='description'>breed object's partner (if <a show='settings'>Require_Partners</a> is set to TRUE)</p></span>
            </div>

            <p style='font-weight:bold;color: #0F67A1;font-size:0.9em;'>DEFAULT VALUES</p>
            <div class='expand entry'>
            <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />Sound_Volume</p>
            <span><p class='description'>The sound volume (with a loudness range of 0.0 to 1.0) which can also be changed later using the val() method.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />Text_Color</p>
            <span><p class='description'>The hover text color that shows up over your breed can be defined here in vector format ( ie &lt;red, green, blue&gt; ). You can also change this value later using the val() method.</p></span>
            </div>
            <div class='expand entry'>
            <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />Owner_Only</p>
            <span><p class='description'>TRUE or FALSE : Only interact with same-owner action-objects?</p></span>
            </div>
            
            
            </span>