
<?php
print "<p class='widget-line-$odd'>Methods: Binding and unbinding events.</p>";
?>

<span style='display:none;'>

    	<?php print wtheadline('Events can be created','for activities such as touch, timer, listen, and a variety of other conditions. Each event is a chance to insert unique functionality.'); ?> 
        	<?php print method_profile(
			'bind',
			'event, filter, callback [ , handle ]',
			array(
				'event','defines what activity to bind to.',
				'filter','a static value or an expression.',
				'callback','when event passes the filter this callback is toggled.',
				'handle','an optional unbind() handle used to release/remove this activity.'
			),
			actions_code('"start", 
"bind(touch, owner, touched)",

"touched",
"say(Owner touched!)"'),
			"This example creates an owner-only touch event. When the breed is touched by it's owner, the breed-object displays a 'Owner touched!' message in local chat."
			);?>
            <?php print method_profile(
			'unbind',
			'[ handle [ , handle ... ] ]',
			array(
				'','Unbind multiple events by seperating their handles with a comma.'
			),
			actions_code('"start",
"bind(touch, owner, event, handle)",

"event",
"unbind(handle)
say(Success!)"'),
			"This example binds an owner-only touch event named 'event_name'. When touched by the object's owner, the script unbinds the touch event and then displays a 'Success!' message in local chat. Since the touch bind is released, the touch event will only trigger the callback once."
			);?>			
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

</span>
            
            
            
            
            
        