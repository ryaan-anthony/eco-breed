
<?php
print "<p class='widget-line-$odd'>Hungry Breeds have Stunted Growth</p>";
?>

<span style='display:none;'>
	<?php print wtheadline('Stunted growth','can be set to randomly occur using the "Growth_Odds" setting, you can also inhibit growth based on other breed conditions, such as the built in hunger level.'); ?>
    
    <div style='padding:20px;'>     
        
        <h3>Using the <a class='title inline '>filter method</a> to detect hunger:</h3>
<?php print actions_code('"start",
"bind(timer, 600, check-hunger)",

"check-hunger",
"filter(%MyHunger%<20)
prop(Growth, %Growth_Stages%)
filter(%Growth%>0)
prop(Growth, -1)
val(Growth_Stages,%Growth%)"');?>
        <p class='sub-in'>This method allows us to inhibit growth by reducing the remaining Growth_Stages value over time. Not as a random occurance, but as a result of poor nutrition.</p>
    </div>
</span>