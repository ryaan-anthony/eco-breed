
<?php
print "<p class='widget-line-$odd'>Methods List</p>";
?>

<span style='display:none;'>
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Lifespan</h3>
    <?php print method_profile(
    'die',
    'null',
    array('','This method destroys the object. Be very careful!')
	);?>		    
    <?php print method_profile(
    'revive',
    '[ years [ , hunger-start ] ]',
    array(
    '','Used to revive dead breeds.')
    );?>	
    
    <div style='height:20px'></div>
    
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Movement</h3>
    <?php print method_profile(
    'move',
    '[ position [ , offset [ , type [ , speed [ , callback [ , flags [ , callback ] ] ] ] ] ] ]',
    array('','For physical/nonphysical movement.')
    );?>
    <?php print method_profile(
    'sethome',
    '[ position ]',
    array('','To save a position vector as the objects \'home\' position.')
    );?>
    
    <div style='height:20px'></div>
    
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Communication</h3>
    <?php print method_profile(
    'menu',
    'avatar-key, message [ , button=callback ... ]',
    array(
    '','Easy to use dialog menu.')
	);?>
    <?php print method_profile(
    'textbox',
    'avatar-key, message, callback',
    array(
    '','Text input menu')
	);?>
    
    <?php print method_profile(
    'say',
    'message',
    array(
    '','Local chat message that is displayed to a 20 meter radius from the breed-object.'
    )
	);?>
    <?php print method_profile(
    'shout',
    'message',
    array(
    '','Local chat message that is displayed to a 100 meter radius from the breed-object.'
    )
	);?>    
    <?php print method_profile(
    'whisper',
    'message',
    array(
    '','Local chat message that is displayed to a 10 meter radius from the breed-object.'
    )
	);?>    
    <?php print method_profile(
    'ownersay',
    'message',
    array(
    '','Owner-only chat message. Messages will not be sent if owner is offline.'
    )
	);?>
    
    <?php print method_profile(
    'message',
    'avatar-key, message',
    array(
    '','instant message to a specific avatar'
    )
	);?>  
    <?php print method_profile(
    'text',
    '[message]',
    array(
    '','Display text over your breed.'
    )
	);?> 
    
    <div style='height:20px'></div>
    
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Inventory</h3>
    <?php print method_profile(
    'attach',
    '[ attach-point ]',
    array(
    '','Attach breed to owner.'
    )
	);?>
    <?php print method_profile(
    'anim',
    '[ animation [ , duration ] ]',
    array(
    '','Animate the owner avatar.'
    )
	);?>
    <?php print method_profile(
    'give',
    'avatar-key, inventory',
    array(
    '','Give any type of inventory. Must be in the breed-object\'s inventory or this method will silently fail.'
    )
	);?>
    <?php print method_profile(
    'rez',
    'inventory [ , offset [ , start_param [ , force [ , target [ , callback ] ] ] ] ]',
    array('','Rez objects from the breed.'
	)
	);?>
    <?php print method_profile(
    'sound',
    '[ sound [ , loop ] ]',
    array(
    "","Play or loop a sound file by name or key."
	)
	);?>
    
    <div style='height:20px'></div>
    
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Event Flow</h3>
    <?php print method_profile(
    'bind',
    'event, filter, callback [ , handle ]',
    array('','Create new events.')
	);?>
    <?php print method_profile(
    'unbind',
    '[ handle [ , handle ... ] ]',
    array(
    '','Unbind previously created events.'
    )
	);?>		
    <?php print method_profile(
    'filter',
    'condition [ , callback [ , condition [ , callback ... ] ] ]',
    array(
    '','Set conditions that must be passed to continue.')
	 );?>
    <?php print method_profile(
    'rfilter',
    'condition [ , callback [ , condition [ , callback ... ] ] ]',
    array(
    '','This is the reverse application of filter()'
	)
    );?>  
    <?php print method_profile(
    'off',
    'event',
    array(
    '','Disables event by name.'
    )
	);?>
    <?php print method_profile(
    'on',
    'event',
    array(
    '','Enable previously disabled events.')
    );?>   
    <?php print method_profile(
    'pause',
    'time',
    array(
    '','Pause/delay the event.'
    )
	);?>
    <?php print method_profile(
    'toggle',
    'event [ , event [ , event ... ] ]',
    array('','Trigger events by name.')
	);?>
    
    <div style='height:20px'></div>
    
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Manipulation</h3>
    <?php print method_profile(
    'prop',
    'identifier [ , value [ , value ... ] ]',
    array(
    '',"This method is used for creating, modifying, and deleting user-defined values including strings, lists, and integers."
    )
    );?>
    <?php print method_profile(
    'val',
    'setting, value [ , setting, value ... ]',
    array(
    '','This method is used to change core settings.'
    )
	);?>
    
    <div style='height:20px'></div>
    
    <h3 style='color: #0F67A1;text-transform:uppercase;'>Animations</h3>
    <?php print method_profile(
    'cache',
    'anim [ , anim ... ]',
    array(
    '','Request the prim animations from the webserver')
    );?>        	
    <?php print method_profile(
    'set',
    'anim [, anim ... ]',
    array(
    '','Start or trigger animations.')
	);?>        	
    <?php print method_profile(
    'unset',
    'anim [, anim ... ]',
    array(
    '','Stop looping animations.')
	);?>        	
    <?php print method_profile(
    'uncache',
    'anim [, anim ... ]',
    array(
    '','Use this method uncache prim animations that will no longer be used in the action-classes list.'
    )
	);?> 
    
</span>