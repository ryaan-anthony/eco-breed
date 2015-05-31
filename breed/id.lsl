//////////////////////////////*///breed-name/skin///*//////////////////////////
string      url="http://eco.takecopy.com/remote/1.0";
key         skin_request;
string      secure_channel;
string      Creator_Name;
integer     Skins_Min;
integer     Skins_Max;
integer     Genders;
integer     Female_Odds;
integer     Name_Generator;
integer     Name_Gender_Specific;
string      MyGender;
string      Name_Set_Object;
//list        Name_Prefix;
//list        Name_Middle;
//list        Name_Male_Suffix;
//list        Name_Female_Suffix;
list Name_Prefix=["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","R","S","T","B","C","D","G","H"];
list Name_Middle=["a","e","i","et","u","ed","oo","ou","er","ar","uo","ai","erla","erlo","uar","el","an","ey","ul","in","al","ila","ilo","erp","es","e","o","y"];
list Name_Male_Suffix=["","bo","chu","de","der","th","is","o","eem","oh","elo","oo","rp","ler","er","mo","moe","mos","id","pler","urk","obo","ple","it","e","od","rod","rix","lem","ter","ure","ox","oid","erd","nie","in","up"];
list Name_Female_Suffix=["","a","bai","chu","de","es","oo","ee","la","ela","lera","era","mo","moo","oba","ina","ita","ees","ey","ie","nie","plea","mi","zee","zai","yai","ola","ii","aa","ai","oia","oa","ni","plera","ica","ula"];
integer     Skins;
string      MyTraits;
string      MyParents;
//integer     MyGen;
string      setTYPE;
string      setSTR;
string      MyKey;
integer     Rebuilding;
string      MyName;
integer     MyGeneration;
string      skins_key;
string      skins_raw;
integer     Select_Highest_Gen;
integer     Preserve_Lineage;
string      Gender_Male;
string      Gender_Female;
string      Gender_Unisex;
list        Skin_Preferences;
integer     Clear_Lists;
vector Text_Color =<1,1,0>;
integer force_skin;

string debug_this="none";
string timestamp(){
    list timestamp = llParseString2List( llGetTimestamp(), ["T",":","Z"] , [] );
    return llList2String( timestamp, 1 )+":"+llList2String( timestamp, 2 )+":"+llList2String( timestamp, 3 );
}
_DEBUG(string str){//llOwnerSay(str);
    string add="["+timestamp()+"]("+llGetScriptName()+": "+(string)((64000-llGetUsedMemory())/1000)+"kb) ";
    _link(_encode("error.log"),add+str);
    if(~llSubStringIndex(debug_this, "id")||~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(add+str);}
}

integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}

//set gender
string _randGender(){
_DEBUG("set: gender"); 
    if(MyGender!=""){return MyGender;}
    if(Genders){
        if(~llSubStringIndex(llGetObjectDesc(),"-female")){return Gender_Female;}
        if(~llSubStringIndex(llGetObjectDesc(),"-male")){return Gender_Male;}
        integer odds = llRound(llFrand(Female_Odds));
        if(Female_Odds==-1){
            return Gender_Male;
        }
        else if((Female_Odds<0&&odds<0)||(Female_Odds>=0&&odds==0)){
            return Gender_Female;
        }
        else{
            return Gender_Male;
        }
    }
    else{return Gender_Unisex;}
}

////CREATE A NAME
string _makeName(string gender){
    if(MyName!=""){_setName(MyName);return MyName;}
    if(!Name_Generator){return llGetObjectName();}
    string prefix = llList2String(Name_Prefix,(integer)llFrand(llGetListLength(Name_Prefix)));
    string middle = llList2String(Name_Middle,(integer)llFrand(llGetListLength(Name_Middle)));
    string suffix = llList2String(Name_Male_Suffix+Name_Female_Suffix,(integer)llFrand(llGetListLength(Name_Male_Suffix+Name_Female_Suffix)));
    if(Name_Gender_Specific){
        if(gender==Gender_Female){suffix = llList2String(Name_Female_Suffix,(integer)llFrand(llGetListLength(Name_Female_Suffix)));}
        else{suffix = llList2String(Name_Male_Suffix,(integer)llFrand(llGetListLength(Name_Male_Suffix)));}
    }
_DEBUG("set: "+gender+" name "+prefix+middle+suffix); 
    return _setName(prefix+middle+suffix);
}

