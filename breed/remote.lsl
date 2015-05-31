//////////////////////////////*///breed-remote///*//////////////////////////
//global retrieval
string  url="http://eco.takecopy.com/remote/1.0";
key data_request;
key rebuild_request;

//local storage
string secure_channel;
//integer alwayson;//dont send
string Creator_Name;
integer MyGeneration;
string MyParents;
string MyGender;    
string breed_id;   
string partner_name;
integer notDead=TRUE; 
integer Timer_Age;
integer Timer_Breed;   
integer Timer_Grow;  
integer Timer_Hunger;
integer MyAge;
integer MyLitters;
integer MyHunger;
string owner="Not Set";   
list Saved_Anims;
float total_growth;
integer Growth_Stages;
integer prim_status;
string version;
integer timeofBirth;
integer timeofDeath; 
string MyPartner;
integer UPDATEKEY;
integer Timer_Event;
string breed_name;
//string MyFamily;
string MySkins;
string globals;
integer return_request;
integer Initialized;
//list Lineage_Globals;
//integer Lineage_Selection;
//string Gender_Male;
integer CRATED_BIRTH;
string      data_key;
string      data_raw;
string      debug_this;
integer     start;
integer new_breed;
_rebuild(){
    rebuild_request = llHTTPRequest(url+
        "?name="+llEscapeURL(Creator_Name)+
        "&rebuild_request="+llEscapeURL(
            llDumpList2String([
                breed_id,
                llGetKey(),
                owner,
                Creator_Name,
                version,
                llGetPos(),
                llGetRegionName(),
                llGetUnixTime(),
                secure_channel
            ],":#%")
        ), 
        [ ], 
        "" 
    );
}

_saveValues(){
    if(~llSubStringIndex(llGetObjectDesc(),"-local")){
        state disabled;
    }
    data_request = llHTTPRequest(url+
        "?config="+llEscapeURL(llGetObjectDesc())+
        "&name="+llEscapeURL(Creator_Name)+
        "&values="+llEscapeURL(
            llDumpList2String([
                secure_channel,
                Creator_Name,
                llGetKey(),
                llGetUnixTime(),
                llGetPos(),
                llGetRegionName(),
                MyGeneration,
                MySkins,
                MyParents,
                MyGender,
                breed_id,
                breed_name,
                llGetOwner(),
                notDead,
                Timer_Age,
                Timer_Breed,
                Timer_Grow,
                Timer_Hunger,
                MyAge,
                MyLitters,
                MyHunger,
                llToLower(owner),
                llDumpList2String(Saved_Anims,","),
                total_growth,
                Growth_Stages,
                prim_status,
                version,
                timeofBirth,
                timeofDeath,
                "",
                MyPartner,
                UPDATEKEY,
                globals
            ],":#%")
        ),
        [ ], 
        "" 
    );
}

string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}
_link(integer n, string str,string alt){llMessageLinked(LINK_THIS, n, str, alt);}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
default{
on_rez(integer n){
    if(n==-2){CRATED_BIRTH=TRUE;}
}

timer(){llSetTimerEvent(Timer_Event);_saveValues();}

link_message(integer n, integer num, string str, key id){

    //settings from auth
    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        integer Save_Records=(integer)llList2String(data,61);
        if(!Save_Records||~llSubStringIndex(llGetObjectDesc(),"-local")){state disabled;}
        secure_channel=llList2String(data,0);
        Creator_Name=llToLower(llList2String(data,60));
        if(llList2String(data,114)!=""){url=llList2String(data,114);}
    }

    //set web2SL update speed
    else if(num==_encode("update speed")){
        Timer_Event=(integer)str;
    }  
    
    //re-rezzed : update uuid
    else if(num==_encode("update key")){
        UPDATEKEY=1;
        return_request=TRUE;
        _saveValues();
    }
    
    //rebuild request
    else if(num==_encode("rebuild breed")){
        if(str!=""){
            breed_id=str;
            _rebuild();
            if((string)id=="start"){
                start=TRUE;
            }
        }
    }
    
    //auth sets owner
    else if(num==_encode("set owner")){
        if((string)id!=""){version=(string)id;}
        owner=str;
    }
    
    //skin and breed info from #ID
    else if(num==_encode("breed created")){
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        MyGeneration=(integer)llList2String(data,0);    
        MySkins=llList2String(data,1);                  
        MyParents =llList2String(data,2);
        if(MyParents==""){MyParents="None";}
        MyGender=llList2String(data,3);                 
        breed_id=llList2String(data,4);                    
        breed_name=llList2String(data,5);  
        new_breed=TRUE;
    }
    
    //timer info from #PROCESS and breed info from #REGEX
    else if(num==_encode("save values")){
        list data = llParseStringKeepNulls(str,["?!@"],[""]); 
        notDead=(integer)llList2String(data,0);    
        Timer_Age=(integer)llList2String(data,1);    
        Timer_Breed=(integer)llList2String(data,2);    
        Timer_Grow=(integer)llList2String(data,3);    
        Timer_Hunger=(integer)llList2String(data,4);    
        MyAge=(integer)llList2String(data,5);    
        MyLitters=(integer)llList2String(data,6);    
        MyHunger=(integer)llList2String(data,7);    
        timeofBirth=(integer)llList2String(data,8);    
        timeofDeath=(integer)llList2String(data,9);
        if(new_breed){
            new_breed=FALSE;
            return_request=TRUE;
            _saveValues();      
        }  
    }
    
    else if(num==-97||num==97){
        if(num==-97){globals = str;} 
        //if(!Initialized){Initialized=TRUE;llSetTimerEvent(0.5);}//initialized => send data 
    }
    
    
    else if(num==-90){breed_name=str;}
    //if(num==-91){MyFamily=str;}
    else if(num==-31){MyAge=(integer)str;}
    else if(num==-49){MyPartner=str;}
    else if(num==-109){Growth_Stages=(integer)str;}
    else if(num==-42){//animate - anims (save)
        Saved_Anims += [str];//force = _link(-5,class);
    }
    else if(num==-43){//common - growth
        list data = llParseStringKeepNulls(str,["?!@"],[""]); 
        total_growth=(float)llList2String(data,0);  
        Growth_Stages=(integer)llList2String(data,1);  
        prim_status=(integer)llList2String(data,2);   
    }
    else if(num==-44){//animate - anims (unsave)
        integer found = llListFindList(Saved_Anims,[str]);
        if(~found){Saved_Anims = llDeleteSubList(Saved_Anims,found,found+1);}
    }
    else if(num==-121){//revive
        Timer_Age=llGetUnixTime();
        Timer_Breed=llGetUnixTime();
        Timer_Grow=llGetUnixTime();
        Timer_Hunger=llGetUnixTime();
        notDead=TRUE;
        timeofDeath=0;
    }
}

