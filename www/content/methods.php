<?php include('preload.php');?>
<!--< ?php print wtheadline('<strong>Methods</strong> listed below','with their associated values highlighted to the right. Invalid methods or values may silently fail and in some instances cause unexpected behaviors.'); ?>-->

<div style="background: #eee;border: 1px solid #E1E1E1;font-family: monospace;padding: 0 10px;display: table;margin-right: auto;margin-left: auto;-moz-border-radius: 10px;  -webkit-border-radius: 10px;  -opera-border-radius: 10px;  -khtml-border-radius: 10px;  border-radius: 10px;">
	<p class="sub-in"><strong>Brackets ' [ ' and ' ] '</strong> indicate an optional value. </p>
	<p class="sub-in"><strong>Ellipsis ' ... '</strong> (three dots in a row) indicate repeating values.</p>
</div>
<!--<h4 ALIGN='CENTER'>Actions Methods</h4>-->
<!--<p>The Action_Class is where functionality is derived. You may use native and non-native methods to create unique simulations for your eco-breed. Native methods are calls to predefined functions (and are Case Sensitive) which can accept a variety of values, <a show='expressions'>expressions</a>, and <a show='attr'>attributes</a> when an <a show='events'>event or callback</a> is triggered or toggled. Custom methods can also be created using <a show='extend'>extensions</a> and triggered using a hashtag '#' or at symbol '@' as a prefix (this lets the <a show='core'>core</a> code know that the method being called is for a breed-object or action-object <a show='extend'>extension</a>, respectively). </p>-->

<h3 style='color: #0F67A1;text-transform:uppercase;'>Lifespan</h3>

