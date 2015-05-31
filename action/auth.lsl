//remote globals
string  url="http://eco.takecopy.com/remote/1.0";
key     data_request;
integer RESET;
integer Kill_Unauthorized;
string  owner;
integer Auto_Activate;
string  error_code;
string  data_key;
string  data_raw;
list    Actions;
string user;
string authorized_user;
string get_settings_for;
string config;

_DEBUG(string str){llSetText(str,<1,1,0>,1);}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer n, string str, string info){llMessageLinked(LINK_THIS, n, str, info);} 
string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}
_setOwner(){string a = llToLower(llKey2Name(llGetOwner()));if(a!=""&&a!=owner){owner=a;_link(251,owner,"");}}
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
default{
    changed(integer change){if(change & CHANGED_INVENTORY){llResetScript();}}
    on_rez(integer n){llResetScript();}
    timer(){if(config!=_trim(llGetObjectDesc())){llResetScript();}}
    state_entry(){  
        _DEBUG("Resetting..");
        integer i;
        for(i=0;i<llGetInventoryNumber(INVENTORY_SCRIPT);i++){
            string script = llGetInventoryName(INVENTORY_SCRIPT,i);
            if(script!=llGetScriptName()){llResetOtherScript(script);}
        }
        llSleep(1);
        config = llGetObjectDesc();
        if(config==""||llGetListLength(llParseString2List(config,["-"],[]))<2){
            _DEBUG("Missing Configuration ID");
            llSetTimerEvent(3);
            return;
        }
        user = llToLower(llKey2Name(llGetOwner()));
        if(user==""){
            _DEBUG("Authentication Failed.\n Retrying...");
            llSleep(10);
            llResetScript();
            return;
        }
        _DEBUG("Requesting Authentication\nPlease wait..");
        get_settings_for = user;
        state settings;
    }
}

state settings{
    state_entry(){
        data_request = llHTTPRequest(url+
        "?name="+llEscapeURL(get_settings_for)+
        "&config="+llEscapeURL(llGetObjectDesc())+
        "&version=2"+
        "&authorize=action", [ ], "" );
    }
    http_response(key id, integer status, list meta, string body){
        body=_trim(body);//llOwnerSay(body);
        if(id!=data_request){return;}
        if(body=="destroy"||body=="die"){llDie();}
        if(status!=200){
            _DEBUG("Authentication Failed.\n Retrying...");
            llSleep(600);
            llResetScript();
            return;
        }
        list data = llParseStringKeepNulls(body,["!@#"],[""]);
        data_key = llList2String(data,0);
        data_raw += llList2String(data,1);
        if(llGetListLength(data)<2){
            error_code=body;
            state error;
        }
        if(llSubStringIndex(data_raw,"{D}")!=-1){
            data_raw = _replace(["{D}"],"",data_raw);
            data = llParseStringKeepNulls(data_raw,["+;&"],[""]);
            data_key="";
            body="";
            _DEBUG("Settings Received"); 
            Kill_Unauthorized=(integer)llList2String(data,35);
            Auto_Activate=(integer)llList2String(data,49);
            _setOwner();
            _link(252,llList2String(data,53),"");//time index
            Actions = llParseString2List(llList2String(data,54),["/;"],[]);
            _link(_encode("action_settings"),data_raw,"");
            data_raw="";
            if(authorized_user==""){authorized_user=user;}
            //llSetTimerEvent(2.5); 
            state authenticated;
        }
        else{
            llSleep(1);
            data_request = llHTTPRequest(url+"?params_key="+data_key, [ ], "" );
        }
    }
}

////
////ERROR
state error{ 
    on_rez(integer n){llResetScript();}
    changed(integer change){if(change & CHANGED_INVENTORY){llResetScript();}}
    state_entry(){
        _link(_encode("action_settings"),"FAILED","");
        _DEBUG(error_code);
    } 
}

state authenticated{
    on_rez(integer n){
        if(!Auto_Activate || Auto_Activate == n){
            _link(-208,"authed","");
            _setOwner();
        }
        else{
            state error;
        }
    }
    state_entry(){_DEBUG("");}
    timer(){
        if(RESET){llResetScript();}
        _setOwner();
    }
    link_message(integer n, integer num, string str, key id){
        if(num==-202){
            integer found=llListFindList(Actions,[str]);
            if(found!=-1){_link(201,llList2String(Actions,found+1),"");}
            else{_link(241,str,"");}
        }
        //reset
        if(num==205){
            RESET=TRUE;
        }
        //initialize
        if(num==208){
            _setOwner();
        }
        if(num==_encode("refresh")){
            _DEBUG("Requesting Settings\nPlease wait..");
            get_settings_for=authorized_user;
            state settings;
        }
    }
} 


