<p>In the <a show='videos'>tutorial "Simulations: simulating a game of fetch"</a> we set up a game of fetch which includes several extensions and objects.</p>
<p class='description'>The worn attachment is a ball shaped prim which contains a physical ball, action script, action settings, extension. The breed object also contains an extension with custom <a show='methods'>methods</a>.</p>

<h3 align="center">Ball Attachment</h3>
<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the action-object:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
string object = "ball";
float speed = 20.0;
integer has_ball = TRUE;

throw(){
    if(!has_ball){return;}
    llStartAnimation("throw_r");
    llSleep(0.8);
    llSetAlpha(0,ALL_SIDES);
    rotation rot = llGetRot();
    vector vel = llRot2Fwd(rot)*speed;
    vector pos = llGetPos();
    pos.z += 0.75; 
    llRezObject(object, pos, vel, rot, 0); 
    has_ball=FALSE;
}

default{

on_rez(integer param){
    llResetScript();
}

state_entry(){
    llSetAlpha(1,ALL_SIDES);
    llListen(-1,"","","");
    llRequestPermissions(llGetOwner(), PERMISSION_TRIGGER_ANIMATION| PERMISSION_TAKE_CONTROLS);
}

listen(integer ch, string name, key id, string msg){
    if(msg=="give"){llSetAlpha(1,ALL_SIDES);has_ball=TRUE;}
}

run_time_permissions(integer perm){
    if(perm){llTakeControls(CONTROL_UP,TRUE,FALSE);}
}

control(key name, integer level, integer edge){
    integer pressed = level & edge;
    if(pressed & CONTROL_UP){throw();}
}
  
} 
</pre></div>

<h3 align="center">Ball Attachment</h3>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>

list Action_Classes=[                   //create action events here

"return_to_owner",
"move(%ownerpos%,null,walk,normal,arrived)",

"arrived",
"#returned()"

]; 
</pre></div>

<h3 align="center">Physical Ball</h3>
<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the action-object:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
default{

on_rez(integer param){
    llResetScript();
}

state_entry(){
    llListen(-1,"","","");
}

listen(integer ch, string name, key id, string msg){
    if(msg=="die"){llDie();}
}
  
} 
</pre></div>

<h3 align="center">Physical Ball</h3>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>

list Action_Classes=[                   //create action events here

"start", 
"pause(2)
move(%actionpos%,<0,0,0>,walk,normal,caught)",

"caught",
"#pickupball()"

];  
</pre></div>

<h3 align="center">Breed-object</h3>
<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the breed-object:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="#pickupball"){
       llSetLinkAlpha(2,1,ALL_SIDES);
       llSay(-1,"die");
        _link(1,"return_to_owner");
    }
    if(function=="#returned"){
       llSetLinkAlpha(2,0,ALL_SIDES);
       llSay(-1,"give");
    }
}

_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}

default{
link_message(integer a, integer b, string c, key d){if(b==-20){_extend(c,(string)d);}}
}
</pre></div>