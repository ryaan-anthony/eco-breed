
//integer secure_channel;
key lastid=NULL_KEY;
//integer lastchan;

float rez_offset;
string Breed_rez_object;
integer Breed_One_Family;
integer Food_Level;
integer Food_Unit_Value;
integer Breed_Rez_Max;
integer Breed_Maxed_Die;
integer Food_Threshold;
string Rebuild_Rez_Object_Name;
float heightOffset;
vector rotOffset = <0.0, 0.0, 0.0>; 
key breed_mother;
string rez_object;
integer deathCount;
string toucher;
key touchkey;
vector touchpos;
string Version;
string owner;
string rebuild;
string rez_skinlist="";

string rez_family; 
integer rez_remain;
integer numCur;
integer rez_total;
integer totalRezzed;
string Breed_Pair="None";
string last_event;
integer Action_Touch_Events;
//string Text;

integer Object_Rez_Pattern;
vector    Object_Rez_Offset;
float    Object_Rez_Arc;
integer Reserve_Food;
//integer Reserve_Breeding;
integer extended_Breeding;
string Throttle_Type;
integer Allow_Breeding;
integer Initialized;
integer check_rez_error;
integer failed_births; 


_debug(string str){if(llGetObjectDesc()=="debug"){llOwnerSay(str);}}
_die(){llDie();}
string _howMany(integer num){if(num==-1){return "unlimited";}return (string)num;}
string _getRezObject(integer build){
    if(build){
        if(Rebuild_Rez_Object_Name==""){return llGetInventoryName(INVENTORY_OBJECT,0);}
        return Rebuild_Rez_Object_Name;
    }
    else{
        if(Breed_rez_object==""){return llGetInventoryName(INVENTORY_OBJECT,0);}
        return Breed_rez_object;
    }   
}
string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}
_link(integer n, string str, string filter){llMessageLinked(LINK_THIS, n, str, filter);} 





////
////BREEDING
////
_breed(string str){
    if(Breed_Rez_Max==0){
        if(Breed_Maxed_Die){deathCount=llGetUnixTime()+15;}
        _link(241,"null","");
        return;
    }
    list data = llParseString2List(str,["+;&"],[""]); 
    rez_remain = (integer)llList2String(data,0);
    rez_total = rez_remain;
    if(!Object_Rez_Pattern){numCur=0;}
    rez_skinlist=llList2String(data,1);
    if(Breed_Pair=="None"&&Breed_One_Family){Breed_Pair=_PullNames(str);_link(236,Breed_Pair,"");}
    _eachOffspring();
}
_eachOffspring(){   
    rez_object=_getRezObject(0);
    if(llGetInventoryType(rez_object)==-1||Breed_Rez_Max==0){
        rez_skinlist="";
        if(Breed_Maxed_Die){deathCount=llGetUnixTime()+15;}
        _link(241,"null","");
        return;
    }
    integer numTot = rez_total;
    if(Object_Rez_Pattern){numTot=Object_Rez_Pattern;}
    _rezIT(numCur,numTot);
    numCur++;
    if(Object_Rez_Pattern && numCur==Object_Rez_Pattern){numCur=0;}
}
_rezIT(integer NUM, integer TOTAL){
    float theta;
    vector pos;
    rotation rot;
    float xRadius = rez_offset;
    float yRadius = rez_offset*Object_Rez_Arc;
    float flareAngle = 0.0; 
    float bendCoefficient = 0.0;
    vector posOffset = Object_Rez_Offset;
    theta = TWO_PI * ( (float)NUM / (float)TOTAL );
    pos.x = xRadius * llCos(theta); 
    pos.y = yRadius * llSin(theta);
    pos.z = -bendCoefficient*llCos(theta)*llCos(theta);
    pos = pos + llGetPos() + posOffset;
    rot = llEuler2Rot(<rotOffset.x*DEG_TO_RAD, rotOffset.y*DEG_TO_RAD, rotOffset.z*DEG_TO_RAD>); 
    rot = rot * llEuler2Rot(<0, -1*flareAngle*DEG_TO_RAD, 0>);
    rot = rot * llRotBetween(<0.0,1.0,0.0>, <-1.0 * xRadius * llSin(theta) / ( llSqrt ( (yRadius*yRadius * llCos(theta) * llCos(theta)) + (xRadius*xRadius * llSin(theta) * llSin(theta))) ),yRadius * llCos(theta) / ( llSqrt ( (yRadius*yRadius * llCos(theta) * llCos(theta)) + (xRadius*xRadius * llSin(theta) * llSin(theta))) ),0.0>);
    if ( (integer)(TOTAL/2)*2 == TOTAL && NUM== (TOTAL/2) ) {rot = rot * llEuler2Rot( <0,PI,0> );}
    integer index = -1;
    if(rebuild!=""){index=-3;}
    check_rez_error = TRUE;
    llSetTimerEvent(3);//check if not rezzed
    llRezObject(rez_object, pos+<0,0,heightOffset>, ZERO_VECTOR, rot, index);
}