<div class='expand entry'>
<p class='tags'>null</p><p class='title'><img src='img/expand.gif' class='icon' />die()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method destroys the object. Be very careful!</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"dead", 
"die()"
];  </pre>
</div>
<p class='description'>This example is the most common use for the die() method, placed within the native "dead" event. This allows you to control populations and unauthorized copys.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>[ years [ , hunger-start ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />revive()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Used to revive a "dead" breed.</p>

<p style='font-size:0.9em;'><strong>years</strong> : additional "years" to add to it's min/max lifespan.</p>
<p style='font-size:0.9em;'><strong>hunger-start</strong> : Hunger value (0-100).</p>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>revive(10,50)</pre></div>
<p class='description'>This revives the breed with 10 additional years and a starting hunger of 50.</p>
</span>
</div>

<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Movement</h3>

<div class='expand entry'>
<p class='tags'>[ position [ , offset [ , type [ , speed [ , callback [ , avoid-flags [ , avoid-callback ] ] ] ] ] ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />move()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>The move() method triggers the <a show='core'>core</a> movement. As defined in the <a show='settings'>breed-settings</a> script.</p>

<p style='font-size:0.9em;'><strong>position</strong> : a pre-defined vector, or an <a show='expressions'>expression</a> which defines the target position.</p>
<p style='font-size:0.9em;'><strong>offset</strong> : a pre-defined vector which may include the 'r' or 'i' modifier or an <a show='expressions'>expression</a>, or a comination of these.</p>
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>	"&lt;0,0,5r&gt;"
results in a random offset within the range of &lt;0,0,0.0&gt; to &lt;0,0,5.0&gt;</pre></div>
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>	"&lt;0,0,5i&gt;"
results in an inverted random offset within the range of &lt;0,0,-5.0&gt; to &lt;0,0,5.0&gt; </pre></div>
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>	"&lt;%radius%i,%radius%i,0&gt;"
results in an inverted random offset within the range defined by a prop() method value called 'radius'.</pre></div>
<p style='font-size:0.9em;'><strong>type</strong> : is an <a show='attr'>attribute</a> which determines the type of movement, for example walk, swim, fly, or nonphysical movements.</p> 
<p style='font-size:0.9em;'><strong>speed</strong> : a speed modifier : float value or 'slow', 'normal', 'fast' which uses the speed value from the <a show='settings'>settings</a> script.</p> 
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-wrap;'>
slow	=  0.5 x pre-defined speed
normal	=  1.0 x pre-defined speed
fast	=  1.5 x pre-defined speed</pre></div>
<p style='font-size:0.9em;'><strong>callback</strong> : the <a show='events'>event</a> toggled when the object reaches it's destination.</p>
<p style='font-size:0.9em;'><strong>avoid-flags</strong> : these flags define what obstacles and hazards to avoid. You can apply just one, or multiples using the vertical bar '|' as a separator. These flags are 99% accurate with margin of error based on the bounding box of your breed and movement velocity (ie large/fast breeds are less accurate than slow/small breeds)</p>
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>-1 = ALL_FLAGS : Set all flags.
&nbsp;0 = AVOID_REGION_CROSSING : Avoid crossing into another region.
&nbsp;1 = AVOID_PARCEL_CROSSING : Avoid crossing into another parcel.
&nbsp;2 = AVOID_WATER : Avoid moving to a position that is over water.
&nbsp;3 = AVOID_OBJECTS : Avoid moving where nonphysical objects are in the way.
&nbsp;4 = AVOID_AVATARS : Avoid moving where avatars are in the way.
&nbsp;5 = AVOID_BREEDS : Avoid moving where physical objects are in the way.
&nbsp;6 = AVOID_LAND : Avoid moving where land/raised terrain is in the way.
&nbsp;7 = AVOID_PHANTOM : Avoid moving where phantom objects are in the way.
&nbsp;8 = AVOID_SLOPES : Avoid ground slopes lower than value set in breed settings.
&nbsp;9 = AVOID_NO_ACCESS : Avoid parcels where scripts or object entry is disabled.</pre></div>
<p style='font-size:0.9em;'><strong>avoid-callback</strong> : the <a show='events'>event</a> toggled if an avoid-flag is triggered.</p>
<p style='font-size:0.9em;margin-bottom:0;'><strong>Caveats:</strong></p>
<p style='font-size:0.9em;margin:0;'>&bull; AVOID_WATER and AVOID_SLOPES flags may toggle a false positive if the breed object is on floor prims or in a skybox.</p>
<p style='font-size:0.9em;margin:0;'>&bull; A blank move() method will stop current movement and disable the objects physics.</p>
<p style='font-size:0.9em;margin-top:0;'>&bull; The main/root prim must be upright and facing EAST at ZERO_ROTATION.</p>
<p style='font-weight:bold;margin:0;'>Simple example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"move(%ownerpos%, &lt;0,0,0&gt;, setpos, normal, arrived)",

"arrived", 
"say(Success!)"
];  </pre></div>
<p class='description'>This example moves the breed-object, using non-physical movement, to the owner and displays a 'Success!' message in local chat when it finishes moving.</p>

<p style='font-weight:bold;margin:0;'>Wander example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(timer, 10r, wander)",

"wander",
"move(%actionpos%, &lt;10i,10i,0&gt;, walk, slow, null, 3|4, avoid)",

"avoid", 
"toggle(wander)"
];  </pre>
</div>
<p class='description'>This example sets a random timer between 0 and 10 seconds. Each time the timer expires, the breed object walks slowly toward the destination position. AVOID_OBJECTS and AVOID_AVATARS is set, and if either flag is triggered the resulting callback re-toggles the 'wander' <a show='events'>event</a>.</p>
</div>
</span>
</div>

<div class='expand entry'>
<p class='tags'>[ position ]</p><p class='title'><img src='img/expand.gif' class='icon' />sethome()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To save a position vector as the objects 'home' position, call the sethome() method with a valid <a show='expressions'>expression</a> or call a blank sethome() method to save it's current position. You can access this value later by using the %MyHome% <a show='expressions'>expression</a> which can be useful with the move() method.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"sethome()
bind(touch,owner,msg_home)",

"msg_home",
"say(My home is: %MyHome%)"
];  </pre>
</div>
<p class='description'>The above example saves the objects home vector on start and sets an owner-only touch <a show='events'>event</a>. When touched, it will say the object's home vector in local chat.</p>
</span>
</div>

<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Communication</h3>
<!--<p style='margin-top:0px;font-size:0.9em;'>Messages supplied in these methods may be up to 511 characters and include special characters like <strong>\n</strong> for new line, <strong>\t</strong> for tab, <strong>\"</strong> for quotes and <strong>&amp;#37</strong> for percent characters ' % '. Messages may also contain <a show='expressions'>expressions</a> embedded in the string to include dynamic values. Additionally, if you wrap a segment of text with the ' / ' character and the expression within is Undefined, the regex algoritm removes the section of text from the string. This is very useful for displaying optional buttons for menus or stats within hovertext or chat messages where the value may or may not have been set yet.</p>-->

<div class='expand entry'>
<p class='tags'>avatar-key, message [ , button=callback [ , button=callback ... ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />menu()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This easy to use dialog menu allows you to toggle a <a show='events'>callback</a> for each menu button and also return the results to the <a show='expressions'>expressions</a>: %chatid% %chatname% %chatmsg% %chatpos%.</p>

<p style='font-size:0.9em;'><strong>avatar-key</strong> : the avatar's key for who gets the menu, most common value would be an <a show='expressions'>expression</a>.</p>
<p style='font-size:0.9em;'><strong>message</strong> : the message supplied in the dialog. If you need to use a comma ' , ' in the message, enclose the message with curly brackets: ' { ' and ' } '.</p>

<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>Example:
"menu(%ownerkey%, {message goes here, and commas can be used}, Okay=null)"</pre></div>
<p style='font-size:0.9em;'><strong>button</strong> : You may supply up to 12 buttons per menu() method, if no buttons are supplied, the dialog will not trigger a <a show='events'>callback</a> and simply supply an 'OK' button. If you want additional menus, use a <strong>button</strong> to toggle a <strong>callback</strong> to another menu.</p>
<p style='font-size:0.9em;'><strong>callback</strong> : Each button requires a <a show='events'>callback</a> separated by an equals character ' = ' using this format: button=callback.</p>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"menu(%ownerkey%, Say or shout?, Say=saymsg, Shout=shoutmsg)",

"saymsg", 
"say(Success!)",

"shoutmsg", 
"shout(Success!)"
];  </pre>
</div>
<p class='description'>This example would display a popup menu for the owner. If the owner selects 'Say' the response <a show='events'>callback</a> will say 'Success!' in local chat. If the owner selects 'Shout' the response callback will shout 'Success!' in local chat. If ignored, no <a show='events'>callbacks</a> are toggled.</p>

<p style='font-size:0.9em;' align='center'><strong>For a more advanced example, see the "Menu Example" in the <a show='plugins'>plugin repository</a>.</strong></p>

</span>
</div>

<div class='expand entry'>
<p class='tags'>avatar-key, message</p><p class='title'><img src='img/expand.gif' class='icon' />message()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Send a private message to a specific avatar.</p>
<p style='font-size:0.9em;'><strong>avatar-key</strong> : the avatar's key for who gets the private message, most common value would be an <a show='expressions'>expression</a>.</p>
<p style='font-size:0.9em;'><strong>message</strong> : If you need to use a comma ' , ' in the message, enclose the message with curly brackets: ' { ' and ' } '.</p>
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>Example:
"message(%ownerkey%, {message goes here, and commas can be used})"</pre></div>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>message(%ownerkey%, Hello! My name is %MyName%.)</pre></div>
<p class='description'>This example would send an instant message: "Hello! My name is Eco-Breed" to the owner.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>message</p><p class='title'><img src='img/expand.gif' class='icon' />ownersay()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Owner-only chat message. Messages will not be sent if owner is offline.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>ownersay(Hello world, my owner is %owner%)</pre></div>
<p class='description'>This example would say "Hello world, my owner is Dev Khaos" in global chat to just the owner.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>message</p><p class='title'><img src='img/expand.gif' class='icon' />say()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Local chat message that is displayed to a 20 meter radius from the breed-object.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>say(Hello world, my owner is %owner%)</pre></div>
<p class='description'>This example would say "Hello world, my owner is Dev Khaos" in local chat</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>message</p><p class='title'><img src='img/expand.gif' class='icon' />shout()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Local chat message that is displayed to a 100 meter radius from the breed-object.</p>
<p style='font-weight:bold;margin-bottom:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>shout(Hello world, my owner is %owner%)</pre></div>
<p class='description'>This example would shout "Hello world, my owner is Dev Khaos" in local chat</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>[message]</p><p class='title'><img src='img/expand.gif' class='icon' />text()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>"Floaty" hover text that is displayed directly over the center of the breed-object.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>text(My owner is %owner% \n I am %MyAge% years old)</pre></div>
<p class='description'>The hover text would say something like: </p>
<div class='codeblock'>
<p align='center'>My owner is Dev Khaos</p>
<p align='center'>I am 10 years old</p>
</div>
</span>
</div>

<div class='expand entry'>
<p class='tags'>avatar-key, message, callback</p><p class='title'><img src='img/expand.gif' class='icon' />textbox()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This easy to use textbox input method allows you to toggle a <a show='events'>callback</a> and return the resulting input to the <a show='expressions'>expressions</a>: %chatid% %chatname% %chatmsg% %chatpos%.</p>
<p style='font-size:0.9em;'><strong>avatar-key</strong> : the avatar's key for who gets the textbox, most common value would be an <a show='expressions'>expression</a>.</p>
<p style='font-size:0.9em;'><strong>message</strong> : the message supplied in the textbox. If you need to use a comma ' , ' in the message, enclose the message with curly brackets: ' { ' and ' } '.</p>

<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-line;'>Example:
"textbox(%ownerkey%, {message goes here, and commas can be used}, null)"</pre></div>

<p style='font-weight:bold;margin-bottom:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"textbox(%ownerkey%, Change my name , Change_Name)",

"Change_Name", 
"val(MyName,%chatmsg%)
say(My name is now %MyName%)"
];  </pre>
</div>
<p class='description'>This example would display a popup menu with a text input for the owner. The owner can set the breeds name, clicking "Submit" will trigger the <a show='events'>callback</a> which will use the response to set the MyName value with the %chatmsg% <a show='expressions'>expression</a>. It then displays a message in chat with the updated name.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>message</p><p class='title'><img src='img/expand.gif' class='icon' />whisper()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Local chat message that is displayed to a 10 meter radius from the breed-object.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>whisper(Hello world, my owner is %owner%)</pre></div>
<p class='description'>This example would whisper "Hello world, my owner is Dev Khaos" in local chat</p>
</span>
</div>

<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Inventory</h3>
        
<div class='expand entry'>
<p class='tags'>[ attach-point ]</p><p class='title'><img src='img/expand.gif' class='icon' />attach()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Use this method to attach or 'wear'/'hold' a breed-object. This method requires a one-time permissions request which is handled automatically and can only be performed on the object's owner. Successful attaching/wearing of the breed-object also toggles the 'attach' bind(). To detach without the breed-object going into your inventory, right click and select 'drop' which will return the object to the ground and raise the 'detach' bind().</p>
<p style='font-size:0.9em;'><strong>attach-point</strong> : an <a href='http://wiki.secondlife.com/wiki/LlAttachToAvatar' target='_blank'>optional attachment point</a> as an integer number.</p>
<p style='font-size:0.9em;margin-bottom:0;'><strong>Caveats:</strong></p>
<p style='font-size:0.9em;margin-top:0;'>&bull; A blank attach() method will attach the object to the last known attachment point. </p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(attach,null,attached)
bind(detach,null,detached)
attach()",

"attached", 
"say(Successfully attached!)",

"detached", 
"say(Successfully detached!)"
];  </pre>
</div>
<p class='description'>This example attaches the breed-object at the native 'start' <a show='events'>event</a> and binds attach/detach callbacks. The breed-object displays a success message in local chat when successfully attached and another success message when the avatar manually drops the breed-object.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>[ animation [ , duration ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />anim()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Animate the owner's avatar! This method requires a one-time permissions request which is handled automatically.</p>

<p style='font-size:0.9em;'><strong>animation</strong> : name of the animation, must be within the contents of the breed object or this method will silently fail.</p>
<p style='font-size:0.9em;'><strong>duration</strong> : set a timeout, in seconds, so you can loop the animation for a controled period of time. Without the duration, the animation persists and remains active until released.</p>

<p style='font-weight:bold;margin-bottom:0;font-size:0.9em;'>To play an animation for 10 seconds: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>anim(animation, 10)</pre></div>

<p style='font-weight:bold;margin-bottom:0;font-size:0.9em;'>To release the animation after one cycle: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>anim(animation, 0)</pre></div>

<p style='font-weight:bold;margin-bottom:0;font-size:0.9em;'>To release all animations: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>anim()</pre></div>

<p style='font-weight:bold;margin-bottom:0;font-size:0.9em;'>To release a specific animation: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>anim(animation, -1)</pre></div>

</span>
</div>

<div class='expand entry'>
<p class='tags'>avatar-key, inventory</p><p class='title'><img src='img/expand.gif' class='icon' />give()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Give inventory to any avatar.</p> 

<p style='font-size:0.9em;'><strong>avatar-key</strong> : the recipient. Most common value is an <a show='expressions'>expression</a>.</p>
<p style='font-size:0.9em;'><strong>inventory</strong> : any type of inventory. Must be in the breed-object's inventory or this method will silently fail.</p>

<p style='font-weight:bold;margin:0;'>Simple example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes =[

"start",
"bind(touch,owner,touched)",

"touched",
"give(%ownerkey%,notecard)"

];</pre></div>
<p class='description'>This example binds an owner only touch event. When touched, it gives an inventory item called "notecard".</p>

<p style='font-weight:bold;margin:0;'>Expression example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
prop(note,INVENTORY_NOTECARD[0])
give(%ownerkey%,%note%)</pre></div>
<p class='description'>This example finds the first notecard in the breed-object's contents and sets the property "note". Then it gives the notecard to the owner.</p>

<p style='font-weight:bold;margin:0;'>Advanced example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes =[

"start",
"bind(listen,owner,chat_event)",

"chat_event",
"filter(%chatmsg% = /help)
give(%chatid%,notecard)"

];</pre></div>
<p class='description'>This example binds an owner only listen event. When the breed-object hears owner say '/help', it gives an inventory item called "notecard".</p>

</span>
</div>

<div class='expand entry'>
<p class='tags'>inventory [ , offset [ , start_param [ , force [ , target  [ , fail-callback ] ] ] ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />rez()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Rez inventory objects in place, at an offset, with an <a href='http://lslwiki.net/lslwiki/wakka.php?wakka=on_rez' target="_blank">on_rez</a> start_param, and/or with a force at a target vector.</p> 

<p style='font-size:0.9em;'><strong>inventory</strong> : name of the object, must be within the contents of the breed object or the <strong>fail-callback</strong> will be triggered and the rezzing will fail.</p>
<p style='font-size:0.9em;'><strong>offset</strong> : a vector &lt;x, y, z&gt; offset to rez the object up to 10 meters away from the breed-object.</p>
<p style='font-size:0.9em;'><strong>start_param</strong> : the integer supplied to the <a href='http://lslwiki.net/lslwiki/wakka.php?wakka=on_rez' target="_blank">on_rez</a> event within any scripts in the rezzed objects contents. This is most commonly used for creating rezzables that activate with a secure start_param value.</p>
<p style='font-size:0.9em;'><strong>force</strong> : a float/integer value to rez the object with a force similiar to a gun. A rez() with a force value will 'shoot' the prim forwards, supply a negative value to 'shoot' backwards.</p>
<p style='font-size:0.9em;'><strong>target</strong> : a target position; the breed-object will turn towards this vector before rezzing the prim.</p>
<p style='font-size:0.9em;'><strong>fail-callback</strong> : if the <strong>offset</strong> is an invalid vector position or the <strong>inventory</strong> object is missing, this callback is triggered.</p>
<p style='font-weight:bold;margin:0;'>Simple example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"rez(Object)"
];  </pre></div>
<p class='description'>This example rezzes a prim named 'Object' as the breed-objects current position.</p>

<p style='font-weight:bold;margin:0;'>Force example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(touch,owner,shoot_prim)",

"shoot_prim",
"rez(Object, <0,0,0.5>, 0, 10, %ownerpos%)"
];  </pre>
</div>
<p class='description'>This example binds an owner-only touch <a show='events'>event</a> which, when touched, the breed-object shoots an inventory_object named 'Object' with a force of 10 towards the owner. For this method to work, the breed-object must contain a physical prim named 'Object'. If the object is not physical, it will not have gun-like behavior.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>[ sound [ , loop ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />sound()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Trigger a looping or one-time sound from your breed objects.</p>

<p style='font-size:0.9em;'><strong>sound</strong> : name or uuid of the sound; if name is used, it must be within the contents of the breed object or this method will silently fail. To get the uuid of the sound, right-click the sound file from your inventory and select 'Copy Asset UUID'.</p>
<p style='font-size:0.9em;'><strong>loop</strong> : set to ' 1 ' to loop the sound. Once loop is enabled, use a blank sound() method to stop it.</p>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start",
"sound(sound_file, 1)
bind(touch,all,stop_sound)",

"stop_sound",
"sound()
say(Sound Stopped)"
];  </pre>
</div>
<p class='description'>This example loops a sound file named 'sound_file' from the breed-object's inventory over and over until touched by an avatar.</p>
</div>
</span>
</div>

<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Event Flow</h3>

<div class='expand entry'>
<p class='tags'>event, filter, callback [ , handle ]</p><p class='title'><img src='img/expand.gif' class='icon' />bind()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method allows you to bind a variety of progressive, scale-able functionality.</p>
<p style='font-size:0.9em;'><strong>event</strong> : defines what activity to bind to, see <a show='events'>"Bind Events"</a> for accepted values.</p>
<p style='font-size:0.9em;'><strong>filter</strong> : a static value, an <a show='expressions'>expression</a>, or a <a show='attr'>"Bind Attribute"</a> depending on the <strong>event</strong>. The filter acts to define what results to filter out such as 'owner' to block any interaction for this activity from anyone except the object's owner.</p>
<p style='font-size:0.9em;'><strong>callback</strong> : a user-defined callback or native <a show='events'>event</a>. When the <strong>event</strong> interaction passes the <strong>filter</strong> <em>this</em> callback is toggled.</p>
<p style='font-size:0.9em;'><strong>handle</strong> : an optional unbind() handle used to release/remove this activity.</p>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(touch, owner, touched)",

"touched",
"say(Owner touched!)"
];  </pre>
</div>
<p class='description'>This example creates an owner-only touch event. When the breed is touched by it's owner, the breed-object displays a 'Owner touched!' message in local chat.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>condition [ , callback [ , condition, callback ... ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />filter()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method compares two values and continues traversing the methods string if result is TRUE. If result is FALSE, the filter() method blocks subsequent methods and toggles a <strong>callback</strong>.</p>

 If the results are TRUE, the <a show='core'>core</a> code will continue traversing the methods string or if FALSE, stop the iteration and ignore the remainder of the methods string. </p>

<p style='font-size:0.9em;'><strong>condition</strong> : two values, either static, a <a show='attr'>"Filter Attribute"</a>, or an <a show='expressions'>expression</a>, separated by a single digit operator.</p>
<div class='codeblock'><pre style='font-size:1.2em; white-space: pre-wrap;'>
&lt;	less than
&gt;	greater than
=	equal to
!	not equal
^	list contains
~	string contains</pre></div>
<p class='description'>The "list contains" operator checks lists separated by the vertical bar " | " including %MyParentsRaw%, %MySkins%, and %MyDormantSkins% <a show='expressions'>expressions</a>, as well as user-defined lists such as those defined with the prop() method.</p>
<p class='description'>The "string contains" operator checks strings for the value.</p>
<p style='font-size:0.9em;'><strong>callback</strong> : a user-defined or native <a show='events'>event</a> that is toggled when result is FALSE. Otherwise skipped.</p>

<p style='font-size:0.9em;'>You can supply additional conditions and callback pairs which are only checked if previous conditions are TRUE.</p>
<p style='font-weight:bold;margin:0;'>Example:</p>
<div class='codeblock'>
<pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(touch,all,check)",

"check",
"filter(%toucher%=owner,is_false, %touchkey%=group, wrong_group) 
say(You are my owner and in my group, %owner%)",

"wrong_group",
"say(You are my owner, %toucher%, but not in my group)",

"is_false",
"say(You are not my owner, %toucher%)"
];  </pre>
</div>
<p class='description'>This example uses the bind() method to set a public touch <a show='events'>event</a> named 'check'. When touched by an avatar, the filter() method diverts non-owners to the 'is_false' <a show='events'>event</a> or when touched by owner it will check if the owner is active under the same group tag as the breed-object. If TRUE the <a show='core'>core</a> code continues traversing the method string.</p>
<p class='description'>The LSL equivalent would be:</p>
<div class='codeblock'>
<pre style='font-size:1.2em;'>
string owner;

default{

state_entry(){
    owner=llKey2Name(llGetOwner());
}

touch_start(integer n){
    string toucher = llDetectedName(0);
    string touchkey = llDetectedKey(0);
    if(toucher==owner&&llSameGroup(touchkey)){
        llSay(0,"You are my owner and in my group, "+toucher);
    }
    else if(toucher==owner&&!llSameGroup(touchkey)){
        llSay(0,"You are my owner "+toucher+" but not in my group.");
    }
    else{
        llSay(0,"You are not my owner "+toucher);
    }
}

}
</pre>
</div>

<p style='font-weight:bold;margin:0;margin-top:30px;'>Alternate Example: </p>
<div class='codeblock'>
<pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"prop(Friends[n], Me, You)
 filter(%Friends% ^ You, not_found)
 say('You' was found in list 'Friends')",

"not_found",
"say('You' was NOT found in list 'Friends')"

];  </pre>
</div>
<p class='description'>This example creates a list called "Friends" and adds the values "Me" and "You". The filter checks if "You" is in the list "Friends" by calling the list identifier as an expression and comparing values using the 'list contains' operator "^". The result is the breed object saying <strong>" 'You' was found in list 'Friends' "</strong> in local chat.</p>
<p class='description'>The LSL equivalent would be:</p>
<div class='codeblock'>
<pre style='font-size:1.2em;'>

