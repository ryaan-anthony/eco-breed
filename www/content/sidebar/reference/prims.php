
<?php
print "<p class='widget-line-$odd'>Prim Methods</p>";
?>

<span style='display:none;'>
        <?php print wtheadline('Prim Methods','are used to define changes to a linkset such as the texture, color, sculpt, and/or size for prim animations and skins. These methods can only be compiled on the webserver and <strong>can not be directly injected</strong> into the Actions. For a skin, each method will only accept 1 value. Animations can be 1 or more value, with each value indicating a frame in the anim sequence. A class name is given to a set of prim animations, meaning a single class name can trigger one or more prim methods and run them based on other settings for that class.'); ?>
 
			<?php print normalSetting(
		'alpha',
		'prim, face, float [ , float ... ]',
		'Transparency animations allow you to set or alternate the transparency (alpha) of a specific prim and face (with a range of 0.0 to 1.0).',
		'alpha(-1,-1,0,1)',
		'This example changes all sides (-1) and all prims of a linkset\'s transparency to invisible before returning it to visible.'
		); ?>
			<?php print normalSetting(
		'color',
		'prim, face, vector [ , vector ... ]',
		'Color animations allow you to set or alternate the color of a specific prim and face. This method also accepts the "r" modifier for randomized colors.',
		'color(-1,-1,<1,0,0>,<1,1,1>)',
		'This example changes all sides (-1) and all prims of a linkset\'s color to red before returning it to white.',
		'color(-1,-1,<1r,0,0>)',
		'This example uses the "r" modifier in the color vector which creates a random shade of red which is set to all prims and sides.'
		); ?>
			<?php print normalSetting(
		'glow',
		'prim, face, value [ , value ... ]',
		'Sets a glow to a specific prim/face. Valid glow values include float (decimal) values between 0.0 and 1.0',
		'glow(1,-1,0.5)',
		'This example changes all sides (-1) and all prims (-1) of the linkset\'s shine to 0.5.'
		); ?>
			<?php print normalSetting(
		'pos',
		'prim, vector [ , vector ... ]',
		'Position animations require local positions (the offset position vector from the root prim, based on the objects local rotation). If this method is used on the root prim, it will act as an offset from its currently global position vector (ie. <0,0,1> will move the entire object up 1 meter from its current global position vector).',
		'pos(2,<0,0,1>,<0,0,0.5>)',
		'This example moves the 2nd linked prim to 1 meter directly above the root prim before returning it to 0.5 meters above the root.'
		); ?>
			<?php print normalSetting(
		'rot',
		'prim, rotation [ , rotation ... ]',
		'Rotation animations require local rotations, meaning the rotation of the child prims relative to the local object itself.',
		'rot(2,<0, 0, 0.38, 0.92>, <0,0,0,0>)',
		'This example rotates the 2nd linked prim 45 degrees along the Z axis before returning it to a zero rotation.'
		); ?>
			<?php print normalSetting(
		'sculpt',
		'prim, flags, uuid [ , uuid ... ]',
		'Sculpt animations are very useful for swapping sculpt maps or for progressively applying new sculpts to individual prims. To return a sculpted prim to a standard prim, use the type() method.
		<hr style="margin: 5px 0;" />
		<span style="font-size:0.8em;">
			Append flags to the stitching type with a \'|\' seperator. 
			<br /> 
			<strong>Stitching type:</strong> 0=none, 1=sphere, 2=torus, 3=plane, 4=cylinder.
			<br /> 
			<strong>Optional flags:</strong> 64=invert, 128=mirror. 
			<br /> 
			&nbsp; &nbsp; Sphere mirrored: 1|128.
			<br /> 
			&nbsp; &nbsp; Cylinder inverted and mirrored: 4|64|128.
		</span>',
		'sculpt(2, 1|64, bea82b0f-27c6-730b-fd7f-733f2340b449)',
		'This example sets the 2nd linked prim to an apple sculpt with a sphere stitch type and marked inside-out.'
		); ?>
			<?php print normalSetting(
		'shine',
		'prim, face, value [ , value ... ]',
		'Sets a shine to a specific prim/face. Valid shine values include "high", "med", "low", or "none".',
		'shine(-1,-1,med)',
		'This example changes all sides (-1) and all prims (-1) of the linkset\'s shine to medium ("med").'
		); ?>
			<?php print normalSetting(
		'size',
		'prim, vector [ , vector ... ]',
		'Size/Scale animations are useful for a range of effects and may be used on the main/root prim.',
		'size(1,<1,1,1>,<0.5,0.5,0.5>)',
		'This example scales the root prim to 1 meter, then to 0.5 meters on all axis.'
		); ?>
			<?php print normalSetting(
		'texture',
		'prim, face, uuid [ , uuid ... ]',
		'Texture animations can be used for a variety of purposes. Most common uses are blinking textured (non-prim) eyes or moving textured (non-prim) lips. Use caution with applying textures rapidly as each client must load each texture. Preloading the textures by retaining an already rendered texture within the linkset is the best practice for rapid texture rendering. Also, textures equal to or less than 512x512 pixils render faster.',
		'texture(-1, -1, 840e0d6d-a176-3076-2708-5b3fb1a0cdba, 89556747-24cb-43ed-920b-47caed15465f)',
		'This example sets all sides (-1) and all prims (-1) of a linkset to an "apple" texture before returning it to a "default box" texture.'
		); ?>
			<?php print normalSetting(
		'type',
		'prim, type, params',
		'The type() method cannot be a repeating animation, rather it is used to change the prim type of a prim or multiple prims. This method requires you supply the correct set of params for each prim type. See the <a href="http://wiki.secondlife.com/wiki/LlSetLinkPrimitiveParamsFast" target="_blank">lsl wiki page</a> for details on the expected parameters for each type or refer to the following table:'.normal_code('[type]			[params]

box 		hole,cut,hollow,twist,top_size,shear
cylinder 	hole,cut,hollow,twist,top_size,shear
prism 		hole,cut,hollow,twist,top_size,shear
sphere 		hole,cut,hollow,twist,dimple
torus 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
tube 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
ring 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
sculpt 		map,type'),
		'type(-1,box,0,<0, 1, 0>,0,<0, 0, 0>,<1, 1, 0>,<0, 0, 0>)',
		'This example sets all prims (-1) of a linkset to default box. Note: this does not change the scale, rotation, color, or texture of the object.'
		); ?>
 
    	<?php print wtheadline('Condense your prim methods','to save space, increase execution time, and make modifications easier. Prim methods give you the ability to define an attribute for a specific prim or face. To set the <strong>same value to multiple prims</strong> or faces, use the vertical bar \'|\' as a separator or use \'-1\' for ALL.'); ?>
   
        
            <p class='sub-in sit'><strong>Use '-1'</strong> to indicate ALL_PRIMS.</p>
        	<?php print big_code('method( -1, value )');?>
            
            <p class='sub-in sit'>If the method <strong>requires sides to be defined</strong>, use '-1' to indicate ALL_SIDES (faces).</p>
        	<?php print big_code('method( -1, -1, value )');?>
                        
            <p class='sub-in sit'>All sides (faces) of the <strong>2nd, 3rd, and 4th</strong> prim.</p>
        	<?php print big_code('method( 2|3|4, -1, value )');?>
            
            <p class='sub-in sit'>Only face '0' of the <strong>2nd, 3rd, and 4th</strong> prim.</p>
        	<?php print big_code('method( 2|3|4, 0, value )');?>
            
            <p class='sub-in sit'>Face '1' and '3' of the <strong>4th</strong> prim.</p>
        	<?php print big_code('method( 4, 1|3, value )');?>
            
            <hr />
            
            <p class='sub-in'>This next example creates a walking animation for the <strong>default dog</strong>; the legs are animated using 4 rotation frames:</p>
            
            <?php print normal_code('rot(10,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(11,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(9,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(12,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)');?>
            <p class='description'>This is the raw result from a basic param finder script for 4 prims rotated</p>
            
            <?php print normal_code('rot(10|12,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(9|11,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)');?>
            <p class='description'>This condenses 4 methods into 2 by combining prim 10 & 12 as well as 9 & 11 since they have the same animation sequence.</p>
            
            <?php print normal_code('rot(10|12,<0,.173,0,.984>,0,<0,-.173,0,.984>,0)
rot(9|11,<0,-.173,0,.984>,0,<0,.173,0,.984>,0)');?>
            <p class='description'>This condenses the string length by removing unnecessary zeros and set the ZERO_ROTATION values to just '0'. This does not speed up execution time, but it does reduce the amount of memory used to cache or apply the animation, skin, or effect.</p>

</span>