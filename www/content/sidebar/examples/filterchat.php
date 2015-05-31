
<?php
print "<p class='widget-line-$odd'>Detect and filter local chat commands</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Bind a "listen" event', 'to detect messages in local chat or reserved channels. Accepted filter values can be an object or avatar\'s name, description, or key or just one of the following attributes: "owner", "notowner", "all", "group", "notgroup". Otherwise, filter value can be "null" to disable filter. This event returns %chatname%, %chatid%, %chatpos%, and %chatmsg% expressions.'); ?>
 
        	<h3>Basic chat relay.</h3>
        	<?php print actions_code('"start",
"bind(listen, all, chat-relay)",

"chat-relay",
"ownersay(%chatname% said %chatmsg%)"');?>
			<p class='description'>Anything said in local chat is repeated to the owner.</p>
            
        	<h3>Listen for chat commands.</h3>
        	<?php print actions_code('"start",
 "bind(listen, owner, return)",
 
 "return",
 "filter(%chatmsg%~%MyName%,not)
  rfilter(%chatmsg%~come, come, %chatmsg%~home, home, %chatmsg%~stop, disable_wander, %chatmsg%~wander, start_wander) 
  say(Say my name plus "home", "stop", "wander" or "come" for more options!)",
 
 "home",
 "unbind(end-wander)
  move()
  move(%actionpos%, <0.2i,0.2i,0>, walk)",
 
 "come",
 "unbind(end-wander)
  move()
  move(%ownerpos%, null, walk)",
  
 "wander",
 "move(%actionpos%, <5i,5i,-0.25>, nonphys, normal, null, 3, avoid)",

 "avoid",
 "toggle(wander)",
   
 "start_wander",
 "bind(timer, 10r, wander, end-wander)",
  
 "disable_wander",
 "unbind(end-wander)
  move()"');?>
			<p class='description'>Say the breed's name in local chat with the following commands: 'come', 'home', 'stop', 'wander'. (ex. "Hey eco, come here!" assuming the breed's name is "eco")</p>
            
        	<h3>Reserved Channel</h3>
        	<?php print actions_code('"start",
"bind(listen|3, all, input)",

"input",
"ownersay(%chatmsg%)"');?>
			<p class='description'>Listens on channel 3 and relays message to owner.</p>
            
        	<h3>Listen to owner for keyword</h3>
        	<?php print actions_code('"start",
"bind(listen, owner, input)",

"input",
"rfilter(%chatmsg%~help, help, %chatmsg%~all, stats, %chatmsg%~name, name, %chatmsg%~age, age, %chatmsg%~gender, gender, %chatmsg%~hide, clear)",

"help",
"ownersay(Say \'help\', \'all\', \'name\', \'age\', \'gender\', \'hide\')
 give(notecard)",//include a note named "notecard" or change this value

"stats",
"text(%MyName% - %MyGender% \n Age: %MyAge%)
 bind(timer, 15, clear, remove)",

"name",
"text(%MyName%)
 bind(timer, 15, clear, remove)",

"age",
"text(Age: %MyAge%)
 bind(timer, 15, clear, remove)",

"gender",
"text(%MyGender%)
 bind(timer, 15, clear, remove)",

"clear",
"unbind(remove)
text()"');?>
			<p class='description'>This example displays stats over all breeds based on the chat command from the owner. If 'help' is said, the owner is given a notecard (if the breed object contains the notecard). The text stats are cleared after 15 seconds.</p>   
</span>