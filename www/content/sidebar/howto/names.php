
<?php
print "<p class='widget-line-$odd'>Breed Setup: The name generator.</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('The Name Generator','automatically creates a unique name when the breed is first created by picking a random prefix, middle, and suffix from a series of lists. If the generator is set for gender specific names, it chooses from either male or female suffixes based on it\'s gender. This name can also be applied to the object\'s name or description for easy identification.'); ?>
        	<h3>Explore these <a class='title inline'>breed settings</a> values:</h3>
        	<?php print breedSetting(
		'Create random names?',
		'YES/NO',
		'Enable or disable name generator.'
		); ?>
        	<?php print breedSetting(
		'Create names based on gender?',
		'YES/NO',
		'Create gender specific or random names.'
		); ?>
        	<?php print breedSetting(
		'Set breed_name on object',
		'null',
		'When the breed name is changed or reset, the name can be inserted into the object\'s name field. Use the %name% expression to insert the breed\'s name into the string.'
		); ?>
        	<?php print breedSetting(
		'Prefix - Middle - Suffix',
		'see library',
		'To create a unique name, the library is constructed of dozens of letter combos which when combined generate cute and funny names. This library can be altered in the advanced settings section of Breed Configurations.'
		); ?>
</span>