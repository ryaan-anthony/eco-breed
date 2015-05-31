




<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"prop(sound_button,Sound OFF)
 bind(touch,owner,give_menu)",

"give_menu",
"menu(%ownerkey%,Example Menu, 
    %sound_button%=sound_toggle, 
    Set Name=input_name, 
    Show Stats=show_stats, 
    Text Color=color_menu)",

"sound_toggle",
"filter(%sound_button%=Sound OFF,disable_sound)
 prop(sound_button,Sound ON)
 val(Sound_Volume,0)
 say(Sound is now off)",

"disable_sound",
"prop(sound_button,Sound OFF)
 val(Sound_Volume,1)
 say(Sound is now on)",
 
"input_name",
"textbox(%ownerkey%,Breed's name is currently: %MyName%\nSet breeds name here:, set_name)",

"set_name",
"val(MyName,%chatmsg%)",

"show_stats",
"bind(timer,20,hide_text,remove_text_timer)
 text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender%)",
 
"hide_text",
"unbind(remove_text_timer)
 text()",
 
"color_menu",
"menu(%ownerkey%,Set text color, Red=set_red,Blue=set_blue,Green=set_green)",

"set_red",
"val(Text_Color,<1,0,0>)",

"set_blue",
"val(Text_Color,<0,0,1>)",

"set_green",
"val(Text_Color,<0,1,0>)"

];
</pre></div>


<p style='font-size:0.9em;'>This binds an owner-only touch which triggers a menu with four options:</p> 

<p style='font-size:0.9em;'><strong>"Text Color"</strong> gives the owner a secondary menu with "Red", "Green", and "Blue" as options. Selecting one of these changes the Text_Color <a show='settings'>setting</a> to the respective color.</p>

<p style='font-size:0.9em;'><strong>"Sound OFF"</strong> sets the Sound_Volume <a show='settings'>setting</a> to 0 and changes the button name to <strong>"Sound ON"</strong> using the prop() <a show='methods'>method</a> so when the menu is called again and <strong>"Sound ON"</strong> is selected, it will set Sound_Volume <a show='settings'>setting</a> to 1 and change the button name back to <strong>"Sound OFF"</strong>.</p>

<p style='font-size:0.9em;'><strong>"Set Name"</strong> gives the owner a textbox which is an input dialog where the user can supply a name which is set using the val() <a show='methods'>method</a>.</p>

<p style='font-size:0.9em;'><strong>"Show Stats"</strong> displays the Name, Age, and Gender of the breed in hover text and sets a 20 second timer using the bind() <a show='methods'>method</a>. When the timer expires, the timer is removed and the text is hidden.</p>

<hr />
<h4>Alternate example:</h4>
<p>Here is another example of how to toggle custom_button labels to on and off.</p>

<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"prop(event_button,OFF)
 bind(touch,owner,give_menu)",

"give_menu",
"menu(%ownerkey%,Example Menu, %event_button%=event_toggle)",

"event_toggle",
"filter(%event_button%=OFF,disable_event)
 prop(event_button,ON)
 say(Event is now off)",

"disable_event",
"prop(event_button,OFF)
 say(Event is now on)"

];
</pre></div>
<p style='font-size:0.9em;margin-top:0;'>You can now set the functionality change where the say() method is located for ON and OFF response. Also, you can change ON and OFF button labels to whatever you want!</p> 

