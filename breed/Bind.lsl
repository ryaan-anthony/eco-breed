
list        bind_class;
integer     WATER=FALSE;
key         sitter=NULL_KEY;
integer     HOLD;
integer     TIMER_READY=FALSE;
integer     DAYTIME=2;
integer     ONLINE=2;
integer     SENSOR=2;
integer     ONLINE_TIMER;
key         online_result;
integer     listen_handle;
string      listen_params;
integer     CHECK_TIMER;
integer     CHECK_MOVING;
integer     CHECK_TOUCH;
integer     CHECK_ONLINE;
integer     CHECK_SUN;
integer     CHECK_WATER;
string      owner;
integer     Pause_Action;


integer _attrCheck(string value, string attr){
    vector vel = llList2Vector(llGetObjectDetails(value, [OBJECT_VELOCITY]),0);
    attr=llToLower(attr);
    if(attr=="all"||attr=="null"){return TRUE;}
    if(attr=="owner" && (llToLower(value)==owner || (key)value==llGetOwner() || llGetOwnerKey((key)value)==llGetOwner())){return TRUE;}
    if(attr=="notowner" && (llToLower(value)!=owner && (key)value!=llGetOwner() && llGetOwnerKey((key)value)!=llGetOwner())){return TRUE;}
    if(attr=="group" && (llSameGroup(value) || llSameGroup(llGetOwnerKey((key)value)))){return TRUE;}
    if(attr=="notgroup" && !llSameGroup(value) && !llSameGroup(llGetOwnerKey((key)value))){return TRUE;}
    if(attr==llKey2Name(value)){return TRUE;}
    if(attr==(string)llGetObjectDetails(value, [OBJECT_DESC])){return TRUE;}
    if(attr=="faster"&&llVecMag(llGetVel())<llVecMag(vel)){return TRUE;}
    if(attr=="slower"&&llVecMag(llGetVel())>llVecMag(vel)){return TRUE;}    
    return FALSE;
}

_event(string type, string class_str){
    integer i;
    list classes = llParseStringKeepNulls(class_str,["|"],[]);
    for(i=0;i<llGetListLength(classes);i++){        
        string class = _trim(llList2String(classes,i));
        _link(-152,type+";"+class);
    }
}


//Check bound events
//
_checkBind(string type, string value){
    integer i;
    for(i=0;i<llGetListLength(bind_class);i+=5){    
        if(llList2String(bind_class,i+1)==type){
            string val = llList2String(bind_class,i+2);
            string class = llList2String(bind_class,i+3); 
            integer last_time = llList2Integer(bind_class,i+4);        
            if(type=="timer"){
                float limit = _modify(val);
                if(limit<0.1){limit=0.1;}
                if(llGetUnixTime()>=(last_time+limit)){
                    bind_class=llListInsertList(llDeleteSubList(bind_class,i+4,i+4),[llGetUnixTime()],i+4);
                    _event(type,class);
                }
            }
            else if(type=="listen"){
                if(_attrCheck(value,val)){
                    _link(-155,listen_params);
                    _event(type,class);
                }
            }
            else if(type=="water"){
                if((float)value>=(float)val){
                    if(WATER==FALSE){_event(type,class);}
                    WATER=TRUE;
                }
            }
            else if(type=="land"){
                if((float)value>=(float)val){
                    if(WATER==TRUE){_event(type,class);}
                    WATER=FALSE;
                }
            }
            else if(type=="day"){
                if(value==llToUpper(val)&&DAYTIME!=1){DAYTIME=1;_event(type,class);}
            }
            else if(type=="night"){
                if(value==llToUpper(val)&&DAYTIME!=0){DAYTIME=0;_event(type,class);}
            }
            else if(type=="touch"||type=="collide"||type=="sit"||type=="unsit"||type=="hold"){
                if(_attrCheck(value,val)){_event(type,class);}
            }
            else if(type=="attach"){
                if((integer)val==(integer)value||(integer)val==-1||val=="null"){_event(type,class);}
            }
            else if(type=="detach"){_event(type,class);}
            else if(type=="moving"){_event(type,class);}
            else if(type=="stopped"){_event(type,class);}
            else if(type=="online"){_event(type,class);}
            else if(type=="offline"){_event(type,class);}
            else if(type=="sensor"){_event(type,class);}
            else if(type=="nosensor"){_event(type,class);}
            else if(type=="region"){
                if(val==value||val=="null"){_event(type,class);}
            }
        }
    }
}


