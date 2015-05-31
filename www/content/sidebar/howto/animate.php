
<?php
print "<p class='widget-line-$odd'>Methods: Animating the owner's avatar.</p>";
?>

<span style='display:none;'>

             
    	<?php print wtheadline('Animating the owner\'s avatar', 'requires a one time permissions request which is sent during the first anim() activity. After the permissions have been granted, the breed can trigger a variety of animations upon the owner, seamlessly.'); ?>
     
        	<?php print method_profile(
'anim',
'[ animation [ , duration ] ]',
array(
'animation','name of the animation, must be within the contents of the breed object or this method will silently fail.',
'duration','set a timeout, in seconds, so you can loop the animation for a controled period of time. Without the duration, the animation persists and remains active until released.'
),
actions_code('"start",
"anim(animation, 10)"'),
'play an animation for 10 seconds',
actions_code('"start",
"anim(animation, 0)"'),
'release the animation after one cycle',
actions_code('"start",
"anim()"'),
'release all animations',
actions_code('"start",
"anim(animation, -1)"'),
'release a specific animation'
);?>            
        	<h3>Pet the breed on arrival</h3>
			<?php print actions_code('"start", 
"bind(touch, owner, come)",

"come",
"move(%owner_pos%,<0,0,0>,walk,normal,arrived)",

"arrived",
"anim(pet,10)"');?>
			<p class='description'>When touched by the owner, the breed comes to the owner's position. When the breed arrives, the owner is animated for 10 seconds. This example requires an animation named "pet".</p>
            
            

</span>