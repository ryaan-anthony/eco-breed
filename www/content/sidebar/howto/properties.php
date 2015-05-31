
<?php
print "<p class='widget-line-$odd'>Methods: Create and modify properties</p>";
?>

<span style='display:none;'>

        <?php print wtheadline('Traits, attributes, and other properties', 'can be created, managed, and used to affect functionality such as creating levels that control breeding, titles that give special food rights, points that earn happiness, health, and other status. These properties can be maintained throughout a lifetime and even passed on through breeding to offspring, effectively creating unique simulations based on breed levels or status.'); ?>
    
        	<?php print method_profile(
			'prop',
			'identifier [ , value [ , value ... ] ]',
			array(
				'',"This method is used for creating, modifying, and deleting user-defined values including strings, lists, and integers. This is very useful for creating traits or saving important values which can be used in other methods as an expression by declaring the %identifier% (wrapped in '%' symbols). You can also access inventory items (any texture, sound, landmark, note, animation, or object in the breed's contents) which can be saved as a static value and used in other methods. The value parameter can also be an expression! Calling prop() without a value removes the property entirely."
			)
			);?>
        	
			<?php print actions_code('"start",
"prop(Health, 100)
say(Health: %Health%)"');?>
            <p class='description'>Sets "Health" to 100. If "Health" is not already created, it will create it for you and save it's value as 100.</p>
            
			<?php print actions_code('"start",
"prop(Damage, 5)
say(Damage: %Damage%)"');?>
            <p class='description'>Sets "Damage" to 5. If "Damage" is not already created, it will create it for you and save it's value as 5.</p>
            
			<?php print actions_code('"start",
"prop(Damage, 5)
prop(Damage, *2)
say(Damage: %Damage%)"');?>
            <p class='description'>Multiplies "Damage" by 2, resulting in "Damage" equaling 10. If "Damage" is not already created, it will create it for you and save it's value as 0 since 0 x 2 = 0.</p>
            
			<?php print actions_code('"start",
"prop(Damage, 10)
prop(Damage, /2)
say(Damage: %Damage%)"');?>
            <p class='description'>Divides "Damage" by 2, the result is "Damage" equaling 5. If "Damage" is not already created, it will create it for you and save it's value as 0 since you cannot divide by zero.</p>
            <hr />
            
			<?php print actions_code('"start",
"prop(Health, -Damage)
say(Health: %Health%)"')?>
            <p class='description'>Reduces "Health" by "Damage". "Health" value is now 95.</p>
            
			<?php print actions_code('"start",
"prop(Health, +5)
say(Health: %Health%)"')?>
            <p class='description'>Increases "Health" by 5. As per the previous examples, health would be back to 100.</p>
            
			<?php print actions_code('"start",
"prop(Health)"');?>
            <p class='description'>Without giving a second value, this tells the prop() method to remove the value "Health". If "Health" is not set, nothing would happen.</p>
            
            <hr />
            
			<?php print actions_code('"start",
"prop(Friends[n], me, myself, you)"');?>
            <p class='description'>Creates a list called "Friends" with 3 string values: 'me', 'myself', 'you'. The brackets indicate that this value is a list. The [n] means it will point to the end of the list, thus inserting the provided values at the end of the list.</p>
            
			<?php print actions_code('"start",
"prop(Friends[n])"');?>
            <p class='description'>Assuming that we already created a list called "Friends" with 3 string values: 'me', 'myself', and 'you', calling this method would remove the last list value making "Friends" list now just 2 string values: 'me' and 'myself'. Alternately, you can remove the whole list by calling prop(Friends).</p>
            
			<?php print actions_code('"start",
"prop(Friends[0],%owner%)"');?>
            <p class='description'>You can also use expressions with this method. Assuming that we already created a list called "Friends" with now just 2 string values: 'me', and 'myself', calling this method would replace the first list value 'me' with the owner name. In this instance, making "Friends" list: 'Dev Khaos' and 'myself'.</p>
            
			<?php print actions_code('"start",
"prop(Friends[r])"');?>
            <p class='description'>We can also use a random index! Let's assume our "Friends" list still has 3 string values: 'me', 'myself', 'you'. The 'r' within the brackets indicates a random index. In this example, calling this method as written would remove a random value from the list, resulting in a list of 2 string values, such as: 'me' and 'you' or 'me' and 'myself', or 'myself' and 'you'.</p>
            
			<?php print actions_code('"start",
"prop(Friends[r],person)"');?>
            <p class='description'>You could even replace one of the 3 list values randomly. Let's assume our "Friends" list still has 3 string values: 'me', 'myself', 'you'. In this example, calling this method as written would result in the list still having 3 string values, but with a randomly replaced value, such as: 'me', 'person', 'you' or 'me', 'myself', 'person' or 'person', 'myself', 'you'.</p>
            
			<?php print actions_code('"start",
"prop(Enemies[n],Friends[2])
prop(Friends[2])"');?>
            <p class='description'>You could even use previously declared list values to define another property. Let's assume our "Friends" list still has 3 string values: 'me', 'myself', 'you'. In this example, calling this method as written would first result in the creation of a new list called "Enemies" and defined with the 3rd value on the "Friends" list (The [2] index = 3rd value as is common practice in programming languages. 0 = first, 1 = second, etc). After moving 'you' to the "Enemies" list, the 2nd prop() method removes the 3rd value 'you' from the "Friends" list. So now, "Enemies" is 'you', and "Friends" is 'me' and 'myself'. Lonely example, but it works!</p>
            
			<?php print actions_code('"start",
"prop(Sound,INVENTORY_SOUND[r])"');?>
            <p class='description'>You can also use INVENTORY_* flags as possible lists. You can not change the list by using an INVENTORY_* flag as an identifier, but in this example we are setting a value called "Sound" with a random sound from the breed-object's contents. This can be used later with the sound() method, written like: sound(%Sound%).</p>

</span>