list Friends=[];

default{

state_entry(){
    Friends += ["Me", "You"];
    if(llListFindList(Friends,["You"])!=-1){
    	llSay(0,"'You' was found in list 'Friends'");
    }
    else{
    	llSay(0,"'You' was NOT found in list 'Friends'");
    }
}

}
</pre>
</div>
</span>
</div>

<div class='expand entry'>
<p class='tags'>condition [ , callback [ , condition, callback ... ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />rfilter()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method is similar to filter() where it compares two values, HOWEVER, if result is TRUE it blocks subsequent conditions or methods and toggles the <strong>callback</strong>. If the result is FALSE, the algorithm continues traversing subsequent conditions or the methods string.</p>

<p style='font-weight:bold;margin:0;'>Example:</p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(touch,all,check)",

"check",
"rfilter(%toucher%=owner, is_owner, %touchkey%=group, in_group)
 say(You are not my owner or in my group, %toucher%.)",

"is_owner",
"say(You are my owner, %owner%.)",

"in_group",
"say(You are in my group, %toucher%.)"
];  
</pre></div>
</span>
</div>

<div class='expand entry'>
<p class='tags'>event</p><p class='title'><img src='img/expand.gif' class='icon' />off()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To disable native or user-defined <a show='events'>events and callbacks</a> supply the event/callback name as the only value. Null (blank) values will be ignored.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>off(dead)</pre>
</div>
<p class='description'>This example disables the native "dead" event, the method string response will be ignored.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>event</p><p class='title'><img src='img/expand.gif' class='icon' />on()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To re-enable native or user-defined <a show='events'>events and callbacks</a> supply the event/callback name as the only value. Null (blank) values will re-enable all previously disabled events. By default, all events are enabled and must be disabled prior to calling this method for it to have any effect.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>on(dead)</pre>
</div>
<p class='description'>This example re-enables the native "dead" event which we disabled in the off() example above, the method string response will no longer be ignored.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>time</p><p class='title'><img src='img/expand.gif' class='icon' />pause()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To pause the script between method calls, simply call this method with a user-defined float value, calculated in seconds. The pause() time can include the 'r' modifier, for example "pause(5r)" which results in a random delay within the range of 0.0 to 5.0 seconds. When the pause() method is executed, any existing activity beside active movement or prim animations will be delayed, however new <a show='events'>event</a> toggles or <a show='events'>callbacks</a> will be cached and run when the pause() expires.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"say(Pausing for 5 seconds..)
pause(5)
"say(Pause expired.)"
];</pre>
</div>
<p class='description'>This example first says a message in local chat, pauses for 5 seconds, then displays another message in local chat.</p>
<p style='font-weight:bold;margin:0;'>Min/Max example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"say(Pausing for 5 to 10 seconds..)
pause(5)
pause(5r)
"say(Pause expired.)"
];</pre>
</div>
<p class='description'>This example first says a message in local chat, pauses for 5 seconds, then pauses for a random time between 0.0 to 5.0 seconds, then displays another message in local chat.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>event [ , event [ , event ... ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />toggle()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To toggle a specific <a show='events'>event</a> in the <em>Action_Classes</em> <a show='classes'>class</a> list, use this method with the user-defined or native <a show='events'>event</a> as the value. </p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[

"start",
"bind(touch,owner,touched)",

"touched",
"say(Touched)
toggle(toggled)",

"toggled",
"say(Toggled!)"

];  </pre></div>
<p class='description'>This example sets an owner-only touch bind to create a callback for this method. The <a show='events'>callback</a> is named 'touched' which when touched by the object's owner displays a 'Touched' message in local chat then toggles the <a show='events'>event</a> named 'toggled' which displays a 'Toggled!' message in local chat.</p>

<p style='font-size:0.9em;'><strong>Random toggle</strong> : supply additional events and a random event will be selected, the rest are discarded.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[

"start",
"toggle(A, B, C)",

"A",
"say(Event A was chosen!)",

"B",
"say(Event B was chosen!)",

"C",
"say(Event C was chosen!)"

];  </pre></div>
<p class='description'>This example toggles a random event: A, B, or C.</p>

</span>
</div>

<div class='expand entry'>
<p class='tags'>[ handle [ , handle ... ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />unbind()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To unbind an <a show='events'>event</a>, simply call the unbind(handle) method within your Action_Class <a show='classes'>class</a> list using the handle that you created in the bind() <a show='methods'>method</a>. You can also call a blank unbind() (without a handle) to destroy all previously declared binds. Unbind multiple events by seperating their handles with a comma.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start",
"bind(touch,owner,event_name,remove_handle)",

"event_name",
"unbind(remove_handle)
say(Success!)"
];</pre>
</div>
<p class='description'>This example binds an owner-only touch event named 'event_name'. When touched by the object's owner, the script unbinds the touch event and then displays a 'Success!' message in local chat. Since the touch bind is released, the touch event will only trigger the <a show='events'>callback</a> once.</p>
</span>
</div>

<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Manipulation</h3>

<div class='expand entry'>
<p class='tags'>identifier [ , value  [ , value ... ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />prop()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method is used for creating, modifying, and deleting user-defined values including strings, lists, and integers. This is very useful for creating traits or saving important values which can be used in other methods as an <a show='expressions'>expression</a> by declaring the custom %identifier% wrapped in '%' symbols. You can also access inventory items (any texture, sound, landmark, note, animation, or object in the breed's contents) which can be saved as a static value and used in other methods. The value parameter can also be an expression! Calling prop() without a value removes the property entirely.</p>

<p style='font-weight:bold;margin:0;'>Lists Indexes: </p>
<div class='codeblock'><pre style='font-size:1.2em;white-space:pre-wrap;'>
[0]	First list item
[1]	Second list item (and greater numbers for subsequent indexes)
[r]	Random list item
[n]	Last list item
</pre></div>
<p class='description'>List indexes can be prefixed to the <strong>identifier</strong> or <strong>value</strong> allowing you to modify, add to, or retrieve the properties value.</p>

<p style='font-weight:bold;margin:0;'>Inventory Lists: </p>
<div class='codeblock'><pre style='font-size:1.2em;white-space:pre-wrap;'>
INVENTORY_TEXTURE	= list of all textures in the breed-objects inventory
INVENTORY_LANDMARK	= list of all landmarks in the breed-objects inventory
INVENTORY_NOTE		= list of all notecards in the breed-objects inventory
INVENTORY_ANIMATION	= list of all animations in the breed-objects inventory
INVENTORY_OBJECT	= list of all objects in the breed-objects inventory
INVENTORY_SOUND		= list of all sounds in the breed-objects inventory
</pre></div>
<p class='description'>Inventory is automatically compiled to a list which can be used to set prop() values dynamically such as selecting a random inventory item to give, rez (object), or trigger (animation / sound).</p>

<p style='font-weight:bold;margin:0;'>Modifiers: </p>
<div class='codeblock'><pre style='font-size:1.2em;white-space:pre-wrap;'>
+	Add value to identifier's value
-	Subtract value from the identifier's value
*	Multiply identifier's value by the provided value
/	Divide identifier's value by the provided value
~	Sets the identifier's value as a random number between 0 and value
</pre></div>
<p class='description'>Modifiers can be prefixed to the value allowing you to modify the identifiers original value. Without a modifier prefix, the identifier's value is set to the value provided. Calling prop() without a value removes the property entirely.</p>

<p style='font-weight:bold;margin:0;'>Examples: </p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Health, 100)</pre></div>
<p class='description'>Sets "Health" to 100. If "Health" is not already created, it will create it for you and save it's value as 100.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Damage, 5)</pre></div>
<p class='description'>Sets "Damage" to 5. If "Damage" is not already created, it will create it for you and save it's value as 5.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Damage, *2)</pre></div>
<p class='description'>Multiplies "Damage" by 2, resulting in "Damage" equaling 10. If "Damage" is not already created, it will create it for you and save it's value as 0 since 0 x 2 = 0.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Damage, /2)</pre></div>
<p class='description'>Divides "Damage" by 2, assuming "Damage" is now 10, the result is "Damage" equaling 5. If "Damage" is not already created, it will create it for you and save it's value as 0 since you cannot divide by zero.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Health, -Damage)</pre></div>
<p class='description'>Reduces "Health" by "Damage" which we defined as 5. In this scenerio, "Health" is now 95. If "Health" was not already created, it would create it for you and save it's value as -5.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Health, +5)</pre></div>
<p class='description'>Increases "Health" by 5. As per the previous examples, health would be back to 100.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Health)</pre></div>
<p class='description'>Without giving a second value, this tells the prop() method to remove the value "Health". If "Health" is not set, nothing would happen.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Friends[n], me, myself, you)</pre></div>
<p class='description'>Creates a list called "Friends" with 3 string values: 'me', 'myself', 'you'. The brackets indicate that this value is a list. The [n] means it will point to the end of the list, thus inserting the provided values at the end of the list.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Friends[n])</pre></div>
<p class='description'>Assuming that we already created a list called "Friends" with 3 string values: 'me', 'myself', and 'you', calling this method would remove the last list value making "Friends" list now just 2 string values: 'me' and 'myself'. Alternately, you can remove the whole list by calling prop(Friends).</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Friends[0],%owner%)</pre></div>
<p class='description'>You can also use expressions with this method. Assuming that we already created a list called "Friends" with now just 2 string values: 'me', and 'myself', calling this method would replace the first list value 'me' with the owner name. In this instance, making "Friends" list: 'Dev Khaos' and 'myself'.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Friends[r])</pre></div>
<p class='description'>We can also use a random index! Let's assume our "Friends" list still has 3 string values: 'me', 'myself', 'you'. The 'r' within the brackets indicates a random index. In this example, calling this method as written would remove a random value from the list, resulting in a list of 2 string values, such as: 'me' and 'you' or 'me' and 'myself', or 'myself' and 'you'.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Friends[r],person)</pre></div>
<p class='description'>You could even replace one of the 3 list values randomly. Let's assume our "Friends" list still has 3 string values: 'me', 'myself', 'you'. In this example, calling this method as written would result in the list still having 3 string values, but with a randomly replaced value, such as: 'me', 'person', 'you' or 'me', 'myself', 'person' or 'person', 'myself', 'you'.</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Enemies[n],Friends[2])
prop(Friends[2])</pre></div>
<p class='description'>You could even use previously declared list values to define another property. Let's assume our "Friends" list still has 3 string values: 'me', 'myself', 'you'. In this example, calling this method as written would first result in the creation of a new list called "Enemies" and defined with the 3rd value on the "Friends" list (The [2] index = 3rd value as is common practice in programming languages. 0 = first, 1 = second, etc). After moving 'you' to the "Enemies" list, the 2nd prop() method removes the 3rd value 'you' from the "Friends" list. So now, "Enemies" is 'you', and "Friends" is 'me' and 'myself'. Lonely example, but it works!</p>

