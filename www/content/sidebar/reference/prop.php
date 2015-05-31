

<?php
print "<p class='widget-line-$odd'>prop() values and operators</p>";
?>

<span style='display:none;'>
<?php
print "
<p style='font-weight:bold;margin-bottom:0;'>Lists Indexes: </p>
".big_code('[0]	First list item
[1]	Second list item (and greater numbers for subsequent indexes)
[r]	Random list item
[n]	Last list item
[u]	Unique entries only
[s]	Sorted low to high
[S]	Sorted high to low')."
<p class='description'>List indexes can be prefixed to the <strong>identifier</strong> or <strong>value</strong> allowing you to modify, add to, or retrieve the properties value.</p>

<p style='font-weight:bold;margin:0;'>Inventory Lists: </p>
".big_code('INVENTORY_TEXTURE	= list of all textures
INVENTORY_LANDMARK	= list of all landmarks
INVENTORY_NOTE		= list of all notecards
INVENTORY_ANIMATION	= list of all animations
INVENTORY_OBJECT	= list of all objects
INVENTORY_SOUND		= list of all sounds')."
<p class='description'>An inventory list is created which can be used to set prop() values dynamically such as selecting a random inventory item to give, rez (object), or trigger (animation / sound).</p>

<p style='font-weight:bold;margin:0;'>Modifiers: </p>
".big_code('+	Add value to identifier\'s value
-	Subtract value from the identifier\'s value
*	Multiply identifier\'s value by the provided value
/	Divide identifier\'s value by the provided value
~	Sets the identifier\'s value as a random number between 0 and value')."
<p class='description'>Modifiers can be prefixed to the value allowing you to modify the identifiers original value. Without a modifier prefix, the identifier's value is set to the value provided. Calling prop() without a value removes the property entirely.</p>";
?>
</span>