_checkStatus(){
    //online
    if(CHECK_ONLINE){
        ONLINE_TIMER++;
        if(ONLINE_TIMER==12){
            ONLINE_TIMER=0;
            online_result = llRequestAgentData(llGetOwner(), DATA_ONLINE);
        }
    }
    //sun
    if(CHECK_SUN){
        integer time = (integer)llGetWallclock()/3600;
        string PST;
        if(time>=6&&time<18){PST="day";}
        else{PST="night";}
        _checkBind(PST,"RL");
        vector sun = llGetSunDirection();
        if (sun.z <= 0){_checkBind("night","SL");}
        else if (sun.z > 0){_checkBind("day","SL");}
        
    }
    //water
    if(CHECK_WATER){
        float water = llWater(ZERO_VECTOR);
        vector pos = llGetPos();
        if(pos.z<water && (llGround(ZERO_VECTOR) < llWater(ZERO_VECTOR))){//under water
            _checkBind("water",(string)(water-pos.z));
        }
        else{//now on land
            _checkBind("land",(string)(pos.z-water));
        }
    }
}



float _modify(string str){
    str=_trim(str);
    string mod = llGetSubString(str,-1,-1);
    float mixed = (float)llGetSubString(str,0,-2);
    if(mod=="r"){return llFrand(mixed);}
    else if(mod=="i"){
        if(llRound(llFrand(1))){
            return llFrand(mixed*-1);
        }
        else{
            return llFrand(mixed);
        }
    }
    return (float)str;
}
string _replace(list a, string b, string c){
    return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);
}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}

