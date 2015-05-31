
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the action-object:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="@destroy"){
       llDie();//destroys the object when this method is called
       llRemoveInventory("action-events");//removes main script to prevent attachment exploit of llDie()
    }
}

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>


<p style='font-size:0.9em;margin-bottom:0;'>Call this method from the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
@destroy()
</pre></div>