<div class='codeblock'><pre style='font-size:1.2em;'>prop(Sound,INVENTORY_SOUND[r])</pre></div>
<p class='description'>You can also use INVENTORY_* flags as possible lists. You can not change the list by using an INVENTORY_* flag as an identifier, but in this example we are setting a value called "Sound" with a random sound from the breed-object's contents. This can be used later with the sound() method, written like: sound(%Sound%).</p>

</span>
</div>
<div class='expand entry'>
<p class='tags'>setting, value [ , setting, value ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />val()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method allows you to change a variety global <a show='settings'>settings</a> that are recognized as <a show='attr'>"attributes"</a> and can be changed dynamically during event flow. You can change multiple settings at the same time by listing each <strong>setting, value</strong> pair in succession. This method is extremely useful when used in combination with the prop() and filter() methods, allowing you to enable/disable/modify <a show='core'>core</a> functionality based on user-defined properties.</p>

<p style='font-size:0.9em;'><strong>setting</strong> : a recognized global value listed on the <a show='attr'>attributes</a> page.</p>
<p style='font-size:0.9em;'><strong>value</strong> : a static value or an <a show='expressions'>expression</a>.</p>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"bind(timer,60,breed_status)",

"breed_status",
"filter(%Happiness%&gt50, disable_breed)
val(Breed_Time,60)",

"disable_breed",
"val(Breed_Time,0)"

];  </pre>
</div>
<p class='description'>The above example checks the breed's happiness level every 60 seconds, and "Happiness" must be previously set using the prop() method. If "Happiness" is greater than 50, the filter is passed and the val() method sets the Breed_Time <a show='attr'>attribute</a> to every 60 minutes. If the filter is not passed, it stops the current method string and calls back to the "disable_breed" <a show='events'>event</a> which turns Breed_Time to 0 minutes, disabling breeding completely.</p>
</span>
</div>

