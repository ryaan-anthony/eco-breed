//////////////////////////////*///breed-hunger/growth///*//////////////////////////
list animations;
string currAnim;
vector AXIS_FWD = <1,0,0>;
float strength = 0.1;//turning strength 
float damping = 0.5;//turning damping 
integer     attach_point;
integer     Growth_Stages;
float       Growth_Scale;
integer     Growth_Stunted_Odds;
integer     Growth_Timescale;
float       total_growth = 1.0;
integer     Hunger_Consume_Odds;
integer     Hunger_Percent_Lost;
integer     Hunger_Consume_Min;
integer     Hunger_Consume_Max;
integer     Hunger_Percent_Min;
integer     Hunger_Death_Odds;
integer     MyHunger;
integer     EATING;
integer     HUNGRY;
list        hunger_choices;
integer     CRATED_BIRTH;
vector      Sit_Pos;
vector      Sit_Rot;
integer     Sit_Adjust;
vector      Cam_Pos;
vector      Cam_Rot;
integer     Cam_Adjust;
integer refreshed;
float Growth_Offset;
string debug_this;
string timestamp(){
    list timestamp = llParseString2List( llGetTimestamp(), ["T",":","Z"] , [] );
    return llList2String( timestamp, 1 )+":"+llList2String( timestamp, 2 )+":"+llList2String( timestamp, 3 );
}
_DEBUG(string str){
    str="["+timestamp()+"]("+llGetScriptName()+": "+(string)((64000-llGetUsedMemory())/1000)+"kb) "+str;
    _link(_encode("error.log"),str);
    if(~llSubStringIndex(debug_this, "func")||~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(str);}
}


integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}
////HUNGER

_funcEat(string str){
    hunger_choices=[];
    _DEBUG("eat event triggered");
    if(EATING){_DEBUG("already eating");return;}
    if(str==""){_DEBUG("invalid food");return;}
    if(MyHunger==100){_DEBUG("not hungry");return;}
    list data = llParseStringKeepNulls(str,["+;&"],[""]);
    integer amt = (integer)llList2String(data,0);
    integer val = (integer)llList2String(data,1);
    string obj = llList2String(data,2);   
    integer original = amt;
    EATING=10;
    HUNGRY=FALSE;
    //set consumption amt
    integer consume = (Hunger_Consume_Min+llRound(llFrand(Hunger_Consume_Max-Hunger_Consume_Min)));
    if(amt>consume||amt==-1){amt=consume;}//more than enough or infinite
    if(amt>Hunger_Consume_Max){amt=Hunger_Consume_Max;}//more than max; set max
    if(amt<Hunger_Consume_Min){//less than min; set min if available
        amt=0;
        if(original>=Hunger_Consume_Min){amt=Hunger_Consume_Min;}
    }
    //adjust consumption amt for need/val
    integer need = 100-MyHunger;
    if(need<=0||amt==0||val==0){amt=0;}
    else{
        if(amt*val>need/val){
            amt=need/val;
            if(amt>Hunger_Consume_Max){amt=Hunger_Consume_Max;}
            else if(amt<Hunger_Consume_Min){amt=0;}
        }
    }
    if(amt<0){amt=0;}
    if(amt){
        MyHunger+=(amt*val);
        if(MyHunger>100){MyHunger=100;}
        _DEBUG("consumed "+(string)amt+" food units worth "+(string)val+" points each for "+(string)(amt*val)+" hunger points");
        _link(2,"eat;"+obj+";"+(string)amt);////respond to action object with consumed amount & toggle food event
        //depreciated//_link(5,"eat"+obj+"+;?"+(string));
        _link(-14,(string)MyHunger);//set MyHunger in functions script or 'die' command
    }
    else{
        _DEBUG("not enough food");
    }
}

_eventHunger(){
    _DEBUG("hunger event");
    if(_odds(Hunger_Consume_Odds)){_DEBUG("not hungry");return;}//randomly not hungry
    if(MyHunger<=Hunger_Percent_Min){
        if(!_odds(Hunger_Death_Odds)){_DEBUG("died from hunger");_link(-14,"die");return;}//die : hungry
    }
    _hungerPangs();//reduce MyHunger
    _link(2,"hungry;"+(string)NULL_KEY+";"+(string)Hunger_Consume_Min);//look for food : action object gives total remaining
    //depreciated//_link(5,"hungry+;?"+(string)Hunger_Consume_Min);
    HUNGRY=10;//set timeout
}


