

integer Food_Unit_Value;
integer Food_Level;
integer totalRezzed;
integer Breed_Rez_Max;
string Breed_Pair="None";
vector Text_Color;
string Text_String;
list filter_breeds = [];
string Throttle_Type;
integer Num_Breeds;
integer Breed_Timeout;
integer Action_Touch_Events;
integer Hover_Text;
string Creator_Name;
string Version;
integer Initialized;

_enable(){
    filter_breeds = [];
    _link(208,"ready","");
    llSetTimerEvent(3);
}

integer numFiltered(){
    integer Limit = llGetListLength(filter_breeds);
    if(Limit){Limit=Num_Breeds-(Limit/2);}
    else{Limit=Num_Breeds;}
    return Limit;
}

string _regex(string str){list e = [
"%version%",Version,
"%creator%",Creator_Name,
"%Food_Value%",Food_Unit_Value,
"%Limit_Breeds%",_howMany(numFiltered()),
"%Rez_Total%",totalRezzed,
"%Rez_Remain%",_howMany(Breed_Rez_Max),
"%Breed_Pair%",Breed_Pair,
"%Food_Level%",_howMany(Food_Level)
];integer i;for(i=0;i<llGetListLength(e);i+=2){str = _replace([llList2String(e,i)], llList2String(e,i+1), str);}return str;}

integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}
string _howMany(integer num){if(num==-1){return "unlimited";}return (string)num;}
_link(integer n, string str, string filter){llMessageLinked(LINK_THIS, n, str, filter);} 

default{

timer(){
    if(~llSubStringIndex(llGetObjectDesc(),"-refresh")){
        llSetObjectDesc(_replace(["-refresh"],"",llGetObjectDesc()));
        _link(_encode("refresh"),"","");
    }
    if(Breed_Timeout){
        @repeat;
        if(llGetListLength(filter_breeds)){
            integer i;
            for(i=0;i<llGetListLength(filter_breeds);i+=2){
                integer time = llList2Integer(filter_breeds,i+1);
                if((llGetUnixTime()-time)>=Breed_Timeout){
                    //_link(207,"unthrottle+?+"+llList2String(filter_breeds,i),"");//no reset
                    filter_breeds=llDeleteSubList(filter_breeds,i,i+1);
                    jump repeat;
                }
            }
        }
    }
    if(Hover_Text){_link(280,_regex(Text_String),"");}
}


link_message(integer n, integer num, string str, key id){
if(num==281){if(Hover_Text==1){llSetText(str,Text_Color,1);}}
if(num==-208){_enable();}
if(num==236){Breed_Pair=str;}
if(num==237){Breed_Rez_Max=(integer)str;}
if(num==238){totalRezzed=(integer)str;}
if(num==239){Food_Level=(integer)str;}
if(num==271){Food_Unit_Value=(integer)str;}
if(num==_encode("action_settings")){//settings 
    if(str==""){return;}
    list data = llParseStringKeepNulls(str,["+;&"],[""]);
    Breed_Rez_Max=(integer)llList2String(data,6);
    Text_Color=(vector)llList2String(data,10);
    Text_String=llList2String(data,11);    
    Num_Breeds=(integer)llList2String(data,30);
    Breed_Timeout=(integer)llList2String(data,31);
    Throttle_Type=llList2String(data,34);
    Action_Touch_Events=(integer)llList2String(data,38);
    Hover_Text=(integer)llList2String(data,45);
    Version=llList2String(data,51);
    Creator_Name=llToLower(llList2String(data,37));
    if(!Initialized){
        Initialized=TRUE;
        Food_Level=(integer)llList2String(data,4);
        Food_Unit_Value=(integer)llList2String(data,5);
        _enable();
    }
}   
if(num==234){
    list data = llParseStringKeepNulls(str,["`~;}"],[]);
    string name = llList2String(data,0);
    key id = (key)llList2String(data,1);
    str = llList2String(data,2);
    
    //llOwnerSay("----------------------------"+name+":"+str);
    
    
    if(name=="find-mate"){
        _link(241,"null","");
        return;
    }
    
    //LIMIT BREED
    if(str=="throttle_start"){
        data = llParseStringKeepNulls(name,["+&"],[]);
        //name = llList2String(data,0);
        string start_obj = llList2String(data,1);
        string start_type = llList2String(data,2);
        integer alreadyThrottled = (start_obj!="" && Throttle_Type!="" && start_type==Throttle_Type && start_obj!=(string)llGetKey());
        if(llGetListLength(filter_breeds)==(Num_Breeds*2) || alreadyThrottled){
            //llOwnerSay("-----------ignore:"+(string)id+" ( "+name+" )");
            _link(241,"null","");
            return;
        }
        else{
            //llOwnerSay("-----------verify:"+(string)id+" ( "+name+" )"+" / "+(string)llGetKey());
            _link(203,"throttle_verify"+"+?+"+Throttle_Type,(string)id);
            if(llListFindList(filter_breeds,[id])==-1){filter_breeds += [id,llGetUnixTime()];}
            return;
        }
    }
    integer found = llListFindList(filter_breeds,[id]);
    if(found==-1){
        if(Num_Breeds!=-1){
            if(llGetListLength(filter_breeds)==(Num_Breeds*2) || llListFindList(["selectnest","breed","unthrottle"],[name])!=-1){
                _link(241,"null","");
                return;
            }
            else{//add to list
                filter_breeds += [id,llGetUnixTime()];
                //_throttle();
            }
        }
    }
    else{//update time
        if(name=="unthrottle"){
            //llOwnerSay("--------unthrottle: "+(string)id+" / "+(string)llGetKey());
            filter_breeds=llDeleteSubList(filter_breeds,found,found+1);
            _link(241,"null","");
            return;
        }
        filter_breeds=llListInsertList(llDeleteSubList(filter_breeds,found+1,found+1),[llGetUnixTime()],found+1);
    }
    
    //ACTION EXTENSION
    if(llGetSubString(str,0,0)=="@"){_link(240,str,"");}//resets
    
    //HUNGER
    else if(name=="hungry"){_link(233,str,"");}//resets
    else if(name=="eat"){_link(232,str,"");}//resets
    
    //BREEDING
    else if(name=="selectnest"){_link(231,str,"");}//resets
    else if(name=="breed"){_link(230,str,"");}//resets
    
    //SEARCH FOR EVENT
    else{_link(-202,str,"");}//resets after all action-lists have been checked

}
}


touch_start(integer n){
    if(Action_Touch_Events){
        integer num = llDetectedLinkNumber(0);
        if(Action_Touch_Events==1){_link(211,"touch-"+llGetLinkName(num),"");}
        if(Action_Touch_Events==2){_link(211,"touch-"+(string)llGetObjectDetails(llGetLinkKey(num), [OBJECT_DESC]),"");}
        if(Action_Touch_Events==3){_link(211,"touch-"+(string)num,"");}
    }
}

}


