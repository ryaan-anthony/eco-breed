
<?php
print "<p class='widget-line-$odd'>Growing Plants as a Food Source</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Growing food','is an alternative to store bought foods. In this simulation, corn seed is planted and the  stalks grow until it reaches maturity and produces corn. The corn is then harvested to supply a food trough for the goat. A watering can is used to keep the gardens watered, otherwise the corn turns brown and dies:'); ?>
        <div style='padding:20px;'>
	      	<?php print videolink('Growing Plants as a Food Source', 'qGmjxFwbl60');?>
        	<?php print listItem('The corn <strong>seed</strong>.', 'A Breed object w/ growth and hunger enabled.'); ?>            
        	<?php print listItem('Plant bed (<strong>dirt</strong>).', 'Action object with food enabled; "Food Level" script, "Plant Bed" actions.'); ?>
        	<?php print toggle_example('Plant Bed Water Level (extension)',normal_code('integer Extension_Channel = -999666;
integer Water_Channel = -666999;

_extend(string function, string attributes){
    if(function=="@foodlevel"){
    if((integer)attributes>90){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,       <0.15, 4.456, 3.298>]);}
    else if((integer)attributes>80){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.13, 4.456, 3.298>]);} 
    else if((integer)attributes>70){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.11, 4.456, 3.298>]);}
    else if((integer)attributes>60){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.09, 4.456, 3.298>]);}
    else if((integer)attributes>50){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.07, 4.456, 3.298>]);}
    else if((integer)attributes>40){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.05, 4.456, 3.298>]);}
    else if((integer)attributes>30){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.03, 4.456, 3.298>]);}
    else if((integer)attributes>20){llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,  <0.02, 4.456, 3.298>]);}
    else{llSetLinkPrimitiveParamsFast(0,[PRIM_SIZE,                             <0.010, 4.456, 3.298>]);}
    }
    if(function=="@fillTrough"){
        llRegionSay(Extension_Channel,"harvest");
    }
}
toggle(string class){_link(211,class);}     
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
food_level(integer amt){_link(221,(string)amt);}  
default{
on_rez(integer n){llResetScript();}
state_entry(){llListen(Water_Channel,"",llGetOwner(),"");}
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
listen(integer ch, string name, key id, string msg){if(msg=="water"){food_level(10);}}
}'),'script'); ?>     
        	<?php print toggle_example('Plant Bed Actions',actions_code('"start",
"filter(%Dead%=false)
bind(timer,20,text_stats)
toggle(text_stats)",

"text_stats",
"val(Text_Color,<0.3, 0.9, 0.5>)
text(/%harvest% \n/Name: %MyName% \n Age: %MyAge% \n Healthiness: %MyHunger%)
filter(%MyAge%>5)
prop(harvest,Ready for Harvest)
bind(touch,owner,harvest,null,%actionid%)", 

"dead",
"unbind()
val(Text_Color,<1,0,0>)
text(DEAD)",

"harvest",
"filter(%MyAge%>5,null,%Dead%=false)
unbind()
@fillTrough()
pause(1)
die()"'),'actions'); ?>  
        	<?php print listItem('A <strong>package</strong> to sell young corn seeds.', 'Contains: "Seed Package" script and seeds.'); ?>
        	<?php print toggle_example('Seed Package',normal_code('string seed = "Corn";
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
}'),'script'); ?>
        	<?php print listItem('Create a <strong>watering can</strong>', 'Contains: "Watering Can" script only.'); ?>
        	<?php print toggle_example('Watering Can',normal_code('integer Water_Channel = -666999;

default{
    touch_start(integer total_number){
        if(llGetOwner()==llDetectedKey(0)){
            llRegionSay(Water_Channel,"water");
            llSleep(10);
        }
    }
}       '),'script'); ?>
        	<?php print listItem('A <strong>goat</strong>.', 'A Breed object w/ growth and hunger enabled.'); ?>
        	<?php print listItem('A <strong>food trough</strong> for the goat.', 'Action object with food enabled: "Food Trough" script and actions.'); ?>
        	<?php print toggle_example('Food Trough Show Corn (extension)',normal_code('integer Extension_Channel = -362223; 

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
        for(i=0;i<llGetNumberOfPrims();i++){
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
}'),'script'); ?>     
        	<?php print toggle_example('Food Trough Actions',actions_code('"start",
"@foodlevel(%Food_Level%)",

"food",
"@foodlevel(%Food_Level%)",

"setLevel",
"@foodlevel(%Food_Level%)"'),'actions'); ?>      
        </div>
</span>