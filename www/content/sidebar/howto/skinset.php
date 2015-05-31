

<?php
print "<p class='widget-line-$odd'>Skins: Define skins on the web server.</p>";
?>

<span style='display:none;'>
<?php print wtheadline('After creating your skinsets','define them on the webserver. '); ?>
      
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
</span>