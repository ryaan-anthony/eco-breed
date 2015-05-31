
<?php
print "<p class='widget-line-$odd'>Breed Setup: Setting up the appetite</p>";
?>

<span style='display:none;'>
<?php print wtheadline('The hunger level',' is part of the built-in point system. Food consumption is precise and secure with built in logic to handle multiple food sources. A breed\'s appetite can range from predictable to finicky. Every hunger cycle, hunger points are lost to simulate a progressive appetite. Make sure the amount lost due to digestion is less than the minimum amount consumed.'); ?>

    <h3>Explore these <a class='title inline'>breed settings</a> values:</h3>
    <?php print breedSetting(
    'How often to look for food, in minutes',
    '0',
    'Each time the hunger cycle expires, the breed requests food from any action objects that contain food units. If the action object is set for restricted use, the breed must have prior access before the hunger cycle expires to access food.'
    ); ?>
    <?php print breedSetting(
    'Starting hunger level',
    '40%',
    'Hunger level is a range between 100% health and 0% starvation.'
    ); ?>
    <?php print breedSetting(
    'Odds of eating each cycle',
    'ALWAYS',
    'If the hunger cycle is skipped, no hunger points are lost.'
    ); ?>
    <?php print breedSetting(
    'Food units eaten each cycle',
    'min:1 max:5',
    'Minimum and maximum food units consumed per cycle.'
    ); ?>
    <?php print breedSetting(
    'Hunger points lost each cycle',
    '1%',
    'Also known as hunger pangs, this is used to balance the constant gain of food intake. Each successful hunger cycle (with or without food) will cause the loss of this many hunger percentage points.'
    ); ?>
    <?php print breedSetting(
    'Should breed die from hunger?',
    '-1',
    'Odds of death when below starvation threshold'
    ); ?>   
    <?php print breedSetting(
    'Death occurs below this level',
    '10%',
    'Hunger death threshold. Hunger levels must not be at zero for death to occur.'
    ); ?>  
	
</span>