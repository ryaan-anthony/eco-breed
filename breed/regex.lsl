//////////////////////////////*///breed-regex///*/////////////////////////

////GLOBAL SETTINGS 
//
integer     Growth_Stages;
vector      Text_Color;
key         actionkey;
key         touchkey;
key         sitkey;
string      owner;
string      toucher;
string      sitter;
integer     Require_Partners;
string      MyParents;
string      MyKey;
string      MyGender;
integer     MyAge;
integer     MyGeneration;
integer     MyLitters;
integer     MyHunger;
string      MyName;
string      partner_owner;
string      MySpecies;
string      MySkins;
list        globals;
string      MyPartnerName;  
vector      MyHome;
string      MyTraits;
string      MyPartner;
string      chat_name;
key         chat_id;
string      chat_msg;
vector      chat_pos;
string      Undefined_Value;
integer     Pregnancy_Time_Left;
integer     CRATED_BIRTH;
string      Allowed_Keywords;
integer     secure_channel;
integer Appetite;
integer Maturity;
string version;
integer notDead=TRUE;
string _isDead(){
if(notDead){return "false";}
return "true";
}
_DEBUG(string str){if(~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(str);}}


integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}

string _toTime(integer num){
    if(!num){return Undefined_Value;}
    num = (num-llGetUnixTime());
    if(num<0){return Undefined_Value;}
    integer monthsDiff = llFloor(num/60/60/24/30);
    num -= monthsDiff*60*60*24*30;
    if(monthsDiff>0){
        if(monthsDiff==1){return (string)monthsDiff+" month";}
        return (string)monthsDiff+" months";
    }
    integer daysDiff = llFloor(num/60/60/24);
    num -= daysDiff*60*60*24;
    if(daysDiff>0){
        if(daysDiff==1){return (string)daysDiff+" day";}
        return (string)daysDiff+" days";
    }
    integer hrsDiff = llFloor(num/60/60);
    num -= hrsDiff*60*60;
    if(hrsDiff>0){
        if(hrsDiff==1){return (string)hrsDiff+" hour";}
        return (string)hrsDiff+" hours";
    }
    integer minsDiff = llFloor(num/60);
    num -= minsDiff*60;
    if(minsDiff>0){
        if(minsDiff==1){return (string)minsDiff+" minute";}
        return (string)minsDiff+" minutes";
    }
    return (string)num+" seconds";
}

string _regex(string str){
    list e = [
    "%breed_name%",MyName,
    "%breed_id%",MyKey,
    "%obj_name%",llGetObjectName(),
    "%obj_key%",llGetKey(),
    "%obj_desc%",llGetObjectDesc(),
    "%pos%",llGetPos(),
    "%height%",_height(),
    "%speed%",llVecMag(llGetVel()),
    
    "%species_name%",MySpecies,
    "%species_id%",llList2String(llParseString2List(llGetObjectDesc(),["-"],[]),0),
    "%config_id%",llList2String(llParseString2List(llGetObjectDesc(),["-"],[]),1),
    "%version%",version,
    
    "%owner_name%",owner,
    "%owner_key%",llGetOwner(),
    "%owner_pos%",_pos(llGetOwner()),
    
    "%touch_name%",toucher,
    "%touch_key%",touchkey,
    "%touch_pos%",_pos(touchkey), 
    
    "%sit_name%",sitter,
    "%sit_key%",sitkey,
    
    "%chat_name%",chat_name,
    "%chat_key%",chat_id,
    "%chat_pos%",chat_pos,
    "%chat_msg%", chat_msg,
    
    "%action_dist%",llVecDist(llGetPos(), _pos(actionkey)),
    
    "%region%",llGetRegionName(),
    "%water%",llWater(ZERO_VECTOR),
    "%chan%",secure_channel,
    "%time%",llGetUnixTime(),
    "%hour%",(integer)llGetWallclock()/3600,
    "%rand%",(integer)llFrand(1),
    "%script_mem%",64000-llGetUsedMemory(),
    "%script_time%",(string)llGetObjectDetails(llGetKey(),[OBJECT_SCRIPT_TIME]), 
    "%undefined%",Undefined_Value,
    //"%Text_Color%",Text_Color,
    
    "%gender%",MyGender,
    "%age%",MyAge,
    "%dead%",_isDead(),
    "%growth_stages%",Growth_Stages,
    "%generation%",MyGeneration,
    "%hunger%",MyHunger,
    "%partner%",MyPartnerName,
    "%partner_raw%",MyPartner,
    "%home%",MyHome,
    "%parents%",_PullNames(MyParents),
    "%parents_raw%",llDumpList2String(llParseStringKeepNulls(MyParents,["&&"],[]),"|"),
    "%breed_litters%",MyLitters,
    "%pregnant%",_toTime(Pregnancy_Time_Left),
    "%maturity%",_toTime(Maturity),
    "%appetite%",_toTime(Appetite),
    "%pregnant_raw%",Pregnancy_Time_Left,
    "%maturity_raw%",Maturity,
    "%appetite_raw%",Appetite,
    "%skins_raw%",MySkins,
    "%partner_owner%",partner_owner   
    ]+_splitSkins()+globals;
    
    integer i;
    for(i=0;i<llGetListLength(e);i+=2){
        if(str=="DUMP_ALL_VALUES"){
            string obj = llGetObjectName();
            llSetObjectName(llList2String(e,i));
            string val = llList2String(e,i+1);
            if(val==""){val=Undefined_Value;}
            llOwnerSay(val);
            llSetObjectName(obj);
        }
        else{str = _replace([llList2String(e,i)], llList2String(e,i+1), str);}
    }
    if(str=="DUMP_ALL_VALUES"){return "";}
    str = _removeExp(str);
    str = _removeUndefined(str);
    return _trim(str);
}


