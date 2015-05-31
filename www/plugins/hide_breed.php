<p style='font-size:0.9em;margin-bottom:0;'>Add this to the action-object:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
integer Say_Once = 0;

_extend(string function, string attributes){
    if(function=="@unbind_hide"){
        Say_Once=0;
        llOwnerSay(attributes+" was hidden.");
        toggle("unbind_hide");
    }
    if(function=="@ownersay" && !Say_Once){
        Say_Once++;
        llOwnerSay(attributes);
    }
}

toggle(string class){_link(211,class);}             // toggle an Action_Class event : toggle(event);

_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>


<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"touch-num-0", 
"@ownersay(Touch a breed to hide it.)
bind(touch,owner,hide_me,remove_hide)", 

"hide_me",
"@unbind_hide(%MyName%)
toggle(hide)",

"hide",
"die()",

"unbind_hide",
"unbind(remove_hide)"

];
</pre></div>