
<?php
print "<p class='widget-line-$odd'>Changing breed names.</p>";
?>

<span style='display:none;'>
<div style='padding:20px;'>       
        	<?php print wtheadline('Changing the name','requires user interaction such as a chat command, a feature in a menu system, or even by rezzable objects.'); ?>  
            <div class='entry expand sub-pad'>
                <?php print listItem('Set the breed name using an <strong style="font-size:1.1em;">input menu</strong>');?>
                <?php print actions_code('"start",
"bind(touch, owner, input_menu)",
    
"input_menu",
"textbox(%owner_key%, \nSet name and click \'Send\':, set_name)",
    
"set_name",
"val(breed_name,%chat_msg%)
say(My name is now %breed_name%)"');?>
            </div>        
            <div class='entry expand sub-pad'>
                <?php print listItem('Set the breed name using a <strong style="font-size:1.1em;">chat commands</strong>');?>
				<?php print actions_code('"start",
"bind(touch, owner, start_listen)",

"start_listen",
"say(Type new name in chat:)
bind(listen, owner, listen_name, remove_listen)",

"listen_name",
"unbind(remove_listen)
 val(breed_name,%chat_msg%)
 say(My name is now %breed_name%)"');?>
            </div>        
            <div class='entry expand sub-pad'>
                <?php print listItem('Set the breed name using <strong style="font-size:1.1em;">rezzable objects</strong>');?>
				<?php print actions_code('"start",
"bind(touch, owner, set_name)",

"set_name",
"val(breed_name, Roger)
 say(My name is now %breed_name%)
 @destroy()"');?>
            </div>        
            <div class='entry expand sub-pad'>
                <?php print listItem('The rezzable objects example requires <strong style="font-size:1.1em;">the <tag class="bool">@destroy()</tag> extension:</strong>');?>
                <?php print normal_code('_extend(string function, string attributes){
	if(function=="@destroy"){
	   llDie();llRemoveInventory("action-comm");
	}
}

default{
link_message(integer a, integer b, string c, key d){
	if(b==-220){_extend(c,(string)d);}
}
}');?>
            </div>
</div>
</span>