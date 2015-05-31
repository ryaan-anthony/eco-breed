//////////////////////////////*///breed-methods///*/////////////////////////

integer     secure_channel;
list        menudata;
string      chat_callback;
string      owner;
integer     handle;
vector      Text_Color;
float       Sound_Volume;
float       Slope_Offset=0.5;
integer     Text_Prim;
float       Text_Alpha=1.0;
integer     Pause_Action;
string      Undefined_Value;
   
string _unicode(string str){
    str = _replace(["&#40"], "(", str);
    str = _replace(["&#41"], ")", str);
    str = _replace(["&#44"], ",", str);
    str = _replace(["&#37"], "%", str);
    str = _replace(["&#47"], "/", str);
    return str;
}
integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
} 
list _findOperator(string str){
    integer i;
    list operators = ["=","!","<",">","^","~"];
    for(i=0; i<llGetListLength(operators);i++){
        integer n = llSubStringIndex(str,llList2String(operators,i));
        if(n>0){return [_trim(llGetSubString(str,0,n-1)),_trim(llGetSubString(str,n+1,-1)),llGetSubString(str,n,n)];}
        if(n==0){return [_trim(llGetSubString(str,1,-1)),TRUE,"?"];}
    }
    return [];
}

_methods(string func, string attr){
    list attrs = llParseStringKeepNulls(attr,[","],[]);
    string callback;
    if(llGetSubString(func,0,0)=="#"){
        llMessageLinked(LINK_THIS, -20, func, attr);
        jump true;
    }
    else if(llGetSubString(func,0,0)=="@"){
        list method_string = llParseStringKeepNulls(func,["@"],[]);
        string actionkey = llList2String(method_string,1);
        func = llList2String(method_string,2);
        llRegionSayTo(actionkey,secure_channel,"@"+func+"("+attr+")");
        jump true;
    }
    else if(func=="0"){//toggle
        attr=_trim(llList2String(attrs,(integer)llFrand(llGetListLength(attrs))));
        integer i;
        list classes = llParseStringKeepNulls(attr,["|"],[]);
        string functions;
        for(i=llGetListLength(classes);i>0;i--){        
            string class = _trim(llList2String(classes,i-1));
            if((i-1)==0){attr=class;}
            else{functions="0("+class+")"+functions;}
        }
        if(functions!=""){_link(187,functions);}
        _link(2,attr);
        jump wait;        
    }
    else if(func=="5"||func=="6"){//filter | rfilter
        integer n;
        for(n=0;n<llGetListLength(attrs);n+=2){
            string statement = _replace(["TRUE","true"],"1",_trim(llList2String(attrs,n)));
            callback =  _trim(llList2String(attrs,n+1));
            if(callback=="null"){callback="true";}
            list found = _findOperator(statement);
            if(llGetListLength(found)>0){
                string value = llList2String(found,0);
                string attribute = llList2String(found,1);
                string sub = llList2String(found,2);
                integer before = _encode(value);
                integer after = _encode(attribute);
                if(func=="rfilter"){
                    if     (sub=="?"){ if(value==Undefined_Value || (integer)value==FALSE){jump false;} }
                    else if(sub=="!"){ if(before != after && !_attrCheck(value,attribute)){jump false;} }
                    else if(sub=="="){ if(before == after || _attrCheck(value,attribute)){jump false;} }
                    else if(sub=="<"){ if((float)value  < (float)attribute){jump false;} }
                    else if(sub==">"){ if((float)value  > (float)attribute){jump false;} }
                    else if(sub=="^"){ if(_inList(value,attribute)||_inList(attribute,value)){jump false;} }
                    else if(sub=="~"){ if(~llSubStringIndex(attribute,value)||~llSubStringIndex(value,attribute)){jump false;} }
                }
                else{
                    if     (sub=="?"){ if(value!=Undefined_Value && (integer)value!=FALSE){jump false;} }
                    else if(sub=="="){ if(before != after && !_attrCheck(value,attribute)){jump false;} }
                    else if(sub=="!"){ if(before == after || _attrCheck(value,attribute)){jump false;} }
                    else if(sub==">"){ if((float)value  <= (float)attribute){jump false;} }
                    else if(sub=="<"){ if((float)value  >= (float)attribute){jump false;} }
                    else if(sub=="^"){ if(_inList(value,attribute)||_inList(attribute,value)){}else{jump false;} }
                    else if(sub=="~"){ if(llSubStringIndex(attribute,value)==-1&&llSubStringIndex(value,attribute)==-1){jump false;} }
                }
            }
            else{
                if     ( ( (integer)statement || ( statement!=Undefined_Value && statement!="null" ) ) && func=="rfilter" ){jump false;}
                else if( ( (integer)statement!=TRUE  || ( statement==Undefined_Value || statement=="null" ) ) && func=="filter" ){jump false;}
            }
        }
        jump true;
    }
    else if(func=="7"){//bind
        _link(-151,attr);
        jump true;    
    }
    else if(func=="8"){//give
        key Key = (key)_trim(llList2String(attrs,0));
        string Obj =  _trim(llList2String(attrs,1));
        if(Key!=NULL_KEY && ~llGetInventoryType(Obj)){llGiveInventory(Key,Obj);}
        jump true;
    }
    else if(func=="9"){//pause
        float time = _modify(attr);
        _link(150,(string)time);
        if(Pause_Action){llSleep(time);}
        jump true;
    }
    else if(func=="10"){//anim
        _link(-18,attr);
        jump true;
    }
    else if(func=="11"){//say
        llSay(0,_unicode(attr));
        jump true;
    }
    else if(func=="12"){ //shout
        llShout(0,_unicode(attr));
        jump true;
    }
    else if(func=="13"){ //message
        llInstantMessage(llList2String(attrs,0),_unicode(llList2String(attrs,1)));
        jump true;
    }
    else if(func=="14"){//sethome
        if((vector)attr==ZERO_VECTOR){_link(-162,(string)llGetPos());}
        else{_link(-162,attr);}
        jump true;
    }
    else if(func=="15"){//whisper
        llWhisper(0,_unicode(attr));
        jump true;
    }
    else if(func=="16"){//ownersay
        llOwnerSay(_unicode(attr));
        jump true;
    }
    else if(func=="17"||func=="18"){//set | unset
        integer i;
        for(i=0;i<llGetListLength(attrs);i++){
            list classes = llParseStringKeepNulls(_trim(llList2String(attrs,i)),["|"],[]);
            string class = _trim(llList2String(classes,0));
            string save = llToLower(_trim(llList2String(classes,1)));
            if(func=="17"){
                if(save=="true" || (integer)save){_link(-42,class);}//save anim
                _link(-5,class);//set anim
            }
            else{
                if(save=="true" || (integer)save){_link(-44,class);}
                _link(-6,class);
            }
        }
        jump true;
    }
    else if(func=="19"){//uncache
        integer i;
        for(i=0;i<llGetListLength(attrs);i++){
            string class = _trim(llList2String(attrs,i));
            _link(-164,class);
        }
        jump true;
    }
    else if(func=="20"){//attach
        _link(-16,attr);
        jump true;
    }
    else if(func=="21"){//revive
        _link(-121,attr);
        jump true;
    }
    else if(func=="22"){//unbind
        _link(-150,attr);
        jump true;
    }
    else if(func=="23"||func=="24"){//menu | textbox
        string who = llList2String(attrs,0);
        string msg = _unicode(llList2String(attrs,1));
        if(llKey2Name(who)==""){jump true;}
        if(msg==""){msg="NULL";}
        integer chan = _encode((string)llGetKey());
        llListenRemove(handle);
        handle = llListen(chan,"","","");
        if(func=="24"){chat_callback=_trim(llList2String(attrs,2)); llTextBox(who,msg,chan);jump true;}
        menudata = _trimlist(llParseStringKeepNulls(llDumpList2String(llDeleteSubList(attrs, 0, 1),"="),["="],[]));
        list btns = llList2ListStrided(menudata, 0, -1, 2); 
        if(llGetListLength(btns)){llDialog(who,msg,btns,chan);}
        jump true;
    }
    else if(func=="25"){//text
        if(attr=="null"){_text("");}
        else{_text(_unicode(attr));}
        jump true;
    }
    else if(func=="26"){//sound
        string file = _trim(llList2String(attrs,0));
        if(~llGetInventoryType(file) || forceKey(file)!=NULL_KEY){
            integer loop = (integer)_trim(llList2String(attrs,1));
            if(loop==1){llLoopSound(file,Sound_Volume);}
            else if(file=="null"){llStopSound();}
            else{llTriggerSound(file,Sound_Volume);}
        }
        jump true;
    }
    else if(func=="27"){//prop
        _link(-95,attr);
        jump wait;
    }
    else if(func=="4"){//cache
        _link(-159,attr);
        jump wait;
    }
    else if(func=="28"){//val
        _link(-102,attr);
        jump wait;
    }
    else if(func=="29"){//rez
        attrs = _split(attr,"<",">",TRUE);
        _link(-17,llDumpList2String(attrs,"+;&"));
        jump wait;
    }
    else if(func=="30"){//move
        if(attr=="null"){_link(-3,"stop");jump true;}
        attrs = _split(attr,"<",">",TRUE);
        vector pos = (vector)_trim(llList2String(attrs,0));
        vector offset = _modex(_replace(["<",">"],"",llList2String(attrs,1)));
        string type = _trim(llList2String(attrs,2));
        string speed = _trim(llList2String(attrs,3));
        string complete = _trim(llList2String(attrs,4));
        list flags = llParseString2List(_trim(llList2String(attrs,5)),["|"],[]);
        string flagged_callback = _trim(llList2String(attrs,6));
        if(flagged_callback==""){flagged_callback="true";}
        vector dest = pos+offset;
        if(dest==ZERO_VECTOR){_link(-3,"stop");jump true;}
        if(type == "setpos"){vector p=llGetPos();dest.z=p.z;}
        if(llGetListLength(flags)==0){jump noflags;}
        string this_parcel=(string)llGetParcelDetails(llGetPos(),[PARCEL_DETAILS_NAME]);
        string dest_parcel=(string)llGetParcelDetails(dest,[PARCEL_DETAILS_NAME]);
        integer i;
        integer Cast_Rejects;
        integer AVOID_OBJECTS;
        integer AVOID_AVATARS;
        integer AVOID_BREEDS;
        integer AVOID_LAND;
        integer AVOID_PHANTOM;
        list Cast_Phantom;
        vector curPos=llGetPos();
        for(i=0;i<llGetListLength(flags);i++){
            integer flag = (integer)_trim(llList2String(flags,i));
            if((flag==-1 || flag==0) && dest!=_safevector(dest)){_link(-163,flagged_callback); jump true;}//AVOID_REGION_CROSSING
            if((flag==-1 || flag==1) && this_parcel!=dest_parcel){_link(-163,flagged_callback); jump true;}//AVOID_PARCEL_CROSSING
            if((flag==-1 || flag==2) && llWater(ZERO_VECTOR)>llGround(dest-llGetPos())){_link(-163,flagged_callback); jump true;}//AVOID_WATER
            if((flag==-1 || flag==8) && curPos.z>llGround(dest-llGetPos())+Slope_Offset){_link(-163,flagged_callback); jump true;}//AVOID_SLOPES
            if((flag==-1 || flag==9) && llScriptDanger(dest)){_link(-163,flagged_callback); jump true;}//AVOID_NO_ACCESS
            if(flag==3){AVOID_OBJECTS=TRUE;}//AVOID_OBJECTS
            if(flag==4){AVOID_AVATARS=TRUE;}//AVOID_AVATARS
            if(flag==5){AVOID_BREEDS=TRUE;}//AVOID_BREEDS
            if(flag==6){AVOID_LAND=TRUE;}//AVOID_LAND
            if(flag==7){AVOID_PHANTOM=TRUE;}//AVOID_PHANTOM
            if(flag==-1){AVOID_OBJECTS=TRUE;AVOID_AVATARS=TRUE;AVOID_BREEDS=TRUE;AVOID_LAND=TRUE;AVOID_PHANTOM=TRUE;}//ALL_FLAGS
        }
        if(AVOID_OBJECTS||AVOID_AVATARS||AVOID_BREEDS||AVOID_LAND|AVOID_PHANTOM){
            if(!AVOID_OBJECTS){Cast_Rejects=(Cast_Rejects|RC_REJECT_NONPHYSICAL);}//AVOID_OBJECTS
            if(!AVOID_AVATARS){Cast_Rejects=(Cast_Rejects|RC_REJECT_AGENTS);}//AVOID_AVATARS
            if(!AVOID_BREEDS){Cast_Rejects=(Cast_Rejects|RC_REJECT_PHYSICAL);}//AVOID_BREEDS
            if(!AVOID_LAND){Cast_Rejects=(Cast_Rejects|RC_REJECT_LAND);}//AVOID_LAND
            if(AVOID_PHANTOM){Cast_Phantom=[RC_DETECT_PHANTOM, 1];}//AVOID_PHANTOM
            list Cast = llCastRay(llGetPos(),dest, [RC_MAX_HITS, 1, RC_REJECT_TYPES, Cast_Rejects]+Cast_Phantom);
            if((string)Cast!="0"){_link(-163,flagged_callback); jump wait;}
        }
        @noflags;
        _link(-3,llDumpList2String([dest,type,speed,complete],"+;&"));
        jump true;
    }
    @true; 
    _link(1,"true");
    if(1==1){return;}
    @false; 
    _link(1,callback);
    @wait; 
    return;
}