_hungerPangs(){
    _DEBUG("hunger points reduced "+(string)Hunger_Percent_Lost);
    MyHunger-=Hunger_Percent_Lost;
    if(MyHunger<0){MyHunger=0;}
    _link(-14,(string)MyHunger);
}


////GROWTH

_eventGrow(integer force){
    float Scale=total_growth;
    if(!force){
        Growth_Stages--;
        _DEBUG("growth event: "+(string)Growth_Stages+" remaining");
        _link(-157,(string)Growth_Stages);
        if((integer)llFrand(Growth_Stunted_Odds)>0){_link(11,"done");_DEBUG("growth stunted");return;}//||_maxSize()
        Scale=Growth_Scale;
    }
    else{
        _DEBUG("re-grow");
    }
    integer total = llGetNumberOfPrims();
    integer i = 0;
    integer start = 1;
    integer status = llGetStatus(STATUS_PHYSICS);
    vector before_size = llList2Vector(llGetBoundingBox(llGetKey()),1)-llList2Vector(llGetBoundingBox(llGetKey()),0);
    float before_height = before_size.z;
    if(total==1){start=0;}
    else{total+=1;}
    for (i = start; i < total; i++){
        if(llGetAgentSize(llGetLinkKey(i))==ZERO_VECTOR){
            vector pos = llList2Vector(llGetLinkPrimitiveParams(i,[PRIM_POS_LOCAL]),0)* Scale;
            vector size = llList2Vector(llGetLinkPrimitiveParams(i,[PRIM_SIZE]),0)* Scale;//current size
            list change = [PRIM_SIZE, size];
            if (i != 1&&start>0) {change=[PRIM_SIZE, size, PRIM_POSITION, pos];}
            if(status){llSetStatus(STATUS_PHYSICS,FALSE);}
            llSetLinkPrimitiveParamsFast(i, change);
        }
    }
    if(status){llSetStatus(STATUS_PHYSICS,status);}
    else{
        
        llSleep(1);
        vector after_size = llList2Vector(llGetBoundingBox(llGetKey()),1)-llList2Vector(llGetBoundingBox(llGetKey()),0);
        float after_height = after_size.z;
        float difference = after_height-before_height;
        //vector before_pos =llGetPos();
        llSetPos(llGetPos()+<0,0,difference*Growth_Offset>);
        //vector after_pos =llGetPos();
    }
    if(!force){
        _link(2,"growth"); 
        total_growth*=Growth_Scale;
        _toRemote();
    }
    if(Sit_Adjust){
        llSitTarget(Sit_Pos*Scale,llEuler2Rot(Sit_Rot*DEG_TO_RAD)); 
    }
    if(Cam_Adjust){
        llSetCameraEyeOffset(Cam_Pos*Scale);
        llSetCameraAtOffset(Cam_Rot*Scale);
    }
    _DEBUG("growth complete");
    _link(11,"done");
}

//integer _maxSize(){
//    integer total = llGetNumberOfPrims();
//    integer i = 0;
//    integer start = 1;
//    if(total==1){start=0;}
//    else{total+=1;}
//    for (i = start; i < total; i++){
//       vector size = llList2Vector(llGetLinkPrimitiveParams(i,[PRIM_SIZE]),0);
//       size*=Growth_Scale;
//       if(size.x>64||size.y>64||size.z>64){return TRUE;}
//       if(size.x<0.01||size.y<0.01||size.z<0.01){return TRUE;}
//   }
//    return FALSE; 
//}


////REZ OBJECT
    
