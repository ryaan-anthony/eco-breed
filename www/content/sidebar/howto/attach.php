
<?php
print "<p class='widget-line-$odd'>Methods: Attaching to the owner's avatar.</p>";
?>

<span style='display:none;'>
              
    	<?php print wtheadline("Hold or 'wear' a breed object","using the attach() method which requires a one-time permissions request. Successful attaching/wearing of the breed-object also toggles the 'attach' bind() event. To detach without the breed-object going into your inventory, right click and select 'drop' which will return the object to the ground and raise the 'detach' bind()."); ?>
<?php print method_profile(
'attach',
'[ attach-point ]',
array(
	'attach-point','an optional <a href="http://wiki.secondlife.com/wiki/LlAttachToAvatar" target="_blank">attachment point</a> as an integer number.'
),
actions_code('"start", 
"attach()"'),
'Attaches breed to last known or default attachment spot.',
actions_code('"start", 
"bind(attach,null,attached)
bind(detach,null,detached)
attach()",

"attached", 
"say(Successfully attached!)",

"detached", 
"say(Successfully detached!)"'),
			'This example attaches the breed-object at the native \'start\' event and binds attach/detach callbacks. The breed-object displays a success message in local chat when successfully attached and another success message when the avatar manually drops the breed-object.'
			);?>
        	<h3>Animate and attach.</h3>
        	<?php print actions_code('"start", 
"bind(touch, owner, come)
 bind(attach, null, on)
 bind(detach, null, off)",

"come",
"move(%owner_pos%,<0,0,0>,walk,normal,arrived)",

"arrived",
"attach()",

"on",
"anim(hold,10)",

"off",
"anim(hold,-1)"');?>
			<p class='description'>When touched by the owner, the breed comes to the owner's position. When the breed arrives, the breed is attached and the owner is animated for 10 seconds. This example requires an animation named "hold".</p>


</span>