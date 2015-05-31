
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the breed-object:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="#SetKey"){
        llSetObjectDesc(attributes);
    }
}
default{
link_message(integer a, integer b, string c, key d){if(b==-20){_extend(c,(string)d);}}
}
</pre></div>


<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"#SetKey(%MyKey%)"

];
</pre></div>