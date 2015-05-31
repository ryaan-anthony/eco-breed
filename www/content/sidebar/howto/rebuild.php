
<?php
print "<p class='widget-line-$odd'>Action Setup: How to enable rebuilding.</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('Rebuilding breeds','that are lost/missing is vital for maintaining the value of individuals. All of the values that make a breed a unique individual are hosted externally. This enables users to recreate existing breeds with all core values appropriately adjusted. If an older copy of that breed attempts to re-activate, it will automatically delete (destroy) itself.'); ?>
        
        <h2 align='center'>Enable Rebuilding</h2>
        <?php print actionSetting(
		'Allow breeds to be rebuilt?',
		'NO',
		'Turn rebuilding on with just one configuration. NO = Disable | YES = Enable | RESERVE = Extensions Only'
		); ?>
        
        <h2 align='center'>Configure Rebuild Object</h2>
        <?php print listItem('Install the child breed into an action object', 'Put a breed object configured as a child, into the contents of an action object. This breed object will be rezzed from the action object and used to recreate an existing breed.'); ?>
        <?php print listItem('OPTIONAL: Designate the name of the child object', 'Use the following configuration to assign which object to use as child.'); ?>
		<?php print actionSetting(
		'Rebuild object name',
		'null',
		'The name of object to be rezzed from contents. If blank, the first object in the action inventory will be used to create offspring.'
		); ?>
        
        
        <h2 align='center'>Limitations</h2>
        
        <?php print actionSetting(
		'How many breeds to provide rebuild support for',
		'10',
		'The rebuild menu will allow up to 200 breeds to be selected for regeneration, however this value allows you to limit it further.'
		); ?>
        <?php print actionSetting(
		'Rebuild based on status',
		'Not Responding',
		'Use this value to filter breeds by status. All breeds owned by same owner will appear in the rebuild menu. Useful for updating customers with new scripts or configurations by allowing them to rebuild any of their breeds regardless of status (with the exception of the \'Dead_Breeds\' setting).'
		); ?>
        <?php print actionSetting(
		'Rebuild dead breeds?',
		'NO',
		'Use this value to filter out dead breeds.'
		); ?>
        
        
        <h2 align='center'>Customize the Rebuild Menu</h2>
        <?php print actionSetting(
		'Time in seconds to hold for menu',
		'2',
		'Set to 0 for the menu to appear instantly when clicked.'
		); ?>
        <?php print actionSetting(
		'Message in the breed selection menu',
		'"\nSelect a breed:"'
		); ?>
        <?php print actionSetting(
		'Define the \'NEXT\' button.',
		'"NEXT >"'
		); ?>
        <?php print actionSetting(
		'Define the \'PREV\' button.',
		'"< PREV"'
		); ?>
        <?php print actionSetting(
		'Message in the confirmation popup.',
		'"\nAre you sure?"'
		); ?>
        <?php print actionSetting(
		'Define the \'CONFIRM\' button.',
		'"Yes"'
		); ?>
        <?php print actionSetting(
		'Define the \'CANCEL\' button.',
		'"Cancel"'
		); ?>
</span>