
    integer     Initialized = FALSE;
    list        Contact_List = [];
    integer     notDead = TRUE;
    integer     Toggle=FALSE;
    integer     Retry_Timeout;
    integer     Action_Retry_Timeout;
    list        Allowed_Keywords;
    list        throttle_queue;
    integer     THROTTLE_VERIFY;
    integer     Action_Sync_Timeout;
    integer     Pause_Action;
    integer     Allow_Throttling;
    string      debug_this;
    
    _event(string type, string class, key id){
        _DEBUG("event: "+type+" : "+class+" => "+(string)id);
        if((string)id=="all"||(id==NULL_KEY && llGetListLength(Contact_List)==0)){
            _DEBUG("event request: all");
            _link(-188,type+";"+class+";"+(string)NULL_KEY,"");
        }
        else if(id!=NULL_KEY){
            _DEBUG("event request: "+(string)id);
            _link(-188,type+";"+class+";"+(string)id,"");
        }
        else{
            integer i;
            for(i=0;i<llGetListLength(Contact_List);i+=3){
                string returnid = llList2String(Contact_List,i+1);
                _link(-188,type+";"+class+";"+returnid,"");
                _DEBUG("event request: "+returnid);
            }
        }
    }
    
    integer _allowType(string str){
        if(!llGetListLength(Allowed_Keywords) || str==""){return TRUE;}//if empty or generic
        integer i;
        for(i=0;i<llGetListLength(Allowed_Keywords);i++){
            if(llSubStringIndex(str,llList2String(Allowed_Keywords,i))!=-1){return TRUE;}//allowed keyword
        }
        return FALSE;
    }

    string timestamp(){
        list timestamp = llParseString2List( llGetTimestamp(), ["T",":","Z"] , [] );
        return llList2String( timestamp, 1 )+":"+llList2String( timestamp, 2 )+":"+llList2String( timestamp, 3 );
    }
    _DEBUG(string str){ 
        str="["+timestamp()+"]("+llGetScriptName()+": "+(string)((64000-llGetUsedMemory())/1000)+"kb) "+str;
        _link(_encode("error.log"),str,"");
        if(~llSubStringIndex(debug_this, "comm")||~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(str);}
    }
    
    integer _encode(string val){
        return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
    }
    
    string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}//find, replace, source
    _link(integer n, string str, string alt){llMessageLinked(LINK_THIS, n, str, alt);}