http_response(key id, integer status, list meta, string body){
    body=_trim(body);
    if(id==data_request){
        if(body=="destroy"||body=="die"){llDie();}
        if(status!=200||~llSubStringIndex(body,"<b>Warning</b>")||body==""){
        if(~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(body);}
            data_raw="";
            llSetTimerEvent(600);
            return;
        }        
        list data = llParseStringKeepNulls(body,["!@#"],[""]);
        if(llGetListLength(data)<2){
            data_raw="";
            llSetTimerEvent(600);
            return;
        }
        data_key = llList2String(data,0);
        data_raw += llList2String(data,1);
        if(~llSubStringIndex(data_raw,"{D}")){  
            UPDATEKEY=FALSE;  
            data_raw=_replace(["{D}"],"",data_raw);   
            data = llParseStringKeepNulls(data_raw,[":%:"],[""]); 
            data_raw="";
            if(llGetListLength(data)<3){
                if(~llSubStringIndex(llList2String(data,1),"error:")){
                    llInstantMessage(llList2String(data,0),llList2String(data,1));
                    state disabled;
                }
                llSetTimerEvent(600);
                return;
            }
            _link(_encode("debug_this"),debug_this= llList2String(data,6),"");  
            _link(-90,breed_name= llList2String(data,0),"");
            _link(-92,llList2String(data,1),"");//species name
            _link(-93,MySkins= llList2String(data,2),"");          
            _link(_encode("update speed"),(string)(Timer_Event=(integer)llList2String(data,3)),"");
            if(llList2String(data,7)!=""){llSetObjectDesc(llGetObjectDesc()+llList2String(data,7));}
            if(llList2String(data,5)!=""){_link(187,llList2String(data,5),"run");}//method injection
            if(llList2String(data,4)!=""){
                data=llParseString2List(llList2String(data,4),[","],[]);
                integer i;
                for(i=0;i<llGetListLength(data);i+=2){
                    _link(-95,llList2String(data,i)+","+llList2String(data,i+1),"wait");
                }
                _link(-95,"","save");
                data=[];
            }
            llSetTimerEvent(Timer_Event);
            if(return_request){
                return_request=FALSE;
                _link(_encode("return_request"),"","");
            } 
        }
        else{
            llSleep(1);
            data_request = llHTTPRequest(url+"?params_key="+data_key, [ ], "");
        }
    }
    else if(id==rebuild_request){//llOwnerSay(body);
        if(body=="destroy"||body=="die"){llDie();}
        if(status!=200||~llSubStringIndex(body,"<b>Warning</b>")||body==""){
        if(~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(body);}
            llSleep(600);
            _rebuild();
            return;
        }
        list data = llParseStringKeepNulls(body,[":#%"],[""]);   
        if(llGetListLength(data)<3){
            llSleep(600);
            _rebuild();
            return;
        }
        breed_name=llList2String(data,0);
        MyGender=llList2String(data,2);
        MyAge=(integer)llList2String(data,3);
        MySkins=llList2String(data,5);
        if(!CRATED_BIRTH){
            MyHunger=(integer)llList2String(data,6);
            MyPartner=llList2String(data,23);
            Growth_Stages=(integer)llList2String(data,18);
        }
        else{
            MyPartner="";
        }
        MyParents=llList2String(data,7);
        partner_name=llList2String(data,8);
        MyGeneration=(integer)llList2String(data,9);
        Timer_Breed=(integer)llList2String(data,10);
        Timer_Age=(integer)llList2String(data,11);
        Timer_Grow=(integer)llList2String(data,12);
        Timer_Hunger=(integer)llList2String(data,13);
        notDead=(integer)llList2String(data,14);
        MyLitters=(integer)llList2String(data,15);
        Saved_Anims= llParseStringKeepNulls(llList2String(data,16),[","],[""]);
        total_growth=(float)llList2String(data,17);
        timeofBirth=(integer)llList2String(data,20);
        timeofDeath=(integer)llList2String(data,21);
        breed_id=llList2String(data,22);
        globals = llList2String(data,24);
            
        if(start){
            _link(_encode("rebuilt"),body,"cmd");
            _link(_encode("start"),"","");
        }
        else{
            _link(_encode("rebuilt"),body,"");
        }
        if(!Initialized){Initialized=TRUE;llSetTimerEvent(0.5);}//initialized => send data 
    }
}

 
}
state disabled{
state_entry(){
    if(return_request){
        return_request=FALSE;
        _link(_encode("return_request"),"","");
    } 
}
link_message(integer n, integer num, string str, key id){
    if(num==_encode("breed created")||num==_encode("update key")){
        _link(_encode("return_request"),"","");
    }
}
    
}


