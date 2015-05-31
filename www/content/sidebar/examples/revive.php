
<?php
print "<p class='widget-line-$odd'>Reviving a Dead Breed</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Death','occurs from old age, hunger, or can be triggered by a user-defined event.'); ?>     
        <div style='padding:0 20px;'>
      		<?php print listItem('Use revive() to bring a breed back to life');?>
        	<?php print method_profile(
			'revive',
			'[ years [ , hunger ] ]',
			array(
				'years','additional "years" to add to it\'s min/max age',
				'hunger', 'Set MyHunger level (0-100).'
			),
			actions_code('"start",
"revive(10,50)"'),
			'This revives the breed with 10 additional years and a starting hunger of 50.'
			);?>
            <h3 align='center'>Revival tool w/ self destruct extension</h3>
        	<?php print actions_code('
"start",
"bind(touch,owner,revive,remove_revive)",

"revive",
"say(Added 1 Year to %MyName%\'s Lifespan)
unbind(remove_revive)
revive(1)
@destroy()"');?>
        	<?php print normal_code('// Revival Tool (Extension Script)
_extend(string function, string attributes){
    if(function=="@destroy"){

       llDie();
    }
}
default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}');?>
            
        </div>
</span>