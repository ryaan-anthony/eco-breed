//////////////////////////////*///breed-events///*//////////////////////////
integer     secure_channel;
string      functions;
integer     RUNNING=FALSE;
integer     RUNNING_EXPIRE;
string      cached_functions; 
integer     Toggle=FALSE;
integer     Flagged;
list        disabled_events;
integer     Event_Throttle;
integer     notDead = TRUE;
integer     Pause_Action;


string debug_this;
string timestamp(){
    list timestamp = llParseString2List( llGetTimestamp(), ["T",":","Z"] , [] );
    return llList2String( timestamp, 1 )+":"+llList2String( timestamp, 2 )+":"+llList2String( timestamp, 3 );
}
_DEBUG(string str){
    str="["+timestamp()+"]("+llGetScriptName()+": "+(string)((64000-llGetUsedMemory())/1000)+"kb) "+str;
    _link(_encode("error.log"),str);
    if(~llSubStringIndex(debug_this, "event")||~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(str);}
}

integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}

//Run function
//
integer _run(string func,string attr){
_DEBUG("run function: \""+func+"\"");
if(func=="0"){//toggle
    _link(-2,func+";"+attr);
    Toggle=TRUE;
    _link(189,"toggle");//arbitrary : sets TOGGLE to TRUE in #comm
    return FALSE;
}
else if(func=="1"){//on
    integer found = llListFindList(disabled_events,[_trim(attr)]);
    if(found!=-1){disabled_events=llDeleteSubList(disabled_events,found,found);}
    else if(_trim(attr)=="null"){disabled_events=[];}
}
else if(func=="2"){//off
    integer found = llListFindList(disabled_events,[_trim(attr)]);
    if(found==-1){disabled_events+=[_trim(attr)];}
}
else if(func=="3"){//die
    llDie();
    llRemoveInventory(llGetScriptName());
}
else{
    RUNNING=TRUE;
    if(func!="4"){//cache
        RUNNING_EXPIRE=30;
    }
    _link(-2,func+";"+attr);
    return FALSE;
}
if(functions==""){return FALSE;}
return TRUE;
}

_clearOld(){
    list Events = llParseString2List(functions,["{&}"],[]);
    list Cached = llParseString2List(cached_functions,["{&}"],[]);
    integer count_events = llGetListLength(Events);
    integer count_cached = llGetListLength(Cached);
    if(count_events>Event_Throttle){
        _DEBUG("dumping "+(string)(count_events-Event_Throttle)+" events");
        functions=llDumpList2String(llDeleteSubList(Events,Event_Throttle,-1),"{&}")+"{&}";
        cached_functions="";
    }
    else if(count_events+count_cached>Event_Throttle){
        _DEBUG("dumping "+(string)((count_events+count_cached)-Event_Throttle)+" events");
        cached_functions=llDumpList2String(llDeleteSubList(Cached,Event_Throttle-count_events,-1),"{&}")+"{&}";
    }
    
}

//Traverse each function
//
_endOfEvent(){
    @retry;
    integer last =      llSubStringIndex(functions,"{&}");
    if(llStringLength(functions)==3){functions="";}
    else if(last==0){functions=_trim(llGetSubString(functions,3,-1));jump retry;}    
}
_each(){
    if(Event_Throttle){_clearOld();}
    @retry;
    _endOfEvent();
    integer start =     llSubStringIndex(functions,"(");
    integer end =       llSubStringIndex(functions,")");
    if(end==-1||start==-1){
        functions="";
        if(cached_functions==""){return;}
        else{functions=cached_functions;cached_functions="";jump retry;}
    }
    string func =       _trim(llGetSubString(functions,0,start-1));
    string attr =       _trim(llGetSubString(functions,start+1,end-1));
    if(end+1 == llStringLength(functions)){functions="";}
    else{functions = _trim(llGetSubString(functions,end+1,-1));}
    if(_run(func,attr)){_each();}
}


////
////START EVENTS
default{
timer(){
    if(RUNNING_EXPIRE||RUNNING){
        RUNNING_EXPIRE--;
        if(RUNNING_EXPIRE<=0){RUNNING=FALSE;RUNNING_EXPIRE=0;}
    }
}
link_message(integer n, integer num, string str, key id){
    
    if(num==_encode("debug_this")){
        debug_this=str;
_DEBUG("debug enabled for \""+llGetScriptName()+"\"");
    }
    
    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);  
        secure_channel=_encode(llList2String(data,0));
        Event_Throttle=(integer)llList2String(data,74);
        Pause_Action=(integer)llList2String(data,109);
        return;
    } 
    
if(num==150 && Pause_Action){llSleep((float)str);}
//notDead
if(num==_encode("save values")){notDead=(integer)llList2String(llParseStringKeepNulls(str,["?!@"],[""]),0);}
if(num==-121){notDead=TRUE;}
if(num==_encode("rebuilt")){notDead=(integer)llList2String(llParseStringKeepNulls(str,[":#%"],[""]),14);} 
if(num==2 && str=="dead"){notDead=FALSE;}
if(num==139){notDead=(integer)str;}

//functions
if(num==187){
    functions=str+functions;
    if((string)id=="run"){Toggle=FALSE;_each();}//toggled
}
if(num==188){
    cached_functions+=str;
    if(!RUNNING||Flagged){
        if(Flagged){Flagged=FALSE;}
        functions+=cached_functions;
        cached_functions="";
        _each();
    }
}
 

//flagged callback
if(num==-163){
    if(str!="true"){
        Flagged=TRUE;
        RUNNING_EXPIRE=30; 
    }
    else{
        RUNNING=FALSE;
        RUNNING_EXPIRE=0;
        functions+=cached_functions;
        cached_functions="";
        if(functions!=""){_each();}
    }
}

//send breeding & food requests
if(num==5){
    list data = llParseStringKeepNulls(str,["+;?"],[""]);
    string name = llGetObjectName();
    llSetObjectName(llList2String(data,0));
    llRegionSay(secure_channel,llList2String(data,1));
    llSetObjectName(name);
}

//methods callback
if(num==1){
    RUNNING=FALSE;
    RUNNING_EXPIRE=0;
    if(str=="true"){//event continue
        functions+=cached_functions;
        cached_functions="";
        if(functions!=""){_each();}
    }
    else{//filter callback
        integer find = llSubStringIndex(functions,"{&}");
        if(find==-1||find+3==llStringLength(functions)){functions="";}
        else{functions=llGetSubString(functions,find+3,-1);}
        if(str!=""){Toggle=TRUE;_link(189,"toggle");}
    }
}  

//event flow
if(num==-188){
    list data = llParseStringKeepNulls(str,[";"],[""]);
    string type=llList2String(data,0);
    string class=llList2String(data,1);
    key return_key=(key)llList2String(data,2);    
    if(llListFindList(disabled_events,[type])==-1){
        string name = llGetObjectName();
        llSetObjectName(type);
        if(return_key!=NULL_KEY){llRegionSayTo(return_key,secure_channel,class);}
        else{llRegionSay(secure_channel,class);}
        llSetObjectName(name);
    }
    
}



}
}
