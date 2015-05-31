
<h4 align='center'>Please watch the video before continuing.</h4>

<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"cache(Hatched)
bind(timer,5,text_stats)
bind(timer,20,hatch,remove_hatch)",

"hatch",
"unbind(remove_hatch)
set(Hatched)
prop(BORN,true)
val(Lifespan,1)",

"text_stats",
"filter(%BORN%=true,egg_stats)
text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender%)",

"egg_stats",
"text(Name: %MyName% \n Gender: %MyGender%)"

];
</pre></div>
<p style='font-size:0.9em;margin-top:0;'>This example enables Lifespan after a timer expires and removes the 'Egg' prim that is covering the breed object. 'Hatched' sets the main prim back to it's original parameters and is defined in the Prim Anims section of the <a show='myacount'>species configuration</a> page.</p>

<p style='font-size:0.9em;margin-bottom:0;'>To re-apply the 'Egg' after hatching, ammend the action list to include:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"cache(Egg)
bind(touch,owner,set_egg,remove_set)",

"set_egg",
"unbind(remove_set)
set(Egg)
prop(BORN,false)
val(Lifespan,0)"

];
</pre></div>
<p style='font-size:0.9em;margin-top:0;'>This example disables Lifespan after the owner touches it (or otherwise toggles 'set_egg' event and changes the property BORN to false which removes 'age' from the text() values as per the previous example. 'Egg' sets the main prim to a large egg that covers the breed object and is defined in the Prim Anims section of the <a show='myacount'>species configuration</a> page.</p>