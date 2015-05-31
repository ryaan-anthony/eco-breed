
<?php
print "<p class='widget-line-$odd'>Breed Setup: Explore the breeding behaviors</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('Breeding','is the act of mating and/or producing offspring where the parent(s) pass on unique information such as skin preferences or other traits to their offspring, thus creating a unique lineage. <strong>Partnership, sexuality, and pregnancy</strong> are individually configured to define the overall breeding behavior of your species.'); ?>
	        <h2 align='center'>Genders</h2>
        	<?php print breedSetting(
		'Does your breed have genders?',
		'YES/NO',
		'This determines whether or not your breeds will have dual gender labels such as "Male" and "Female" or if it is a unisex breed. These labels can be defined in the advanced settings.'
		); ?>
        	<?php print breedSetting(
		'Gender ratio',
		'EVEN',
		'Ratio of gender selection upon creation. This is where you can force gender or make one sex more rare than another.'
		); ?>
        	<hr />
	        <h2 align='center'>Partners</h2>
        	<?php print breedSetting(
		'Require partners to breed?',
		'YES/NO',
		'If set to "NO" the results will be an asexual breed.'
		); ?>
        	<?php print breedSetting(
		'Disallow breeding among siblings and parents?',
		'YES/NO',
		'This is the "incest" filter which if set to YES will disallow breeding between any breed that have a common relative such as a parent or sibling.'
		); ?>
        	<?php print breedSetting(
		'Keep the same partners each breeding cycle?',
		'YES/NO',
		'If partners are kept each cycle (set to YES for monogamy), both partners will have to be present when each breeding cycle reaches maturity, otherwise the breeding cycle is skipped. If set to NO, a random partner is selected from the available gene pool.'
		); ?>
        	<?php print breedSetting(
		'Look for new partner after how many cycles?',
		'0',
		'If partners are set to be kept each cycle, how many breeding cycles without a partner can pass before looking for new partner? Setting this value to 1 is not recommended and will cause monogamous breeds to leave their partners early.'
		); ?>
        	<hr />
	        <h2 align='center'>Breed Cycle</h2>
        	<?php print breedSetting(
		'How often does your breed reproduce, in minutes?',
		'0',
		'When a breeding cycle expires the breeding protocol is initiated. Depending on the configurations, during this event the breed either seeks out a partner to breed with or breeds with an existing partner.'
		); ?>
        	<?php print breedSetting(
		'Age bracket where breeding occurs',
		'min:0 max:-1',
		'With this filter set, the breeding event is disabled when not within the age range.'
		); ?>
        	<hr />
	        <h2 align='center'>Pregnancy</h2>    
        	<?php print breedSetting(
		'Length of pregnancy in minutes',
		'0',
		'Time in minutes between breeding and birth. At the start of pregnancy, the "pregnant" event is raised and the "%pregnant%" expression is created with the expected time of birth which is accurate for months in advance with a margin of error of only 1 or 2 minutes.'
		); ?>    
        	<?php print breedSetting(

		'Number of breeds in each litter',
		'min:1 max:3',
		'A random number between min and max is chosen to decide the number of child breeds created in each litter. one breed will be born each birth sequence. If both numbers are set to the same value, strictly that number of child breeds will be created.'
		); ?>
        	<?php print breedSetting(
		'Large litters more rare?',
		'YES/NO',
		'If set to YES, larger litters are more rare.'
		); ?>
        	<?php print breedSetting(
		'Maximum number of litters a breed can have.',
		'-1',
		'Total number of litters a breed can have over a lifespan (failed births do not count). Breeds stop giving birth and disable their breeding protocol to preserve script memory.'
		); ?>
        	<?php print breedSetting(
		'Birth success rate',
		'ALWAYS',
		'Odds of failed birth can be set to counter act excessive breeding.'
		); ?>
</span>