<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Animations</h3>

<div class='expand entry'>
<p class='tags'>anim-name [ , anim-name ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />cache()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>To use prim animations using the set() method, you must first cache them in the scripts. This allows you to store only the prim animations you need per action object without flooding your scripts with all of your defined animations. The cache() method is most practical in the 'start' <a show='events'>event</a>.</p>

<p style='font-size:0.9em;'><strong>anim-name</strong> : the prim animation's name; for multiple animations, separate them using a comma ','.</p>

<p style='font-size:0.9em;' align='center'><strong>For examples of usage, see the set() and uncache() methods.</strong></p>

</span>
</div>

<div class='expand entry'>
<p class='tags'>anim-name [ , anim-name ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />uncache()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Use this method uncache prim animations that will no longer be used in the action-classes list. It is good practice to clear un-needed animations from the script's overhead memory.</p>

<p style='font-size:0.9em;'><strong>anim-name</strong> : the prim animation's name; for multiple animations, separate them using a comma ','.</p>

<p style='font-weight:bold;margin:0;'>Random hat example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"prop(Hats[n], Red Hat, Green Hat, Blue Hat)
 prop(Hat,Hats[r])
 cache(%Hat%)
 ownersay(Touch a breed to apply this hat!)
 bind(touch,owner,apply,unbind-touch)",
 
"apply",
"set(%Hat%,true)
 uncache(%Hat%)
 unbind(unbind-touch)
 ownersay(Applied %Hat% to %MyName%)
 prop(Hats)
 prop(Hat)
 @destroy()"
]; </pre></div>
<p class='description'>This unique example creates a list of 3 possible hats to apply to the breed. A random hat is selected and defined by the prop() value "Hat" which can be used globally as an <a show='expressions'>expression</a> "%Hat%". The script caches the animation defined by '%Hat%' and binds an owner only touch event to all breeds. When touched it sets and saves it so it will be reapplied if it's ever rebuilt. The script then uncaches the animation parameters, unbinds the touch event from all breeds, and clears the prop() values from the breed object. This example would be useful for applying a random accessory to a single breed then self-destructing. (See <a show='extend'>action extensions</a> to learn how to create custom methods like "@destroy()".)</p>

</span>
</div>

<div class='expand entry'>
<p class='tags'>anim-name [ | anim-name ... [ , save ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />set()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>The set() method is used to toggle prim animation methods which are compiled using the eco-web <a show='api'>API</a> or from the 'my_species' tab on the <a show='myaccount'>"My Eco-Breeds"</a> page with options for declaring the number of frames, repeat, and length of delay in seconds. See the methods below in the <a style='cursor:pointer;' jump='anim-methods'>Anim Methods</a> section.</p>

<p style='font-size:0.9em;'><strong>anim-name</strong> : the prim animation's name; for multiple animations, separate them using a vertical bar '|'.</p>
<p style='font-size:0.9em;'><strong>save</strong> : if set to "true", any anims declared in this method will be saved so they can be reapplied if the breed is rebuilt.  Saving mostly only useful for accesories or other permanant changes that should be kept when rebuilt. Otherwise leave it out.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start", 
"cache(flash)
 bind(touch, owner, touched)",

"touched",
"set(flash)"
]; </pre></div>
<p class='description'>This example caches the animation named 'flash' and binds an owner only touch. When touched, it starts the prim animation.</p>
</span>
</div>

<div class='expand entry'>
<p class='tags'>anim-name [ | anim-name ... [ , unsave ] ]</p><p class='title'><img src='img/expand.gif' class='icon' />unset()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>This method unsets the prim animation previously declared by the set() method.</p>

<p style='font-size:0.9em;'><strong>anim-name</strong> : the prim animation's name; for multiple animations, separate them using a vertical bar '|'.</p>
<p style='font-size:0.9em;'><strong>unsave</strong> : if set to "true", any anims declared in this method will be unsaved.</p>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>
list Action_Classes=[
"start",
"bind(touch,owner,unset_anim)
cache(flash, blink)
set(flash|blink)",

"unset_anim",
"unset(flash)"
];
</pre>
</div>
<p class='description'>This example toggles two prim animations named 'flash' and 'blink' and binds an owner-only touch <a show='events'>event</a> which will stop only the 'flash' animation when touched.</p>
</span>
</div>

<!--
<div style='height:20px'></div>

<h3 style='color: #0F67A1;text-transform:uppercase;'>Prim Methods <span style='margin-left:10px;font-size:0.7em;color:red;'>not for use in Actions list</span></h3>
<!--<h4 ALIGN='CENTER' jump='anim-methods'>Prim Methods</h4>
<p>The following methods are used for Skins, Poses, and Animations. These cannot be supplied to the Action_Classes list. Prim methods are defined and compiled using the eco-web <a show='api'>API</a> or from the 'my_species' tab on the <a show='myaccount'>"My Eco-Breeds"</a> page.</p>

<p align='center' style='font-size:0.9em;color:orangered;'>To set the same value to multiple prims or faces, use the vertical bar '|' as a separator. <p style='font-size:0.9em;'><strong>Example:</strong> Let's say you have an object that is 4 prims, and you want to set the same value to the entire object, use -1 for ALL_PRIMS and -1 for ALL_SIDES. If you want to set all prims except the main prim, use 2|3|4 for the 2nd, 3rd, and 4th prim. Same goes for faces.</p>-->
<!--

<div class='expand entry'>
<p class='tags'>prim, face, float [ , float ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />alpha()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Transparency animations allow you to set or alternate the transparency (alpha) of a specific prim and face (with a range of 0.0 to 1.0).</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>alpha(-1,-1,0,1)</pre></div>
<p class='description'>This example changes all sides (-1) and all prims of a linkset's transparency to invisible before returning it to visible.</p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, face, vector [ , vector ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />color()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Color animations allow you to set or alternate the color of a specific prim and face.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>color(-1,-1,<1,0,0>,<1,1,1>)</pre></div>
<p class='description'>This example changes all sides (-1) and all prims of a linkset's color to red before returning it to white.</p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, face, value [ , value ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />glow()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Sets a glow to a specific prim/face. Valid glow values include float (decimal) values between 0.0 and 1.0</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>glow(1,-1,0.5)</pre></div>
<p class='description'>This example changes all sides (-1) and all prims (-1) of the linkset's shine to 0.5.</p>

</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, vector [ , vector ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />pos()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Position animations require local positions (the offset position vector from the root prim, based on the objects local rotation). If this method is used on the root prim, it will act as an offset from its currently global position vector (ie. <0,0,1> will move the entire object up 1 meter from its current global position vector).</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>pos(2,<0,0,1>,<0,0,0.5>)</pre></div>
<p class='description'>This example moves the 2nd linked prim to 1 meter directly above the root prim before returning it to 0.5 meters above the root. </p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, rotation [ , rotation ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />rot()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Rotation animations require local rotations. </p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>rot(2,<0, 0, 0.38, 0.92>, <0,0,0,0>)</pre></div>
<p class='description'>This example rotates the 2nd linked prim 45 degrees along the Z axis before returning it to a zero rotation. </p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, flags, uuid [ , uuid ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />sculpt()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Sculpt animations are very useful for swapping sculpt maps or for progressively applying new sculpts to individual prims. To return a sculpted prim to a standard prim, use the type() method. Use caution with applying sculpt maps rapidly as each client must load each sculpt map. Preloading the sculpts by retaining an already rendered sculpt shape within the linkset is the best practice for rapid sculpt rendering. Stitching types include: 0=none, 1=sphere, 2=torus, 3=plane, 4=cylinder. Optional flags: 64=invert, 128=mirror. Append these to the stitching type with a '|' seperator. So for a sphere stitch that is mirrored: 1|128. For a cylinder stitch type inverted and mirrored: 4|64|128.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>sculpt(2, 1|64, bea82b0f-27c6-730b-fd7f-733f2340b449)</pre></div>
<p class='description'>This example sets the 2nd linked prim to an apple sculpt with a sphere stitch type and marked inside-out. </p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, face, value [ , value ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />shine()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Sets a shine to a specific prim/face. Valid shine values include "high", "med", "low", or "none".</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>shine(-1,-1,med)</pre></div>
<p class='description'>This example changes all sides (-1) and all prims (-1) of the linkset's shine to medium ("med").</p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, vector [ , vector ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />size()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Size/Scale animations are useful for a range of effects and may be used on the main/root prim.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>size(1,<1,1,1>,<0.5,0.5,0.5>)</pre></div>
<p class='description'>This example scales the root prim to 1 meter, then to 0.5 meters on all axis. </p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, face, uuid [ , uuid ... ]</p><p class='title'><img src='img/expand.gif' class='icon' />texture()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>Texture animations can be used for a variety of purposes. Most common uses are blinking textured (non-prim) eyes or moving textured (non-prim) lips. Use caution with applying textures rapidly as each client must load each texture. Preloading the textures by retaining an already rendered texture within the linkset is the best practice for rapid texture rendering. Also, textures equal to or less than 512x512 pixils render faster.</p>
<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>texture(-1, -1, 840e0d6d-a176-3076-2708-5b3fb1a0cdba, 89556747-24cb-43ed-920b-47caed15465f)</pre></div>
<p class='description'>This example sets all sides (-1) and all prims (-1) of a linkset to an "apple" texture before returning it to a "default box" texture. </p>
</span>
</div>
<div class='expand entry'>
<p class='tags'>prim, type, params</p><p class='title'><img src='img/expand.gif' class='icon' />type()</p>
<span>
<p class='description' style='color: black;font-size: 0.9em;'>The type() method cannot be a repeating animation, rather it is used to change the prim type of a prim or multiple prims. This method requires you supply the correct set of params for each prim type. See the <a href='http://wiki.secondlife.com/wiki/LlSetLinkPrimitiveParamsFast' target="_blank">lsl wiki page</a> for details on the expected parameters for each type or refer to the following table:</p>

<pre style='overflow:scroll;'>
[type]			[params]

box 		hole,cut,hollow,twist,top_size,shear
cylinder 	hole,cut,hollow,twist,top_size,shear
prism 		hole,cut,hollow,twist,top_size,shear
sphere 		hole,cut,hollow,twist,dimple
torus 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
tube 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
ring 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
sculpt 		map,type

</pre>

<p style='font-weight:bold;margin:0;'>Example: </p>
<div class='codeblock'><pre style='font-size:1.2em;'>type(-1,box,0,<0, 1, 0>,0,<0, 0, 0>,<1, 1, 0>,<0, 0, 0>)</pre></div>
<p class='description'>This example sets all prims (-1) of a linkset to default box. Note: this does not change the scale, rotation, color, or texture of the object.</p>
</span>
</div>
-->
<div style='height:50px'></div>