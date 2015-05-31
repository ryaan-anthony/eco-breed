


<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the action-object:</p>
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
<p style='margin-top:0;font-size:0.9em;'>This extension kills the disposable action object.</p>
<hr>



<p><strong>Apply Accessory Example:</strong></p>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list: </p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[ 

"start",
"bind(touch,owner,apply)",

"apply",
"set(Animation)@delete()"

];  
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>"Animation" is the prim animation identifier defined on the webserver.</p>
<hr>

<p><strong>Revive Dead Breeds Example:</strong></p>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[ 

"start",
"bind(touch,owner,apply)",

"apply",
"revive(10,50)@delete()"

];  
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>This revives a dead pet with 10 additional years and a 50% start hunger level</p>