////
////REGEX
////
string _regex(string str){list e = [
    "%action_touch_name%",toucher,
    "%action_touch_key%",touchkey,
    "%action_touch_pos%",touchpos,
    "%this%",last_event,
    "%action_name%",llGetObjectName(),
    "%action_desc%",llGetObjectDesc(),
    "%action_pos%",llGetPos(),
    "%action_id%",llGetKey(),
    "%version%",Version,
    "%failed_births%",failed_births,
    "%Breed_Pair%",Breed_Pair,
    "%Breed_Created%",totalRezzed,
    "%Food_Level%",_howMany(Food_Level)
];integer i;for(i=0;i<llGetListLength(e);i+=2){str = _replace([llList2String(e,i)], llList2String(e,i+1), str);}return str;}

string _PullNames(string str){
    list each = llParseString2List(str,["&&"],[]);
    string mom = llList2String(each,0);
    string dad = llList2String(each,1);
    list F = llParseString2List(mom,["|"],[]); 
    list M = llParseString2List(dad,["|"],[]);
    mom=llList2String(F,1);
    dad=llList2String(M,1);
    if(dad==""&&mom!=""){return mom;}
    if(mom!=""&&dad!=""){return mom+" and "+dad;}
    return "None";
}

integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}


default{
state_entry(){llSetTimerEvent(3);}
changed(integer change){if(change & CHANGED_INVENTORY){if(rez_skinlist==""&&rebuild==""){_link(205,"reset","");}}}
link_message(integer n, integer num, string str, key id){
if(num==280){
    _link(281,_regex(str),"");
}
if(num==239){//food
    Food_Level=(integer)str;
}
if(num==-239){//food extension
    Food_Level+=(integer)str;
}
if(num==201){//event relay 
    _link(203,(string)lastid+"+?+"+_regex(str),lastid);
}
if(num==234){//listencontrol
    lastid = (key)llList2String(llParseStringKeepNulls(str,["`~;}"],[]),1);
}
if(num==251){//update owner
    owner=str;
}
if(num==_encode("action_settings")){//settings 
    if(str==""){return;}
    list data = llParseStringKeepNulls(str,["+;&"],[""]);
    rez_offset=(float)llList2String(data,1);
    if(rez_offset==0){rez_offset=0.01;}
    Breed_rez_object=llList2String(data,2);
    Breed_One_Family=(integer)llList2String(data,3);
    Breed_Maxed_Die=(integer)llList2String(data,7);
    Food_Threshold=(integer)llList2String(data,8);
    Rebuild_Rez_Object_Name=llList2String(data,19);
    heightOffset=(float)llList2String(data,28);
    rotOffset=(vector)llList2String(data,29);
    Action_Touch_Events=(integer)llList2String(data,38);
    Object_Rez_Pattern=(integer)llList2String(data,42);
    Object_Rez_Offset=(vector)llList2String(data,43);
    Object_Rez_Arc=(float)llList2String(data,44);
    Reserve_Food=(integer)llList2String(data,47);
    //Reserve_Breeding=(integer)llList2String(data,48);
    Throttle_Type=llList2String(data,34);
    Allow_Breeding=(integer)llList2String(data,50);
    Version=llList2String(data,51);
    
    if(!Initialized){
        Initialized=TRUE;
        Food_Level=(integer)llList2String(data,4);
        Food_Unit_Value=(integer)llList2String(data,5);
        Breed_Rez_Max=(integer)llList2String(data,6);
    }
}  
if(num==206){//rebuild
    rez_object=_getRezObject(1);
    if(llGetInventoryType(rez_object)==-1){return;}
    rebuild=str;
    if(!Object_Rez_Pattern){
        _rezIT(0,1);
    }
    else{
        _rezIT(numCur,Object_Rez_Pattern);
        numCur++;
        if(numCur==Object_Rez_Pattern){numCur=0;}
    }
}
if(num==230){//breed
    if(!Allow_Breeding){_link(241,"null","");return;}
    rez_object=_getRezObject(0);
    if(llGetInventoryType(rez_object)==-1 || Allow_Breeding==2 || Breed_One_Family&&rez_family!=str&&rez_family!=""){_link(241,"null","");return;}//no rezzables | breeding reserved | not family
    if(Breed_One_Family&&rez_family==""){rez_family=str;}
    _link(203,(string)lastid+"+?+birthobject",lastid);
    
}
if(num==231){//selectnest
    if(!Allow_Breeding){_link(241,"null","");return;}
    list data = llParseString2List(str,["&+&"],[""]);
    if(llList2String(data,1)!=(string)llGetKey()){
        if(Breed_One_Family&&rez_family==llList2String(data,2)){
            rez_family="";
            Breed_Pair="None";
            _link(236,Breed_Pair,"");
        }
        _link(241,"null","");
        return;
    }    
    breed_mother = llList2String(data,3);
    extended_Breeding=(integer)llList2String(data,4);
    _breed(llList2String(data,0));
}
if(num==232){//eat
    if((Food_Level>0||Food_Level==-1) && !Reserve_Food){
        if(Food_Level!=-1){
            Food_Level-=(integer)str;
            if(Food_Level<0){Food_Level=0;}
            _link(239,(string)Food_Level,"");//regex
        }
        if(Food_Threshold && Food_Level<Food_Threshold){deathCount=llGetUnixTime()+15;}
        _link(-202,"food","");//send back food event
        return;
    }
    _link(241,"null","");
}
if(num==233){//hungry
    if((Food_Level==-1 || Food_Level>=(integer)str) && !Reserve_Food){//resets
        _link(203,"hunger"+"+?+"+(string)Food_Level+"+;&"+(string)Food_Unit_Value+"+;&"+(string)llGetKey(),lastid);
    }
    else{
        _link(241,"null","");
    }
}

////EXTENSION MODIFIER
if(num==221 && Food_Level!=-1){
    Food_Level+=(integer)str;
    _link(239,(string)Food_Level,"");
}
if(num==271){Food_Unit_Value=(integer)str;}
if(num==-202){
    last_event = str;
}

}
timer(){
    if(check_rez_error){
        check_rez_error = FALSE;
        rebuild="";
        rez_skinlist="";
        failed_births+=rez_remain;
        rez_remain=0;
        _link(241,"","");
    }
    if(deathCount&&deathCount<llGetUnixTime()){_die();}
}
object_rez(key id){
    if(rez_skinlist==""&&rebuild==""){return;}
    check_rez_error=FALSE;
    llSleep(0.1);
    if(rebuild!=""){
        _link(203, (string)id+"+?+"+rebuild+"-+;"+owner,(string)id+";"+"wait");
        rebuild="";
        return;
    }
    totalRezzed++;
    _link(238,(string)totalRezzed,"");
    rez_remain--;
    if(Breed_Rez_Max>0){
        Breed_Rez_Max--;
        _link(237,(string)Breed_Rez_Max,"");
    }
    _link(203, (string)id+"+?+"+rez_skinlist+"-+;"+owner,(string)id+";"+"wait");
    if(rez_remain){
        _eachOffspring();
        return;
    }
    else{
        if(!extended_Breeding){_link(203, (string)breed_mother+"+?+birth",(string)breed_mother);}
        else{extended_Breeding=FALSE;}
        rez_skinlist="";
    }
    if(Breed_Rez_Max==0&&Breed_Maxed_Die){
        deathCount=llGetUnixTime()+15;
    }
}
touch_start(integer n){
    if(Action_Touch_Events){
        toucher = llDetectedName(0);
        touchkey = llDetectedKey(0);
        touchpos = llDetectedPos(0);
    }
}
}