_rezObject(string str){//inv_object[,pos/%expression%,force,target/%expression%]
    list data = llParseStringKeepNulls(str,["+;&"],[""]);  
    string rez_object = _trim(llList2String(data,0));
    vector pos = (vector)_trim(llList2String(data,1)); 
    integer param = (integer)_trim(llList2String(data,2)); 
    float force = (float)_trim(llList2String(data,3)); 
    vector target = (vector)_trim(llList2String(data,4)); 
    string callback = _trim(llList2String(data,5)); 
    if(callback==""){callback="true";}
    if(llGetInventoryType(rez_object)==-1){_DEBUG("unable to rez object");_link(1,callback);return;} 
    if(target!=ZERO_VECTOR){
        llRotLookAt(_axis2rot(AXIS_FWD, target), strength, damping);
        llSleep(0.4);
        llStopLookAt();
    }
    rotation rot = llGetRot();
    vector vel = llRot2Fwd(rot) * force;
    vector position = llGetPos()+pos* llGetLocalRot();
    if(_safevector(position)){
        llRezObject(rez_object, position, vel, rot, param); 
        _DEBUG("object rezzed: "+rez_object);
        _link(1,"true");
    }
    else{
        _DEBUG("unable to rez object");
        _link(1,callback);
    }
}

integer _safevector(vector pos){
    if(pos.x>256||pos.x<0||pos.y>256||pos.y<0||pos.z<0||llVecDist(llGetPos(), pos)>10){return FALSE;}//protect from bad rez locations
    return TRUE;
}

////ATTACH TO AVATAR

_attachMe(string str){
    attach_point=(integer)str; 
    if(str=="null"){attach_point=0;}
    if(llGetPermissions() & PERMISSION_ATTACH){llAttachToAvatar(attach_point);_DEBUG("attach to avatar");}
    else{_DEBUG("request permissions to attach");llRequestPermissions(llGetOwner(),PERMISSION_ATTACH);}
}


////ANIMATE AVATAR

_animateMe(string str){
    list data = llParseStringKeepNulls(str,[","],[""]);
    string inventory = _trim(llList2String(data,0));
    integer duration = (integer)_trim(llList2String(data,1));
    if(str=="null"){_stopAnims(inventory);}
    else if(duration==-1){_stopAnims("");}
    else if(~llGetInventoryType(inventory)){
        if(duration>0){animations+=[inventory,duration];}
        if(llGetPermissions() & PERMISSION_TRIGGER_ANIMATION){_DEBUG("animate avatar");_animation(inventory);}
        else{currAnim=inventory;_DEBUG("request permissions to animate");llRequestPermissions(llGetOwner(),PERMISSION_TRIGGER_ANIMATION);}
    }
    else{
        _DEBUG("missing inventory "+inventory);
    }
    
}

_animation(string anim){llStartAnimation(anim);}

_stopAnims(string anim){
    _DEBUG("stop animation");
    if(llGetPermissions()&PERMISSION_TRIGGER_ANIMATION){
        if(anim==""){
            integer i;
            for(i=0;i<llGetListLength(animations);i+=2){
                llStopAnimation(llList2String(animations,i));
            }
            animations=[];
        }
        else{llStopAnimation(anim);}
    }
    else{animations=[];}
}

_iterateAnims(){
    integer i;
    list handleAnims;
    for(i=0;i<llGetListLength(animations);i+=2){
        string anim = llList2String(animations,i);
        integer duration = (integer)llList2String(animations,i+1)-1;
        if(duration==0){_stopAnims(anim);}//stop and remove
        else{handleAnims+=[anim,duration];}//replace
    }
    animations=handleAnims;
}


//FUNCTIONS

_toRemote(){_link(-43,llDumpList2String([total_growth,Growth_Stages,llGetStatus(STATUS_PHYSICS)],"?!@"));}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
rotation _axis2rot(vector axis, vector target) {return llGetRot() * llRotBetween(axis * llGetRot(), target - llGetPos());}
integer _odds(integer num){if(num==-1){return TRUE;}return (integer)llFrand(num);}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}

