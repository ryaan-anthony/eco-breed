
<h4>Text Updater</h4>

<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"bind(timer,7,text_stats)",

"text_stats",
"filter(%Dead%=false,dead_stats)
val(Text_Color,<0.3, 0.9, 0.5>)
text(Name: %MyName% \n Age: %MyAge% \n Gender: %MyGender% \n Skin: %Body%)",

"dead_stats",
"val(Text_Color,<1,0.2,0.2>)
text(DEAD \n Name: %MyName% \n Gender: %MyGender% \n Skin: %Body%)"

];
</pre></div>

<p style='font-size:0.9em;margin-top:0;'>This sets the hover text over all breed objects based on their status (dead or alive), changing the text color.</p>

<hr />



<h4>Revive Object</h4>

<p style='font-size:0.9em;margin-bottom:0;'>Add this to the action-object:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="@delete"){
       llDie();//destroys the object when this method is called
       llRemoveInventory("action-events");//removes main script to prevent attachment exploit of llDie()
    }
}

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>


<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"bind(touch,owner,revive,remove_revive)",

"revive",
"say(Added 1 Year to %MyName%'s Lifespan)
unbind(remove_revive)
revive(1)
@delete()"

];
</pre></div>