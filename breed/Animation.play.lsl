//////////////////////////////*///breed-runanims///*/////////////////////////

list run_set;
string values;//temp
integer Pause_Anims;


_each(){
    integer i;
    for(i=0;i<llGetListLength(run_set);i+=7){
        float elapsed = llGetTime();
        float limit = llList2Float(run_set,i);
        float last = llList2Float(run_set,i+4);
        if(elapsed>=limit+last){
            string namespace = llList2String(run_set,i+1);
            string params = llList2String(run_set,i+2);
            integer repeat = llList2Integer(run_set,i+3);
            integer index = llList2Integer(run_set,i+5);
            integer stages = llList2Integer(run_set,i+6);
            index++; 
            if(index==stages-1&&repeat==0){_unset(namespace);}
            else{
                if(index==stages){
                    index=0;
                    if(~repeat&&repeat!=0){repeat--;}
                }
                run_set=llListInsertList(llDeleteSubList(run_set,i+3,i+5),[repeat,elapsed,index],i+3);
            }
            _link(-160,(string)params+":?:"+(string)index);
        }
    }
}
 
  
_unset(string namespace){
    integer found = llListFindList(run_set,[namespace]);
    if(found==-1){return;}
    run_set = llDeleteSubList(run_set, found-1, found+5);
    if(llGetListLength(run_set)==0){llSetTimerEvent(0);}
}
 


string _find(string find){
    integer start = llSubStringIndex(values,find); 
    if(start==-1){return "0";}
    string data = llGetSubString(values,start+1+llStringLength(find),-1);   
    data = llGetSubString(data,0,llSubStringIndex(data,")")-1);  
    values = llDeleteSubString(values,start,start+llStringLength(find+"("+data+")")-1);           
    return _trim(data);
}

string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}
integer _encode(string val){return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);}

default{

timer(){_each();}
link_message(integer n, integer num, string str, key id){

    if(num==_encode("stop")){
        llOwnerSay("Animations stopped.");
        run_set=[];
        llSetTimerEvent(0);
    }

    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        Pause_Anims=(integer)llList2String(llParseStringKeepNulls(str,["+;&"],[""]),106);
        return;
    }
    
if(num==150 && Pause_Anims){llSleep((float)str);}
if(num==-6){
    list info = llParseStringKeepNulls(str,["+&;"],[]);
    string namespace = _trim(llList2String(info,0));
    values = _trim(llList2String(info,1));
    if(values==""){_unset(str);return;} 
    integer found = llListFindList(run_set,[namespace]);
    if(~found){_unset(namespace);}//remove duplicates
    integer stages = (integer)_find("12");         
    float delay = (float)_find("7");         
    string repeat = llToLower(_find("6"));         
    if(repeat=="0"){repeat="0";}
    else if(repeat!="-1"){repeat=(string)((integer)repeat-1);}
    run_set+=[(float)delay,namespace,values,(integer)repeat,0,-1,stages];//delay,namespace,values,repeat,last,index,stages
    values="";                                                
    llSetTimerEvent(0.1);
}
}
}
