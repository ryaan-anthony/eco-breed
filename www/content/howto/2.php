
<button num='2a' class='sub-tab sub-howto'><span class='subCap'>a</span> Actions</button>
<button num='2b' class='sub-tab sub-howto'><span class='subCap'>b</span> Names</button>
<button num='2c' class='sub-tab sub-howto'><span class='subCap'>c</span> Lifespan</button>
<button num='2d' class='sub-tab sub-howto'><span class='subCap'>d</span> Growth</button>
<button num='2e' class='sub-tab sub-howto'><span class='subCap'>e</span> Hunger</button>
<button num='2f' class='sub-tab sub-howto'><span class='subCap'>f</span> Breeding</button>
<button num='2g' class='sub-tab sub-howto'><span class='subCap'>g</span> Rebuild</button>

<!--Start-->
<div class='sub-content sub-default'>
	<?php print subButton('2a','Explore the Action Object'); ?>
    <?php print wttabline('lifecycle and <strong>behavior</strong>.','add, modify, or disable core events',true); ?>
    <?php print insertlogo(); ?>
    <div class='sub-info'>
        <p>This section covers...</p>
        <ul>
            <li num='2a'>How to use <strong>Actions</strong>.</li>
            <li num='2b'>How to set the <strong>name</strong> of your breed.</li>
            <li num='2c'>How to define <strong>life</strong> and <strong>death</strong>.</li>
            <li num='2d'>How to make the breed <strong>grow</strong>.</li>
            <li num='2e'>Working up an <strong>appetite</strong>.</li>
            <li num='2f'>How to establish <strong>mating</strong> behaviors of a species.</li>
            <li num='2g'>How to <strong>rebuild</strong> existing breeds.</li>
        </ul>
    </div>
</div>

