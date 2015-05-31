
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the action-object:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="@foodlevel"){
        if((integer)attributes>80){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,       <0.33, 0.20, 0.33>]);}//full
        else if((integer)attributes>50){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.33, 0.10, 0.33>]);}//half 
        else if((integer)attributes>20){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.33, 0.05, 0.33>]);}//small
        else{llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,                             <0.33, 0.01, 0.33>]);}//empty
    }
}
default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>Resizes the 2nd prim in the linkset based on food level</p>

<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes = [

"start",
"@foodlevel(%Food_Level%)",

"food",
"@foodlevel(%Food_Level%)"

];
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>Sets food level when first created and when food is consumed.</p>
