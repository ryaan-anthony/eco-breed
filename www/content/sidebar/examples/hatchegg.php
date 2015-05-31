
<?php
print "<p class='widget-line-$odd'>Hatch your breed from an egg</p>";
?>

<span style='display:none;'>	
		
		<?php print wtheadline('Hatch your breed',' from an egg. You can use this example to have a more advanced birth sequence. Breeds will display stats but will not age, grow, get hungry, or breed until \'hatched\'.'); ?>
        <div style='padding:20px;'>
	      	<?php print videolink('STARTING FROM AN EGG (9:40)', 'xPd12IWLJv0');?>
			<h4 align='center'>Please watch the video before continuing.</h4>
        	<?php print actions_code('"start",
"filter(!%BORN%)
cache(Hatched)
text(Name: %MyName% \n Gender: %MyGender%)
bind(timer,20,hatch,remove_hatch)",

"hatch",
"unbind(remove_hatch)
text(Hatching..)
set(Hatched)
uncache(Hatched)
prop(BORN,true)
val(Lifespan,1)
bind(timer,15,text_stats)",

"text_stats",
"text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender%)"');?>
			<p class='sub-in hang'>This example requires an animation named <strong>"Hatched"</strong> to be created. This simulation <strong>enables Lifespan</strong> after the timer expires and sets the "Hatched" animations, essentially shrinking the 'Egg' prim.</p>
        </div>
        
</span>