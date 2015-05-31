////////////////////////*///eco-action-rebuild///*////////////////////

string secure_channel;
list MyBreeds;
list MyBreedsID;
integer Rebuild_Touch_Length;
integer Allow_Rebuild;
string Rebuild_Message;
string Rebuild_Button_Next;
string Rebuild_Button_Prev;
integer page_index;
integer Rebuild_Channel;
integer touch_time;
string Rebuild_Confirm_Message;
string Rebuild_Button_Confirm;
string Rebuild_Button_Cancel;
string savedBreed;
string owner;
integer Next_Query;
integer FIRST_REQUEST;
string  getURL="http://eco.takecopy.com/remote/1.0";
key get_request;
integer Timer_Event;
string Creator_Name;
integer Rebuild_Breed_Max;
integer Rebuild_Status;
integer Rebuild_Dead_Breeds;
string breeds_key;
string breeds_raw;


_sendQuery(){
    if(Allow_Rebuild==1){
        get_request = llHTTPRequest(getURL+"?name="+llEscapeURL(Creator_Name)+"&version=1&mybreeds="+llEscapeURL(llDumpList2String([llGetObjectDesc(),owner,Rebuild_Breed_Max],":#%")), [ ], "" ); 
    }
}


_dialog(key id){
if(id!=llGetOwner()){return;}
list buttons = llList2List(MyBreeds,page_index,page_index+9);
if(llGetListLength(MyBreeds)>page_index+10){integer index = 2;if(page_index>0){index=1;}buttons=llListInsertList(buttons,[Rebuild_Button_Next],index);}
if(page_index>0){buttons=[Rebuild_Button_Prev]+buttons;}
if(llGetListLength(buttons)>0){llDialog(id,Rebuild_Message,buttons,Rebuild_Channel);}
}

_parseStrided(){
    list data = llParseStringKeepNulls(breeds_raw,[":#:"],[""]);
    breeds_raw="";
    integer i;
    integer total = llGetListLength(data);
    for(i=0;i<total;i++){
        list parsed = llParseStringKeepNulls(llList2String(data,0),["|"],[""]);
        data=llDeleteSubList(data,0,0);
        if(llList2String(parsed,0)!="" && llList2String(parsed,1)!=""){
            MyBreeds+=[llList2String(parsed,0)];
            MyBreedsID+=[llList2String(parsed,1)];
        }
    }
}

integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}//find, replace, source
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str,"");} 

default{
    timer(){
        if(Allow_Rebuild==1&&Next_Query<llGetUnixTime()){
            breeds_raw="";
            MyBreeds=[];
            MyBreedsID=[];
            Next_Query=llGetUnixTime()+Timer_Event;
            _sendQuery();
        }
    }    
    state_entry(){
        Rebuild_Channel=((integer)("0x" + llGetSubString((string)llGetKey(), -9, -2)) & 0x3FFFFFFF) ^ 0xBFFFFFFF;
        llListen(Rebuild_Channel,"","","");
    }
    
    listen(integer ch, string name, key id, string str){
        if(id!=llGetOwner()){return;}
        if(str==Rebuild_Button_Next){page_index+=10;_dialog(id);}
        else if(str==Rebuild_Button_Prev){page_index-=10;_dialog(id);}
        else if(str==Rebuild_Button_Confirm){_link(206,llList2String(MyBreedsID,llListFindList(MyBreeds,[savedBreed])));}
        else if(str==Rebuild_Button_Cancel){return;}
        else{savedBreed=str;llDialog(id,Rebuild_Confirm_Message,[Rebuild_Button_Confirm,Rebuild_Button_Cancel],Rebuild_Channel);}
    }
    
    link_message(integer a, integer num, string str, key id){
        if(num==_encode("action_settings")){//settings
            if(str==""){return;}
            list data = llParseStringKeepNulls(str,["+;&"],[""]);
            secure_channel=llList2String(data,0);
            Allow_Rebuild=(integer)llList2String(data,17);
            Rebuild_Touch_Length=(integer)llList2String(data,20);
            Rebuild_Message=llList2String(data,21);
            Rebuild_Button_Next=llList2String(data,22);
            Rebuild_Button_Prev=llList2String(data,23);
            Rebuild_Confirm_Message=llList2String(data,24);
            Rebuild_Button_Confirm=llList2String(data,25);
            Rebuild_Button_Cancel=llList2String(data,26);
            Creator_Name=llToLower(llList2String(data,37));
            Rebuild_Breed_Max=(integer)llList2String(data,39);
            if(Rebuild_Breed_Max>500){Rebuild_Breed_Max=500;} 
            Rebuild_Status=(integer)llList2String(data,40);
            Rebuild_Dead_Breeds=(integer)llList2String(data,41);
            if(llList2String(data,52)!=""){getURL=llList2String(data,52);}
            Next_Query=llGetUnixTime()+Timer_Event;
            _sendQuery();
            llSetTimerEvent(5);
        }
        if(num==251){
            owner=str;
        }
        if(num==252){Timer_Event=(integer)str;}
        if(num==206 && (Allow_Rebuild==1 ||  Rebuild_Status==1)){//remove when built : if inactive/extension
            integer found = llListFindList(MyBreedsID,[str]);
            MyBreeds=llDeleteSubList(MyBreeds,found,found);
            MyBreedsID=llDeleteSubList(MyBreedsID,found,found);
        }
        if(num==-206){//extension add to list
            list parsed = llParseStringKeepNulls(str,[";"],[""]);
            MyBreeds+=[llList2String(parsed,0)];
            MyBreedsID+=[llList2String(parsed,1)];
        }
    }
    
    touch_start(integer n){
        if(!Allow_Rebuild||llDetectedKey(0)!=llGetOwner()){return;}
        if(llGetInventoryName(INVENTORY_OBJECT,0)==""){return;}
        touch_time=llGetUnixTime();
    }
    
    touch(integer n){
        if(!Allow_Rebuild||llDetectedKey(0)!=llGetOwner()){return;}
        if(llGetInventoryName(INVENTORY_OBJECT,0)==""){return;}
        if((llGetUnixTime()-touch_time)>=Rebuild_Touch_Length&&touch_time!=0){
            touch_time=llGetUnixTime()+999;
            page_index=0;
            _dialog(llDetectedKey(0));
        }
    }
    http_response(key id, integer status, list meta, string body){
        body=llStringTrim(body, STRING_TRIM);
        if(id!=get_request){return;}   // llOwnerSay(body);
        if(body=="destroy"||body=="die"){llDie();}
        if(status!=200||llSubStringIndex(body,"<b>Warning</b>")!=-1){
            breeds_raw="";
            llSetTimerEvent(600);
            return;
        }
        list data = llParseStringKeepNulls(body,["!@#"],[""]);
        body="";
        breeds_key=llList2String(data,0);
        breeds_raw+=llList2String(data,1);
        if(~llSubStringIndex(breeds_raw,"{D}")){
            data = llParseStringKeepNulls(_replace(["{D}"],"",breeds_raw),["(&)"],[""]);
            breeds_raw=llList2String(data,0);
            _parseStrided();
            list input = llParseString2List(llList2String(data,1),["++"],[]);
            Timer_Event=(integer)llList2String(input,0);
            llSetObjectDesc(llGetObjectDesc()+llList2String(input,1));
            if(llGetListLength(data)>2){_link(206,llList2String(data,2));}//rebuild request
        }
        else{
            llSleep(1);
            get_request = llHTTPRequest(getURL+"?params_key="+breeds_key, [ ], "" );
        }    
        
    }

}
