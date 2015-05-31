
<button num='3a' class='sub-tab sub-howto'><span class='subCap'>a</span> Prim Methods</button>
<button num='3b' class='sub-tab sub-howto'><span class='subCap'>b</span> Skinsets</button>
<button num='3c' class='sub-tab sub-howto'><span class='subCap'>c</span> Animations</button>

<!--Start-->
<div class='sub-content sub-default'>
	<?php print subButton('3a','Explore Prim Methods'); ?>
    <?php print wttabline('<strong>personalize</strong> your species.','skins, animations, poses, and effects',true); ?>
    <?php print insertlogo(); ?>
    <div class='sub-info'>
        <p>This section covers...</p>
        <ul>
            <li num='3a'>How to create <strong>prim methods</strong>.</li>
            <li num='3b'>Learn how to create <strong>rare and unlockable</strong> skins.</li>
            <li num='3c'>Multi-framed <strong>animation</strong> sequences.</li>
            <li num='3d'>The many uses for <strong>prim methods</strong>.</li>
        </ul>
    </div>
</div>

<!--Prim Methods-->
<div num='3a' class='sub-content' style='display:none;'>
    <div class='frame-3a'>
        <?php print subButton('3b','Continue to Skins'); ?>
        <?php print wtheadline('Prim Methods','are used to define changes to a linkset such as the texture, color, sculpt, and/or size for prim animations and skins. These methods can only be compiled on the webserver and <strong>can not be directly injected</strong> into the Actions. A class name is given to a set of prim animations, meaning a single class name can trigger one or more prim methods and run them based on other settings for that class.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Explore the prim methods:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Using shorthand for readability:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Fast configuration using a Prim Method Generator:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Other scripts for easy configuration:</strong> <button num='4' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-3a' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Prim Methods','are used by both skins and animations. For a skin, each method will only accept 1 value. Animations can be 1 or more value, with each value indicating a frame in the anim sequence.'); ?>
        <div style='padding:20px;'>
			<?php print normalSetting(
		'alpha',
		'prim, face, float [ , float ... ]',
		'Transparency animations allow you to set or alternate the transparency (alpha) of a specific prim and face (with a range of 0.0 to 1.0).',
		'alpha(-1,-1,0,1)',
		'This example changes all sides (-1) and all prims of a linkset\'s transparency to invisible before returning it to visible.'
		); ?>
			<?php print normalSetting(
		'color',
		'prim, face, vector [ , vector ... ]',
		'Color animations allow you to set or alternate the color of a specific prim and face. This method also accepts the "r" modifier for randomized colors.',
		'color(-1,-1,<1,0,0>,<1,1,1>)',
		'This example changes all sides (-1) and all prims of a linkset\'s color to red before returning it to white.',
		'color(-1,-1,<1r,0,0>)',
		'This example uses the "r" modifier in the color vector which creates a random shade of red which is set to all prims and sides.'
		); ?>
			<?php print normalSetting(
		'glow',
		'prim, face, value [ , value ... ]',
		'Sets a glow to a specific prim/face. Valid glow values include float (decimal) values between 0.0 and 1.0',
		'glow(1,-1,0.5)',
		'This example changes all sides (-1) and all prims (-1) of the linkset\'s shine to 0.5.'
		); ?>
			<?php print normalSetting(
		'pos',
		'prim, vector [ , vector ... ]',
		'Position animations require local positions (the offset position vector from the root prim, based on the objects local rotation). If this method is used on the root prim, it will act as an offset from its currently global position vector (ie. <0,0,1> will move the entire object up 1 meter from its current global position vector).',
		'pos(2,<0,0,1>,<0,0,0.5>)',
		'This example moves the 2nd linked prim to 1 meter directly above the root prim before returning it to 0.5 meters above the root.'
		); ?>
			<?php print normalSetting(
		'rot',
		'prim, rotation [ , rotation ... ]',
		'Rotation animations require local rotations, meaning the rotation of the child prims relative to the local object itself.',
		'rot(2,<0, 0, 0.38, 0.92>, <0,0,0,0>)',
		'This example rotates the 2nd linked prim 45 degrees along the Z axis before returning it to a zero rotation.'
		); ?>
			<?php print normalSetting(
		'sculpt',
		'prim, flags, uuid [ , uuid ... ]',
		'Sculpt animations are very useful for swapping sculpt maps or for progressively applying new sculpts to individual prims. To return a sculpted prim to a standard prim, use the type() method.
		<hr style="margin: 5px 0;" />
		<span style="font-size:0.8em;">
			Append flags to the stitching type with a \'|\' seperator. 
			<br /> 
			<strong>Stitching type:</strong> 0=none, 1=sphere, 2=torus, 3=plane, 4=cylinder.
			<br /> 
			<strong>Optional flags:</strong> 64=invert, 128=mirror. 
			<br /> 
			&nbsp; &nbsp; Sphere mirrored: 1|128.
			<br /> 
			&nbsp; &nbsp; Cylinder inverted and mirrored: 4|64|128.
		</span>',
		'sculpt(2, 1|64, bea82b0f-27c6-730b-fd7f-733f2340b449)',
		'This example sets the 2nd linked prim to an apple sculpt with a sphere stitch type and marked inside-out.'
		); ?>
			<?php print normalSetting(
		'shine',
		'prim, face, value [ , value ... ]',
		'Sets a shine to a specific prim/face. Valid shine values include "high", "med", "low", or "none".',
		'shine(-1,-1,med)',
		'This example changes all sides (-1) and all prims (-1) of the linkset\'s shine to medium ("med").'
		); ?>
			<?php print normalSetting(
		'size',
		'prim, vector [ , vector ... ]',
		'Size/Scale animations are useful for a range of effects and may be used on the main/root prim.',
		'size(1,<1,1,1>,<0.5,0.5,0.5>)',
		'This example scales the root prim to 1 meter, then to 0.5 meters on all axis.'
		); ?>
			<?php print normalSetting(
		'texture',
		'prim, face, uuid [ , uuid ... ]',
		'Texture animations can be used for a variety of purposes. Most common uses are blinking textured (non-prim) eyes or moving textured (non-prim) lips. Use caution with applying textures rapidly as each client must load each texture. Preloading the textures by retaining an already rendered texture within the linkset is the best practice for rapid texture rendering. Also, textures equal to or less than 512x512 pixils render faster.',
		'texture(-1, -1, 840e0d6d-a176-3076-2708-5b3fb1a0cdba, 89556747-24cb-43ed-920b-47caed15465f)',
		'This example sets all sides (-1) and all prims (-1) of a linkset to an "apple" texture before returning it to a "default box" texture.'
		); ?>
			<?php print normalSetting(
		'type',
		'prim, type, params',
		'The type() method cannot be a repeating animation, rather it is used to change the prim type of a prim or multiple prims. This method requires you supply the correct set of params for each prim type. See the <a href="http://wiki.secondlife.com/wiki/LlSetLinkPrimitiveParamsFast" target="_blank">lsl wiki page</a> for details on the expected parameters for each type or refer to the following table:'.normal_code('[type]			[params]

box 		hole,cut,hollow,twist,top_size,shear
cylinder 	hole,cut,hollow,twist,top_size,shear
prism 		hole,cut,hollow,twist,top_size,shear
sphere 		hole,cut,hollow,twist,dimple
torus 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
tube 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
ring 		hole,cut,hollow,twist,hole_size,shear,advanced_cut,taper,revolutions,radius,skew 
sculpt 		map,type'),
		'type(-1,box,0,<0, 1, 0>,0,<0, 0, 0>,<1, 1, 0>,<0, 0, 0>)',
		'This example sets all prims (-1) of a linkset to default box. Note: this does not change the scale, rotation, color, or texture of the object.'
		); ?>
        </div>
    </div>
    <div num='2' class='frame-3a' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('Condense your prim methods','to save space, increase execution time, and make modifications easier. Prim methods give you the ability to define an attribute for a specific prim or face. To set the <strong>same value to multiple prims</strong> or faces, use the vertical bar \'|\' as a separator or use \'-1\' for ALL.'); ?>
        <div style='padding:20px;'>
        
            <p class='sub-in sit'><strong>Use '-1'</strong> to indicate ALL_PRIMS.</p>
        	<?php print big_code('method( -1, value )');?>
            
            <p class='sub-in sit'>If the method <strong>requires sides to be defined</strong>, use '-1' to indicate ALL_SIDES (faces).</p>
        	<?php print big_code('method( -1, -1, value )');?>
                        
            <p class='sub-in sit'>All sides (faces) of the <strong>2nd, 3rd, and 4th</strong> prim.</p>
        	<?php print big_code('method( 2|3|4, -1, value )');?>
            
            <p class='sub-in sit'>Only face '0' of the <strong>2nd, 3rd, and 4th</strong> prim.</p>
        	<?php print big_code('method( 2|3|4, 0, value )');?>
            
            <p class='sub-in sit'>Face '1' and '3' of the <strong>4th</strong> prim.</p>
        	<?php print big_code('method( 4, 1|3, value )');?>
            
            <hr />
            
            <p class='sub-in'>This next example creates a walking animation for the <strong>default dog</strong>; the legs are animated using 4 rotation frames:</p>
            
            <?php print normal_code('rot(10,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(11,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(9,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(12,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)');?>
            <p class='description'>This is the raw result from a basic param finder script for 4 prims rotated</p>
            
            <?php print normal_code('rot(10|12,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)
rot(9|11,<0.000,-0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>,<0.000,0.173,0.000,0.984>,<0.000,0.000,0.000,1.000>)');?>
            <p class='description'>This condenses 4 methods into 2 by combining prim 10 & 12 as well as 9 & 11 since they have the same animation sequence.</p>
            
            <?php print normal_code('rot(10|12,<0,.173,0,.984>,0,<0,-.173,0,.984>,0)
rot(9|11,<0,-.173,0,.984>,0,<0,.173,0,.984>,0)');?>
            <p class='description'>This condenses the string length by removing unnecessary zeros and set the ZERO_ROTATION values to just '0'. This does not speed up execution time, but it does reduce the amount of memory used to cache or apply the animation, skin, or effect.</p>

      	</div>
    </div>
    <div num='3' class='frame-3a' style='display:none;'>
    	<?php print backButton('Go Back',4); ?>    
    	<?php print wtheadline('Method generator',' scripts work great for skins and basic animations. But keep in mind, more sophisticated animations may require manual setup. <strong>Get to know all of the prim methods before continuing.</strong>'); ?>
        <div style='padding:20px;'>
          	<p class='sub-in sit hang'><strong>Prim Method Generator Script:</strong></p>
            <?php print normal_code('// For use with eco.breeds 
// Skins and Animations 
// http://eco.takecopy.com

string Method_Type;
list Selected_Prims = [];
integer SELECT_PRIM=TRUE;
integer HOLD;
integer SELECT_FACE=TRUE;
integer FRAME=0;
list method_string;
list Types = ["POS","SIZE","COLOR","ROT","SCULPT","TEXTURE"];

frame(){//compile results
    FRAME++;
    integer i;
    for(i=0;i&lt;llGetListLength(Selected_Prims);i++){//get result for each prim
        integer prim = llList2Integer(Selected_Prims,i);
        if(prim==-1){prim=llGetNumberOfPrims()-1;}
        string result;
        if(Method_Type=="POS"){result = (string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_POS_LOCAL]),0);}
        if(Method_Type=="SIZE"){result = (string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_SIZE]),0);}
        if(Method_Type=="COLOR"){result = (string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_COLOR, 0]),0);}
        if(Method_Type=="ROT"){result = (string)llList2Rot(llGetLinkPrimitiveParams(prim,[PRIM_ROT_LOCAL]),0);}
        if(Method_Type=="TEXTURE"){result = llList2String(llGetLinkPrimitiveParams(prim,[ PRIM_TEXTURE, 0 ]),0);}
        if(Method_Type=="SCULPT"){
            if(llList2Integer(llGetLinkPrimitiveParams(prim,[PRIM_TYPE]),0)==7){
                result = llList2String(llGetLinkPrimitiveParams(prim,[PRIM_TYPE]),1);
            }
            else{
                result="invalid";
            }
        }
        
        if(FRAME==1){//first frame: create methods
            string insert_side = "";
            if(llListFindList(["COLOR","TEXTURE"],[Method_Type])!=-1){insert_side = ",-1";}
            else if(Method_Type=="SCULPT"){insert_side = ",1";}
            method_string += [llToLower(Method_Type)+"("+llList2String(Selected_Prims,i)+insert_side+","+result];
        }
        else{//additional frames: add to
            method_string=llListInsertList(llDeleteSubList(method_string,i,i),[llList2String(method_string,i)+","+result],i);
        }
    }
    llOwnerSay("Saved frame #"+(string)FRAME+".");
}

