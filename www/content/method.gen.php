<?php include('preload.php'); ?>

<!--Skinsets-->
<!--Skins are compiled on the webserver using the eco-web API or from the 'my_species' tab on the "My Eco-Breeds" page. When a request is sent from Second Life, the skinset names are saved and the "Prim Methods" are applied to the eco-breeds. Depending on how many min/max skins are set, additional skins will be saved and not applied, these are called "dormant skins". All skinset names are later used to apply their children's skins. The skinning algorithm attempts to apply one skinset per category, allowing you to have a series of possible sets, such as 'Eyes', 'Furs', 'Ears', etc, but only apply one Skin per Category. There must be at least one common skin for each for the category for application to be mandatory (ie. Odds=0 | Gen=1) otherwise a skin for that category may not be applied. The Skins_Min setting should be at least the number of skin categories that have been created in order to ensure that one skin for each category will be applied. Once all categories have been applied and 'slots' remain (available number of skins between Skins_Min and Skins_Max), additional skins may be saved as dormant skins which will be available to offspring. To create rare or unlockable skinsets, set the Odds value (higher = more rare) and/or the Gen value (the skin is available when the breed is a specified generation or greater). Generations are defined by the oldest generation in it's liniage if Select_Highest_Gen is TRUE, otherwise it selects the youngest generation in it's liniage. For example: if TRUE and a 3rd generation male mates with a 10th generation female, the offspring will be an 11th generation breed, otherwise the offspring will be a 4th generation breed. Changes to skinsets can be made at any time but will not affect existing breeds, only their offspring. However, you may also alter the appearance of an existing breed with the same "Prim Methods" by using the set() method (see "Prim Animations").-->
<div num='3b' class='sub-content'>
    <div class='frame-3b'>
        <?php print subButton('skinanim.anims','Continue to Anims'); ?>
        <?php print wtheadline('Skins','can be applied in a variety of ways to suit your needs. Such as mixed coat, pure breed, rare, unlockable, limited edition, with or without genetic or built-in preferences. A skinset can alter the entire primset or just individual surfaces. The skin a breed has can also be used to define functionality such as behavior, traits, titles, etc.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Enable skins in the breed object:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Create a skinset:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Define skins on the web server:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-3b' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('To enable skins,','the breed object requires the following configurations:'); ?>
        <div style='padding:20px;'>
        	<?php print breedSetting(
		'Skins',
		'FALSE',
		'TRUE or FALSE : Apply and save skinsets from the webserver?',
		'Skins = TRUE;',
		'Breeds will now apply skins.'
		); ?>
        	<?php print breedSetting(
		'Skins_Min',
		'1',
		'Minimum number of skinsets to save.',
		'Skins_Min = 5;',
		'The breed will find at LEAST 5 skins and apply one from each category, saving the rest as dormant.'
		); ?>
        	<?php print breedSetting(
		'Skins_Max',
		'2',
		'Maximum number of skinsets to save.',
		'Skins_Max = 5;',
		'The breed will find at MOST 5 skins and apply one from each category, saving the rest as dormant.'
		); ?>
        	<?php print breedSetting(
		'Preserve_Lineage',
		'TRUE',
		'TRUE or FALSE : Allow offspring to get their skins from parents?',
		'Preserve_Lineage = FALSE;',
		'Each breed born/created will create a completely random skinset, instead of genetic preferences.'
		); ?>
        	<?php print breedSetting(
		'Preferred_Skins',
		'null',
		'Apply only these skins if available : Format = ["name;category", "name;category", ... ]',
		'Preferred_Skins = ["Red;None"];',
		'The breed will attempt to apply a skin called "Red" with "None" as the category. If the "Red" skin is limited or locked, alternate skins will be applied and saved.'
		); ?>
        </div>
    </div>
    <div num='2' class='frame-3b' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('How to create a skinset','using the the Prim Method Generator.'); ?>
        <div style='padding:20px;'>
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
        </div>
    </div>
    <div num='3' class='frame-3b' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('After creating your skinsets','define them on the webserver. '); ?>
        <div style='padding:20px;'>
        	<p class='sub-in'>Start by logging into your account and <strong>select the species</strong> you want to modify.</p>
	   		<?php print howToIMG('In the skins section, click new:','newskin',150); ?> 
        	<p class='sub-in sit'>To continue from the previous demo, we'll add the color method we created:</p>
	   		<?php print howToIMG('Add the prim method(s) here:','newskinfilled',150); ?> 
        	<p class='sub-in hang'>The Skin Name is set to <strong>Dark</strong> and the Category is <strong>Coat</strong> which defines it as the dark coat. To create another coat, reuse the "Coat" category with a new Skin Name and the modified methods.</p>
            <hr />            
	        <?php print videolink('Display the skin based on the category', 'W07e5kZuHm8');?>
            <hr />
			<?php print normalSetting(
		'Skin Name',
		'<strong style="font-size:0.8em;">default:</strong> None',
		'Class name which is used to identify the skin.',
		'',
		'Click \'(edit)\' to change the name after it\'s saved.'
		); ?>
			<?php print normalSetting(
		'Category',
		'<strong style="font-size:0.8em;">default:</strong> None',
		'Categories allow multiple skins to be applied to different parts of the body. The breed will apply 1 skin per category.',
		'',
		'Click \'(edit)\' to change the name after it\'s saved.'
		); ?>
			<?php print normalSetting(
		'Gen',
		'<strong style="font-size:0.8em;">default:</strong> 1',
		'This filter limits application of the skin based on the breed\'s generation.',
		'Gen = -3',
		'Only generation 3 breeds can apply this skin.',
		'Gen = 3',
		'Generation 3 AND HIGHER breeds can apply this skin.'
		); ?>
			<?php print normalSetting(
		'Odds',
		'<strong style="font-size:0.8em;">default:</strong> 0',
		'The higher the number, the more rare. Setting this to -1 disables the skin for 1st generation breeds, but can still be passed down to offspring. If you have multiple common skins (set to 0) one will be randomly selected.',
		'Odds = 5',
		'More rare than 2 or 3 but more common than 10 or 12.'
		); ?>
			<?php print normalSetting(
		'Limit',
		'<strong style="font-size:0.8em;">default:</strong> -1',
		'Limit the number of applications of this skin. Set to -1 for unlimited or to 0 to disable use of this skin for any new breed.',
		'Limit = 5',
		'Only 5 breeds will ever be able to apply this skin.'
		); ?>
        </div>
    </div>
</div>
