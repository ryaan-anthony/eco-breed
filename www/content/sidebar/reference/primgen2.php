
<?php
print "<p class='widget-line-$odd'>Prim Method Generator: Anims</p>";
?>

<span style='display:none;'>

 			<?php print wtheadline('How to create a basic animation.','Use this as a general guide for creating basic animations.'); ?>

       	  	<p class='sub-in sit'>First, insert the <strong>Generator Script</strong> into your breed object.</p>
    		<?php print howToIMG('Select a <strong>method type</strong> : <em style="font-size:0.8em;">"ROT" for this demo</em>','1-insertgenerator'); ?>    
    		<?php print howToIMG('Touch <strong>each prim</strong> to record then click "Save":','2-clickprimsave'); ?> 
        	<p class='sub-in'>For this demo, I touched the <strong>right arm</strong> and clicked "Save". Multiple prims can be done simultaneously by touching each prim before clicking "Save".</p>   
            <p class='sub-in'>The generator is now ready to record ROT methods for the <strong>right arm</strong> prim.</p>
    		<?php print howToIMG('Rotate the prim and <strong>click "Set Frame"</strong> :','3-rotandset'); ?>    
    		<?php print howToIMG('Repeat for the second frame and <strong>click "Print"</strong> :','4-printresults'); ?>
        	<p class='sub-in'>This demo creates a waving animation.</p>   
   		  	<?php print howToIMG('Save the results on the website:','5-saveresults'); ?>    
            <p class='sub-in'>Define the frames, repeat, and delay. Demo: 2 frames, -1 repeat, and 0.5 delay</p>
        	<p class='sub-in sit'>Now simply <strong>cache() and set()</strong> the animation in your Actions:</p>
        	<?php print actions_code('"start",
"cache(Wave)
set(Wave)"');?>
            <p class='howto-img-txt'>&bull; Now your breed is animated: <img id='wave-object' src='img/howto/wave1.png' style='height:300px;width:200px;' class='howto-img'/></p>
			<script>$(document).ready(function(){eco_wave0();});</script>
</span>