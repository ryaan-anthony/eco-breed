//////////////////////////////*///breed-auth///*//////////////////////////
string      version = "1.014";
string      url="http://eco.takecopy.com/remote/1.0";
key         data_request;
integer     Kill_Unauthorized;
string      Initializing_Text;
vector      Text_Color=<1,1,0>;
string      Creator_Name;
integer     handle;
integer     secure_channel;
string      breed_string;
string      owner;
integer     INVALID;
key         sitter = NULL_KEY;
integer     Owner_Only;
integer     Text_Prim;
float       Text_Alpha=1.0;
integer     Pause_Action;
integer     Initialized;
integer     Activated; 
integer     Save_Records;
integer     auth_enabled;
string      error_code;
string      authorized_user;
string      data_key;
string      data_raw;
integer     Parent;
string      get_settings_for;
integer     refreshed;
key         authorized;
key         current_user;

_DEBUG(string str){
    if(Initializing_Text!=""){_text(Initializing_Text);}
    else{_text(str);}
}

_text(string msg){
    if(Text_Prim){llSetLinkPrimitiveParamsFast(Text_Prim,[PRIM_TEXT,msg,Text_Color,Text_Alpha]);}
    else{llSetText(msg,Text_Color,Text_Alpha);}
}

_CHANGED(integer change){
    if(change & CHANGED_INVENTORY){
        llResetScript();
    }
    if(change & CHANGED_LINK){
        key av = llAvatarOnSitTarget();
        if(av){sitter=av;}
        else if(sitter!=NULL_KEY&&av==NULL_KEY){sitter=NULL_KEY;}
        else if(auth_enabled){
            if(llSubStringIndex(llGetObjectDesc(),"-link")==-1){
                llResetScript();
            }
        }//unlinked
    }
    if(change & CHANGED_OWNER){
        owner = llToLower(llKey2Name(llGetOwner()));
        if(owner==""){owner="not set";}
        _link(_encode("set owner"),owner,version);
    }
}
string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}//find, replace, source
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer n, string str, string alt){llMessageLinked(LINK_THIS, n, str, alt);}
_clearText(){Text_Prim=LINK_SET;_text("");Text_Prim=0;}
string config;
////
////START
default{
    changed(integer change){_CHANGED(change);}
    on_rez(integer n){llResetScript();} 
    timer(){if(config!=_trim(llGetObjectDesc())){llResetScript();}}
    state_entry(){
        //set default state
        llStopSound();
        _clearText();
        
        //reset scripts
        _DEBUG("Resetting..");
        integer i;
        for(i=0;i<llGetInventoryNumber(INVENTORY_SCRIPT);i++){
            string script = llGetInventoryName(INVENTORY_SCRIPT,i);
            if(script!=llGetScriptName()){llResetOtherScript(script);}
        }
        llSleep(1.0);
        
        //get configuration
        config = _trim(llGetObjectDesc());
        if(config==""||llGetListLength(llParseString2List(config,["-"],[]))<2){
            _DEBUG("Missing Configuration ID");
            llSetTimerEvent(3);
            return;
        }
        
        //get authenticating owner
        owner = llToLower(llKey2Name(llGetOwner()));
        if(owner==""){
            _DEBUG("Authentication Failed.\n Retrying...");
            llSleep(600);
            llResetScript();
            return;
        }
        _link(_encode("set owner"),owner,version);
        
        //authenticate
        get_settings_for = owner;
        state settings;
    }
}