default{
on_rez(integer n){
    if(n==-2){CRATED_BIRTH=TRUE;}
}
    
state_entry(){
    llSetTimerEvent(1);
}

timer(){
    if(llGetListLength(animations)){_iterateAnims();}
    if(HUNGRY){
        HUNGRY--;
        if(!HUNGRY){
            if(llGetListLength(hunger_choices)>0){
                _funcEat(llList2String(hunger_choices,_odds(llGetListLength(hunger_choices))));
            }
            else{
                _DEBUG("unable to find food");
            }
        }
    }
    else if(EATING){EATING--;}
}

link_message(integer n, integer num, string str, key id){  
    
    if(num==_encode("debug_this")){
        debug_this=str;
        _DEBUG("debug enabled for \""+llGetScriptName()+"\"");
    }
  
    if(num==_encode("refresh")){
        refreshed = TRUE;
    }
    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);
        Growth_Stages=(integer)llList2String(data,22);
        Growth_Scale=(float)llList2String(data,23);
        Growth_Stunted_Odds=(integer)llList2String(data,25);
        Hunger_Consume_Min=(integer)llList2String(data,28);
        Hunger_Consume_Max=(integer)llList2String(data,29);
        Hunger_Death_Odds=(integer)llList2String(data,30);
        if(!refreshed){MyHunger=(integer)llList2String(data,31);}
        else{llSleep(0.2);_link(-14,(string)MyHunger);}
        Hunger_Consume_Odds=(integer)llList2String(data,27);
        Hunger_Percent_Lost=(integer)llList2String(data,32);
        Hunger_Percent_Min=(integer)llList2String(data,33);
        Sit_Rot =(vector)llList2String(data,3);
        if(Sit_Rot==ZERO_VECTOR){Sit_Rot=<0,0,0.01>;}
        Sit_Pos =(vector)llList2String(data,2);
        if(Sit_Pos==ZERO_VECTOR){Sit_Pos=<0,0,0.01>;}
        llSitTarget(Sit_Pos,llEuler2Rot(Sit_Rot*DEG_TO_RAD)); 
        Cam_Pos =(vector)llList2String(data,80);
        Cam_Rot =(vector)llList2String(data,81);
        llSetCameraEyeOffset(Cam_Pos);
        llSetCameraAtOffset(Cam_Rot);
        Sit_Adjust=(integer)llList2String(data,85);
        Cam_Adjust=(integer)llList2String(data,86);
        Growth_Offset=(float)llList2String(data,115);
        _toRemote();
        return;
    }
    
    if(num==124){Hunger_Consume_Min=(integer)str;}
    if(num==128){Hunger_Consume_Max=(integer)str;}
    if(num==129){Hunger_Death_Odds=(integer)str;}
    if(num==130){Hunger_Percent_Min=(integer)str;}
    if(num==-122){MyHunger=(integer)str;}
    if(num==-105){Growth_Timescale=(integer)str;}
    if(num==-109){Growth_Stages=(integer)str;}
    if(num==-110){Growth_Scale=(integer)str;}
    if(num==-111){Growth_Stunted_Odds=(integer)str;}
    if(num==-113){Hunger_Consume_Odds=(integer)str;}
    if(num==-114){Hunger_Percent_Lost=(integer)str;}
    if(num==_encode("rebuilt") && (string)id!="cmd"){//remote
        list values = llParseStringKeepNulls(str,[":#%"],[""]);
        if(!CRATED_BIRTH){
            MyHunger=(integer)llList2String(values,6);
            Growth_Stages=(integer)llList2String(values,18);
            _link(-157,(string)Growth_Stages);
        }
        total_growth=(float)llList2String(values,17);
        _eventGrow(TRUE);
    }
    if(num==-11){
        if(Growth_Stages){_eventGrow(FALSE);}
        else{_link(11,"done");}
    }
    if(num==-13){_eventHunger();}
    if(num==-15){hunger_choices+=[str];}
    if(num==-16){ _attachMe(str);}
    if(num==-17){ _rezObject(str);}
    if(num==-18){ _animateMe(str);}
}

run_time_permissions(integer perm){
    if(!perm){_DEBUG("permission denied");return;}
    if(perm&PERMISSION_ATTACH){llAttachToAvatar(attach_point);_DEBUG("attach to avatar");}
    if(perm&PERMISSION_TRIGGER_ANIMATION){_animation(currAnim);currAnim="";_DEBUG("animate avatar");}
}


}