default{
on_rez(integer n){
    bind_class=[];
}
state_entry(){    
    llCollisionSound("",0);
    llCollisionFilter("", NULL_KEY, FALSE);
}
changed(integer change){
    if(change & CHANGED_REGION){
        _checkBind("region",llGetRegionName());
    }
    if(change & CHANGED_LINK){
        key av = llAvatarOnSitTarget();
        if(av){//sit
            sitter=av;
            _checkBind("sit",sitter);
            _link(-153,(string)av+";"+llKey2Name(av));
        }
        else if(sitter!=NULL_KEY&&av==NULL_KEY){//unsit
            _checkBind("unsit",sitter);
            sitter=NULL_KEY;
            _link(-153,";");
        }
        //else{_link(-154,"reset");}//unlinked
    }
}
touch_start(integer n){
    if(CHECK_TOUCH){
        _checkBind("touch",(string)llDetectedKey(0));
        HOLD=llGetUnixTime();
    }
}
touch(integer n){
    if(CHECK_TOUCH){
        if(llGetUnixTime()-HOLD>=3){
            HOLD=llGetUnixTime()+999;
            _checkBind("hold",(string)llDetectedKey(0));
        }
    }
}
collision_start(integer n){
    _checkBind("collide",(string)llDetectedKey(0));
}
attach(key attached){
    if(attached == NULL_KEY){_checkBind("detach",(string)llGetAttached());}
    else{_checkBind("attach",(string)llGetAttached());}
}
moving_start(){
    if(CHECK_MOVING){
        _checkBind("moving","");
    }
}
moving_end(){
    if(CHECK_MOVING){
        _checkBind("stopped","");
    }
} 
timer(){
    _checkStatus();
    if(CHECK_TIMER){_checkBind("timer","");}
}
dataserver(key res, string data){
    if(res==online_result){
        if((integer)data){if(ONLINE!=1){ONLINE=1;_checkBind("online","");}}
        else{if(ONLINE!=0){ONLINE=0;_checkBind("offline","");}}
    }
}
listen(integer ch, string name, key id, string msg){
    listen_params = name+";;"+(string)id+";;"+_replace([",","=","!","<",">","^","~"],"",msg);
    _checkBind("listen",id);
} 
sensor(integer n){
    if(SENSOR!=1){
        SENSOR=1;
        _checkBind("sensor","");
    }
}
no_sensor(){
    if(SENSOR!=0){
        SENSOR=0;
        _checkBind("nosensor","");
    }
}
link_message(integer n, integer num, string str, key id){ 

    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        Pause_Action=(integer)llList2String(llParseStringKeepNulls(str,["+;&"],[""]),109);
        return;
    }
    if(num==_encode("return_request")){
        llSetTimerEvent(1);
        return;
    }
    if(num==_encode("set owner")){
        owner=str;
    }
    
if(num==150 && Pause_Action){llSleep((float)str);}
if(num==3){//checkBind response
    list data = llParseStringKeepNulls(str,[";"],[""]);
    if(str){_checkBind(llList2String(data,0),llList2String(data,1));}
}

if(num==-151){//bind
    list attrs = llParseStringKeepNulls(str,[","],[]);
    string type = _trim(llList2String(attrs,0));
    string filter = _trim(llList2String(attrs,1));
    string callback = _trim(llList2String(attrs,2));
    string handle = _trim(llList2String(attrs,3));
    attrs = llParseStringKeepNulls(type,["|"],[]);
    type = _trim(llList2String(attrs,0));
    string val = _trim(llList2String(attrs,1));
    if(handle==""){handle="null";}
    integer timeout = 0;
    list add = [handle,type=llToLower(type),filter,callback];
    integer found = llListFindList(bind_class,add);
    if(type=="timer" && val=="toggle"){_event(type,callback);}
    if(found==-1){
        if(type=="collide"){llCollisionFilter("", NULL_KEY, TRUE);}
        if(type=="day"||type=="night"){CHECK_SUN=TRUE;}
        if(type=="water"||type=="land"){CHECK_WATER=TRUE;}
        if(type=="touch"||type=="hold"){CHECK_TOUCH=TRUE;}
        if(type=="moving"||type=="stopped"){CHECK_MOVING=TRUE;}
        if(type=="timer"){timeout=llGetUnixTime();CHECK_TIMER=TRUE;}
        if(type=="listen"){
            llListenRemove(listen_handle);
            listen_handle=llListen((integer)val,"","","");
        }
        if(type=="sensor"||type=="nosensor"){
            if((integer)filter<1){filter="1";}
            llSensorRepeat("",NULL_KEY,AGENT,(integer)filter,PI,1);
        }
        if(type=="online"||type=="offline"){CHECK_ONLINE=TRUE;}
        bind_class+= add+[timeout];
    }
    else if(type=="timer"){
        bind_class=llListInsertList(llDeleteSubList(bind_class,found+4,found+4),[llGetUnixTime()],found+4);
    }
}

if(num==-150||num==_encode("stop")){//unbind
    @retry;
    list attrs = llParseStringKeepNulls(str,[","],[]);
    if(num==_encode("stop")){attrs=["null"];}
    integer i;
    for(i=0;i<llGetListLength(attrs);i++){
        string handle = _trim(llList2String(attrs,i));
        integer found = llListFindList(bind_class,[handle]);
        if(~found||handle=="null"){
            if(handle=="null"){
                bind_class=[];
                llListenRemove(listen_handle);
                llSensorRemove();
                llCollisionFilter("", NULL_KEY, FALSE);
                CHECK_SUN=0;
                CHECK_WATER=0;
                CHECK_ONLINE=0;
                CHECK_TIMER=0;
                CHECK_TOUCH=0;
                CHECK_MOVING=0;
            }
            else{
                bind_class = llDeleteSubList(bind_class, found, found+4);
                if(llListFindList(bind_class,["timer"])==-1){CHECK_TIMER=0;}
                if(llListFindList(bind_class,["touch"])==-1&&llListFindList(bind_class,["hold"])==-1){CHECK_TOUCH=0;}
                if(llListFindList(bind_class,["moving"])==-1&&llListFindList(bind_class,["stopped"])==-1){CHECK_MOVING=0;}
                if(llListFindList(bind_class,["day"])==-1&&llListFindList(bind_class,["night"])==-1){CHECK_SUN=0;}
                if(llListFindList(bind_class,["water"])==-1&&llListFindList(bind_class,["land"])==-1){CHECK_WATER=0;}
                if(llListFindList(bind_class,["online"])==-1&&llListFindList(bind_class,["offline"])==-1){CHECK_ONLINE=0;}
                if(llListFindList(bind_class,["collide"])==-1){llCollisionFilter("", NULL_KEY, FALSE);}
                if(llListFindList(bind_class,["listen"])==-1){llListenRemove(listen_handle);}
                if(llListFindList(bind_class,["sensor"])==-1&&llListFindList(bind_class,["nosensor"])==-1){llSensorRemove();}
                if(~llListFindList(bind_class,[handle])){jump retry;}//if bind still exists
            }
        }
    }
    if(num==_encode("stop")){llOwnerSay("Bind events cleared.");}
}

} 


}

