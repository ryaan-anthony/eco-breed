
<?php
print "<p class='widget-line-$odd'>Skins: Enable skins for the breed object.</p>";
?>

<span style='display:none;'>
        <?php print wtheadline('Skins','can be applied in a variety of ways to suit your needs. Such as mixed coat, pure breed, rare, unlockable, limited edition, with or without genetic or built-in preferences. A skinset can alter the entire primset or just individual surfaces. The skin a breed has can also be used to define functionality such as behavior, traits, titles, etc.'); ?>
        	<h3>Explore these <a class='title inline'>breed settings</a> values:</h3>

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

</span>