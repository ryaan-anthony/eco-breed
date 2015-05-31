
integer secure_channel;
integer handle;
string Breed_Desc_Filter;
integer Owner_Only;
integer Event_Overflow;
key lastid=NULL_KEY;
list listencached;
string Throttle_Type;


_listencontrol(list data){//llOwnerSay("start: "+llDumpList2String(data,","));
    lastid=llList2Key(data,1);
    _link(234,llDumpList2String(data,"`~;}"),"");
}

_enable(){
    _relay("all",0,NULL_KEY,"start;"+Throttle_Type);
}

_relay(string name, integer index, key return_key, string msg){
    string obj = llGetObjectName();
    llSetObjectName(name);
    if(return_key!=NULL_KEY){llRegionSayTo(return_key,secure_channel,msg);}
    else{llRegionSay(secure_channel,msg);}
    llSetObjectName(obj);
}

_resetlisten(){
    if(llGetListLength(listencached)>0){
        list cache = llList2List(listencached,0,2);
        listencached=llDeleteSubList(listencached,0,2);
        _listencontrol([llList2String(cache,0), (key)llList2String(cache,1), llList2String(cache,2)]);
    }
    else{
        lastid=NULL_KEY;
    }
}
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
_link(integer n, string str, string info){llMessageLinked(LINK_THIS, n, str, info);} 

default{
    
listen(integer ch, string name, key id, string str){
    if((llGetOwnerKey(id)!=llGetOwner() && Owner_Only)){return;}
    if(llListFindList(["find-mate","all","throttle_verify"],[name])!=-1){return;}
    string desc = (string)llGetObjectDetails(id, [OBJECT_DESC]); 
    if(Breed_Desc_Filter=="%desc%" && desc!=llGetObjectDesc()){return;}//failed : action & breed desc does not match
    if(Breed_Desc_Filter!="%desc%" && Breed_Desc_Filter!="" && Breed_Desc_Filter!=desc && llSubStringIndex(desc,Breed_Desc_Filter)==-1){return;}//failed : breed desc does not match value
    list data = [name, id, str];
    if(lastid==NULL_KEY){_listencontrol(data);}
    else{
        listencached+=data;
        if(Event_Overflow && llGetListLength(listencached)>=(Event_Overflow*3)){
            listencached=llDeleteSubList(listencached,0,2);
        }
    }
}
link_message(integer n, integer num, string str, key id){
    //settings 
    if(num==_encode("action_settings")){
        if(str==""){return;}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);
        secure_channel=_encode(llList2String(data,0));
        Breed_Desc_Filter=llList2String(data,32);
        Owner_Only=(integer)llList2String(data,36);
        Event_Overflow=(integer)llList2String(data,46);
        Throttle_Type=llList2String(data,34);
        llListenRemove(handle);
        handle = llListen(secure_channel,"","","");
    }
     
    
    //extension toggle event -> all breeds
    if(num==211){_relay("all",num,NULL_KEY,"Toggle_"+str);}
    
    if(num==203){//event relay -> breed
        list filters = llParseStringKeepNulls((string)id,[";"],[]);
        string return_key = llList2String(filters,0);
        if(return_key==""){return_key=lastid;}
        list data = llParseString2List(str,["+?+"],[""]);
        _relay(llList2String(data,0),num,return_key,llList2String(data,1));
        if(llList2String(filters,1)!="wait"){_resetlisten();}
    }
    if(num==207){//throttle relay -> action
        list data = llParseString2List(str,["+?+"],[""]);
        _relay(llList2String(data,0),num,NULL_KEY,llList2String(data,1));
    }
    if(num==208){
        _enable();
    }
    if(num==240){
        list data = llParseStringKeepNulls(str,["("],[]);
        string func = llList2String(data,0);
        string attr = llGetSubString(llList2String(data,1),0,-2);
        _link(-220,func,attr);
        _resetlisten();
    }
    if(num==241){
        _resetlisten();
    }
    
}
}