string _removeUndefined(string str){
    string result;
    integer bracket;
    string temp;
    integer i;
    for(i=0;i<llStringLength(str);i++){
        string char = llGetSubString(str,i,i);
        if(char=="{"||char=="}"){
            if(!bracket){bracket=TRUE;}
            else{
                bracket=FALSE;
                if(llSubStringIndex(temp,Undefined_Value)==-1){result+=temp;}
                temp="";
            }
        }
        else if(!bracket){result+=char;}
        else{temp+=char;}
    }
    return result;
}


string _removeExp(string str){
    string result;
    integer bracket;
    integer i;
    for(i=0;i<llStringLength(str);i++){
        string char = llGetSubString(str,i,i);
        if(char=="%"){
            if(!bracket){bracket=TRUE;result+=Undefined_Value;}
            else{bracket=FALSE;}
        }
        else if(!bracket){result+=char;}
    }
    return result;
}

list _splitSkins(){
list skins = llParseStringKeepNulls(MySkins,["|"],[]);
list split =[];
list dormant =[];
list active = [];
integer i;
for(i=0;i<llGetListLength(skins);i++){
    list data = llParseStringKeepNulls(llList2String(skins,i),["~"],[]);
    if(llList2String(data,2)=="2"){
        split+=["%"+llList2String(data,1)+"%",llList2String(data,0)];
        active+=[llList2String(data,0)+" - "+llList2String(data,1)];
    }
    else{dormant+=[llList2String(data,0)+" - "+llList2String(data,1)];}
}
if((string)dormant==""){split+=["%skins_dormant%",Undefined_Value];}
else{split+=["%skins_dormant%",llDumpList2String(dormant,"|")];}
if((string)active==""){split+=["%skins_active%",Undefined_Value];}
else{split+=["%skins_active%",llDumpList2String(active,"|")];}
return split;
}


string _PullNames(string str){
    list each = llParseStringKeepNulls(str,["&&"],[]); 
    string mom = llList2String(each,0);
    string dad = llList2String(each,1);
    list F = llParseStringKeepNulls(mom,["|"],[]); 
    list M = llParseStringKeepNulls(dad,["|"],[]);
    mom=llList2String(F,1);
    dad=llList2String(M,1);
    if(!Require_Partners&&mom!=""){return mom;}
    if(mom!=""&&dad!=""){return mom+" and "+dad;}
    return Undefined_Value;
}

float _height(){
    vector center = llGetGeometricCenter();
    vector pos = llGetPos();
    return pos.z+center.z;
}

string _shortvec(vector vec){
    return "<"+(string)llRound(vec.x)+","+(string)llRound(vec.y)+","+(string)llRound(vec.z)+">";
}

string _replace(list a, string b, string c){
    return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);
}

string _trim(string str){
    return llStringTrim(str,STRING_TRIM);
}

string _desc(key id){
    return (string)llGetObjectDetails(id,[OBJECT_DESC]);
}

string _name(key id){
    return (string)llGetObjectDetails(id,[OBJECT_NAME]);
}

vector _pos(key id){
    return (vector)((string)llGetObjectDetails(id,[OBJECT_POS]));
}



////DEFAULT PROGRAM
//

_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}

