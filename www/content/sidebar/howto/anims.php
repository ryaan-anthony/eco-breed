
<?php
print "<p class='widget-line-$odd'>Prim Animations: How to use animations.</p>";
?>

<span style='display:none;'>
    	<?php print wtheadline('Animate your breed!','Prim methods can include additional values to form an animation sequence where each new value is a new frame. This means, the first frame in each method will be run as \'Frame 1\' in the animation sequence. This gives you the ability to manipulate multiple prims using various methods. To leave a value unchanged during a sequence, just use \'null\' as the value for that frame. Prim animations must be cached (from the webserver) before they can be used by the breed object. Do this by using the cache() method to pull the animations by their name and in the set() method to start the animation.'); ?>     
        	<p class='sub-in'>For the following examples, assume you created an <strong>animation named "Walking".</strong></p>		
			<?php print method_profile(
			'cache',
			'anim [ , anim ... ]',
			array(
				'','Request the prim animations from the webserver and is most practical when applied in the \'start\' event.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.'
			),
			actions_code('"start",
"cache(Walking)"'),
			'The animation "Walking" is loaded into the breed and ready to be used.',
        	actions_code('"start",
"cache(Walking, Stopped)"'),
       	  	'If you have a second animation, such as "Stopped", define them as comma seperated values.'
			);?>        	
			<?php print method_profile(
			'set',
			'anim [, anim ... ]',
			array(
				'','Start or trigger animations.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.',
				'Save the animation?','Append a vertical bar \'|\' to the animation with the word "true" and animations will be saved and reapplied if the breed is rebuilt. Used to reapply changes when rebuilt.'
			),
			actions_code('"start",
"cache(Walking)
 set(Walking)"'),
			'You could start it immediately when loaded, but that\'s not usually practical.',
			actions_code('"start",
"cache(Walking)
bind(touch, owner, animate)",

"animate",
"set(Walking)"'),
			'This starts the animation when the breed is touched by the owner.',
			actions_code('"start",
"cache(Walking)
bind(timer, 15, walk around)",

"walk around",
"move(%action_pos%, <5i,5i,0>, walk|Walking)"'),
			'The most common use for animations is coupled with movement. Here I combined a simple wander where the animation "Walking" is combined with the movement type.',
			actions_code('"start",
"cache(Walking, Stopped)
bind(timer, 15, walk around)",

"walk around",
"move(%action_pos%, <5i,5i,0>, walk|Walking|Stopped)"'),
			'You can also set the standing animation as a 3rd \'type\' value, otherwise the animation is unset() after the move.'
			);?>        	
			<?php print method_profile(
			'unset',
			'anim [, anim ... ]',
			array(
				'','Stop looping animations.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.',
				'Unsave a previously saved animation?','Append a vertical bar \'|\' to the animation with the word "true" and animations will be saved and reapplied if the breed is rebuilt.'
			),
			actions_code('"start",
"cache(Walking)
 set(Walking)
 bind(touch, owner, remove)",
 
"remove",
"unset(Walking)"'),
			'Animation starts immediately and stops when the breed is touched by the owner.'
			);?>        	
			<?php print method_profile(
			'uncache',
			'anim [, anim ... ]',
			array(
				'','Use this method uncache prim animations that will no longer be used in the action-classes list. It is good practice to clear un-needed animations from the script\'s overhead memory.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.'
			),
			actions_code('"start",
"cache(Walking)
 set(Walking)
 uncache(Walking)"'),
			'This is a simple way to request the animation, set it, and clear the params from the cache. Very useful for accessories or other animations that need to be applied only once.'
			);?>            
  
</span>