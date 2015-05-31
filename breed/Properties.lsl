//////////////////////////////*///breed-properties///*//////////////////////////
list globals;
string  Undefined_Value;

list _inventory(integer p){
list data;
integer i;
for(i=0;i<llGetInventoryNumber(p);i++){
data+=[llGetInventoryName(p,i)];
}
return data;
}


list _list(string str){
    if(str==""){return [];}
    if(str=="INVENTORY_TEXTURE"){return _inventory(INVENTORY_TEXTURE);}
    if(str=="INVENTORY_SOUND"){return _inventory(INVENTORY_SOUND);}
    if(str=="INVENTORY_LANDMARK"){return _inventory(INVENTORY_LANDMARK);}
    if(str=="INVENTORY_NOTECARD"){return _inventory(INVENTORY_NOTECARD);}
    if(str=="INVENTORY_ANIMATION"){return _inventory(INVENTORY_ANIMATION);}
    if(str=="INVENTORY_OBJECT"){return _inventory(INVENTORY_OBJECT);}
    return llParseStringKeepNulls(str,["|"],[]);
}

string _string(list data){
    return llDumpList2String(data,"|");
}

list _replace(list data, integer start, string new){
    data = llDeleteSubList(data,start,start);
    if(new==""){return data;}
    return llListInsertList(data,[new],start);
}

integer _index(list data, string i, integer g){
    if(i=="r"){return (integer)llFrand(llGetListLength(data));}
    if(i=="n"){integer num = llGetListLength(data); if(num==0){return 0;}return num-g;}
    return (integer)i;
}

integer _findStrided(list data, string str){
    integer found = llListFindList(data,[str]);
    if(found==-1){return -1;}
    if(found==0){return 0;}
    if((integer)(found/2)*2 == found){return found;}
    if(llGetListLength(data)-1>found){return _findStrided(llDeleteSubList(data,0,found), str);}
    return -1;
}

list replace_dupes(list DupedList)
{
    integer pos;
    list Element;
    list NoDupes;
    while (llGetListLength(DupedList) != 0)
    {
        Element = llList2List(DupedList, 0, 0);
        NoDupes += Element;
        pos = llListFindList(DupedList, Element);
        while ( pos != -1)
        {
            DupedList = llDeleteSubList(DupedList, pos, pos);
            pos = llListFindList(DupedList, Element);
        }
    }
    return NoDupes;
}

_globalVal(string str, string instructions){//prop(global_value[index], modifier change[change_index])
    list data = llParseStringKeepNulls(str,[","],[]);
    list vals = _split(llList2String(data,0));
    string global = llList2String(vals,0);
    string global_index = llList2String(vals,1);
    integer found = llListFindList(globals,[global]);
    if(found==-1){found=llGetListLength(globals);globals+=[global,""];}//add global if not found
    integer i=1;
    string global_value;
    integer LIST=-1;
    for(i=1; i<llGetListLength(data);i++){        
        LIST=-1;
        global_value = llList2String(globals,found+1);
        if(global_index!=""){
            list gList =_list(global_value);
            integer index = _index(gList,global_index,FALSE);
            LIST=index;
            global_value = llList2String(gList,index);
        }        
        string change = _trim(llList2String(data,i));
        string modifier = llGetSubString(change,0,0);
        integer PLUS;
        integer MINUS;
        integer MULTI;
        integer DIV;
        integer RAND;
        if(modifier=="+"){change=llGetSubString(change,1,-1);PLUS=TRUE;}
        if(modifier=="-"){change=llGetSubString(change,1,-1);MINUS=TRUE;}
        if(modifier=="*"){change=llGetSubString(change,1,-1);MULTI=TRUE;}
        if(modifier=="/"){change=llGetSubString(change,1,-1);DIV=TRUE;}
        if(modifier=="~"){change=llGetSubString(change,1,-1);RAND=TRUE;}
        vals = _split(change);
        change = llList2String(vals,0);//new val
        string  change_index = llList2String(vals,1);//possible index
        integer change_found = _findStrided(globals,change);//find value
        string  change_value = llList2String(globals,change_found+1);//if found
        if(change_found==-1 || change_value==""){change_value=change;}//not found
        if(change_index!=""){
            if(llToLower(change_index)=="s"){//sort desc
                integer ASC;
                if(change_index=="S"){ASC=TRUE;}//sort asc
                change_value=llDumpList2String(llListSort(_list(change_value),1,ASC),"|");
            }
            else if(change_index=="u"){//unique
                change_value=llDumpList2String(replace_dupes(_list(change_value)),"|");
            }
            else{
                string val = llList2String(_list(change_value),_index(_list(change_value),change_index,FALSE));//change is a LIST
                if(val!=""){change_value=val;}
            }
        }
        _math(found,global_value,LIST,PLUS,MINUS,MULTI,DIV,RAND,change_value);        
    }
    if(i==1){
        if(global_index!=""){LIST = _index(_list(llList2String(globals,found+1)),global_index,TRUE);}
        if(~LIST){
            string change_value = _string(_replace(_list(llList2String(globals,found+1)),LIST,""));
            globals=_replace(globals,found+1,change_value);
            if(change_value==""){globals=llDeleteSubList(globals,found,found);}
        }
        else{globals=llDeleteSubList(globals,found,found+1);}
    }
    if(instructions==""){
        _link(-97,llDumpList2String(globals,";"));
        _link(-98,llDumpList2String(_createRegex(),";"));
        _link(1,"true");
    }
}