////
////SETTINGS
state settings{
    changed(integer change){_CHANGED(change);}
    on_rez(integer n){llResetScript();} 
    state_entry(){       
        _DEBUG("eco breeds v"+version+" \n requesting settings..");
        data_request = llHTTPRequest(url+
            "?name="+llEscapeURL(get_settings_for)+
            "&config="+llEscapeURL(_trim(llGetObjectDesc()))+
            "&version="+llEscapeURL(version)+
            "&authorize=breed", 
            [ ], 
            "" 
        );
    }
    http_response(key id, integer status, list meta, string body){
        body=_trim(body);
        if(id!=data_request){return;}//llOwnerSay(body);
        if(body=="destroy"||body=="die"){llDie();}
        if(status!=200||~llSubStringIndex(body,"<b>Warning</b>")||body==""){
            _DEBUG("Authentication Failed.\n Retrying in a few minutes...");
            if(~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(body);}
            llSleep(600);
            llResetScript();
            return;
        }
        list data = llParseStringKeepNulls(body,["!@#"],[""]);
        if(llGetListLength(data)<2){
            error_code=body;
            state error;
        }
        _DEBUG("Compiling.."); 
        data_key = llList2String(data,0);
        data_raw += llList2String(data,1);
        if(~llSubStringIndex(data_raw,"{D}")){
            _DEBUG("Settings Received"); 
            data_raw = _replace(["{D}"],"",data_raw);
            _link(_encode("settings"),data_raw,"");
            data = llParseStringKeepNulls(data_raw,["+;&"],[""]);
            data_raw="";
            data_key="";
            body="";
            integer i = 0; 
            integer x = data != [];
            integer index = 0;
            for(; i < x; ++i){
                if(i > 10){data=llDeleteSubList(data,0,i-1);x-=i;i= 0;}
                string val = llList2String(data,i);
                if(index==0){secure_channel=(integer)_encode(val);}
                if(index==1 && !Initialized){
                    if(~llSubStringIndex(llGetObjectDesc(),"-child")){Activated=0;}
                    else{Activated=(integer)val;}
                    Parent = Activated;
                }
                if(index==15){Text_Color=(vector)val;}
                if(index==60){Creator_Name=val;}
                if(index==66){Kill_Unauthorized=(integer)val;}
                if(index==73){Initializing_Text=val;}
                if(index==84){Owner_Only=(integer)val;}
                if(index==91){
                    if((integer)val!=Text_Prim){_clearText();}
                    Text_Prim=(integer)val;
                }
                if(index==92){Text_Alpha=(float)val;}
                if(index==61){Save_Records=(integer)val;}//cannot change
                if(index==109){Pause_Action=(integer)val;}
                if(index==113){_link(_encode("update speed"),val,"auth");}
                index++;
            }
            auth_enabled=TRUE;
            if(authorized_user==""){authorized_user=owner;authorized=llGetOwner();current_user=llGetOwner();}            
            if(Activated==1){state authenticated;}
            else{state reset;}
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
    changed(integer change){_CHANGED(change);}
    state_entry(){
        _link(_encode("settings"),"FAILED","");
        _DEBUG(error_code);
    } 
}


////
////STANDBY
state reset{

    //changed
    changed(integer change){_CHANGED(change);}
    
    //rezzed
    on_rez(integer start){
        
        //inventory rez
        if(!start){
            _DEBUG("Ready for Breeding!");
            llSleep(0.5);
            _text("");
        }
        
        //secure rez
        else if(Activated!=0 && Activated !=1){
            if(start==Activated){
                Activated=TRUE;
                state authenticated;
            }
            else{
                state error;            
            }
        }
        
        //birthed | rebuilt
        else{
            _DEBUG("waiting for response.");
        }
        
    }
    
    //triggered
    state_entry(){   
        //get new owner
        string user = llToLower(llKey2Name(llGetOwner()));
        if(user!="" && owner != user){
            owner=user;
            _link(_encode("set owner"),owner,"");
        } 
    
        //restart parent
        if(Activated==1){
            state authenticated;
        }
        
        //wait for secure rez
        else if(Activated){
            _DEBUG("ready to be rezzed!");
            llSleep(0.5);
            _text("");
        }
        else{//wait for birth | rebuild
            _DEBUG("ready for breeding!");
            llSleep(0.5);
            _text("");
            llListenRemove(handle);
            handle = llListen(secure_channel,"","","");
        }
    }
    
    //listen for command from action object
    listen(integer ch, string name, key id, string msg){      
        if(name==(string)llGetKey()){
            _DEBUG("Activated!");
            list data = llParseStringKeepNulls(msg,["-+;"],[]);
            breed_string = llList2String(data,0);
            _link(_encode("set owner"),owner = llList2String(data,1),"");
            state authenticated;
        }
    }
}


////
////AUTHENTICATED
state authenticated{
    
    //re-rezzed
    on_rez(integer n){
        state reset;
    }
    
    //change occured
    changed(integer change){
        _CHANGED(change);
    }
    
    //authenticated
    state_entry(){
        
        //set activate state
        _DEBUG("Authenticated!");
        llListenRemove(handle);
        handle = llListen(secure_channel,"","","");
        
        if(current_user==authorized && authorized!=llGetOwner()){
            current_user=llGetOwner();
            authorized="void";
            Initialized=FALSE;
            _DEBUG("resetting parent..");
        }
        //previously created =>
        if(Initialized){
        
            //tell remote script to update object UUID (when it first updates)
            if(refreshed){
                refreshed=FALSE;
                if(owner==authorized_user){llOwnerSay("Refresh complete");}
                _DEBUG("");
                return;
            }
            
            //if '-alt' allow creator:reset to be skipped
            else if(llGetOwner()==authorized && llSubStringIndex(llGetObjectDesc(),"-alt")==-1){
                
                //reset child
                if(!Parent){
                    Activated=FALSE; 
                    _DEBUG("resetting child..");
                    llSleep(0.5);
                    state reset;
                }
                
                //reset parent
                else{
                    Initialized=FALSE;
                    _DEBUG("resetting parent..");
                }
            }
            else{
                _DEBUG("updating uuid..");
                _link(_encode("update key"),"","");
                return;
            }
        }
        
        //new creation =>
        if(!Initialized){
            
            //tell id script to clear name lists (after it creates the name)
            Initialized=TRUE;
            _link(_encode("first rez"),"","");
            
            //create parent
            if(breed_string==""){ 
                if(!Parent){state reset;}
                _DEBUG("Requesting a Random Skin\nPlease wait..");
                _link(_encode("parent skin"),"","");
            }            
            
            //rebuild breed
            else if(llSubStringIndex(breed_string,"|")==-1){
                _DEBUG("Rebuild Breed: "+breed_string+"\nPlease wait..");
                _link(_encode("rebuild breed"),breed_string,"");
            }
            
            //create child
            else{  
                _DEBUG("Generating Offspring\nPlease wait..");
                _link(_encode("child skin"),breed_string,"");
            }
            
            //set state
            breed_string="";
            Activated=TRUE;
        }
    } 
    link_message(integer n, integer num, string str, key id){ 
        
        if(num==_encode("Owner_Only")){
            Owner_Only=(integer)str;
        }
    
        if(num==_encode("return_request")){
            _DEBUG("Verifying Action-Objects\nPlease wait..");
        }
        
        if(num==150 && Pause_Action){
            llSleep((float)str);
        }
        if(num==199){
            _clearText();
        }  
        if(num==_encode("refresh")){
            if(owner==authorized_user){llOwnerSay("Refreshing core timers.");}
            refreshed = TRUE;
            state settings;
        }  
        if(num==_encode("reset")){
            if(str=="reset"){llResetScript();}
            _DEBUG("Resetting..");
            llSleep(3);
            _DEBUG("Rebuild Breed: "+str+"\nPlease wait..");
            _link(_encode("rebuild breed"),str,"start");
        }
        if(num==_encode("start")){
            _DEBUG("");
        }
    }
    listen(integer ch, string name, key id, string str){ 
        if(llGetOwnerKey(id)!=llGetOwner() && Owner_Only){return;}
        _link(-181,llDumpList2String([name,id,str],"+{#"),"");//send to events
    }
}

