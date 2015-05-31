//////////////////////////////*///breed-lifecycle///*//////////////////////////
integer     MyAge;
//integer     secure_channel;
integer     MyGeneration;
string      MySkins;
string      MyParents;
string      MyGender;
string      breed_id;
string      breed_name;
integer     MyLitters;
integer     MyHunger;
integer     Require_Partners;
integer     Unique_Partner;
integer     Breed_Litters;
integer     Breed_Age_Min;
integer     Breed_Age_Max;
integer     Breed_Failed_Odds;
integer     Breed_Litter_Min;
integer     Breed_Litter_Max;
integer     Breed_Litter_Rare;
integer     BREEDING;
integer     BREEDING_EXPIRE;
string      breedstring;
integer     Keep_Partners;
string      MyPartner;
string      FindPartner;
integer     Genders;
integer     Lifespan_Age_Start;
integer     CRATED_BIRTH;
integer     TIMER = 5;
integer     Time_Count;
integer     Lifespan;
integer     Lifespan_Year;
integer     Lifespan_Survival_Odds;
integer     Lifespan_Age_Min;
integer     Lifespan_Age_Max;
integer     Timer_Breed;
integer     Timer_Age;
integer     Timer_Grow;
integer     Timer_Hunger;
integer     Hunger_Consume_Time;
integer     Breed_Time;
integer     Growth_Timescale;
string      owner;
integer     timeofBirth;
integer     timeofDeath;
integer     notDead = TRUE;
integer     Growth_Stages;
integer     Breed_Ready;
integer     Partner_Timeout;
integer     Pregnancy_Timeout;
integer     Partner_Timeout_Cycles;
string      saved_breedstring;
integer     Pregnancy_Time;
integer     Timer_Pregnancy;
integer     Pregnant_Partner;
string      Gender_Male;
string      Gender_Female;
string      Gender_Unisex;
string      Undefined_Value;
integer     Pause_Core;


string debug_this;
string timestamp(){
    list timestamp = llParseString2List( llGetTimestamp(), ["T",":","Z"] , [] );
    return llList2String( timestamp, 1 )+":"+llList2String( timestamp, 2 )+":"+llList2String( timestamp, 3 );
}
_DEBUG(string str){
    str="["+timestamp()+"]("+llGetScriptName()+": "+(string)((64000-llGetUsedMemory())/1000)+"kb) "+str;
    _link(_encode("error.log"),str);
    if(~llSubStringIndex(debug_this, "process")||~llSubStringIndex(llGetObjectDesc(), "-debug")){llOwnerSay(str);}
}


string _replace(list a, string b, string c){
    return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);
}

integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}
_saveValues(){
    _DEBUG("saving timers..");
    _link(_encode("save timers"), 
        llDumpList2String([
            notDead,
            Timer_Age,
            Timer_Breed,
            Timer_Grow,
            Timer_Hunger,
            timeofBirth,
            timeofDeath
        ],"?!@")
    );  
}

_die(){
_DEBUG("breed died");// dead
    timeofDeath = llGetUnixTime();
    notDead=FALSE; 
    _link(2,"dead");
}

string _trim(string str){
    return llStringTrim(str,STRING_TRIM);
}

revive(){
_DEBUG("breed revived");// dead
    timeofDeath=0;
    Timer_Age=llGetUnixTime();
    Timer_Breed=llGetUnixTime();
    Timer_Grow=llGetUnixTime();
    Timer_Hunger=llGetUnixTime();
    _link(2,"start");
}



_eventBreed(){
_DEBUG("breed event");
    Breed_Ready=TRUE;
    if(MyAge<Breed_Age_Min){
_DEBUG("too young to breed");// not breeding age
        return;
    }
    if(MyAge>Breed_Age_Max&&~Breed_Age_Max){
_DEBUG("too old to breed");// not breeding age
        return;
    }
    if(!Require_Partners){
_DEBUG("asexual");// asexual
        _breedingCall("");
        return;
    }
    if(MyGender!=Gender_Female&&(MyPartner!=""||FindPartner!=""||!Keep_Partners)){
_DEBUG("send mating call");// mating call
        _matingCall();
    }
    if(MyGender!=Gender_Male&&Keep_Partners){
        if(MyPartner==""){
_DEBUG("female: look for partner");// look for partner
            _link(5,"find-mate+;?single;+;"+breed_id+";+;"+breed_name);
        }
        else if(Partner_Timeout){
            Partner_Timeout_Cycles++;
            if(Partner_Timeout_Cycles==Partner_Timeout){
_DEBUG("female: leave partner");// leave partner
                MyPartner=""; 
                _link(-49,MyPartner);
                _link(-124,"Undefined");
                Partner_Timeout_Cycles=0;
            }
            else{
_DEBUG("female: without partner for "+(string)Partner_Timeout_Cycles+" cycles");//without partner
            }
        }
    }
}

