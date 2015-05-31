//////////////////////////////*///breed-saved///*/////////////////////////
list cache;
list anims;
list Saved_Anims;
list Prev_Cached; 
key anim_request;
string url="http://eco.takecopy.com/remote/1.0";
string secure_channel;
string Creator_Name;
string anims_raw;
integer anim_index;
integer run_cached;
string  MyKey;
integer set_cached;
integer Timer_Event;
integer Initialized;
string anims_key;


_update(){
    anim_request = llHTTPRequest(url+
    "?anim_request="+llEscapeURL(MyKey)
    +"&name="+llEscapeURL(Creator_Name)
    +"&anim_channel="+llEscapeURL(secure_channel)
    +"&anim_rebuilt="+llEscapeURL((string)set_cached)
    +"&anim_string="+llEscapeURL(llDumpList2String(cache,"||"))
    , [ ], "" );
}

_animContinued(){ 
    anim_request = llHTTPRequest(url+"?params_key="+anims_key, [ ], "" );
}

_setCached(){
    integer i;
    for(i=0; i<llGetListLength(Saved_Anims);i++){
        integer found = llListFindList(anims,[llList2String(Saved_Anims,i)]);
        if(~found){
            _link(-6,llList2String(anims,found)+"+&;"+llList2String(anims,found+1));
        }
    }
    Saved_Anims=[];
    for(i=0; i<llGetListLength(cache);i++){
        integer found = llListFindList(Prev_Cached,[llList2String(cache,i)]);
        if(found==-1){uncache(llList2String(cache,i));}//uncache if not previously cached
    }
    Prev_Cached=[];
}

uncache(string str){
    integer cache_found = llListFindList(cache,[str]);
    if(~cache_found){cache=llDeleteSubList(cache,cache_found,cache_found);}
    integer anim_found = llListFindList(anims,[str]);
    if(~anim_found){anims=llDeleteSubList(anims,anim_found,anim_found+1);}
}


string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}//find, replace, source
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer a, string b){llMessageLinked(LINK_THIS,a,b,NULL_KEY);}
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
default{

timer(){anim_index=0;_update();}

link_message(integer a, integer num, string str, key alt){

    if(num==_encode("stop")){
        cache=[];
        anims=[];
        Saved_Anims=[];
        Prev_Cached=[]; 
        set_cached=2;
        run_cached=2;
        llOwnerSay("Anim cache cleared.");
    }
    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        secure_channel=llList2String(data,0);//cannot change
        Creator_Name=llToLower(llList2String(data,60));//cannot change
        if(llList2String(data,114)!=""){url=llList2String(data,114);}
        return;
    }

    if(num==_encode("update speed")){
        Timer_Event = (integer)str;
        if(!Initialized && (string)alt!="auth"){
            Initialized=TRUE;
            list data = Saved_Anims+Prev_Cached;
            if(llGetListLength(data)){
                integer i;
                for(i=0;i<llGetListLength(data);i++){
                    string add = _trim(llList2String(data,i));
                    if(llListFindList(cache,[add])==-1){cache+=[add];}
                }
                data=[];
                set_cached=TRUE;
                llSetTimerEvent(Timer_Event);
                anim_index=0;
                _update();
            }
        }
    }
    if(num==_encode("rebuilt")){//remote
        list values = llParseStringKeepNulls(str,[":#%"],[""]);
        MyKey=llList2String(values,22);
        Saved_Anims= llParseString2List(llList2String(values,16),[","],[""]);
        Prev_Cached = llParseString2List(llList2String(values,25),["||"],[""]);
    }
    if(num==_encode("breed created")){
        MyKey=llList2String(llParseStringKeepNulls(str,["+;&"],[""]),4);                    
    }
    
    if(num==-5){
        integer found = llListFindList(anims,[str]);
        if(~found){_link(-6,str+"+&;"+llList2String(anims,found+1));}
    }
    if(num==-164){
        uncache(str);
    }
    if(num==-159){//||num==159){
        //if(num==159){set_cached=TRUE;}
        run_cached=TRUE;
        list data = llParseStringKeepNulls(str,[","],[""]);
        integer i;
        for(i=0;i<llGetListLength(data);i++){
            string add = _trim(llList2String(data,i));
            if(llListFindList(cache,[add])==-1){cache+=[add];}
            //if(num==159){run_rebuilt+=[add];}
        }
        llSetTimerEvent(Timer_Event);
        anim_index=0;
        _update();
    }
}
    
http_response(key id, integer status, list meta, string body){
    body=_trim(body);
    if(id!=anim_request){return;}//llOwnerSay(body);
    if(body=="destroy"||body=="die"){llDie();}
    if(status!=200||~llSubStringIndex(body,"<b>Warning</b>")||body==""){
        if(~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(body);}
        anims_raw="";
        llSleep(600);
        _update();
        return;
    }
    if(llGetSubString(body,0,5)=="ignore"){
        if(run_cached){_link(1,"true");run_cached=FALSE;}
        return;
    }
    list data = llParseStringKeepNulls(body,["!@#"],[""]);
    body="";
    anims_key=llList2String(data,0);
    anims_raw+=llList2String(data,1);
    if(~llSubStringIndex(anims_raw,"{D}")){
        anims=llParseStringKeepNulls(_replace(["{D}"],"",anims_raw),["#"],[]);
        anims_raw="";
        if(set_cached){if(set_cached==1){_setCached();}set_cached=FALSE;}
        if(run_cached){_link(1,"true");run_cached=FALSE;}        
    }
    else{llSleep(1);_animContinued();}
}
}
