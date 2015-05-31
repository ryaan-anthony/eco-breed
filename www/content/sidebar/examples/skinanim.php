
<?php
print "<p class='widget-line-$odd'>Skin-based prim animations.</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Skin-based animations','use the breed\'s current skin to determine which animation to use. This is very useful for skins that alter the linkset (alternate rotations/positions/sizes).'); ?>
      		<?php print videolink('Random | Skin-Based Animations (11:45)', 'uf237Zr3V0I');?>
			<p class='sub-in sit'>Skin-based animation example:</p>
			<?php print actions_code('"start",
"cache(%Type% collar)
 set(%Type% collar)"');?>
			<p class='sub-in sit'>Random animation example:</p>
			<?php print actions_code('"start",
 "prop(collars[n], red collar, yellow collar, blue collar)
 prop(Collar,collars[r])
 cache(%Collar%)
 set(%Collar%)
 say(Applied %Collar%)"');?>
			<p class='sub-in sit'>Breed-Specific random animation example:</p>
			<?php print actions_code('"start",
 "bind(touch, owner, touched, remove)",
 
 "touched",
 "unbind(remove)
 prop(collars[n], red collar, yellow collar, blue collar)
 prop(Collar,collars[r])
 cache(%Collar%)
 set(%Collar%)
 say(Applied %Collar%)
 @destroy()"');?>
			<p class='sub-in sit'>Breed-Specific random animation action-extension:</p>
			<?php print normal_code('_extend(string function, string attributes){
    if(function=="@destroy"){
       llDie();//destroys the object when this method is called
       llRemoveInventory("action-events");//removes main script to prevent attachment exploit of llDie()
    }
}

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}');?>
</span>