default{
on_rez(integer n){
    if(n==-2){CRATED_BIRTH=TRUE;}
}

touch_start(integer n){
    toucher=llDetectedName(0);
    touchkey=llDetectedKey(0);
}

link_message(integer n, integer num, string str, key id){

    integer Update_Keywords;//update keywords after conditions?

    if(num==_encode("Appetite")){
        Appetite=(integer)str;        
    }
    else if(num==_encode("Maturity")){
        Maturity=(integer)str;
    }
    else if(num==_encode("dump")){
        string run = _regex("DUMP_ALL_VALUES");
    }
    else if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);
        secure_channel=_encode(llList2String(data,0));
        Growth_Stages=(integer)llList2String(data,22);
        Text_Color=(vector)llList2String(data,15); 
        Require_Partners=(integer)llList2String(data,41); 
        MyHunger=(integer)llList2String(data,31);
        Undefined_Value=llList2String(data,62);
        MyPartnerName=Undefined_Value;
        Allowed_Keywords = llList2String(data,83);
        return;
    }
    else if(num==_encode("set owner")){
        if((string)id!=""){version=(string)id;}
        owner=str;
        Update_Keywords=TRUE;
    }    
    
    //skin and breed info from #ID
    else if(num==_encode("breed created")){
        _DEBUG("Saving Skin");
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        MyGeneration=(integer)llList2String(data,0);    
        MySkins=llList2String(data,1);                  
        MyParents =llList2String(data,2);
        MyGender=llList2String(data,3);                 
        MyKey=llList2String(data,4);                    
        MyName=llList2String(data,5);     
        Update_Keywords=TRUE;
    }
    
    //timer info from #PROCESS
    else if(num==_encode("save timers")){
        list data=llParseStringKeepNulls(str,["?!@"],[]);
        _link(_encode("save values"),llDumpList2String([
            notDead=(integer)llList2String(data,0),
            llList2String(data,1),//Timer_Age
            llList2String(data,2),//Timer_Breed
            llList2String(data,3),//Timer_Grow
            llList2String(data,4),//Timer_Hunger
            MyAge,
            MyLitters,
            MyHunger,
            llList2String(data,5),//timeofBirth
            llList2String(data,6)//timeofDeath
            ],"?!@")
        );
    }

    //rebuilt from #remote
    else if(num==_encode("rebuilt")){
        list values = llParseStringKeepNulls(str,[":#%"],[""]);
        MyName=llList2String(values,0);
        partner_owner=llList2String(values,1);if(partner_owner=="Undefined"){partner_owner=Undefined_Value;}
        MyGender=llList2String(values,2);
        MyAge=(integer)llList2String(values,3);
        MySpecies=llList2String(values,4);if(MySpecies=="Undefined"){MySpecies=Undefined_Value;}
        MySkins=llList2String(values,5);
        if(!CRATED_BIRTH){
            MyHunger=(integer)llList2String(values,6);
            MyPartner=llList2String(values,23);
            MyPartnerName=llList2String(values,26);
        }
        else{
            MyPartnerName=Undefined_Value;
        }
        MyParents=llList2String(values,7);
        MyTraits=llList2String(values,8);
        MyGeneration=(integer)llList2String(values,9);
        MyLitters=(integer)llList2String(values,15);
        llSetStatus(STATUS_PHYSICS,(integer)llList2String(values,19));
        MyKey=llList2String(values,22);
        Update_Keywords=TRUE;
    }
    
    
    else if(num==-153){
        list data=llParseStringKeepNulls(str,[";"],[]);
        sitkey=llList2String(data,0);
        sitter=llList2String(data,1);
    }
    
    else if(num==-155){
        list data=llParseStringKeepNulls(str,[";;"],[]);
        chat_name=llList2String(data,0);
        chat_id=llList2String(data,1);
        chat_msg=llList2String(data,2);
        chat_pos=_pos(chat_id);
    }
    
    else if(num==-172){Pregnancy_Time_Left=(integer)str;}
    else if(num==-162){MyHome=(vector)str;}
    else if(num==-31){MyAge=(integer)str;Update_Keywords=TRUE;}//lifecycle
    else if(num==-124){MyPartnerName=str;}//properties
    else if(num==-4){actionkey=str;}//save : lastid
    else if(num==-60){MyLitters=(integer)str;}//lifecycle
    else if(num==-92){MySpecies=str;if(MySpecies=="Undefined"){MySpecies=Undefined_Value;}}//remote
    else if(num==-93&&str!=""){MySkins=str;}//remote
    else if(num==-90){MyName=str;Update_Keywords=TRUE;}//remote
    else if(num==-106){Text_Color=(vector)str;}//properties
    else if(num==-49){MyPartner=str;}//lifecycle
    else if(num==-122){MyHunger=(integer)str;}//properties
    else if(num==-109||num==-157){Growth_Stages=(integer)str;}//hunger/growth
    
    else if(num==-98){//regex globals
        globals=llParseStringKeepNulls(str,[";"],[]);
        if((string)globals==""){globals=[];} 
        Update_Keywords=TRUE;
    }
    
    else if(num==-14){
        if(str=="die"){_link(-100,"die");}
        else{MyHunger=(integer)str;} 
    }
    
    else if(num==-2){//Relaying Regexed Values
        list data = llParseStringKeepNulls(_regex(str),[";"],[]);
        _link(-161,llList2String(data,0)+":!@"+llList2String(data,1));
    }
    
    //Update Keywords?
    
    if(Update_Keywords){
        _link(120,_regex(Allowed_Keywords));//Allowed_Keywords
    
    }
}

}