key forceKey(key in){
    if(in) return in;
    return NULL_KEY;
}

_text(string msg){
    if(Text_Prim){llSetLinkPrimitiveParamsFast(Text_Prim,[PRIM_TEXT,msg,Text_Color,Text_Alpha]);}
    else{llSetText(msg,Text_Color,Text_Alpha);}
}

vector _safevector(vector pos){
    if(pos.x>256||pos.x<0||pos.y>256||pos.y<0||pos.z<0){pos=llGetPos();}//protect from crossing regions
    return pos;
}

string _trim(string str){
    return llStringTrim(str,STRING_TRIM);
}

string _replace(list a, string b, string c){
    return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);
}

float _modify(string str){
    str=_trim(str);
    string mod = llGetSubString(str,-1,-1);
    float mixed = (float)llGetSubString(str,0,-2);
    if(mod=="r"){return llFrand(mixed);}
    else if(mod=="i"){if((integer)llRound(llFrand(1))){return llFrand(mixed*-1);}else{return llFrand(mixed);}}
    return (float)str;
}

vector _modex(string str){
    list each = llParseStringKeepNulls(str,[","],[]);  
    if(llGetListLength(each)!=3){return ZERO_VECTOR;}  
    return <_modify(llList2String(each,0)),_modify(llList2String(each,1)),_modify(llList2String(each,2))>;
}

