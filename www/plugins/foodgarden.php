
<p style='font-size:0.9em;'>1. create the corn as a breed object. (growth and hunger only)</p>
<p style='font-size:0.9em;'>2. create the plant bed as a food source action object. (food source, extension script, action methods)</p>
<p style='font-size:0.9em;'>3. make a package to sell young corn seeds. (extension script only)</p>
<p style='font-size:0.9em;'>4. create a water pale as a non-food source action object (named and contains action script but with no functionality)</p>
<p style='font-size:0.9em;'>5. create the goat as a second breed object (hunger required, everything else optional)</p>
<p style='font-size:0.9em;'>6. create a second food source action object "food trough" for the goat breed object (food source with extension script)</p>
<hr>

<h4>Seed Package</h4>
<p style='font-size:0.9em;margin-bottom:0;'>Use this extension script to rez "Corn" breed-objects:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
string seed = "Corn";
default{
state_entry(){
	llSetText("Touch to plant seed",<0.3, 0.9, 0.5>,1);
}
touch_start(integer n){
	if(llDetectedKey(0)!=llGetOwner()){return;}
	rotation rot = llEuler2Rot(<0,0,125>*DEG_TO_RAD);
	llRezObject(seed,llGetPos()+<.25,.25,-.25>,ZERO_VECTOR,rot,0);
	llRezObject(seed,llGetPos()+<-.25,.25,-.25>,ZERO_VECTOR,rot,0);
	llRezObject(seed,llGetPos()+<.25,-.25,-.25>,ZERO_VECTOR,rot,0);
	llRezObject(seed,llGetPos()+<-.25,-.25,-.25>,ZERO_VECTOR,rot,0);
	llRemoveInventory(seed);//if object is NO COPY, remove this line
	llDie();
}
}
</pre></div>
<hr>


<h4>Plant Bed</h4>
<p style='font-size:0.9em;margin-bottom:0;'>Use this extension script to feed the corn:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
integer Extension_Channel = -362223;

_extend(string function, string attributes){
    if(function=="@foodlevel"){
        if((integer)attributes>90){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,       <0.15, 4.456, 3.298>]);}
        else if((integer)attributes>80){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.13, 4.456, 3.298>]);} 
        else if((integer)attributes>70){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.11, 4.456, 3.298>]);}
        else if((integer)attributes>60){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.09, 4.456, 3.298>]);}
        else if((integer)attributes>50){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.07, 4.456, 3.298>]);}
        else if((integer)attributes>40){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.05, 4.456, 3.298>]);}
        else if((integer)attributes>30){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.03, 4.456, 3.298>]);}
        else if((integer)attributes>20){llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,  <0.02, 4.456, 3.298>]);}
        else{llSetLinkPrimitiveParamsFast(2,[PRIM_SIZE,                             <0.010, 4.456, 3.298>]);}
    }
    if(function=="@water_garden"){
        food_level(10);
        toggle("setLevel");
    }
    if(function=="@fillTrough"){
        llRegionSay(Extension_Channel,"harvest");
    }
}
toggle(string class){_link(211,class);}     
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
food_level(integer amt){_link(221,(string)amt);}  
default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"start",
"prop(DEAD,false)
bind(timer,20,budset)
bind(touch,owner,harvest)
@foodlevel(%Food_Level%)",

"food",
"@foodlevel(%Food_Level%)",

"budset",
"filter(%MyAge%=10)
set(Budset)",

"dead",
"set(Brown)
prop(DEAD,true)",

"harvest",
"filter(%MyAge%>9)
filter(%DEAD%=false)
@fillTrough()
toggle(remove)",

"remove",
"die()",

"touch-name-Water",
"@water_garden(%Food_Level%)",

"setLevel",
"@foodlevel(%Food_Level%)"

];
</pre></div>
<hr>


<h4>Food Trough</h4>
<p style='font-size:0.9em;margin-bottom:0;'>Use this extension script to feed the corn:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
integer Extension_Channel = -362223; 

_extend(string function, string attributes){
    if(function=="@foodlevel"){
        list prims = [1,18];
        if((integer)attributes>90){prims = [1,18,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>80){prims = [1,18,5,6,7,8,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>70){prims = [1,18,7,8,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>60){prims = [1,18,9,10,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>50){prims = [1,18,11,12,13,14,15,16,17,2];}
        else if((integer)attributes>40){prims = [1,18,13,14,15,16,17,2];}
        else if((integer)attributes>30){prims = [1,18,15,16,17,2];}
        else if((integer)attributes>20){prims = [1,18,17,2];}
        else if((integer)attributes>10){prims = [1,18,2];}
        integer i;
        for(i=0;i&lt;llGetNumberOfPrims();i++){
            if(llListFindList(prims,[i])==-1){llSetLinkAlpha(i,0,-1);}
            else{llSetLinkAlpha(i,1,-1);}
        }

    }
}
   
toggle(string class){_link(211,class);}    
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
food_level(integer amt){_link(221,(string)amt);}  
default{
state_entry(){llListen(Extension_Channel,"","","");}
listen(integer ch, string name, key id, string msg){food_level(10);toggle("setLevel");}
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[ 

"start",
"@foodlevel(%Food_Level%)",

"food",
"@foodlevel(%Food_Level%)",

"setLevel",
"@foodlevel(%Food_Level%)"

]; 
</pre></div>
