
<?php
print "<p class='widget-line-$odd'>Action Setup: Creating a food source.</p>";
?>

<span style='display:none;'>
<?php print wtheadline('A food source',' is created by defining food quality and levels in an action object.'); ?>

        <h3>Explore these <a class='title inline'>action settings</a> values:</h3>
	<?php print actionSetting(
'Set a food level to create a food source',
'0',
'If a food level is set, the action object will be detected by the breeds as a potential food source. 0 = Not a food source. -1 = Unlimited Food. Otherwise sets the initial available units of food.'
); ?>
	<?php print actionSetting(
'Food Quality',
'5',
'How many points each food unit is worth.'
); ?>
	<?php print actionSetting(
'Self destruct when food level is less than this limit.',
'0',
'0 = Disabled. This tells the action object to self-delete when food level is below a certain level. Use 1 to delete when empty.'
); ?>
</span>