_matingCall(){
    string parent;
    if(MyParents!=""){parent="&&"+MyParents;}
    string look = FindPartner;
    integer saved = FALSE;
    if(MyPartner!=""){
        look=MyPartner;
        saved = TRUE;
        if(Partner_Timeout){
            Partner_Timeout_Cycles++;
            if(Partner_Timeout_Cycles==Partner_Timeout){
_DEBUG("male: leave partner");// leave partner
                MyPartner=""; 
                _link(-49,MyPartner);
                _link(-124,"Undefined");
                Partner_Timeout_Cycles=0;
                return;
            }
            else{
_DEBUG("male: without partner for "+(string)Partner_Timeout_Cycles+" cycles");//without partner
            }
                
        }
    }
_DEBUG("male: look for partner");//look for partner
    _link(5,"find-mate+;?"+breed_id+"|"+breed_name+"|"+(string)MyGeneration+"|"+MyGender+"||"+parent+";/;"+look+";/;"+(string)saved);
} 


_breedingCall(string add){//trigger custom action event
    if(~llSubStringIndex(add,"single;+;")){return;}//mating call detected, ignore
    if(MyGender==Gender_Male){//males dont breed
_DEBUG("male: finished breeding protocol");
        Breed_Ready=FALSE;
        return;
    }
    if(!Breed_Ready){
_DEBUG("female: not ready to breed");
        return;
    }
    if(Unique_Partner && _isFamily(add)){
_DEBUG("female: disable incest");
        return;
    }//disable incest
    if(MyLitters>=Breed_Litters&&~Breed_Litters){
_DEBUG("female: max litters");
        return;
    }//disallow excessive births
    if(BREEDING){
        if(BREEDING_EXPIRE<=llGetUnixTime()){
_DEBUG("female: previous breeding protocol timed out");
            BREEDING=FALSE;
        }
        else{
_DEBUG("female: currently breeding");
            return;
        }
    }//disallow multiple births
    if((integer)llFrand(Breed_Failed_Odds)!=0){
_DEBUG("female: failed birth");
        return;
    }//random failed birth
    integer rand = llRound(llFrand(Breed_Litter_Max));//create litter size
    if(Breed_Litter_Rare){rand-=llRound(llFrand(Breed_Litter_Min));}//rare litter size
    if(rand<Breed_Litter_Min){rand=Breed_Litter_Min;}//minimum litter size
    list send = [breed_id+"|"+breed_name+"|"+(string)MyGeneration+"|"+MyGender+"||"];
    if(add!=""){send += [add];}
    if(MyParents!=""){send += [MyParents];}
    BREEDING=TRUE;
    Breed_Ready=FALSE;
    BREEDING_EXPIRE=llGetUnixTime()+20;
    breedstring="selectnest+;?"+(string)rand+"+;&"+llDumpList2String(send,"&&");
_DEBUG("female: looking for birth object");
    _link(5,"breed+;?"+breed_id);
    //string name = llGetObjectName();
    //llSetObjectName("breed");
    //llRegionSay(secure_channel,breed_id);
    //llSetObjectName(name);
}


integer _isFamily(string new){
    list keys;
    list mykeys=[breed_id];
    list other = llParseStringKeepNulls(new,["&&"],[]);
    integer i;
    for(i=0; i<llGetListLength(other);i++){
        list data = llParseStringKeepNulls(llList2String(other,i),["|"],[]);
        keys+=[llList2String(data,0)];
    }
    if(MyParents!=""&&MyParents!="None"){
        other = llParseStringKeepNulls(MyParents,["&&"],[]);
        for(i=0; i<llGetListLength(other);i++){
            list data = llParseStringKeepNulls(llList2String(other,i),["|"],[]);
            mykeys+=[llList2String(data,0)];
        }
    }
    for(i=0; i<llGetListLength(mykeys);i++){
        if(~llListFindList(keys,[llList2String(mykeys,i)])){return TRUE;}
    }
    return FALSE;   
}


    