menu(string Message, list btns){//menu handler
    string msg = "Your Linkset =&gt; "+(string)llGetNumberOfPrims()+" prims";
    if(Method_Type!=""){msg+="\nSelected Method =&gt; "+llToLower(Method_Type)+"( ... )";}
    if(llGetListLength(Selected_Prims)){
        string prims = (string)llGetListLength(Selected_Prims);
        if((string)Selected_Prims=="-1"){prims="all";}
        msg+="\nSelected =&gt; "+prims+" prims";
        if(FRAME){msg+="\nLength of Sequence =&gt; "+(string)FRAME+" frames";}
    }
    msg+=Message;
    llDialog(llGetOwner(),msg,btns,chan());
}

relay(string msg){//relay results
    string name = llGetObjectName();
    llSetObjectName(" ");
    llOwnerSay("/me "+msg);
    llSetObjectName(name);
}

done(){//print result
    integer i;
    relay("RESULTS: "+(string)FRAME+" frame sequence");
    for(i=0;i&lt;llGetListLength(method_string);i++){
        relay(llList2String(method_string,i)+")");    
    }
    llResetScript();
}


integer chan(){
    return (((integer)("0x"+llGetSubString(llMD5String((string)llGetKey(),0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}

default{
    on_rez(integer n){
        llOwnerSay("Touch and hold to reset the script at any time.");
        llResetScript();
    }
    state_entry(){
        llListen(chan(),"",llGetOwner(),"");
        menu("\n \nSelect the type of values you are trying to record:",Types);
    }
    touch_start(integer n){
        HOLD=llGetUnixTime();
        if(Method_Type!=""){
            if(SELECT_PRIM){
                integer num = llDetectedLinkNumber(0);
                if(llListFindList(Selected_Prims,[num])==-1){
                    Selected_Prims+=[num];
                    llOwnerSay("Added link #"+(string)num);
                }
            }
        }
    }
    touch(integer n){
        if(llGetUnixTime()-HOLD&gt;=4){llOwnerSay("Resetting..");llResetScript();}
    }
    listen(integer ch, string name, key id, string msg){
        if(msg=="-"){
            return;
        }
        if(msg=="RESET"){
            llOwnerSay("Resetting..");
            llResetScript();
        }
        if(msg=="[PRINT]"){
            done();
        }
        if(Method_Type==""){
            Method_Type=msg;
            menu("\n \nClick each prim you want to record, then select \"SAVE\":",["SAVE","ALL_PRIMS","RESET"]);
        }
        else if((msg=="SAVE" || msg=="ALL_PRIMS")  && SELECT_PRIM){
            SELECT_PRIM = FALSE;
            if(msg=="ALL_PRIMS"){
                Selected_Prims=[-1];
            }
            else if(llGetListLength(Selected_Prims)==0){
                llOwnerSay("Error: No prims were selected!");
                llResetScript();
            }
            menu("\n \nSet up the first frame and select \"SET FRAME\":",["SET FRAME","-","RESET"]);
        }
        else if(msg=="SET FRAME"){
            frame();
            menu("\n \nSet up the next frame or print the results:",["SET FRAME","[PRINT]","RESET"]);            
        }
    }
    
}',200);?>
        	<p class='sub-in hang' style='margin-bottom:20px;'>To reset at any time, <strong>click and hold</strong> until start menu appears.</p>
      	</div>
    </div>
    <div num='4' class='frame-3a' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Param Finder Scripts','are useful for getting specific information from one prim or face at a time.'); ?>
        <div style='padding:20px;'>
          	<p class='sub-in sit hang'><strong>Param Finder Script:</strong></p>
            <?php print normal_code('
string _compress(string params){
    string compressed="";
    integer dec=0;
    integer i;
    for(i=0;i&lt;llStringLength(params);i++){
        string char = llGetSubString(params,i,i);
        if(char=="&gt;"||char==","||char=="/"){dec=0;}
        if(char=="."||dec&gt;0){dec++;}
        if(dec&lt;5){compressed+=char;}
    }
    return compressed;
}

default{
touch_start(integer total_number){
    integer prim = llDetectedLinkNumber(0);
    integer face = llDetectedTouchFace(0);
    string scale = _compress((string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_SIZE]),0));
    string loc_pos = _compress((string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_POS_LOCAL]),0));
    string loc_rot = _compress((string)llList2Rot(llGetLinkPrimitiveParams(prim,[PRIM_ROT_LOCAL]),0));
    string texture = (string)llList2Key(llGetLinkPrimitiveParams(prim,[ PRIM_TEXTURE, face ]),0);
    string alpha = _compress((string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_COLOR, face]),1));
    string color = _compress((string)llList2Vector(llGetLinkPrimitiveParams(prim,[PRIM_COLOR, face]),0));
    string type = _compress(llDumpList2String(llList2List(llGetLinkPrimitiveParams(prim,[PRIM_TYPE]),1,-1),","));
    string shape = (string)llList2Integer(llGetLinkPrimitiveParams(prim,[PRIM_TYPE]),0);
    if(shape=="0"){shape="box";}
    else if(shape=="1"){shape="cylinder";}
    else if(shape=="2"){shape="prism";}
    else if(shape=="3"){shape="sphere";}
    else if(shape=="4"){shape="torus";}
    else if(shape=="5"){shape="tube";}
    else if(shape=="6"){shape="ring";}
    else if(shape=="7"){shape="sculpt";}

llOwnerSay("
size("+(string)prim+","+scale+")
pos("+(string)prim+","+loc_pos+")
rot("+(string)prim+","+loc_rot+")
texture("+(string)prim+","+(string)face+","+texture+")
color("+(string)prim+","+(string)face+","+color+")
alpha("+(string)prim+","+(string)face+","+alpha+")
type("+(string)prim+","+shape+","+type+")"
);


}
}',200);?>
        	<p class='sub-in hang' style='margin-bottom:20px;'>Touch the prim or face, results for all params are displayed.</p>
        </div>
    </div>