list _trimlist(list data){
    integer i;
    for(i=0;i<llGetListLength(data);i++){
        string button = _trim(llList2String(data,i));
        if(button==""){button="NULL";}
        data = llListReplaceList(data,[button],i,i);
    }
    return data;
}

list _split(string str,string start, string end, integer keep){
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

integer _inList(string val1, string val2){
    list data = llParseStringKeepNulls(_replace(["~"]," - ",_replace(["~1","~2"],"",val1)),["|"],[]);
    if(~llListFindList(data,[val2])){return TRUE;}
    return FALSE;
}

integer _attrCheck(string value, string attr){
    if(attr=="owner" && (value==owner || (key)value==llGetOwner() || llGetOwnerKey((key)value)==llGetOwner())){return TRUE;}
    if(attr=="notowner" && (value!=owner && (key)value!=llGetOwner() && llGetOwnerKey((key)value)!=llGetOwner())){return TRUE;}
    if(attr=="group" && llSameGroup(value)){return TRUE;}
    if(attr=="notgroup" && !llSameGroup(value)){return TRUE;}
    return FALSE;
}

_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}

default{
    
listen(integer ch, string name, key id, string str){
    _link(-155,name+";;"+(string)id+";;"+str);
    llListenRemove(handle);
    if(llGetListLength(menudata)==0){_link(1,chat_callback);return;}
    integer found = llListFindList(menudata,[str]);
    if(~found){_link(1,llList2String(menudata,found+1));}
    menudata=[];
} 
    
link_message(integer n, integer num, string str, key id){

    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);
        secure_channel=_encode(llList2String(data,0));
        Sound_Volume=(float)llList2String(data,4);
        Text_Color=(vector)llList2String(data,15); 
        Slope_Offset=(float)llList2String(data,63);
        Text_Prim=(integer)llList2String(data,91);
        Text_Alpha=(float)llList2String(data,92);
        Pause_Action=(integer)llList2String(data,109);
        Undefined_Value=llList2String(data,62);
        return;
    }
    if(num==_encode("set owner")){
        owner=str;
    }
    if(num==123){//properties
        Slope_Offset=(float)str;
    }
    if(num==-106){//properties
        Text_Color=(vector)str;
    }
    if(num==-107){//properties
        Sound_Volume=(float)str;
    }
    if(num==-161){
        list data = llParseStringKeepNulls(str,[":!@"],[]);
        _methods(llList2String(data,0),llList2String(data,1));
    }
}

}

