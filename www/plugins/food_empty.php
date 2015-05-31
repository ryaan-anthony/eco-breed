
<p style='font-size:0.9em;margin-bottom:0;'>Add this to your action_class list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes =[
"food",
"@Check_Food(%Food_Level%)"
];
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>Toggle custom method when food is consumed.</p>
<hr />


<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the action-object:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="@Check_Food"&&attributes == "0"){
        llRemoveInventory("action-events");//deletes action script
        llSetText("EMPTY",&lt;1,0,0&gt;,1);
    }
}

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>This script removes the "action-events" script and displays alternate hover text, in red.</p>
<hr />

<p><strong>Alternate Example:</strong></p>
<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the action-object:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="@Check_Food"&&attributes == "0"){
    	food_level(100);
    }
}

food_level(integer amt){_link(221,(string)amt);}     // change food levels : food_level(amount); 

_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>This extension script adds 100 units to the food_level.</p>