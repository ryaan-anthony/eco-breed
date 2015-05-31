

<p style='font-size:0.9em;margin-bottom:0;'>Use this script, no action-object scripts required:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list contents = ["eco-mom","eco-dad","eco-food","eco-water"];//objects to rez *once* and remove
list vectors = [<2,0,0.25>,<2,1,0.25>,<3,0,-0.2>,<3,1,-0.2>];//positions to rez each object, must match above contents
list offsets = [<0,0,0>,<0,0,0>,<180,90,0>,<180,90,0>];//rotations of each object in vector format

default{
on_rez(integer n){
	llSleep(5);
    integer i;
    for(i=0;i&lt;llGetListLength(contents);i++){
    	string inventory = llList2String(contents,i);
    	vector position = llList2Vector(vectors,i);
    	vector offset = llList2Vector(offsets,i);
    	llRezObject(inventory,llGetPos()+position,ZERO_VECTOR,llEuler2Rot(offset*DEG_TO_RAD),0);
		if(llGetInventoryType(inventory)!=-1){llRemoveInventory(inventory);}
		llSleep(1);
	}
	llDie();//self destruct
	llRemoveInventory(llGetScriptName());//removes this script when task is completed (if object is worn, llDie() will fail)
}
}
</pre></div>