string _setName(string name){
    MyName=name;
    if(Clear_Lists){
       // Clear_Lists=FALSE;Name_Prefix=[];Name_Middle=[];
       // Name_Male_Suffix=[];Name_Female_Suffix=[];
    }
    if(Name_Set_Object!=""&&Name_Generator){
        if(~llSubStringIndex(Name_Set_Object,"%name%")){llSetObjectName(_replace(["%name%"],name,Name_Set_Object));}
        else if(~llSubStringIndex(Name_Set_Object,"%desc%")){llSetObjectDesc(_replace(["%desc%"],name,Name_Set_Object));}
        else{llSetObjectName(Name_Set_Object);}
    }
    return name;
}
////FIND MY GENERATION
integer _findGen(list breed){
    _DEBUG("set: generation"); 
    if(MyGeneration){return MyGeneration;}
    integer mygen=0;
    integer i;
    for(i=0;i<llGetListLength(breed);i++){//find older gens & set
        list curr_list = llParseStringKeepNulls(llList2String(breed,i),["|"],[]);
        integer gen = (integer)llList2String(curr_list,2);
        if((Select_Highest_Gen && gen>mygen)||(!Select_Highest_Gen && gen<mygen)||mygen==0){mygen=gen;}
    }
    mygen++;//increment gen 
    return mygen;
}
          
     
////GENETIC STRING
_setBreedskin(string type, string str){
    
    //set generation
    list breed = llParseStringKeepNulls(str,["&&"],[]);
    MyGeneration = _findGen(breed);
    
    //end if skins are DISABLED
    integer NumSkins = _randNum(Skins_Min,Skins_Max);
    if(!Skins||!NumSkins){
        _DEBUG(type+": skins are disabled");
        _jumpFinished("None","");
        return;
    }
    
    //save input for re-starting the sequence
    _DEBUG(type+": requesting skins from webserver");
    setTYPE=type;
    setSTR=str;
    
    //find child input
    if(str!="null"){
        //separate parents from grandparents
        if(llGetListLength(breed)>1){
            MyParents=llList2String(breed,0)+"&&"+llList2String(breed,1);
        }
        //preserve lineage or pick new skin
        if(!Preserve_Lineage&&type=="child"){
            type="parent";
            str="null";
        }
    }
    
    //send request
    skin_request = llHTTPRequest(url+
            "?skin_type="+type
            +"&name="+llEscapeURL(Creator_Name)
            +"&skin_channel="+llEscapeURL(secure_channel)
            +"&skin_pref="+llEscapeURL(llDumpList2String(Skin_Preferences,","))
            +"&skin_string="+llEscapeURL(str)
            +"&skin_gen="+llEscapeURL((string)MyGeneration)
            +"&skin_num="+llEscapeURL((string)NumSkins), 
            [ ], 
        "" 
    );
}

_skinContinued(){
    _DEBUG("sending additional requests to webserver");    
    skin_request = llHTTPRequest(url+"?params_key="+skins_key, [ ], "" );
}

//FINISH BREED CREATION
_jumpFinished(string skins, string params){
    if(params!=""){_link(-160,params);}
    if(force_skin){force_skin=FALSE;return;}
    string gender = _randGender();
    _DEBUG("saving unique breed information"); 
    _link(_encode("breed created"),
        llDumpList2String([
            MyGeneration,
            skins,
            MyParents,
            gender,
            _makeKey(),
            _makeName(gender),
            Rebuilding
        ],"+;&")
    );
}


////FUNCTIONS: LINK, TRIM, SKINNUM, GENDER
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}
integer _randNum(integer min, integer max){integer n = llRound(llFrand(max));if(n<min){n=min;}return n;}