integer _expired(integer time, integer limit){
    if((llGetUnixTime()-time)/60>=limit){return TRUE;}
    return FALSE;
}

_eventAge(){
    integer adjust = ((llGetUnixTime()-timeofBirth)/60)/Lifespan_Year;
    if(MyAge!=adjust){
        MyAge = adjust;    
        _link(-31,(string)MyAge);    
_DEBUG("age set to "+(string)MyAge);// birthday
    }
    if(~Lifespan_Survival_Odds && ((MyAge>=Lifespan_Age_Min && (integer)llFrand(Lifespan_Survival_Odds)==0) || (MyAge>=Lifespan_Age_Max && ~Lifespan_Age_Max))){_die();}
}

_runTimerEvents(){
    integer end_session;
    if(~llSubStringIndex(llGetObjectDesc(),"-rebuild")){
        llSetObjectDesc(_replace(["-rebuild"],"",llGetObjectDesc()));        
        llSleep(2);
        _link(_encode("reset"),breed_id);
        end_session = TRUE;
    }
    if(~llSubStringIndex(llGetObjectDesc(),"-reset")){
        llSetObjectDesc(_replace(["-reset"],"",llGetObjectDesc()));        
        _link(_encode("reset"),"reset");
        end_session = TRUE;
    }
    if(~llSubStringIndex(llGetObjectDesc(),"-start")){
        llSetObjectDesc(_replace(["-start"],"",llGetObjectDesc()));
        _link(_encode("start"),"");
    }
    if(~llSubStringIndex(llGetObjectDesc(),"-dump")){
        llSetObjectDesc(_replace(["-dump"],"",llGetObjectDesc()));
        _link(_encode("dump"),"");
        
    }
    if(~llSubStringIndex(llGetObjectDesc(),"-skin")){
        llSetObjectDesc(_replace(["-skin"],"",llGetObjectDesc()));
        _link(_encode("parent skin"),"keep stats");
        
    }
    if(~llSubStringIndex(llGetObjectDesc(),"-stop")){
        llSetObjectDesc(_replace(["-stop"],"",llGetObjectDesc()));
        _link(_encode("stop"),"");
        end_session = TRUE;
    }
    if(~llSubStringIndex(llGetObjectDesc(),"-refresh")){
        llSetObjectDesc(_replace(["-refresh"],"",llGetObjectDesc()));
        _link(_encode("refresh"),"");
        integer currTime = llGetUnixTime();
        Timer_Breed=currTime;
        Timer_Age=currTime;
        Timer_Grow=currTime;
        Timer_Hunger=currTime;
        end_session = TRUE;
    }
    
    if(end_session){return;}
    Time_Count++;
    if(Time_Count<12){return;}
    Time_Count = 0;
    
    if(notDead){
        //age
        if(Lifespan){
            if(_expired(Timer_Age,Lifespan_Year)){_eventAge();Timer_Age=llGetUnixTime();}
        }
        else{Timer_Age=llGetUnixTime();}
        //breed
        if(Pregnancy_Time){
            if(_expired(Timer_Pregnancy,Pregnancy_Time)){
                Pregnancy_Time=0;
_DEBUG("female: give birth");
                _link(-172,"0");
                _link(5,saved_breedstring);//selectnest            
            }
        }
        else if(Breed_Time && !Pregnant_Partner){
            if(_expired(Timer_Breed,Breed_Time)){
                _link(_encode("Maturity"),(string)((Breed_Time*60)+llGetUnixTime()));
                _eventBreed();
                Timer_Breed=llGetUnixTime();
            }
        }
        else{Timer_Breed=llGetUnixTime();}
        //grow
        if(Growth_Stages){
            if(_expired(Timer_Grow,Growth_Timescale)){_link(-11,"grow");Timer_Grow=llGetUnixTime();}
        }
        else{Timer_Grow=llGetUnixTime();}
        //hunger
        if(Hunger_Consume_Time){
            if(_expired(Timer_Hunger,Hunger_Consume_Time)){
                _link(-13,"hungry");
                _link(_encode("Appetite"),(string)((Hunger_Consume_Time*60)+llGetUnixTime()));
                Timer_Hunger=llGetUnixTime();
            }
        }
        else{Timer_Hunger=llGetUnixTime();}
    }
    _saveValues();
}