</div>

<!--Skinsets-->
<!--Skins are compiled on the webserver using the eco-web API or from the 'my_species' tab on the "My Eco-Breeds" page. When a request is sent from Second Life, the skinset names are saved and the "Prim Methods" are applied to the eco-breeds. Depending on how many min/max skins are set, additional skins will be saved and not applied, these are called "dormant skins". All skinset names are later used to apply their children's skins. The skinning algorithm attempts to apply one skinset per category, allowing you to have a series of possible sets, such as 'Eyes', 'Furs', 'Ears', etc, but only apply one Skin per Category. There must be at least one common skin for each for the category for application to be mandatory (ie. Odds=0 | Gen=1) otherwise a skin for that category may not be applied. The Skins_Min setting should be at least the number of skin categories that have been created in order to ensure that one skin for each category will be applied. Once all categories have been applied and 'slots' remain (available number of skins between Skins_Min and Skins_Max), additional skins may be saved as dormant skins which will be available to offspring. To create rare or unlockable skinsets, set the Odds value (higher = more rare) and/or the Gen value (the skin is available when the breed is a specified generation or greater). Generations are defined by the oldest generation in it's liniage if Select_Highest_Gen is TRUE, otherwise it selects the youngest generation in it's liniage. For example: if TRUE and a 3rd generation male mates with a 10th generation female, the offspring will be an 11th generation breed, otherwise the offspring will be a 4th generation breed. Changes to skinsets can be made at any time but will not affect existing breeds, only their offspring. However, you may also alter the appearance of an existing breed with the same "Prim Methods" by using the set() method (see "Prim Animations").-->
<div num='3b' class='sub-content' style='display:none;'>
    <div class='frame-3b'>
        <?php print subButton('3c','Continue to Anims'); ?>
        <?php print wtheadline('Skins','can be applied in a variety of ways to suit your needs. Such as mixed coat, pure breed, rare, unlockable, limited edition, with or without genetic or built-in preferences. A skinset can alter the entire primset or just individual surfaces. The skin a breed has can also be used to define functionality such as behavior, traits, titles, etc.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Enable skins in the breed object:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Create a skinset:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Define skins on the web server:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-3b' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('To enable skins,','the breed object requires the following configurations:'); ?>
        <div style='padding:20px;'>
        	<?php print breedSetting(
		'Skins',
		'FALSE',
		'TRUE or FALSE : Apply and save skinsets from the webserver?',
		'Skins = TRUE;',
		'Breeds will now apply skins.'
		); ?>
        	<?php print breedSetting(
		'Skins_Min',
		'1',
		'Minimum number of skinsets to save.',
		'Skins_Min = 5;',
		'The breed will find at LEAST 5 skins and apply one from each category, saving the rest as dormant.'
		); ?>
        	<?php print breedSetting(
		'Skins_Max',
		'2',
		'Maximum number of skinsets to save.',
		'Skins_Max = 5;',
		'The breed will find at MOST 5 skins and apply one from each category, saving the rest as dormant.'
		); ?>
        	<?php print breedSetting(
		'Preserve_Lineage',
		'TRUE',
		'TRUE or FALSE : Allow offspring to get their skins from parents?',
		'Preserve_Lineage = FALSE;',
		'Each breed born/created will create a completely random skinset, instead of genetic preferences.'
		); ?>
        	<?php print breedSetting(
		'Preferred_Skins',
		'null',
		'Apply only these skins if available : Format = ["name;category", "name;category", ... ]',
		'Preferred_Skins = ["Red;None"];',
		'The breed will attempt to apply a skin called "Red" with "None" as the category. If the "Red" skin is limited or locked, alternate skins will be applied and saved.'
		); ?>
        </div>
    </div>
    <div num='2' class='frame-3b' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('How to create a skinset','using the the Prim Method Generator.'); ?>
        <div style='padding:20px;'>
        	<p class='sub-in'>First, insert the <strong>Prim Method Generator</strong> script into your breed object.</p>
   			<?php print howToIMG('<strong>Select a method</strong>:','1-insertgenerator2'); ?>  
        	<p class='sub-in hang'>For this demo, i selected to record the 'COLOR' method.</p>
   			<?php print howToIMG('<strong>Touch each prim</strong> to record:','2-clickprimsave2'); ?> 
        	<p class='sub-in hang'><strong>Click "SAVE". </strong>For this demo, link numbers <strong>1,2,3,9,11,12,13,14</strong> (the white body prims) will be recorded.</p> 
   			<?php print howToIMG('Set the color, click "Set Frame":','3-colorandset'); ?>  
        	<p class='sub-in sit'>"Set Frame" records the white body prims and the result is <strong>something like this</strong>:</p>
            <?php print normal_code('color(9,-1,<0.74902, 0.74902, 0.74902>)
color(1,-1,<0.74902, 0.74902, 0.74902>)
color(3,-1,<0.74902, 0.74902, 0.74902>)
color(2,-1,<0.74902, 0.74902, 0.74902>)
color(12,-1,<0.74902, 0.74902, 0.74902>)
color(13,-1,<0.74902, 0.74902, 0.74902>)
color(11,-1,<0.74902, 0.74902, 0.74902>)
color(14,-1,<0.74902, 0.74902, 0.74902>)');?>
        	<p class='sub-in sit'>Since these 8 prims have the same value, <strong>use shorthand</strong> for the same effect:</p>
            <?php print normal_code('color(1|2|3|9|11|12|13|14, -1, <0.75, 0.75, 0.75>)');?>
        	<p class='sub-in sit'>We can now <strong>manually change the color</strong> to create other skins:</p>
            <?php print normal_code('color(1|2|3|9|11|12|13|14, -1, <0.50, 0.50, 0.50>)');?>
        	<p class='description'>Now it's a darker gray!</p>
        	<p class='sub-in'>Repeat this process for any other prim methods. Create pure breeds where all prim methods are defined in a single skinset OR as part of a mixed breed where parts of your breed such as eyes, ears, coat, etc are randomly mixed and matched.</p>        	
        </div>
    </div>
    <div num='3' class='frame-3b' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('After creating your skinsets','define them on the webserver. '); ?>
        <div style='padding:20px;'>
        	<p class='sub-in'>Start by logging into your account and <strong>select the species</strong> you want to modify.</p>
	   		<?php print howToIMG('In the skins section, click new:','newskin',150); ?> 
        	<p class='sub-in sit'>To continue from the previous demo, we'll add the color method we created:</p>
	   		<?php print howToIMG('Add the prim method(s) here:','newskinfilled',150); ?> 
        	<p class='sub-in hang'>The Skin Name is set to <strong>Dark</strong> and the Category is <strong>Coat</strong> which defines it as the dark coat. To create another coat, reuse the "Coat" category with a new Skin Name and the modified methods.</p>
            <hr />
			<?php print normalSetting(
		'Skin Name',
		'<strong style="font-size:0.8em;">default:</strong> None',
		'Class name which is used to identify the skin.',
		'',
		'Click \'(edit)\' to change the name after it\'s saved.'
		); ?>
			<?php print normalSetting(
		'Category',
		'<strong style="font-size:0.8em;">default:</strong> None',
		'Categories allow multiple skins to be applied to different parts of the body. The breed will apply 1 skin per category.',
		'',
		'Click \'(edit)\' to change the name after it\'s saved.'
		); ?>
			<?php print normalSetting(
		'Gen',
		'<strong style="font-size:0.8em;">default:</strong> 1',
		'This filter limits application of the skin based on the breed\'s generation.',
		'Gen = -3',
		'Only generation 3 breeds can apply this skin.',
		'Gen = 3',
		'Generation 3 AND HIGHER breeds can apply this skin.'
		); ?>
			<?php print normalSetting(
		'Odds',
		'<strong style="font-size:0.8em;">default:</strong> 0',
		'The higher the number, the more rare. Setting this to -1 disables the skin for 1st generation breeds, but can still be passed down to offspring. If you have multiple common skins (set to 0) one will be randomly selected.',
		'Odds = 5',
		'More rare than 2 or 3 but more common than 10 or 12.'
		); ?>
			<?php print normalSetting(
		'Limit',
		'<strong style="font-size:0.8em;">default:</strong> -1',
		'Limit the number of applications of this skin. Set to -1 for unlimited or to 0 to disable use of this skin for any new breed.',
		'Limit = 5',
		'Only 5 breeds will ever be able to apply this skin.'
		); ?>
        </div>
    </div>
</div>

<!--Animations-->
<!--Prim Animations are defined using "Prim Methods" which allow you to create a repeating or one-time animation with a user-defined frames, delay, and repeat. These animations must first be cached using cache() method which pulls the "Prim Methods" from the webserver and can be uncached using uncache() to free up space for other animation sets. To trigger a prim animation, define the set() method by simply calling the identifier. For example: set(walk) where 'walk' is defined and compiled using the eco-web API or from the 'my_species' tab on the "My Eco-Breeds" page. This enables you to reuse the same animation in multiple events without redefining it. Prim animations can also be used for re-arranging existing prims, such as to create poses or accessories for a breed that can also be saved and re-applied if an object is ever re-created. See the set() method for instructions on how to save prim params. You can repeat an animation sequence a specified number of times (any number greater than 0), infinitely (-1), or just once (0). You can also delay the animation sequence by setting a float value (time in seconds greater than 0.0). The delay is first applied after the first frames of all provided "Prim Methods" in the animset have been run. After this delay, the second frame is run followed by the same delay and so on. Other prim animations can run simultaniously with their own frames, delays, and repeat values without conflict.-->
<div num='3c' class='sub-content' style='display:none;'>
    <div class='frame-3c'>
		<?php print pageButton('e-howto4','Learn More Methods'); ?>
    	<?php print wtheadline('Animate your breed!','Prim methods can include additional values to form an animation sequence where each new value is a new frame. This means, the first frame in each method will be run as \'Frame 1\' in the animation sequence. This gives you the ability to manipulate multiple prims using various methods. To leave a value unchanged during a sequence, just use \'null\' as the value for that frame.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Create an animation:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>How to use animations:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Skin-based animations:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-3c' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
        <?php print wtheadline('How to create a basic animation.','Use this as a general guide for creating basic animations.'); ?>
        <div style='padding:20px;'>
       	  	<p class='sub-in sit'>First, insert the <strong>Generator Script</strong> into your breed object.</p>
    		<?php print howToIMG('Select a <strong>method type</strong> : <em style="font-size:0.8em;">"ROT" for this demo</em>','1-insertgenerator'); ?>    
    		<?php print howToIMG('Touch <strong>each prim</strong> to record then click "Save":','2-clickprimsave'); ?> 
        	<p class='sub-in'>For this demo, I touched the <strong>right arm</strong> and clicked "Save". Multiple prims can be done simultaneously by touching each prim before clicking "Save".</p>   
            <p class='sub-in'>The generator is now ready to record ROT methods for the <strong>right arm</strong> prim.</p>
    		<?php print howToIMG('Rotate the prim and <strong>click "Set Frame"</strong> :','3-rotandset'); ?>    
    		<?php print howToIMG('Repeat for the second frame and <strong>click "Print"</strong> :','4-printresults'); ?>
        	<p class='sub-in'>This demo creates a waving animation.</p>   
   		  	<?php print howToIMG('Save the results on the website:','5-saveresults'); ?>    
            <p class='sub-in'>Define the frames, repeat, and delay. Demo: 2 frames, -1 repeat, and 0.5 delay</p>
        	<p class='sub-in sit'>Now simply <strong>cache() and set()</strong> the animation in your Actions:</p>
        	<?php print actions_code('"start",
"cache(Wave)
 set(Wave)"');?>
            <p class='howto-img-txt'>&bull; Now your breed is animated: <img id='wave-object' 'img/howto/wave1.png' style='height:300px;' class='howto-img'/></p>
			<script>$(document).ready(function(){eco_wave0();});</script>
        </div>
    </div>
    <div num='2' class='frame-3c' style='display:none;'>
    	<?php print backButton('Go Back',3); ?> 
        <?php print wtheadline('Prim animations','must be cached (from the webserver) before they can be used by the breed object. Do this by using the cache() method to pull the animations by their name and in the set() method to start the animation.'); ?>
        <div style='padding:20px;'>       
        	<p class='sub-in'>For the following examples, assume you created an <strong>animation named "Walking".</strong></p>		
			<?php print method_profile(
			'cache',
			'anim [ , anim ... ]',
			array(
				'','Request the prim animations from the webserver and is most practical when applied in the \'start\' event.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.'
			),
			actions_code('"start",
"cache(Walking)"'),
			'The animation "Walking" is loaded into the breed and ready to be used.',
        	actions_code('"start",
"cache(Walking, Stopped)"'),
       	  	'If you have a second animation, such as "Stopped", define them as comma seperated values.'
			);?>        	
			<?php print method_profile(
			'set',
			'anim [, anim ... ]',
			array(
				'','Start or trigger animations.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.',
				'Save the animation?','Append a vertical bar \'|\' to the animation with the word "true" and animations will be saved and reapplied if the breed is rebuilt. Used to reapply changes when rebuilt.'
			),
			actions_code('"start",
"cache(Walking)
 set(Walking)"'),
			'You could start it immediately when loaded, but that\'s not usually practical.',
			actions_code('"start",
"cache(Walking)
bind(touch, owner, animate)",

"animate",
"set(Walking)"'),
			'This starts the animation when the breed is touched by the owner.',
			actions_code('"start",
"cache(Walking)
bind(timer, 15, walk around)",

"walk around",
"move(%actionpos%, <5i,5i,0>, walk|Walking)"'),
			'The most common use for animations is coupled with movement. Here I combined a simple wander where the animation "Walking" is combined with the movement type.',
			actions_code('"start",
"cache(Walking, Stopped)
bind(timer, 15, walk around)",

"walk around",
"move(%actionpos%, <5i,5i,0>, walk|Walking|Stopped)"'),
			'You can also set the standing animation as a 3rd \'type\' value, otherwise the animation is unset() after the move.'
			);?>        	
			<?php print method_profile(
			'unset',
			'anim [, anim ... ]',
			array(
				'','Stop looping animations.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.',
				'Unsave a previously saved animation?','Append a vertical bar \'|\' to the animation with the word "true" and animations will be saved and reapplied if the breed is rebuilt.'
			),
			actions_code('"start",
"cache(Walking)
 set(Walking)
 bind(touch, owner, remove)",
 
"remove",
"unset(Walking)"'),
			'Animation starts immediately and stops when the breed is touched by the owner.'
			);?>        	
			<?php print method_profile(
			'uncache',
			'anim [, anim ... ]',
			array(
				'','Use this method uncache prim animations that will no longer be used in the action-classes list. It is good practice to clear un-needed animations from the script\'s overhead memory.',
				'anim','the prim animation\'s name; for multiple anims, separate using a comma \',\'.'
			),
			actions_code('"start",
"cache(Walking)
 set(Walking)
 uncache(Walking)"'),
			'This is a simple way to request the animation, set it, and clear the params from the cache. Very useful for accessories or other animations that need to be applied only once.'
			);?>            
        </div>
    </div>
    <div num='3' class='frame-3c' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Skin-based animations','use the breed\'s current skin to determine which animation to use. This is very useful for skins that alter the linkset (alternate rotations/positions/sizes).'); ?>
        <div style='padding:20px;'>
      		<?php print videolink('Random | Skin-Based Animations (11:45)', 'uf237Zr3V0I');?>
			<p class='sub-in sit'>Skin-based animation example:</p>
			<?php print actions_code('"start",
"cache(%Type% collar)
 set(%Type% collar)"');?>
			<p class='sub-in sit'>Random animation example:</p>
			<?php print actions_code('"start",
 "prop(collars[n], red collar, yellow collar, blue collar)
 prop(Collar,collars[r])
 cache(%Collar%)
 set(%Collar%)
 say(Applied %Collar%)"');?>
			<p class='sub-in sit'>Breed-Specific random animation example:</p>
			<?php print actions_code('"start",
 "bind(touch, owner, touched, remove)",
 
 "touched",
 "unbind(remove)
 prop(collars[n], red collar, yellow collar, blue collar)
 prop(Collar,collars[r])
 cache(%Collar%)
 set(%Collar%)
 say(Applied %Collar%)
 @destroy()"');?>
			<p class='sub-in sit'>Breed-Specific random animation action-extension:</p>
			<?php print normal_code('_extend(string function, string attributes){
    if(function=="@destroy"){
       llDie();//destroys the object when this method is called
       llRemoveInventory("action-events");//removes main script to prevent attachment exploit of llDie()
    }
}

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}');?>
        </div>
    </div>
</div>
