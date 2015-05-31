
<?php
print "<p class='widget-line-$odd'>Breed Setup: Explore Lifespan</p>";
?>

<span style='display:none;'>

		<?php print wtheadline('Lifespan','refers to life, the ageing process, and death for the breeds. Age can be used to affect functionality and even physical appearance. The breed object\'s age is determined by user-defined \'years\'. The lifespan cycle occurs every \'year\' and is checked every 60 seconds to determine if the cycle has expired. If multiple \'years\' have passed since the last time it was checked, the breed will age accordingly.'); ?>
        	<h3>Explore these <a class='title inline'>breed settings</a> values:</h3>
        	<?php print breedSetting(
		'Does your breed age?',
		'YES/NO',
		'TRUE or FALSE : Enable ageing?'
		); ?>
        	<?php print breedSetting(
		'Length of a year in minutes',
		'1440',
		'The age can be used to manage death as well as breeding, so the length of a year can also affect other behaviors.'
		); ?>
                       
            <?php print breedSetting(
		'Define old age',
		'min:15 max:-1',
		'Minimum age before death from old age can occur.'
		); ?>
	        <?php print breedSetting(
		'Chances of death from old age',
		'NEVER',
		'Odds of death within min/max age'
		); ?>
   
</span>