_math(integer index, string global, integer isList, integer Add, integer Subtract, integer Multiply, integer Divide, integer Random, string change){
if(Random){change = (string)llRound(llFrand((integer)change));}
if(Add){change = (string)((integer)global+(integer)change);}
if(Subtract){change = (string)((integer)global-(integer)change);}
if(Multiply){change = (string)((integer)global*(integer)change);}
if(Divide){if((integer)global&&(integer)change){change = (string)((integer)global/(integer)change);}else{change="0";}}
if(~isList){change = _string(_replace(_list(llList2String(globals,index+1)),isList,change));}
globals=_replace(globals,index+1,change);
}

list _split(string str){
    integer i;
    string temp;
    list split;
    integer bracket = FALSE;
    for(i=0;i<llStringLength(str);i++){
    string char = llGetSubString(str,i,i);
    if(char=="[" || char=="]"){split+=[temp]; temp="";}
    else{temp+=char;}
    }
    if(temp!=""){split+=[_trim(temp)];} 
    return split;
}

list _splitList(string str,string start, string end, integer keep){
    integer i;
    string temp;
    list split;
    integer bracket = FALSE;
    for(i=0;i<llStringLength(str);i++){
    string char = llGetSubString(str,i,i);
    if(char==","&&!bracket){split+=[temp]; temp="";}
    else if(char==","&&bracket){temp+=char;}
    else if(char==start){bracket=TRUE;if(keep){temp+=char;}}
    else if(char==end){bracket=FALSE;if(keep){temp+=char;}}
    else{temp+=char;}
    }
    if(temp!=""){split+=[temp];} 
    return split;
}

list _createRegex(){
list regex;
integer i;
for(i=0;i<llGetListLength(globals);i+=2){
    regex+=["%"+llList2String(globals,i)+"%",llList2String(globals,i+1)];
}
return regex;
}



