
<?php
print "<p class='widget-line-$odd'>Prim Method Generator: Skins</p>";
?>

<span style='display:none;'>
<?php print wtheadline('How to create a skinset','using the the Prim Method Generator.'); ?>

        	<p class='sub-in'>First, insert the <strong>Prim Method Generator</strong> script into your breed object.</p>
   			<?php print howToIMG('<strong>Select a method</strong>:','1-insertgenerator2'); ?>  
        	<p class='sub-in hang'>For this demo, i selected to record the 'COLOR' method.</p>
   			<?php print howToIMG('<strong>Touch each prim</strong> to record:','2-clickprimsave2'); ?> 
        	<p class='sub-in hang'><strong>Click "SAVE". </strong>For this demo, link numbers <strong>1,2,3,9,11,12,13,14</strong> (the white body prims) will be recorded.</p> 
   			<?php print howToIMG('Set the color, click "Set Frame":','3-colorandset'); ?>  
        	<p class='sub-in sit'>"Set Frame" records the white body prims and the result is <strong>something like this</strong>:</p>
            <?php print normal_code('color(9,-1,<0.74902, 0.74902, 0.74902>)
color(1,-1,<0.74902, 0.74902, 0.74902>)
color(3,-1,<0.74902, 0.74902, 0.74902>)
color(2,-1,<0.74902, 0.74902, 0.74902>)
color(12,-1,<0.74902, 0.74902, 0.74902>)
color(13,-1,<0.74902, 0.74902, 0.74902>)
color(11,-1,<0.74902, 0.74902, 0.74902>)
color(14,-1,<0.74902, 0.74902, 0.74902>)');?>
        	<p class='sub-in sit'>Since these 8 prims have the same value, <strong>use shorthand</strong> for the same effect:</p>
            <?php print normal_code('color(1|2|3|9|11|12|13|14, -1, <0.75, 0.75, 0.75>)');?>
        	<p class='sub-in sit'>We can now <strong>manually change the color</strong> to create other skins:</p>
            <?php print normal_code('color(1|2|3|9|11|12|13|14, -1, <0.50, 0.50, 0.50>)');?>
        	<p class='description'>Now it's a darker gray!</p>
        	<p class='sub-in'>Repeat this process for any other prim methods. Create pure breeds where all prim methods are defined in a single skinset OR as part of a mixed breed where parts of your breed such as eyes, ears, coat, etc are randomly mixed and matched.</p>        	

        </span>