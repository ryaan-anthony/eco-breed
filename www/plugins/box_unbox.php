<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"cache(unbox,rebox)
bind(timer,5,text_stats)
bind(touch,owner,show_menu)
filter(%box_button%=Undefined)
prop(box_button,Unbox)",

"show_menu",
"menu(%ownerkey%, What would you like to do?, %box_button%=box_toggle)",

"box_toggle",
"filter(%box_button%=Unbox,repackage)
prop(box_button,Put in Box)
set(unbox)
val(Lifespan,1)",

"repackage",
"prop(box_button,Unbox)
set(rebox)
val(Lifespan,0)",

"text_stats",
"text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender% \n Skin: %Body%)"

];
</pre></div>

<p style='font-size:0.9em;margin-top:0;'>You must supply the prim animation 'unbox' and 'rebox' in the Prim Anims section of your my_species page.</p>