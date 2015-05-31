
<?php
print "<p class='widget-line-$odd'>Breed Setup: Establish a Growth Sequence</p>";
?>

<span style='display:none;'>
		<?php print wtheadline("Growth","is the re-sizing and re-positioning of all prims in a linkset. The difference is applied to animations, rebuilt breeds, as well as sit and camera positions. Once growth has completed it's last stage, the growth timer deactivates and object remains a static size unless re-enabled. "); ?>
        <h3>Explore these <a class='title inline'>breed settings</a> values:</h3>
        	<?php print breedSetting(
		'Number of growth stages',
		'0',
		'Establish a growth cycle by defining the number of stages.'
		); ?>
        	<?php print breedSetting(
		'Growth scale',
		'1.05',
		'The growth scale is applied to each growth stage based on it\'s current size. This value must be greater than \'1.0\' for increasing the size, where 1.0 equals 100% of current size and 1.2 equals 120% of current size. This value can also be less than 1.0 for objects that shrink throughout it\'s lifespan.'
		); ?>
        	<?php print breedSetting(
		'Length of a growth cycle in minutes',
		'1440',
		'Length of time in minutes between each growth cycle.'
		); ?>  
    
		<?php print breedSetting(
        'Odds of growing each cycle',
        'ALWAYS',
        'This value defines the odds of skipping a growth cycle. If a cycle is skipped, a growth stage is subtracted and no growth occurs.'
        ); ?>
</span>