//GENERATE UNIQUE KEY
string _makeKey(){
_DEBUG("set: unique id"); if(MyKey!=""){return MyKey;}string base = uniqid((string)llGetUnixTime()+(string)llGetKey());string hash = llMD5String(base,(integer)llFrand(99));return llGetSubString(mixcase(mixval(hash)),0,20+(integer)llFrand(6));}
string uniqid(string value){return (string)(((integer)("0x" + llGetSubString(value, -9, -2)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}
string mixval(string val){integer total = llStringLength(val);string temp;integer i;for(i=0; i<total; i++){integer rand = (integer)llFrand(total);temp+=llGetSubString(val,rand,rand);}return temp;}
string mixcase(string str){string temp="";integer i;for(i=0; i<llStringLength(str); i++){if(llRound(llFrand(1))==1){temp+=llToUpper(llGetSubString(str,i,i));}else{temp+=llToLower(llGetSubString(str,i,i));}}return temp;}
 
////HANDLE LINKED REQUESTS
default{
link_message(integer n, integer num, string str, key id){
    
    if(num==_encode("debug_this")){
        debug_this=str;
        _DEBUG("debug enabled for \""+llGetScriptName()+"\"");
    }
    else if(num == _encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        secure_channel=llList2String(data,0);//cannot change
        Text_Color=(vector)llList2String(data,15); 
        Skins_Min=(integer)llList2String(data,44);
        Skins_Max=(integer)llList2String(data,45);
        Genders=(integer)llList2String(data,39);
        Female_Odds=(integer)llList2String(data,40);
        Name_Generator=(integer)llList2String(data,53);
        Name_Gender_Specific=(integer)llList2String(data,54);
        Name_Set_Object=llList2String(data,55);
        if(llList2String(data,56)!=""){Name_Prefix=llParseStringKeepNulls(llList2String(data,56),[","],[]);}
        if(llList2String(data,57)!=""){Name_Middle=llParseStringKeepNulls(llList2String(data,57),[","],[]);}
        if(llList2String(data,58)!=""){Name_Male_Suffix=llParseStringKeepNulls(llList2String(data,58),[","],[]);}
        if(llList2String(data,59)!=""){Name_Female_Suffix=llParseStringKeepNulls(llList2String(data,59),[","],[]);}
        Skins=(integer)llList2String(data,43);
        Creator_Name=llToLower(llList2String(data,60));//cannot change
        Select_Highest_Gen=(integer)llList2String(data,64);
        Preserve_Lineage=(integer)llList2String(data,65);
        Gender_Male=llList2String(data,88);
        Gender_Female=llList2String(data,89);
        Gender_Unisex=llList2String(data,90);
        Skin_Preferences=llParseString2List(llList2String(data,105),[","],[]);
        if(llList2String(data,114)!=""){url=llList2String(data,114);}
        return;
    }
    else if(num == _encode("first rez")){
        Clear_Lists=TRUE;
    }

    else if(num==-90){
        _DEBUG("remote set: name "+str); 
        _setName(str);
    }
    else if(num==_encode("rebuilt")){//remote
        list values = llParseStringKeepNulls(str,[":#%"],[""]);
        _DEBUG("rebuild set: name "+llList2String(values,0));
        _setName(llList2String(values,0));
        MyGender=llList2String(values,2);
        MyParents=llList2String(values,7);
        MyGeneration=(integer)llList2String(values,9);
        MyKey=llList2String(values,22);
        Rebuilding=TRUE;
        _setBreedskin("rebuild",llList2String(values,5));        
    }
    else if(num==_encode("parent skin")){//parent
        if(str!="keep stats"){
            MyName="";
            MyKey="";
            MyGender="";
            MyParents="";
            MyGeneration=0;
        }
        else{
            force_skin=TRUE;
        }
        _setBreedskin("parent","null");
    }
    else if(num==_encode("child skin")){//child
        _setBreedskin("child",str);
    }
}

http_response(key id, integer status, list meta, string body){
    body=_trim(body);
    if(id!=skin_request){return;}//llOwnerSay("skin: "+body);
    if(body=="destroy"||body=="die"){llDie();}
    if(status!=200||~llSubStringIndex(body,"<b>Warning</b>")||body==""){
        if(~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(body);}
        skins_raw="";
        llSleep(600);
        _setBreedskin(setTYPE, setSTR);
        return;
    }
    list data = llParseStringKeepNulls(body,["!@#"],[""]);
    body="";
    skins_key=llList2String(data,0);
    skins_raw+=llList2String(data,1);
    if(~llSubStringIndex(skins_raw,"{D}")){
        skins_raw=_replace(["{D}"],"",skins_raw);
        data = llParseStringKeepNulls(skins_raw,[":#%"],[""]);
        skins_raw="";
        Skin_Preferences=[];
        _jumpFinished(llList2String(data,0), llList2String(data,1));
    }
    else{llSleep(1);_skinContinued();}
}
}

