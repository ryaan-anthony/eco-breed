
<?php
print "<p class='widget-line-$odd'>Dead/alive stats.</p>";
?>

<span style='display:none;'>
    <div style='padding:20px;'>   
		<?php print listItem('Display alternate stats after death with a custom message:');?>
		<?php print actions_code('
"start",
"bind(timer|toggle,10,text_stats)",

"dead",
"val(Text_Color,<1,0.2,0.2>)
prop(death_message, I AM DEAD)",


"text_stats",
"text(
{%death_message%}
Name: %breed_name% 
Gender: %gender% 
Age: %age%
)"');?>
    
    </div>
</span>