_link(integer n, string str){
    llMessageLinked(LINK_THIS, n, str, "");
}


default{
on_rez(integer n){
    if(n==-2){CRATED_BIRTH=TRUE;}
}

timer(){
    _runTimerEvents();
}
link_message(integer n, integer num, string str, key id){
    
    if(num==_encode("debug_this")){
        debug_this=str;
        _DEBUG("debug enabled for \""+llGetScriptName()+"\"");
    }
    
    else if(num==_encode("set owner")){
        owner=str;
    }
    
    //settings from auth
    else if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]);
        Require_Partners=(integer)llList2String(data,41);
        Unique_Partner=(integer)llList2String(data,42);
        Breed_Failed_Odds=(integer)llList2String(data,35);
        Breed_Litter_Min=(integer)llList2String(data,36);
        Breed_Litter_Max=(integer)llList2String(data,37);
        Breed_Litter_Rare=(integer)llList2String(data,38);
        Breed_Litters=(integer)llList2String(data,48);
        Breed_Age_Min=(integer)llList2String(data,49); 
        Breed_Age_Max=(integer)llList2String(data,50);
        Keep_Partners=(integer)llList2String(data,52);
        Genders=(integer)llList2String(data,39);
        Lifespan_Age_Start=(integer)llList2String(data,47);
        Growth_Stages=(integer)llList2String(data,22);
        Lifespan=(integer)llList2String(data,18);
        Lifespan_Age_Min=(integer)llList2String(data,19);
        Lifespan_Age_Max=(integer)llList2String(data,20);
        Lifespan_Survival_Odds=(integer)llList2String(data,21);
        Lifespan_Year=(integer)llList2String(data,46);
        Growth_Timescale=(integer)llList2String(data,24);
        Hunger_Consume_Time=(integer)llList2String(data,26);
        Breed_Time=(integer)llList2String(data,34);
        Partner_Timeout=(integer)llList2String(data,71);
        Pregnancy_Timeout=(integer)llList2String(data,72);
        Gender_Male=llList2String(data,88);
        Gender_Female=llList2String(data,89);
        Gender_Unisex=llList2String(data,90);
        Undefined_Value=llList2String(data,62);
        Pause_Core=(integer)llList2String(data,108);
        _link(_encode("Appetite"),(string)((Hunger_Consume_Time*60)+llGetUnixTime()));
        _link(_encode("Maturity"),(string)((Breed_Time*60)+llGetUnixTime()));
    }

    //skin and breed info from #ID
    else if(num==_encode("breed created")){
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        MyGeneration=(integer)llList2String(data,0);    
        MySkins=llList2String(data,1);                  
        MyParents =llList2String(data,2);
        MyGender=llList2String(data,3);                 
        breed_id=llList2String(data,4);                    
        breed_name=llList2String(data,5);   
        integer Rebuilding = (integer)llList2String(data,6);
        // breed created
        if(!Rebuilding||CRATED_BIRTH){
            // new born
            timeofBirth = llGetUnixTime();
            integer currTime = llGetUnixTime();
            _link(_encode("Maturity"),(string)((Breed_Time*60)+llGetUnixTime()));
            _link(_encode("Appetite"),(string)((Hunger_Consume_Time*60)+llGetUnixTime()));
            Timer_Breed=currTime;
            Timer_Age=currTime;
            Timer_Grow=currTime;
            Timer_Hunger=currTime;                      
            MyAge=Lifespan_Age_Start;
            _link(-31,(string)MyAge);  
        }
        llSetTimerEvent(TIMER); 
        _saveValues();  
    }
    
    //save status from #PROCESS
    else if(num==_encode("save timers")){
        notDead=(integer)llList2String(llParseStringKeepNulls(str,["?!@"],[""]),0);
    }
    
    else if(num==_encode("rebuilt")){//remote
        list values = llParseStringKeepNulls(str,[":#%"],[""]);
        breed_name=llList2String(values,0);//t1.breed_name
        _link(_encode("partner_owner"),llList2String(values,1));//t2.owner_name as partner_owner,"./* NEW */"
        MyGender=llList2String(values,2);//t1.breed_gender,
        MyAge=(integer)llList2String(values,3);//t1.breed_age
        
        if(!CRATED_BIRTH){
            _DEBUG("breed rebuilt "+breed_name);// rebuilt
            MyHunger=(integer)llList2String(values,6);
            Growth_Stages=(integer)llList2String(values,18);
            MyPartner=llList2String(values,23);
        }
        else{
            _DEBUG("breed born from eco-crate "+breed_name);// breed born from eco-crate
            MyPartner="";
        }
            
            
            
            
        MySkins=llList2String(values,5);//t1.breed_skins,
        MyParents=llList2String(values,7);
        MyGeneration=(integer)llList2String(values,9);
        MyLitters=(integer)llList2String(values,15);
        breed_id=llList2String(values,22);
        _link(_encode("Maturity"),(string)((Breed_Time*60)+llGetUnixTime()));
        _link(_encode("Appetite"),(string)((Hunger_Consume_Time*60)+llGetUnixTime()));
        Timer_Breed=(integer)llList2String(values,10);
        Timer_Age=(integer)llList2String(values,11);
        Timer_Grow=(integer)llList2String(values,12);
        Timer_Hunger=(integer)llList2String(values,13);
        notDead=(integer)llList2String(values,14);
        timeofBirth=(integer)llList2String(values,20);
        timeofDeath=(integer)llList2String(values,21);
        if(notDead){_eventAge();}
    }
        
    else if(num==150 && Pause_Core){
        llSleep((float)str);
    }
    else if(num==-121){//revive
        list values = llParseStringKeepNulls(str,[","],[""]);
        string years = _trim(llList2String(values,0));
        string food = _trim(llList2String(values,1));
        _DEBUG("revive breed with +"+years+" years and "+food+" hunger level");// revive
        if((integer)years!=0){Lifespan_Age_Min+=(integer)years;if(~Lifespan_Age_Max){Lifespan_Age_Max+=(integer)years;}}
        if((integer)food!=0){MyHunger+=(integer)food;if(MyHunger>100){MyHunger=100;}}
        revive();
        notDead=TRUE;
        _link(-122,(string)MyHunger);
        _saveValues();
    }
    else if(num==139){
        notDead=(integer)str;
        if(!notDead){_die();}
        else{revive();}
        _saveValues();
    }
    else if(num==136){Partner_Timeout=(integer)str;}
    else if(num==137){Pregnancy_Timeout=(integer)str;}
    else if(num==131){Breed_Litter_Min=(integer)str;}
    else if(num==132){Breed_Litter_Max=(integer)str;}
    else if(num==133){Breed_Litter_Rare=(integer)str;}
    else if(num==134){Breed_Age_Min=(integer)str;}
    else if(num==135){Breed_Age_Max=(integer)str;}
    else if(num==-130){Lifespan=(integer)str;Timer_Age=llGetUnixTime();}
    else if(num==-131){Lifespan_Age_Min=(integer)str;}
    else if(num==-132){Lifespan_Age_Max=(integer)str;}
    else if(num==-105){Growth_Timescale=(integer)str;Timer_Grow=llGetUnixTime();}
    else if(num==-108){Lifespan_Survival_Odds=(integer)str;}
    else if(num==-100){_die(); _saveValues();}
    else if(num==-90){breed_name=str;}
    else if(num==-93){MySkins=str;}
    else if(num==-109){Growth_Stages=(integer)str;}
    else if(num==-116){Breed_Failed_Odds=(integer)str;}
    else if(num==-117){Breed_Litters=(integer)str;}
    else if(num==-115){
        _link(_encode("Maturity"),(string)(((Breed_Time=(integer)str)*60)+(Timer_Breed=llGetUnixTime())));
    }
    else if(num==-112){
        _link(_encode("Appetite"),(string)(((Hunger_Consume_Time=(integer)str)*60)+(Timer_Hunger=llGetUnixTime())));
    }
    
    //// BREEDING
    
    else if(num==-171 && llList2String(llParseStringKeepNulls(str,["&+&"],[]),2)==MyPartner){
        if(Require_Partners){
            _DEBUG("male: female partner gave birth "+MyPartner);// male: female partner gave birth
            Pregnant_Partner=FALSE;
        }
    }
    else if(num==-170){
        if(str==MyPartner){
            _DEBUG("male: female partner contacted "+str);// male: female partner contacted
            if(Require_Partners && Pregnancy_Timeout){
                _DEBUG("male: female partner is pregnant "+str);// male: female partner is pregnant
                Pregnant_Partner=TRUE;
            }
            Partner_Timeout_Cycles=0;
        }
        else{
            _DEBUG("not my partner "+str);// not my partner      
        }
    }
    else if(num==-10 && !Pregnancy_Time && !Pregnant_Partner){
        list data = llParseStringKeepNulls(str,[";+;"],[]);
        if(llGetListLength(data)==3){
            string self = llList2String(data,0);
            string partner = llList2String(data,1);
            string partnername = llList2String(data,2);
            _DEBUG("heard mating call from "+partnername+" ("+partner+")");// mating call
            if(MyPartner==""){
                if(self==breed_id){
                    MyPartner=partner;
                    _link(-49,MyPartner);
                    _link(-124,partnername);
                    _DEBUG("set partner "+partnername);// set partner
                }
                else if(self=="single"){
                    FindPartner=partner;
                    _DEBUG("attempt to partner "+partnername);// attempt to partner
                }
            }
        }
        else{
            _DEBUG("heard breeding call");// breeding call
            data = llParseStringKeepNulls(str,[";"],[""]);
            if(llList2String(data,0)=="birthobject"){
                if(BREEDING){
                    BREEDING=FALSE;
                    BREEDING_EXPIRE=0;
                    saved_breedstring=breedstring+"&+&"+llList2String(data,1)+"&+&"+breed_id+"&+&"+(string)llGetKey();
                    if(Pregnancy_Timeout){
                        _DEBUG("female: pregnant");// female: pregnant
                        Pregnancy_Time=Pregnancy_Timeout;
                        Timer_Pregnancy=llGetUnixTime();
                        _link(-172,(string)(Timer_Pregnancy+(Pregnancy_Time*60)));//pregnant time regex
                        _link(2,"pregnant;"+llList2String(data,1));//pregnant event
                    }
                    else{
                        _DEBUG("female: give birth");// female: give birth
                        _link(5,saved_breedstring);//selectnest
                    }
                }
                return;
            }
            _DEBUG("female: gave birth");// female: gave birth
            if(str=="birth"){
                MyLitters++;
                _link(-60,(string)MyLitters);
                return;
            }
            if(MyAge<Breed_Age_Min){
                _DEBUG("too young to breed");// not breeding age
                return;
            }
            if(MyAge>Breed_Age_Max&&~Breed_Age_Max){
                _DEBUG("too old to breed");// not breeding age
                return;
            }
            list info = llParseStringKeepNulls(str,[";/;"],[""]);
            string add = llList2String(info,0);
            string self = llList2String(info,1);
            string saved = llList2String(info,2);
            if(!Keep_Partners||add==""){
                _DEBUG("skip partner filter");// skip partner filter
                jump breedcall;
            }
            data = llParseStringKeepNulls(add,["|"],[]);
            _DEBUG("partner filter");// partner filter
            string partner=llList2String(data,0);
            string partnername=llList2String(data,1);
            if(MyPartner!=partner&&MyPartner!=""){
                _DEBUG(partnername+" is not my partner");// not my partner
                return;
            }
            if(MyPartner==partner){
                _DEBUG("female: found my partner "+partnername);// female: found my partner
                _link(-124,partnername);
                Partner_Timeout_Cycles=0;
                jump breedcall;
            }
            if(MyPartner==""&&Keep_Partners&&_isFamily(add)){
                _DEBUG(partnername+"is family; incest disabled");// disable incest
                return;
            }
            if(self==breed_id){
                _DEBUG("female: found partner "+partnername);// female: set as partner 
                MyPartner=partner;
                _link(-49,MyPartner);
                _link(-124,partnername);
                if((integer)saved==FALSE){
                    _DEBUG("female: confirm partner "+partnername); // female: confirm partner 
                    _link(5,"find-mate+;?"+partner+";+;"+breed_id+";+;"+breed_name);
                }
            }
            else{
                _DEBUG("not my partner "+partnername);// not my partner
                return;
            }
            @breedcall;
            _DEBUG("breeding call");// breeding call
            _breedingCall(add);
        }
    } 
}
}