default{
on_rez(integer n){throttle_queue=[];Contact_List=[];Initialized=FALSE;}
timer(){
    if(THROTTLE_VERIFY){
        integer i;
        for(i=0;i<llGetListLength(throttle_queue);i+=2){//new action objects OR first rez
            string type = llList2String(throttle_queue,i);
            string id = llList2String(throttle_queue,i+1);
            if(llListFindList(Contact_List,[type,(key)id])==-1 && Allow_Throttling){
                _DEBUG("establish sync: "+type+" => "+id);
                Contact_List+=[type,(key)id,llGetUnixTime()];   
            }
            if(notDead){_event("start","start",id);}
            else{_event("dead","dead",id);}
        }
        throttle_queue=[];
        THROTTLE_VERIFY=FALSE;
        llSetTimerEvent(1);
        if(!Initialized){Initialized=TRUE;_link(199,"ready","");}//auth-clear text
        return;
    }
    if(Action_Sync_Timeout && Allow_Throttling){
        integer restart;
        integer i;
        for(i=0;i<llGetListLength(Contact_List);i+=3){
            integer time = (integer)llList2String(Contact_List,i+2);
            if((llGetUnixTime()-time)>=Action_Sync_Timeout){
                _DEBUG("sync timeout: "+llList2String(Contact_List,i)+" => "+llList2String(Contact_List,i+1));
                Contact_List=llDeleteSubList(Contact_List,i,i+2);
                restart = TRUE;
                i-=3;
            }
        }   
        if(restart){
            _DEBUG("restart");
            _event("throttle_start","throttle_start",(key)"all");
            if(!llGetListLength(Contact_List)){Retry_Timeout=TRUE;llSetTimerEvent(Action_Retry_Timeout);}
        }     
    }
    if(Retry_Timeout){
        _DEBUG("timeout: retry action sync");
        _event("throttle_start","throttle_start",(key)"all");
        return;
    }
}
    
link_message(integer n, integer num, string str, key id){
    
    if(num==_encode("debug_this")){
        debug_this=str;
        _DEBUG("debug enabled for \""+llGetScriptName()+"\"");
    }
   
    else if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);  
        Action_Retry_Timeout=(integer)llList2String(data,82);
        Action_Sync_Timeout=(integer)llList2String(data,75);
        Pause_Action=(integer)llList2String(data,109);
        Allow_Throttling=(integer)llList2String(data,112);  
        return;
    }  
    
    else if(num==_encode("rebuilt")){
        notDead=(integer)llList2String(llParseStringKeepNulls(str,[":#%"],[""]),14);
    } 
    
    else if(num==150 && Pause_Action){llSleep((float)str);}
    //set notDead
    else if(num==_encode("save values")){notDead=(integer)llList2String(llParseStringKeepNulls(str,["?!@"],[""]),0);}
    else if(num==-121){notDead=TRUE;}
    else if(num==139){notDead=(integer)str;}
    
    //keywords
    else if(num==120){Allowed_Keywords=llParseString2List(str,[","],[]);}
    
    //initialize
    else if(num==_encode("return_request")){
        if(Action_Retry_Timeout){Retry_Timeout=TRUE;llSetTimerEvent(Action_Retry_Timeout);}
        _event("throttle_start","throttle_start",(key)"all");
    }
    
    //callback handlers for methods/flags
    else if((num==-163 || num==1) && str!="" && str!="true"){
        _event(str,str,NULL_KEY);
    }
    
    //bind event callbacks
    else if(num==-152){
        list data = llParseStringKeepNulls(str,[";"],[""]);  
        _event(llList2String(data,0),llList2String(data,1),NULL_KEY);
    }
    
    //events : type;id;class
    else if(num==2 && str!=""){
        list data = llParseStringKeepNulls(str,[";"],[""]);
        string type = llList2String(data,0);
        string id = llList2String(data,1);
        string class = llList2String(data,2);
        if(class==""){class=type;}
        if(str=="dead"){notDead=FALSE;}
        if(id==""){_event(type,class,NULL_KEY);}
        else{_event(type,class,id);}
    }
    
    //start communication
    else if(num==_encode("start")){
        Contact_List=[];
        throttle_queue=[];
        _DEBUG("restart: all");
        _event("throttle_start","throttle_start",(key)"all");
    }
    
    //set toggle
    else if(num==189){
        Toggle=TRUE;
    }
    
    //event flow
    else if(num==-181){
        list data = llParseStringKeepNulls(str,["+{#"],[""]);
        string name = llList2String(data,0);
        key id = (key)llList2String(data,1);
        str = llList2String(data,2);
        string ThisKey = (string)llGetKey();
        list info = llParseStringKeepNulls(str,[";"],[]);
        if(name=="all" && llList2String(info,0)=="start"){//new action
            string type = llList2String(info,1);
            if(_allowType(type)){//allowed type
                //type available or restart same id
                if(type=="" || llListFindList(Contact_List,[type])==-1 || llListFindList(Contact_List,[id])!=-1){
                    _DEBUG("restart: "+type+" => "+(string)id);
                    if(notDead){_event("throttle_start","throttle_start",id);}
                    else{_event("dead","dead",id);}
                }
            }
            return;
        }
        else if(name=="throttle_verify"){//throttle_start response
            if(_allowType(str) && (llListFindList(throttle_queue,[str])==-1 || str=="")){//type not already in queue
                if(llListFindList(Contact_List,[str])==-1 || (llListFindList(Contact_List,[id])==-1 && str=="")){//type available
                    Retry_Timeout=FALSE;
                    _DEBUG("verify: "+str+" => "+(string)id);
                    throttle_queue+=[str,id];
                    THROTTLE_VERIFY=TRUE;
                    llSetTimerEvent(3);
                }
                else if(llListFindList(Contact_List,[id])!=-1){//restart same id
                    _DEBUG("restart: "+llList2String(Contact_List,llListFindList(Contact_List,[id])-1)+" => "+(string)id);
                    if(notDead){_event("start","start",id);}
                    else{_event("dead","dead",id);}
                }
                else{
                    _event("unthrottle","unthrottle",id);
                }
            }
            else{
                _event("unthrottle","unthrottle",id);
            }
            return;
        }
        if(llListFindList(["find-mate","breed","selectnest","unthrottle"],[name])==-1){
            if(Allow_Throttling){
                integer found = llListFindList(Contact_List,[id]);
                if(found==-1){return;}
                else{
                    _DEBUG("update sync: "+llList2String(Contact_List,found-1)+" => "+(string)id);
                    Contact_List=llListInsertList(llDeleteSubList(Contact_List,found+1,found+1),[llGetUnixTime()],found+1);
                }    
            }
        }
        if(llGetSubString(str,0,6)=="Toggle_"){_event(llGetSubString(str,7,-1),llGetSubString(str,7,-1),id);}
        else if(name=="find-mate"){_link(-10,str,"");}//hear mating call
        else if(name==ThisKey&&str=="birth"){_link(-10,"birth","");_event("birth","birth",id);} 
        else if(name==ThisKey&&str=="birthobject"){_link(-10,"birthobject;"+(string)id,"");}
        else if(name=="hunger"){_link(-15,str,"");}
        else if(name=="breed"){_link(-170,str,"");}
        else if(name=="selectnest"){_link(-171,str,"");}
        else if(name==ThisKey||name=="all"){
            _link(-4,id,"");
            str=str+"{&}";
            str=_replace(["()","( )"],"(null)",str);
            str=_replace(["@"],"@"+(string)id+"@",str);
            if(Toggle){
                _DEBUG("toggle event received: "+(string)id);
                Toggle=FALSE;
                _link(187,str,"run");
                return;
            }
            _DEBUG("event received: "+(string)id);
            _link(188,str,"");
        }
    }
}
}

