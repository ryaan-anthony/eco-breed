
<?php
print "<p class='widget-line-$odd'>Action Setup: Produce offspring from a nest object.</p>";
?>

<span style='display:none;'>
	<?php print wtheadline('Offspring are born directly from action objects.',' The child object must be inserted into the action object along with the proper configurations for the breeding sequence to be successful.'); ?>
        <h2 align='center'>Breeding Options</h2>
        <?php print actionSetting(
        'Allow this to be a breeding source?',
        'NO',
        'If set to YES, the action object will be detected by the breeds as a potential breeding source.'
        ); ?>
        <?php print actionSetting(
        'Limit the number of offspring.',
        '-1',
        'Will only allow this amount of breeds to be created regardless of size of the litter. -1 = Unlimited'
        ); ?>
        <?php print actionSetting(
        'Self destruct when max offspring is created?',
        'NO',
        'Limiting the the total number of breeds that can be created triggers an event that destroys this object when the max offspring have been created.'
        ); ?>
        <hr />
        <h2 align='center'>Child Object Options</h2>
        <?php print actionSetting(
        'Offspring object name',
        'null',
        'The name of object to be rezzed from contents. If blank, the first object in the action inventory will be used to create offspring.'
        ); ?>
        <hr />
        <h2 align='center'>Limited-Use Filters</h2>
        <?php print actionSetting(
        'Reserve for one breeding pair?',
        'NO',
        'Allow only one breeding pair to use this breeding source. Enabling this value creates the expression %Breed_Pair%'
        ); ?>
        <?php print actionSetting(
        'RESERVE',
        'disabled',
        'Allow breeding to occur by extension only. Meaning you do not want to use the core rebuiling mechanism, instead reserve this option for future extensions.'
        ); ?>
</span>