_val(string str){
list attrs = _splitList(str,"<",">",TRUE);
integer i;
for(i=0;i<llGetListLength(attrs);i+=2){
    string Key = llToLower(_trim(llList2String(attrs,i)));
    string Val = _trim(llList2String(attrs,i+1));
    if(Val=="" || Val=="!!llTextBox!!"){Val=Undefined_Value;}
    if(Key=="myname"||Key=="breed_name"){_link(-90,Val);}
    //else if(Key=="MyFamily"){_link(-91,Val);}
    else if(Key=="mypartner"||Key=="partner"){_link(-49,Val);}
    else if(Key=="text_color"){_link(-106,Val);}
    else if(Key=="sound_volume"){_link(-107,Val);}
    else if(Key=="survival_odds"){_link(-108,Val);}
    else if(Key=="growth_timescale"){_link(-105,Val);}
    else if(Key=="growth_stages"){_link(-109,Val);}
    else if(Key=="growth_scale"){_link(-110,Val);}
    else if(Key=="growth_odds"){_link(-111,Val);}
    else if(Key=="consume_time"){_link(-112,Val);}
    else if(Key=="consume_odds"){_link(-113,Val);}
    else if(Key=="percent_lost"){_link(-114,Val);}
    else if(Key=="breed_time"){_link(-115,Val);}
    else if(Key=="breed_failed_odds"){_link(-116,Val);}
    else if(Key=="litters"){_link(-117,Val);}
    else if(Key=="move_timer"){_link(-118,Val);}
    else if(Key=="move_attempts"){_link(-119,Val);}
    else if(Key=="lifespan"){_link(-130,Val);}
    else if(Key=="age_min"){_link(-131,Val);}
    else if(Key=="age_max"){_link(-132,Val);}
    
    else if(Key=="turning_speed"){_link(121,Val);}
    else if(Key=="turning_time"){_link(122,Val);}
    else if(Key=="slope_offset"){_link(123,Val);}
    else if(Key=="finish_move"){_link(125,Val);}
    else if(Key=="target_dist_min"||Key=="target_dist"){_link(126,Val);}
    else if(Key=="allow_drift"){_link(127,Val);}
    
    else if(Key=="consume_min"){_link(124,Val);}
    else if(Key=="consume_max"){_link(128,Val);}
    else if(Key=="starvation_odds"){_link(129,Val);}
    else if(Key=="starvation_threshold"){_link(130,Val);}
    
    else if(Key=="litter_min"){_link(131,Val);}
    else if(Key=="litter_max"){_link(132,Val);}
    else if(Key=="litter_rare"){_link(133,Val);}
    else if(Key=="breed_age_min"){_link(134,Val);}
    else if(Key=="breed_age_max"){_link(135,Val);}
    
    else if(Key=="partner_timeout"){_link(136,Val);}
    else if(Key=="pregnancy_timeout"){_link(137,Val);}
    else if(Key=="dead"){_link(139,Val);}
    else if(Key=="owner_only"){_link(_encode(_trim(llList2String(attrs,i))),Val);}
}
_link(1,"true");
}


integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
default{
link_message(integer n, integer num, string str, key id){
    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);
        Undefined_Value=llList2String(data,62);
        if(llList2String(data,87)!=""){
            globals=llParseString2List(llList2String(data,87),[","],[]);//set default globals
        }
        return;
    }
    if(num==-102){
        _val(str);
    }
    if(num==_encode("breed created")){
        if(llGetListLength(globals)){
            _link(-97,llDumpList2String(globals,";"));
            _link(-98,llDumpList2String(_createRegex(),";"));
        }
    }
    if(num==-95){//Set New Global
        if((string)id=="save"){
            _link(-97,llDumpList2String(globals,";"));
            _link(-98,llDumpList2String(_createRegex(),";"));            
        }
        else{
            _globalVal(str,(string)id);
        }
    }
    if(num==_encode("rebuilt")){
        str = llList2String(llParseStringKeepNulls(str,[":#%"],[""]),24);
        if(str!=""){//Retrieve Saved Globals
            list data =llParseStringKeepNulls(str,[";"],[]);
            integer i;
            for(i=0;i<llGetListLength(data);i+=2){
                integer found = llListFindList(globals,[llList2String(data,i)]);
                if(~found){
                    globals=llListInsertList(llDeleteSubList(globals,found+1,found+1),[llList2String(data,i+1)],found+1);
                }
                else{
                    globals+=[llList2String(data,i),llList2String(data,i+1)];
                }
            }
        }
    }
}
}