<!--Actions-->
<div num='2a' class='sub-content' style='display:none;'>
	<!--Summary Start-->
    <div class='frame-2a'>
		<?php print subButton('2b','Naming the Breed'); ?>
		<?php print wtheadline('The Action object','is a multifunctional access point for the eco-Breeds. The action scripts can be configured for a variety of purposes including as a limited or public food source, breeding nest, home object, toy or game, with the ability to rebuild lost, missing, or hidden breeds. The number of interactions can be limited per Action, and breeds can be configured to ignore certain types of Actions. Additional functionality is defined using eco "methods" which are triggered by a series of "events" defined in the Actions list. Each event is a chance to give your breed unique interactions and functionality.'); ?>  
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Breakdown of the Actions list:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Understanding native events:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>How methods work and how to use them:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Easy events to bind to your breeds:</strong> <button num='4' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Customize your action touch events:</strong> <button num='5' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Syncing breeds with action objects:</strong> <button num='6' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>More event binding for smarter simulations:</strong> <button num='7' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Extending the Action list:</strong> <button num='8' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <!--Formatting Actions-->
    <div num='1' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',2); ?>  
		<?php print wtheadline('The Actions list','is found in the \'action-settings\' script inside of the action object. This list is where functionality is defined is populated by combining an "event" identifier with a string of "methods" in a strided list. Events <span style=\'color:red;\'>can not</span> be listed twice in the same script.'); ?>  
        <div style='padding:0 20px;'>    
       		<?php print actions_comment('Use the following','','format:');?>
       		<?php print actions_code('"event 1", 
"method()",

"event 2", 
"method()"');?>
       		<?php print actions_comment('Also ','','acceptable:');?>
       		<?php print actions_code('"event-3",
  "method()
   method(value)
   method(value, value)",

"event_4",
"method(value) method(value, value)"');?>
        	<p class='sub-in'>Spaces, tabs, and other whitespace <strong>will be removed</strong> during processing.</p>
        	<p class='sub-in'>If the script displays an error when saving, it's usually because <strong>this list was improperly formatted.</strong></p>
		</div>
    </div>
    <!--Native Events-->
    <div num='2' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',3); ?>
		<?php print wtheadline('Native events','are reserved \'event\' names which are toggled automatically at the end of a core event or when specific conditions are met.'); ?>    
        <div style='padding:20px;'>  
            <div class='entry sub-pad'>
            	<?php print actions_comment('When a breed or action is rezzed, a','"start"','event is toggled.');?>
            	<?php print actions_code('"start", 
"say(Hello, %owner%!)"');?>
            </div>          
            <div class='entry sub-pad'>
            	<?php print actions_comment('Each time the breed completes a','"growth"',' stage, this event is toggled.');?>
            	<?php print actions_code('"growth", 
"say(%MyName% has %Growth_Stages% remaining!)"');?>
            </div>          
            <div class='entry sub-pad'>
            	<?php print actions_comment('When the breed eats ','"food"',', this event is toggled.');?>
            	<?php print actions_code('"food", 
"say(%MyName% just ate. [Health: %MyHunger%])"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('If the mother becomes ','"pregnant"',', this event is raised prior to "birth".');?>
            	<?php print actions_code('"pregnant", 
"say(%MyName% is going to have a baby in %Pregnant%.)"');?>
            </div>   
            <div class='entry sub-pad'>
            	<?php print actions_comment('If a breed gives ','"birth"',', this event is toggled for the mother.');?>
            	<?php print actions_code('"birth", 
"say(%MyName% just gave birth.)"');?>
            </div>        
            <div class='entry sub-pad'>
            	<?php print actions_comment('If death occurs from age, hunger, or other causes, the ','"dead"',' event is called.');?>
            	<?php print actions_code('"dead", 
"say(Goodbye, %owner%!)" ');?>
            </div>      
        </div>
    </div>
    <!--How Methods Work-->
    <div num='3' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',4); ?>     
		<?php print wtheadline('Methods','are used to trigger built-in functions. With each event that is called, you can run dozens of methods for your simulation.'); ?>  
        <div style='padding:20px;'>  
            <div class='entry sub-pad'>
            	<?php print actions_comment('Methods are run in order','', 'from first to last.');?>
            	<?php print actions_code('"start", 
"say(One)
 say(Two)
 say(Three)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('This order continues based on','', 'the methods you use.');?>
            	<?php print actions_code('"start", 
"say(One)
 toggle(next)
 say(Three)",
 
"next",
"say(Two)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('Now try a more advanced ','', ' event flow.');?>
            	<?php print actions_code('"start", 
"say(Start)
 toggle(One|Two|Three)
 say(End)",
 
"One",
"say(%this%)",
 
"Two",
"say(%this%)",
 
"Three",
"say(%this%)"');?>
            </div>   
            <div class='entry sub-pad'>
            	<?php print actions_comment('Now to include filters ','', 'and custom values.');?>
            	<?php print actions_code('"start", 
"say(%this%)
 prop(Num,1)
 toggle(say|next)",
 
"say",
"say(%Num%)",

"next",
"prop(Num,+1)
 filter(%Num%<3, end)
 toggle(say|next)",
 
"end",
"toggle(say)
 say(%this%)"');?>
            </div>     
        </div>        
    </div>
    <!--Bind Events-->
    <div num='4' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',5); ?>   
		<?php print wtheadline('Events can be created','for activities such as touch, timer, listen, and a variety of other conditions. Each event is a chance to insert unique functionality.'); ?>    
        <div style='padding:20px;'>  
            <div class='entry sub-pad'>
            	<?php print actions_comment('To repeat actions in regular intervals use a ','timer','event.');?>
            	<?php print actions_code('"start", 
"bind(timer, 5, actions)",

"actions", 
"prop(Counter,+1)
 say(This event has triggered %Counter% times.)"');?>
            	<?php print actions_comment('or create a random','timer',' and add random points.');?>
            	<?php print actions_code('"start", 
"bind(timer, 10r, actions)",

"actions", 
"prop(Bonus, ~10)
 prop(Points, +%Bonus%)
 text(Score: %Points%)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('Filter results from a','touch','event.');?>
            	<?php print actions_code('"start", 
"bind(touch, owner, owner actions)
 bind(touch, notowner, public actions)",

"owner actions", 
"prop(Owner,+1)
 text(Last Touch: Owner \n Owner: %Owner% \n Public: %Public%)",

"public actions", 
"prop(Public,+1)
 text(Last Touch: Public \n Owner: %Owner% \n Public: %Public%)"');?>
            	<?php print actions_comment('You can even combine events such as the','touch','event.');?>
            	<?php print actions_code('"start", 
"prop(extra-info, Click me again!)
bind(touch, owner, actions|remove)",

"remove",
"prop(extra-info)",

"actions", 
"say(Welcome to eco-Breeds Walkthrough! /%extra-info%/)"');?>
            	<?php print actions_comment('Require users to touch and','hold','to trigger the event.');?>
            	<?php print actions_code('"start", 
"bind(hold, all, give menu)",

"give menu", 
"say(Hello, %toucher%.)
 menu(%touchkey%, This is a test:, Okay=results)",

"results",
"say(Goodbye, %chatname%.)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('The breed can also','listen','to local chat.');?>
            	<?php print actions_code('"start", 
"bind(listen, owner, actions)",

"actions", 
"prop(Counter,+1)
 text(%owner% spoke %Counter% times.)"');?>
            	<?php print actions_comment('or even','listen','to a specific channel.');?>
            	<?php print actions_code('"start", 
"bind(listen|2, all, actions)",

"actions", 
"say(%chatname% said \'%chatmsg%\' on channel 2)"');?>
            	<?php print actions_comment('You can also try to','listen','for specific words or phrases.');?>
            	<?php print actions_code('"start", 
"bind(listen, all, actions)",

"actions", 
"rfilter(%chatmsg%~Whisper, listen-Whisper, %chatmsg%~Shout, listen-Shout)
say(Type \'Whisper\' or \'Shout\')",

"listen-Whisper",
"whisper(Whispering..)",

"listen-Shout",
"shout(Shouting..)"');?>
            </div>    
        </div>        
    </div>
    <!--Action Touch Events-->
    <div num='5' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',6); ?>
		<?php print wtheadline('Action Touch Events',' can be created and toggled based on the name or description of the prim touched or it\'s link number; find the action setting \'Touch_Events\' to enable them. This event will trigger all breeds synced with this action object.'); ?>
        <div style='padding:20px;'>  
            <div class='entry sub-pad'> 
                <?php print actions_comment('Name one of the prims in your action object','"Help"','and click it.');?>
                <?php print actions_code('"touch-Help",
"say(Help touched!)"','Touch_Events = 1;');?>
				<?php print actions_comment('Set <strong>Touch_Events</strong> to','1','to detect the touched prim\'s name.');?>
            </div>
            <div class='entry sub-pad'> 
                <?php print actions_comment('Also try','"Say", "Shout","Whisper"','in the object descriptions and click each one.');?>
                <?php print actions_code('"touch-Say",
"say(%action% touched!)",

"touch-Shout",
"shout(%action% touched!)",

"touch-Whisper",
"whisper(%action% touched!)"','Touch_Events = 2;');?>
				<?php print actions_comment('Set <strong>Touch_Events</strong> to','2','to detect the touched prim\'s description.');?>
            </div>
            <div class='entry sub-pad'> 
                <?php print actions_comment('If you want to use the','link number','just try the following.');?>
                <?php print actions_code('"touch-0",
"say(%this%)",

"touch-1",
"say(%this%)",

"touch-2",
"say(%this%)",

"touch-3",
"say(%this%)"','Touch_Events = 3;');?>
				<?php print actions_comment('Set <strong>Touch_Events</strong> to','3','to detect the touched prim\'s link number.');?>
            </div>
		</div>
    </div>
    <!--Syncing \ Throttles-->
    <div num='6' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',7); ?>
		<?php print wtheadline('Syncing is easy!','Throttles, limits, and filters provide a wide range of tools to allow you to decide how the breeds interact with their actions. Limit the total number of breeds, sync by comparing keywords, and even by matching object descriptions.'); ?>
        <div style='padding:20px;'>  
        	<h3>Add or change these <span class='title inline sub-up'>action.settings</span> values:</h3>
        	<?php print breedSetting(
		'Breed_Limit',
		'-1',
		'Limit the number of breeds that can interact with this object.',
		'Breed_Limit = 5;',
		'Allows access for the first 5 breeds to interact with this object.'
		); ?>
        	<?php print breedSetting(
		'Breed_Timeout',
		'60',
		'Time in seconds for a breed to respond before allowing other breeds to interact.',
		'Breed_Timeout = 300;',
		'Breed must send a request to this action object every 5 minutes (300 seconds) from any timed request or lose it\'s position.'
		); ?>
        	<?php print breedSetting(
		'Desc_Filter',
		'null',
		'Optional: Ignore breeds that do not have a matching keyword in their object description field. Leave blank to disable this filter. Or use the value "%desc%" to only communicate with breeds that have matching descriptions.',
		'Desc_Filter = "Friendly";',
		'Now only breed objects with the word "Friendly" in their object description will be able to use this action object.'
		); ?>
        	<?php print breedSetting(
		'Action_Type',
		'null',
		'Define each Action Object with a single word or short phrase. Breeds will be limited to one of each type unless blank.',
		'Action_Type = "Food";',
		'Now breed objects will only be able to communicate with just one action object with this <strong>Action_Type</strong>.'
		); ?>
       
        	<h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
        	<?php print breedSetting(
		'Allow_Throttling',
		'FALSE',
		'TRUE or FALSE : Sync communications with Action Objects?',
		'Allow_Throttling = TRUE;',
		'Syncing allows you to focus communications with a select range of action objects.'
		); ?>
        	<?php print breedSetting(
		'Sync_Timeout',
		'0',
		'If action object is removed, set a timeout for breed to look for replacement.',
		'Sync_Timeout = 300;',
		'If the last response from each action object is older than 5 minutes (300 seconds), expire the connection.'
		); ?>
        	<?php print breedSetting(
		'Retry_Timeout',
		'20',
		'If all connections fail, retry the connection after this many seconds.',
		'Retry_Timeout = 300;',
		'If the last failed attempt to connect to an action object is older than 5 minutes (300 seconds), retry the connection.'
		); ?>
        	<?php print breedSetting(
		'Allowed_Types',
		'null',
		'Allow types that contain these keywords (may contain expressions)',
		'Allowed_Types = [ "Friendly", "Happy" ];',
		'Useful for having multiple groups of breeds. 
		<p class="sub-in sit">Assuming you have a <strong>food source</strong> with:</p>'.
		big_code('Action_Type = "Friendly Food";','action').'
		<p class="sub-in sit">And a <strong>home object</strong> with: </p>'.
		big_code('Action_Type = "Happy Home";','action').'
		<p class="sub-in hang">The breed object will interact with both of the above action objects, but it will ignore types like "Regular Food". However, a breed would eat both foods and use any \'Home\' object if it was configured with:</p>'.
		big_code('Allowed_Types = [ "Food", "Home" ];','breed').'
		<p class="sub-in hang">This is very useful for segregating breeds from certain types of action objects.</p>'
		); ?>
        
        
            <h3>This value is optional in <span class='title inline sub-up'>both scripts</span>:</h3>
            <?php print normalSetting(
            'Owner_Only',
            'TRUE',
            'TRUE or FALSE : Only interact with same-owner action-objects?',
            'Owner_Only = FALSE;',
            'Allows multi-owner objects within the same species to interact.'
            ); ?>
        </div>
    </div>
    <!--More Bind Events-->
    <div num='7' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back',8); ?>        
		<?php print wtheadline('Bind all the things!','Binding is the easiest way to define even more events for your breeds. Consider the possibilities of the following events:'); ?>
        <div style='padding:20px;'>  
            <div class='entry sub-pad'>
            	<?php print actions_comment('Check for ','"region"','changes.');?>
            	<?php print actions_code('"start", 
"bind(region, null, change-event)",

"change-event", 
"message(%ownerkey%, I am now in %region%.)"');?>
            </div>     
            <div class='entry sub-pad'>
            	<?php print actions_comment('Detect if breed and owner ','"collide"','.');?>
            	<?php print actions_code('"start", 
"bind(collide, owner, change-event)",

"change-event", 
"say(%owner% bumped %name%)"');?>
            	<?php print actions_comment('Detect if an object named "Bullet" and breed object ','"collide"','.');?>
            	<?php print actions_code('"start", 
"bind(collide, Bullet, change-event)",

"change-event", 
"prop(Hits,+1)
say(I\'ve been hit %Hits% times.)"');?>
            </div>     
            <div class='entry sub-pad'>
            	<?php print actions_comment('Detect if anyone is around using ','"sensor" <span style="font-size:0.75em;color:black;">&</span> "nosensor"','events.');?>
            	<?php print actions_code('"start", 
"bind(sensor, 10, found)
 bind(nosensor, 10, not-found)",

"found", 
"text(Someone is near me!)",

"not-found", 
"text(No one is around.)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('Detect if owner is ','"online" <span style="font-size:0.75em;color:black;">or</span> "offline"','.');?>
            	<?php print actions_code('"start", 
"bind(timer, 10, text)
 bind(online, null, online)
 bind(offline, null, offline)",

"online", 
"prop(Online,+1)
 say(%owner% is online)",

"offline", 
"prop(Offline,+1)
 say(%owner% is offline)",

"text", 
"text(Owner: %owner% \n Logins: %Online% \n Logoffs: %Offline%)"');?>
				<p class='sub-in sit'>Add or set this value to the <strong>breed.settings</strong> script:</p>
                <?php print big_code('Globals = [ "Online", 0, "Offline", 0 ];','breed');?>
            </div>        
            <div class='entry sub-pad'>
            	<?php print actions_comment('Your breeds know when it\'s ','"day" <span style="font-size:0.75em;color:black;">or</span> "night"',' in <strong>"SL"</strong> time or <strong>"RL"</strong> PST time.');?>
            	<?php print actions_code('"start", 
"bind(timer, 10, text)
 bind(day, SL, awake)
 bind(night, SL, sleeping)",

"awake", 
"prop(status, Awake!)",

"sleeping", 
"prop(status, zzZZzz)",

"text", 
"text(Status: %status%)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('Trigger a callback when ','"attach" <span style="font-size:0.75em;color:black;">&</span> "detach"','events occur.');?>
				<?php print actions_code('"start", 
"bind(touch, owner, come)
 bind(attach, null, on)
 bind(detach, null, off)",

"come",
"move(%ownerpos%,<0,0,0>,walk,normal,arrived)",

"arrived",
"attach()",

"on",
"anim(Sitting,10)" ,

"off",
"anim(Sitting,-1)"');?>
				<p class='sub-in'> Requires an animation called <strong>"Sitting"</strong>.</p>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('You can also trigger a callback when ','"sit" <span style="font-size:0.75em;color:black;">&</span> "unsit"','events occur.');?>
            	<?php print actions_code('"start", 
"toggle(text)
 bind(sit, null, sitting)
 bind(unsit, null, stand)",

"text",
"text(Sit to ride:)",

"sitting",
"text()
 anim(sit)
 move(%actionpos%,<0,0,0>,walk)",
		
"stand",
"toggle(text)
 anim(sit,-1)"');?>
            </div>   
            <div class='entry sub-pad'>
            	<?php print actions_comment('You can also bind an event for when the breed is ','"moving" <span style="font-size:0.75em;color:black;">&</span> "stopped"','.');?>
            	<?php print actions_code('"start", 
"text(Unchanged.)
 bind(moving, null, moved)
 bind(stopped, null, stop)
 bind(touch, owner, come)",

"come",
"move(%ownerpos%, <0,0,0>, walk)",

"moved", 
"text(Moving..)",

"stop", 
"text(Stopped.)"');?>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('Trigger a callback when breed is in ','"water" <span style="font-size:0.75em;color:black;"> or back on </span> "land"','.');?>
            	<?php print actions_code('"start", 
"bind(water, 1.0, swim)
 bind(land, 1.0, walk)
 bind(timer, 5, wander)",

"wander",
"move(%actionpos%, <5i,5i,0>, %type%)",

"moved", 
"prop(type,walk)
 toggle(wander)",

"stop", 
"text(Stopped.)"');?>
				<p class='sub-in sit'>Add or set this value to the <strong>breed.settings</strong> script:</p>
                <?php print big_code('Globals = [  "type", "walk" ];','breed');?>
            </div> 
        </div>        
    </div>
    <!--Extending the Actions List-->
    <div num='8' class='frame-2a' style='display:none;'>
		<?php print backButton('Go Back'); ?>
		<?php print wtheadline('Extend your capabilities','with additional Actions scripts if you run out of room or need a way to organize complex Actions lists.'); ?>
        <div style='padding:20px;'>  
        	<h3>Create a <span class='title inline sub-up'>new script</span> and insert this code:</h3>
        	<?php print normal_code('list Actions = [ 

];  
e(integer a,string b){integer f=llListFindList(Actions,[b]);
string d=llList2String(Actions,f+1);if(a==-201){g(200,"");}
else if(a==-202){if(f!=-1){g(201,d);}else{g(243,"");}}}g(integer n,string b){
llMessageLinked(-4,n,b,"");}default{state_entry(){g(205,"");}
link_message(integer n,integer a,string b,key c){if(a&lt;200){e(a,b);}}}');?>
			<p>And now you can <strong>better organize</strong> long Actions lists!</p>
		</div>
    </div>
</div>

<!--Names-->
<div num='2b' class='sub-content' style='display:none;'>
    <div class='frame-2b'>
        <?php print subButton('2c','Continue to Lifespan'); ?>
		<?php print wtheadline('Names','can be given automatically or defined by the user later. Names can even be \'earned\' and traded. The "breed name" is the name of the individual and the "object name" is the name of the prim. When changed, breed names can be instantly applied to the object\'s name or description. The following are example uses for breed names:'); ?>
        <div style='padding:60px;'>
            <p class='sub-in'><strong>Configure the Name Generator:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Changing the breed's name:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-2b' style='display:none;'>
        <?php print backButton('Go Back',2); ?>
		<?php print wtheadline('The Name Generator','automatically creates a unique name when the breed is first created by picking a random prefix, middle, and suffix from a series of lists. If the generator is set for gender specific names, it chooses from either male or female suffixes based on it\'s gender. This name can also be applied to the object\'s name or description for easy identification.'); ?>
        <div style='padding:20px;'> 
        	<h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
        	<?php print breedSetting(
		'Name_Generator',
		'TRUE',
		'TRUE or FALSE : Enable/Disable name generator?',
		'Name_Generator = FALSE;',
		'The name generator is now disabled.'
		); ?>
        	<?php print breedSetting(
		'Gender_Specific',
		'TRUE',
		'TRUE or FALSE : Create gender specific names?',
		'Gender_Specific = FALSE;',
		'Names will be created randomly, instead of based on gender.'
		); ?>
        	<?php print breedSetting(
		'Set_Object',
		'null',
		'When the breed name is changed or reset, the name can be inserted into the object\'s name or description field. Use the %name% or %desc% expression to insert the breed\'s name into the string. Assuming the breed\'s name is "Ralph":',
		'Set_Object = "eco-%name%";',
		'The object\'s name will now be labeled: eco-Ralph',
		'Set_Object = "eco-%desc%";',
		'The object\'s description will now be labeled: eco-Ralph'
		); ?>
        </div>
    </div>
    <div num='2' class='frame-2b' style='display:none;'>
        <?php print backButton('Go Back'); ?>
		<?php print wtheadline('Changing the name','can be enabled for your users at any time. This would require a user interaction such as a chat command, a feature in a menu system, or even by rezzable objects.'); ?>
        <div style='padding:20px;'>         
            <div class='entry expand sub-pad'>
                <?php print videolink('Set the breed name
 using an <strong style="font-size:1.1em;">input menu</strong>', 'ChJVUTm1Kko');?>
                <?php print actions_code('"start",
"bind(touch, owner, input_menu)",
    
"input_menu",
"textbox(%ownerkey%, \nSet name and click \'Send\':, set_name)",
    
"set_name",
"val(MyName,%chatmsg%)
say(My name is now %MyName%)"');?>
            </div>        
            <div class='entry expand sub-pad'>
                <?php print videolink('Set the breed name
 using an <strong style="font-size:1.1em;">chat commands</strong>', 'ChJVUTm1Kko');?>
				<?php print actions_code('"start",
"bind(touch, owner, start_listen)",

"start_listen",
"say(Type new name in chat:)
bind(listen, owner, listen_name, remove_listen)",

"listen_name",
"unbind(remove_listen)
 val(MyName,%chatmsg%)
 say(My name is now %MyName%)"');?>
            </div>        
            <div class='entry expand sub-pad'>
                <?php print videolink('Set the breed name
 using an <strong style="font-size:1.1em;">rezzable objects</strong>', 'ChJVUTm1Kko');?>
				<?php print actions_code('"start",
"bind(touch, owner, set_name)",

"set_name",
"val(MyName, Roger)
 say(My name is now %MyName%)
 @destroy()"');?>
                <p class='sub-in'>The rezzable objects example requires <strong style='font-size:1.1em;'>the <tag class='bool'>@destroy()</tag> extension:</strong></p>
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
    </div>
</div>

<!--Lifespan-->
<div num='2c' class='sub-content' style='display:none;'>
    <div class='frame-2c'>
		<?php print subButton('2d','Continue to Growth'); ?>
		<?php print wtheadline('Lifespan','refers to life, the ageing process, and death for the breeds. Age can be used to affect functionality and even physical appearance.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>The Ageing Process:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Reviving a Dead Breed:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Ageing Physical Features:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    
    <div num='1' class='frame-2c' style='display:none;'>
        <?php print backButton('Go Back',2); ?>
		<?php print wtheadline('The breed object\'s age','is determined by user-defined \'years\'. The lifespan cycle occurs every \'year\' and is checked every 60 seconds to determine if the cycle has expired. If multiple \'years\' have passed since the last time it was checked, the breed will age accordingly.'); ?>
        <div style='padding:20px;'>   
        	<h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
            <p><strong>STEP 1: </strong><em>Set the speed of <span style='font-size:1.3em;'>life</span> for your breed.</em></p>
        	<?php print breedSetting(
		'Lifespan',
		'TRUE',
		'TRUE or FALSE : Enable ageing?',
		'Lifespan = FALSE;',
		'Disables ageing.'
		); ?>
        	<?php print breedSetting(
		'Year',
		'1440',
		'Length of a year in minutes.',
		'Year = 43000;',
		'Sets length of year to one month (30 days)'
		); ?>
        	<?php print breedSetting(
		'Age_Start',
		'0',
		'Starting age when created/born.',
		'Age_Start = 100;',
		'Breeds are born at 100 years old.'
		); ?>
                       
            <p><strong>STEP 2: </strong>Define the odds of <span style='font-size:1.3em;'>death</span> once the breed is within the min and max age.</p>
	        <?php print breedSetting(
		'Age_Min',
		'15',
		'Minimum age before death from old age can occur.',
		'Age_Min = 0;',
		'Allows death to occur time of birth; requires Survival_Odds to be set.'
		); ?>
	        <?php print breedSetting(
		'Age_Max',
		'-1',
		'Minimum age before death from old age can occur.',
		'Age_Max = 20;',
		'Breed will only live to age 20.'
		); ?>
	        <?php print breedSetting(
		'Survival_Odds',
		'-1',
		'Odds of death within min/max age : 0 = Instant Death or -1 = No Death',
		'Survival_Odds = 1;',
		'Breed has a 50% chance of death with each age cycle.'
		); ?>
        	<p>Now your breed is set to <span style='font-size:1.3em;'>age</span>!</p>
        </div>
    </div>
    
    <div num='2' class='frame-2c' style='display:none;'>
        <?php print backButton('Go Back',3); ?>
		<?php print wtheadline('Death','occurs from old age, hunger, or can be triggered by a user-defined event.'); ?>     
        <div style='padding:0 20px;'>
      		<?php print videolink('Use revive() to bring a breed back to life', 'YgsQR2AfFSA');?>
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
            <h3 align='center'>Revival Tool</h3>
        	<?php print actions_code('// Revival Tool
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
			<hr />
            <h3 align='center'>Home Object</h3>
        	<?php print actions_code('// Home Object
"start",
"bind(timer,7,text_stats)",

"text_stats",
"filter(%Dead%=false,dead_stats)
val(Text_Color,<0.3, 0.9, 0.5>)
text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender% \n Skin: %Body%)",

"dead_stats",
"val(Text_Color,<1,0.2,0.2>)
text(DEAD \n Name: %MyName% \n Gender: %MyGender% \n Skin: %Body%)"');?>
        </div>
    </div>
    
    <div num='3' class='frame-2c' style='display:none;'>
        <?php print backButton('Go Back'); ?> 
		<?php print wtheadline('Age shows character',' and is demonstrated by visual growth. This snippet shows how easy it is to apply visual features to breeds based on age:'); ?>
        <div style='padding:0 20px;'>            
        	<?php print videolink('Ageing features', 'kRoyw_j-7cA');?>
        	<p class='sub-in'>When the breed ages and grows, this video shows you how to set age-based physical features for your breed.</p>
        	<?php print actions_code('"start",
"text(Age: %MyAge%)
 cache(Child,Teen,Adult)
 bind(timer,10,age_check)",

"age_check",
"text(Age: %MyAge%)
 filter(%MyAge%=1,not1)
 set(Child)
 uncache(Child)",

"not1",
"filter(%MyAge%=2,not2)
 set(Teen)
 uncache(Teen)",

"not2",
"filter(%MyAge%=3)
 set(Adult)
 uncache(Adult)"');?>
 		</div>
    </div>
</div>

<!--Growth-->
<div num='2d' class='sub-content' style='display:none;'>
    <div class='frame-2d'>
		<?php print subButton('2e','Continue to Appetite'); ?>
		<?php print wtheadline('Growth',' is the re-sizing and re-positioning of all prims in a linkset. The difference is applied to animations, rebuilt breeds, as well as sit and camera positions.  Once growth has completed it\'s last stage, the growth timer deactivates and the object remains a static size unless re-enabled. <strong>Growth is disabled by default.</strong>'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Establish a Growth Sequence:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Hungry Breeds have Stunted Growth:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-2d' style='display:none;'>
		<?php print backButton('Go Back',2); ?>
		<?php print wtheadline('Establish a growth cycle','by plugging in the following values.'); ?>
        <div style='padding:20px;'>
        	<h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
        	<?php print breedSetting(
		'Growth_Stages',
		'0',
		'How many growth stages?',
		'Growth_Stages = 10;',
		'The breed with have 10 growth stages throughout it\'s life.'
		); ?>
        	<?php print breedSetting(
		'Growth_Scale',
		'1.05',
		'This value must be greater than \'1.0\' for increasing the size, where 1.0 equals 100% of current size and 1.2 equals 120% of current size. This value can also be less than 1.0 for objects that shrink throughout it\'s lifespan',
		'Growth_Scale = 1.5;',
		'The breed will now grow 1.5x it\'s current size every cycle.'
		); ?>
        	<?php print breedSetting(
		'Growth_Timescale',
		'1440',
		'Length of time in minutes between each growth cycle.',
		'Growth_Timescale = 720;',
		'Growth would occur every 12 hours (720 minutes).'
		); ?>
        </div>
    </div>
    <div num='2' class='frame-2d' style='display:none;'>
		<?php print backButton('Go Back'); ?>
		<?php print wtheadline('Stunted growth','can be set to randomly occur using the "Growth_Odds" setting, you can also inhibit growth based on other breed conditions, such as the built in hunger level.'); ?>
        
        <div style='padding:20px;'>
        	<h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
        	<?php print breedSetting(
		'Growth_Odds',
		'0',
		'This value defines the odds of skipping a growth cycle. If a cycle is skipped, a growth stage is subtracted and no growth occurs. Set this value to \'0\' to never skip a growth stage. The higher the number, the more likely the growth stage will be skipped.',
		'Growth_Odds = 1;',
		'There is now a 50% chance of stunted growth.'
		); ?>
        
        
        	<h3>Or use the <span class='title inline sub-up'>filter method</span> to detect hunger:</h3>
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
    </div>
</div>

<!--Hunger-->
<div num='2e' class='sub-content' style='display:none;'>
    <div class='frame-2e'>
        <?php print subButton('2f','Continue to Breeding'); ?>
		<?php print wtheadline('The hunger level',' is part of the built-in point system. Food consumption is precise and secure with built in logic to handle multiple food sources. <strong>Hunger is disabled by default.</strong>'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Setting up the appetite:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Creating a food source:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Growing Plants as a Food Source:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-2e' style='display:none;'>
        <?php print backButton('Go Back',2); ?>
		<?php print wtheadline('A breed\'s appetite',' can range from predictable to finicky. Every hunger cycle, hunger points are lost to simulate a progressive appetite. Make sure the amount lost due to digestion is less than the minimum amount consumed.'); ?>
        <div style='padding:20px;'>
        	<h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
			<?php print breedSetting(
		'Hunger_Timescale',
		'0',
		'0 = Disabled : How often to check for food.',
		'Hunger_Timescale = 480;',
		'The hunger cycle would occur 3 times a day (every 480 minutes).'
		); ?>
			<?php print breedSetting(
            'Hunger_Start',
            '40',
            'Hunger level when first born/created.',
            'Hunger_Start = 0;',
            'Breed is born hungry.',
            'Hunger_Start = 100;',
            'Breed will not need food when first born/created.'
            ); ?>
            <?php print breedSetting(
            'Hunger_Odds',
            '0',
            'Odds of eating : 0 = Always Eat',
            'Hunger_Odds = 1;',
            'The higher the number, the less likely it will eat.'
            ); ?>
            <?php print breedSetting(
            'Hunger_Min',
            '1',
            'Minimum food units consumed per cycle.',
            'Hunger_Min = 5;',
            'Breed will consume at least 5 food units per serving.'
            ); ?>
            <?php print breedSetting(
            'Hunger_Max',
            '5',
            'Maximum food units consumed per cycle.',
            'Hunger_Max = 10;',
            'Breed will consume up to 10 food units per serving.'
            ); ?>
            <hr />
            <?php print breedSetting(
            'Hunger_Lost',
            '1',
            'Hunger points lost each hunger cycle.',
            'Hunger_Lost = 5;',
            'The MyHunger level will be reduced by 5 points every cycle.'
            ); ?>
            <?php print breedSetting(
            'Starvation_Threshold',
            '10',
            'Hunger death threshold.',
            'Starvation_Threshold = 0;',
            'Hunger levels must not be at zero for death to occur.'
            ); ?>
            <?php print breedSetting(
            'Starvation_Odds',
            '-1',
            'Odds of death when below starvation threshold : 0 = Always Die | -1 = Never Die',
            'Starvation_Odds = 0;',
            'Always dies when below starvation threshold.'
            ); ?>               
	    </div>
    </div>
    <div num='2' class='frame-2e' style='display:none;'>
        <?php print backButton('Go Back',3); ?>
		<?php print wtheadline('A food source',' is created by defining food quality and levels in an action object:'); ?>
        <div style='padding:20px;'>
        	<?php print actionSetting(
		'Food_Level',
		'0',
		'0 = None | -1 = Unlimited Food : Units of food.',
		'Food_Level = 10;',
		'Food source with 10 units available.'
		); ?>
        	<?php print actionSetting(
		'Food_Quality',
		'5',
		'How many points each food unit is worth.',
		'Food_Quality = 1;',
		'Each food unit is worth 1 point.'
		); ?>
        </div>
    </div>
    <div num='3' class='frame-2e' style='display:none;'>
        <?php print backButton('Go Back'); ?>
		<?php print wtheadline('Growing food','is an alternative to store bought foods. In this simulation, corn seed is planted and the  stalks grow until it reaches maturity and produces corn. The corn is then harvested to supply a food trough for the goat. A watering can is used to keep the gardens watered, otherwise the corn turns brown and dies:'); ?>
        <div style='padding:20px;'>
	      	<?php print videolink('Growing Plants as a Food Source', 'qGmjxFwbl60');?>
        	<?php print listItem('The corn <strong>seed</strong>.', 'A Breed object w/ growth and hunger enabled.'); ?>            
        	<?php print listItem('Plant bed (<strong>dirt</strong>).', 'Action object with food enabled; "Food Level" script, "Plant Bed" actions.'); ?>
        	<?php print toggle_example('Plant Bed Water Level (extension)',normal_code('integer Extension_Channel = -999666;
integer Water_Channel = -666999;

_extend(string function, string attributes){
    if(function=="@foodlevel"){
    if((integer)attributes>90){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,       <0.15, 4.456, 3.298>]);}
    else if((integer)attributes>80){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.13, 4.456, 3.298>]);} 
    else if((integer)attributes>70){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.11, 4.456, 3.298>]);}
    else if((integer)attributes>60){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.09, 4.456, 3.298>]);}
    else if((integer)attributes>50){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.07, 4.456, 3.298>]);}
    else if((integer)attributes>40){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.05, 4.456, 3.298>]);}
    else if((integer)attributes>30){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.03, 4.456, 3.298>]);}
    else if((integer)attributes>20){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.02, 4.456, 3.298>]);}
    else{llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,                             <0.010, 4.456, 3.298>]);}
    }
    if(function=="@fillTrough"){
        llRegionSay(Extension_Channel,"harvest");
    }
}
toggle(string class){_link(211,class);}     
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
food_level(integer amt){_link(221,(string)amt);}  
default{
on_rez(integer n){llResetScript();}
state_entry(){llListen(Water_Channel,"",llGetOwner(),"");}
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
listen(integer ch, string name, key id, string msg){if(msg=="water"){food_level(10);}}
}'),'script'); ?>     
        	<?php print toggle_example('Plant Bed Actions',actions_code('"start",
"filter(%Dead%=false)
bind(timer,20,text_stats)
toggle(text_stats)",

"text_stats",
"val(Text_Color,<0.3, 0.9, 0.5>)
text(/%harvest% \n/Name: %MyName% \n Age: %MyAge% \n Healthiness: %MyHunger%)
filter(%MyAge%>5)
prop(harvest,Ready for Harvest)
bind(touch,owner,harvest,null,%actionid%)", 

"dead",
"unbind()
val(Text_Color,<1,0,0>)
text(DEAD)",

"harvest",
"filter(%MyAge%>5,null,%Dead%=false)
unbind()
@fillTrough()
pause(1)
die()"'),'actions'); ?>  
        	<?php print listItem('A <strong>package</strong> to sell young corn seeds.', 'Contains: "Seed Package" script and seeds.'); ?>
        	<?php print toggle_example('Seed Package',normal_code('string seed = "Corn";
default{
state_entry(){
    llSetText("Touch to plant seed",<0.3, 0.9, 0.5>,1);
}
touch_start(integer n){
    if(llDetectedKey(0)!=llGetOwner()){return;}
    rotation rot = llEuler2Rot(<0,0,125>*DEG_TO_RAD);
    llRezObject(seed,llGetPos()+<.25,.25,-.25>,ZERO_VECTOR,rot,0);
    llRezObject(seed,llGetPos()+<-.25,.25,-.25>,ZERO_VECTOR,rot,0);
    llRezObject(seed,llGetPos()+<.25,-.25,-.25>,ZERO_VECTOR,rot,0);
    llRezObject(seed,llGetPos()+<-.25,-.25,-.25>,ZERO_VECTOR,rot,0);
    llRemoveInventory(seed);//if object is NO COPY, remove this line
    llDie();
}
}'),'script'); ?>
        	<?php print listItem('Create a <strong>watering can</strong>', 'Contains: "Watering Can" script only.'); ?>
        	<?php print toggle_example('Watering Can',normal_code('integer Water_Channel = -666999;

default{
    touch_start(integer total_number){
        if(llGetOwner()==llDetectedKey(0)){
            llRegionSay(Water_Channel,"water");
            llSleep(10);
        }
    }
}       '),'script'); ?>
        	<?php print listItem('A <strong>goat</strong>.', 'A Breed object w/ growth and hunger enabled.'); ?>
        	<?php print listItem('A <strong>food trough</strong> for the goat.', 'Action object with food enabled: "Food Trough" script and actions.'); ?>
        	<?php print toggle_example('Food Trough Show Corn (extension)',normal_code('integer Extension_Channel = -362223; 

_extend(string function, string attributes){
    if(function=="@foodlevel"){
        list prims = [1,18];
        if((integer)attributes>90){prims = [1,18,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>80){prims = [1,18,5,6,7,8,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>70){prims = [1,18,7,8,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>60){prims = [1,18,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>50){prims = [1,18,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>40){prims = [1,18,13,14,15,16,17,2];}
        else if((integer)attributes>30){prims = [1,18,15,16,17,2];}
        else if((integer)attributes>20){prims = [1,18,17,2];}
        else if((integer)attributes>10){prims = [1,18,2];}
        integer i;
        for(i=0;i<llGetNumberOfPrims();i++){
            if(llListFindList(prims,[i])==-1){llSetLinkAlpha(i,0,-1);}
            else{llSetLinkAlpha(i,1,-1);}
        }

    }
}
   
toggle(string class){_link(211,class);}    
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
food_level(integer amt){_link(221,(string)amt);}  
default{
state_entry(){llListen(Extension_Channel,"","","");}
listen(integer ch, string name, key id, string msg){food_level(10);toggle("setLevel");}
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}'),'script'); ?>     
        	<?php print toggle_example('Food Trough Actions',actions_code('"start",
"@foodlevel(%Food_Level%)",

"food",
"@foodlevel(%Food_Level%)",

"setLevel",
"@foodlevel(%Food_Level%)"'),'actions'); ?>      
        </div>
    </div>
</div>

<!--Breeding-->
<div num='2f' class='sub-content' style='display:none;'>
    <div class='frame-2f'>
		<?php print subButton('2g','Continue to Rebuilding'); ?>
		<?php print wtheadline('Breeding','is the act of mating and/or producing offspring where parents pass on unique information such as skin preferences or other traits to their offspring, thus creating a unique lineage. <strong>Breeding is disabled by default.</strong>'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Explore the breeding behaviors:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Produce offspring from a nest object:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><?php print premium_stamp(); ?><strong>Setting up the eco-crate:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Hatching from an egg:</strong> <button num='4' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-2f' style='display:none;'>
		<?php print backButton('Go Back',2); ?>
		<?php print wtheadline('Partnership, sexuality, and pregnancy','are individually configured to define the overall breeding behavior of your species.'); ?>
        <div style = 'padding:20px;'>
	        <h2 align='center'>Genders</h2>
        	<?php print breedSetting(
		'Genders',
		'TRUE',
		'TRUE or FALSE : Establish two genders?',
		'Genders = FALSE;',
		'Now breeds are unisex.'
		); ?>
        	<?php print breedSetting(
		'Gender_Ratio',
		'1',
		'Ratio of gender selection upon creation. Where 1 is a 1:1 gender ratio, higher positive numbers create a higher male population and higher negative numbers create a higher female population.',
		'Gender_Ratio = 0; // always female
// or
Gender_Ratio = -1; // always male',
		'Always male or always female. Useful for \'Starter Kits\'.',
		'Gender_Ratio = -5; //1 in 5 births are male.
// or
Gender_Ratio = 5; //1 in 5 births are female',
		'This is how to set rare genders.'
		); ?>
        	<hr />
	        <h2 align='center'>Partners</h2>
        	<?php print breedSetting(
		'Require_Partners',
		'TRUE',
		'TRUE or FALSE : Require partners to breed?',
		'Require_Partners = FALSE;',
		'The breed is now asexual and self replicates.'
		); ?>
        	<?php print breedSetting(
		'Unique_Partner',
		'TRUE',
		'TRUE or FALSE : Disallow breeding among siblings and parents?',
		'Unique_Partner = FALSE;',
		'Allow incest.'
		); ?>
        	<?php print breedSetting(
		'Keep_Partners',
		'TRUE',
		'TRUE or FALSE : Keep the same partners each breeding cycle?',
		'Keep_Partners = FALSE;',
		'Disables monogamy.'
		); ?>
        	<?php print breedSetting(
		'Partner_Timeout',
		'0',
		'How many breeding cycles without a partner before looking for new partner?',
		'Partner_Timeout = 2;',
		'If just one is skipped, the breed will look for new partner. Setting to 1 is not recommended.'
		); ?>
        	<hr />
	        <h2 align='center'>Breed Cycle</h2>
        	<?php print breedSetting(
		'Breed_Time',
		'0',
		'How often to look for a mate in minutes : 0 = Disabled',
		'Breed_Time = 1440;',
		'Breed looks for a mate or breeds every day (1440 minutes).'
		); ?>
        	<?php print breedSetting(
		'Breed_Age_Min',
		'0',
		' Minimum age for breeding to occur.',
		'Breed_Age_Min = 18;',
		'Will not breed until 18 years old.'
		); ?>
        	<?php print breedSetting(
		'Breed_Age_Max',
		'-1',
		'Maximum breeding age : -1 = Always Breeds',
		'Breed_Age_Max = 40;',
		'Will stop breeding after 40 years old.'
		); ?>
        	<hr />
	        <h2 align='center'>Pregnancy</h2>    
        	<?php print breedSetting(
		'Pregnancy_Timeout',
		'0',
		'Time in minutes between breeding and birth : 0 = Instant Birth',
		'Pregnancy_Timeout = 10000;',
		'Gives birth 1 week (10,000 minutes) after breeding.'
		); ?>    
        	<?php print breedSetting(
		'Litter_Min',
		'1',
		'Minimum number of breeds in each litter.',
		'Litter_Min = 5;',
		'Always at least 5 offspring in every birth sequence.'
		); ?>
        	<?php print breedSetting(
		'Litter_Max',
		'3',
		'Maximum number of breeds in each litter.',
		'Litter_Min = 1;
Litter_Max = 1;',
		'With both limits set to 1, only one breed will be born each birth sequence.'
		); ?>
        	<?php print breedSetting(
		'Litter_Rare',
		'FALSE',
		'TRUE or FALSE : Larger litters are more rare?',
		'Litter_Rare = TRUE;',
		'Higher number of litters less likely.'
		); ?>
        	<?php print breedSetting(
		'Litters',
		'-1',
		'Total number of litters a breed can have over a lifespan : -1 = Unlimited',
		'Litters = 5;',
		'Breeds stop giving birth after five successful birth sequences.'
		); ?>
        	<?php print breedSetting(
		'Breed_Failed_Odds',
		'0',
		'Odds of failed birth : 0 = No Failed Births',
		'Breed_Failed_Odds = 1;',
		'This sets failed births to 50%.'
		); ?>
        </div>        
    </div>
    <div num='2' class='frame-2f' style='display:none;'>
		<?php print backButton('Go Back',3); ?>
        <?php print wtheadline('Now that you have configured your breeds',' to mate, configure the offspring to be created. Offspring are born directly from action objects. The child object must be installed in the action object and be properly configured for the breeding sequence to be successful.'); ?>
        <div style='padding:20px;'>
            <h3>Set this value for the <span class='title inline sub-up'>child</span> breed:</h3>
            <?php print big_code('Activation_Param =  0;','breed');?>
            <p class='sub-in hang'>Activates when rezzed as a child <strong>from an action object.</strong></p>
            <h3 class='hang'>...and for the <span class='title inline sub-up'>parent</span> breeds:</h3>
            <?php print big_code('Activation_Param =  1;','breed');?>
            <p class='sub-in hang'>Activates when first rezzed <strong>by the next owner.</strong></p>
        </div>
        <div style='padding:20px;'>
	        <h2 align='center'>Breeding Options</h2>
        	<?php print actionSetting(
		'Allow_Breeding',
		'FALSE',
		'TRUE or FALSE : Allow this object to be used as a breeding source.',
		'Allow_Breeding = TRUE;',
		'Enable breeding for this action object.'
		); ?>
        	<?php print actionSetting(
		'Limit_Rezzed',
		'-1',
		'Limit the total number of breeds that can be created : -1 = Unlimited',
		'Limit_Rezzed = 5;',
		'Only 5 breeds will be allowed to be created.'
		); ?>
        	<?php print actionSetting(
		'Breed_Maxed_Die',
		'FALSE',
		'TRUE or FALSE : Destroy this object when \'Limit_Rezzed\' reaches zero?',
		'Breed_Maxed_Die = TRUE;',
		'Action object dies when \'Limit_Rezzed\' reaches zero.'
		); ?>
        	<hr />
	        <h2 align='center'>Child Object Options</h2>
        	<?php print actionSetting(
		'Breed_Any_Object',
		'TRUE',
		'TRUE or FALSE : Rez any object in contents as offspring?',
		'Breed_Any_Object = FALSE;
Breed_Object="child";',
		'Now requires an object named "child".'
		); ?>
        	<?php print actionSetting(
		'Breed_Object',
		'null',
		'The name of object to be rezzed from contents.',
		'Breed_Object="child";
Breed_Any_Object = FALSE;',
		'Now requires an object named "child".'
		); ?>
        	<hr />
	        <h2 align='center'>Limited-Use Filters</h2>
        	<?php print actionSetting(
		'Breed_One_Family',
		'FALSE',
		'TRUE or FALSE : Allow only one breeding pair?',
		'Breed_One_Family = TRUE;',
		'Only one breeding pair can use this as a breeding source.'
		); ?>
        	<?php print actionSetting(
		'Reserve_Breeding',
		'FALSE',
		'TRUE or FALSE : Allow breeding to occur by extension only?',
		'Reserve_Breeding = TRUE;',
		'Disables breeding but reserves it for use with extension scripts.'
		); ?>
        </div>
    </div>
    <div num='3' class='frame-2f' style='display:none;'>
		<?php print backButton('Go Back',4); ?>
		<?php print wtheadline('The eco-crate','is an OPTIONAL add-on for the eco-breed project. This tutorial shows you how to set up crates and explains the many uses of the crate system. '); ?> 
        <div style='padding:20px;'>
	      	<?php print videolink('SETTING UP THE ECO-CRATE (11:26)', 'mjV_Cm-Dycs');?>
            <div align='center'>
                <p><a href="https://marketplace.secondlife.com/p/eco/2999424" target="_blank">Get this Premium Extension!</a></p>
                <img style='height:200px;' src='img/eco-crate.png' />
            </div>
        </div>
    </div>
    <div num='4' class='frame-2f' style='display:none;'>
		<?php print backButton('Go Back'); ?>
		<?php print wtheadline('Hatch your breed',' from an egg. You can use this example to have a more advanced birth sequence. Breeds will display stats but will not age, grow, get hungry, or breed until \'hatched\'.'); ?>
        <div style='padding:20px;'>
	      	<?php print videolink('STARTING FROM AN EGG (9:40)', 'xPd12IWLJv0');?>
			<h4 align='center'>Please watch the video before continuing.</h4>
        	<?php print actions_code('"start",
"filter(!%BORN%)
cache(Hatched)
text(Name: %MyName% \n Gender: %MyGender%)
bind(timer,20,hatch,remove_hatch)",

"hatch",
"unbind(remove_hatch)
text(Hatching..)
set(Hatched)
uncache(Hatched)
prop(BORN,true)
val(Lifespan,1)
bind(timer,15,text_stats)",

"text_stats",
"text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender%)"');?>
			<p class='sub-in hang'>This example requires an animation named <strong>"Hatched"</strong> to be created. This simulation <strong>enables Lifespan</strong> after the timer expires and sets the "Hatched" animations, essentially shrinking the 'Egg' prim.</p>
        </div>
    </div>
</div>

<!--Rebuild-->
<div num='2g' class='sub-content' style='display:none;'>
	<div class='frame-2g'>
		<?php print pageButton('e-howto3','Continue to Prim Methods'); ?>
		<?php print wtheadline('Rebuilding breeds','that are lost/missing is vital for maintaining the value of individuals. All of the values that make a breed a unique individual are hosted externally. This enables users to recreate existing breeds with all core values appropriately adjusted. If an older copy of that breed attempts to re-activate, it will automatically delete (destroy) itself.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>How to enable rebuilding:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Re-defining the rebuild menu:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-2g' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Rebuilding is easy!','Any breed with Save_Records = TRUE is able to be rebuilt from an action object. Follow these few steps to get set up:'); ?>
        <div style='padding:20px;'>
        	<?php print listItem('Configure the child object', 'This breed object will be rezzed from the action object and used to recreate an existing breed.'); ?>
        	<?php print breedSetting(
		'Activation_Param',
		'1',
		'The activation param indicates how the breed is activated : 0 = child and 1 = parent',
		'Activation_Param = 0;',
		'Can now be used to recreate other breeds.'
		); ?>        
        	<?php print listItem('Install the child breed into an action object', 'Put the breed object you just configured into the contents of an action o bject.'); ?>
        	<?php print listItem('Enable rebuilding', 'Turn it on with just one configuration.'); ?>
        	<?php print actionSetting(
		'Allow_Rebuild',
		'FALSE',
		'FALSE = Disable | TRUE = Enable | 2 = Extensions Only',
		'Allow_Rebuild = TRUE;',
		'Rebuilding is now enabled.'
		); ?>
        	<?php print listItem('OPTIONAL: Designate the name of the child object', 'Use the following configuration to assign which object to use as child.'); ?>
			<?php print actionSetting(
		'Rebuild_Object',
		'null',
		'Name of object to be rezzed : "Rebuild_Any_Object" must be FALSE',
		'Rebuild_Object = "Object";',
		'Rezzes "Object" as child when rebuilding is triggered.'
		); ?>
        </div>
    </div>    
    <div num='2' class='frame-2g' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('The rebuild menu','is highly configurable! Define what type of breeds can be rebuilt and supply custom messages.'); ?>
        <div style='padding:20px;'>
        	<?php print actionSetting(
		'Breed_Max',
		'10',
		'How many breeds to provide rebuild support for : 200 = Max',
		'Breed_Max = 30;',
		'The rebuild menu will show up to 30 breed names '
		); ?>
        	<h3>Decide <strong>what type</strong> of breed can be rebuilt.</h3>
        	<?php print actionSetting(
		'Status',
		'1',
		'Use this value to filter breeds by status:<br> 0 = Active Breeds | 1 = Inactive Breeds | 2 = All Breeds',
		'Status = 2;',
		'All breeds owned by same owner will appear in the rebuild menu. Useful for updating customers with new scripts or configurations by allowing them to rebuild any of their breeds regardless of status (with the exception of the \'Dead_Breeds\' setting).'
		); ?>
        	<?php print actionSetting(
		'Dead_Breeds',
		'0',
		'Use this value to filter out dead breeds:<br>0 = Not Dead | 1 = All Breeds | 2 = Dead Breeds',
		'Dead_Breeds = 2;',
		'This example allows only dead breeds to be rebuilt.'
		); ?>
        	<h3>Now to define <strong>the menu</strong> buttons and messages.</h3>
        	<?php print actionSetting(
		'Touch_Length',
		'2',
		'Time in seconds a user must touch and hold to trigger menu.',
		'Touch_Length = 0;',
		'Menu appears instantly when clicked.'
		); ?>
        	<?php print actionSetting(
		'Message',
		'"\nSelect a breed:"',
		'Message in the breed selection menu.',
		'',
		''
		); ?>
        	<?php print actionSetting(
		'Button_Next',
		'"NEXT >"',
		'Define the \'NEXT\' button.',
		'',
		''
		); ?>
        	<?php print actionSetting(
		'Button_Prev',
		'"< PREV"',
		'Define the \'PREV\' button.',
		'',
		''
		); ?>
        	<?php print actionSetting(
		'Confirm_Message',
		'"\nAre you sure?"',
		'Message in the confirmation popup.',
		'',
		''
		); ?>
        	<?php print actionSetting(
		'Button_Confirm',
		'"Yes"',
		'Define the \'CONFIRM\' button.',
		'',
		''
		); ?>
        	<?php print actionSetting(
		'Button_Cancel',
		'"Cancel"',
		'Define the \'CANCEL\' button.',
		'',
		''
		); ?>
        </div>
    </div>
</div>





