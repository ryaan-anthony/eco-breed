//////////////////////////////*///breed-prims///*/////////////////////////

float total_growth=1.0;

string _str(list data, integer index){return llList2String(data,index);}

integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}

_params(integer prim, list params){
llSetLinkPrimitiveParamsFast(prim,params);
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
    list each = llParseStringKeepNulls(_replace(["<",">"],"",str),[","],[]);
    if(llGetListLength(each)!=3){return ZERO_VECTOR;}  
    return <_modify(llList2String(each,0)),_modify(llList2String(each,1)),_modify(llList2String(each,2))>;
}




_animate(string params,integer index){
    list data = llParseString2List(params,[")"],[]);
    params="";
    integer method = 0;
    for(method=0; method<llGetListLength(data); method++){
        string raw = _trim(llList2String(data,method));
        integer n = llSubStringIndex(raw,"("); 
        string func = _trim(llGetSubString(raw,0,n-1));
        list attrs = _split(llGetSubString(raw,n+1,-1),"<",">");
        string attr = _trim(llList2String(attrs,index+1));
        if(attr!="null" && attr!=""){
            list prims = llParseStringKeepNulls(_trim(llList2String(attrs,0)),["|"],[]);
            integer link = 0;
            for(link=0;link<llGetListLength(prims);link++){
                integer prim = (integer)_trim(llList2String(prims,link));
                if(func=="0"){
                    if(attr=="0"){attr=(string)ZERO_VECTOR;}
                    integer status = llGetStatus(STATUS_PHYSICS);
                    if(status){llSetStatus(STATUS_PHYSICS,FALSE);}
                    _params(prim,[PRIM_SIZE,((vector)attr)*total_growth]);
                    if(status){llSetStatus(STATUS_PHYSICS,TRUE);}
               }
                else if(func=="1"){
                    list flags = llParseString2List(attr,["|"],[]);
                    attr = _trim(llList2String(flags,0)); 
                    if(attr=="0"){attr=(string)ZERO_VECTOR;}
                    string rot = llList2String(flags,1);
                    if(prim==1||prim==0){attr=(string)(llGetPos()+((vector)attr*total_growth));}
                    else{attr=(string)(((vector)attr)*total_growth);}
                    if(rot!=""){_params(prim,[PRIM_POSITION,(vector)attr,PRIM_ROT_LOCAL,(rotation)rot]);}
                    else{_params(prim,[PRIM_POSITION,(vector)attr]);}
                }
                else if(func=="2"){
                    if(attr=="0"){attr=(string)ZERO_ROTATION;}                
                    _params(prim,[PRIM_ROT_LOCAL,(rotation)attr]);
               }
                else if(func=="8"){
                    if(index==0){
                        list params=llList2List(attrs,2,-1);
                        attr=llToLower(_trim(llList2String(attrs,1)));
                        if(attr=="box"||attr=="cylinder"||attr=="prism"){
                            integer prim_type = PRIM_TYPE_BOX;
                            if(attr=="cylinder"){prim_type = PRIM_TYPE_CYLINDER;}
                            else if(attr=="prism"){prim_type = PRIM_TYPE_PRISM;}
                            _params(prim,[PRIM_TYPE, prim_type,(integer)_str(params,0),(vector)_str(params,1),(float)_str(params,2),(vector)_str(params,3),(vector)_str(params,4),(vector)_str(params,5)]);
                        }
                        else if(attr=="sphere"){
                            _params(prim,[PRIM_TYPE, PRIM_TYPE_SPHERE,(integer)_str(params,0),(vector)_str(params,1),(float)_str(params,2),(vector)_str(params,3),(vector)_str(params,4)]);
                        }
                        else if(attr=="torus"||attr=="tube"||attr=="ring"){
                            integer prim_type = PRIM_TYPE_TORUS;
                            if(attr=="tube"){prim_type = PRIM_TYPE_TUBE;}
                            else if(attr=="ring"){prim_type = PRIM_TYPE_RING;}
                            _params(prim,[PRIM_TYPE, prim_type,(integer)_str(params,0),(vector)_str(params,1),(float)_str(params,2),(vector)_str(params,3),(vector)_str(params,4),(vector)_str(params,5),(vector)_str(params,6),(vector)_str(params,7),(float)_str(params,8),(float)_str(params,9),(float)_str(params,10)]);
                        }
                        else if(attr=="sculpt"){
                            integer N;
                            integer stitch;
                            list flags = llParseStringKeepNulls(_trim(_str(params,1)),["|"],[]);
                            for(N=0;N<llGetListLength(flags);N++){
                                stitch=(stitch|(integer)_str(flags,N));
                            }
                            _params(prim,[PRIM_TYPE, PRIM_TYPE_SCULPT, _str(params,0), stitch]);
                        }
                    }
                }
                else{
                    attr = _trim(llList2String(attrs,index+2));
                    if(attr!=""&&attr!="null"){
                        list faces = llParseStringKeepNulls(_trim(llList2String(attrs,1)),["|"],[]);
                        integer side;
                        integer stitch;
                        for(side=0;side<llGetListLength(faces);side++){
                            integer face = (integer)_trim(llList2String(faces,side));
                            integer getFace = face;
                            if(face==-1){getFace=0;}
                            if(func=="11"){_params(prim,[PRIM_GLOW, face, (float)attr]);}
                            else if(func=="10"){_params(prim,[PRIM_BUMP_SHINY, face, _shine(attr), 0]);}
                            else if(func=="9"){llSetLinkAlpha(prim,(float)attr,face);}
                            else if(func=="4"){
                                list flags = llParseString2List(attr,["|"],[]);
                                attr = _trim(llList2String(flags,0));
                                vector repeats = (vector)_str(flags,1);
                                vector offsets = (vector)_str(flags,2);
                                float rots = (float)_str(flags,3);
                                integer find = face;
                                if(find==-1){find=0;}
                                list params = llGetLinkPrimitiveParams(prim,[PRIM_TEXTURE,find]);
                                if(_str(flags,1)==""){repeats=(vector)_str(params,1);}
                                if(_str(flags,2)==""){offsets=(vector)_str(params,2);}
                                if(_str(flags,3)==""){rots=(float)_str(params,3);}
                                _params(prim,[PRIM_TEXTURE,face,attr,repeats,offsets,rots]);
                            }
                            else if(func=="5"){llSetLinkColor(prim,_modex(attr),face);} 
                            else if(func=="3"){stitch=(stitch|face);}
                       }
                        if(func=="3"){_params(prim,[PRIM_TYPE, PRIM_TYPE_SCULPT, attr, stitch]);}
                    }
                }
            }
        }
    }
}


 
 
 
  

integer _shine(string value){
    if(value == "high"){return 3;}
    if(value == "med"){return 2;}
    if(value == "low"){return 1;}
    return 0;
}

list _split(string str, string open, string close){
    integer i;
    string temp;
    list split;
    integer bracket = FALSE;
    for(i=0;i<llStringLength(str);i++){
        string char = llGetSubString(str,i,i);
        if(char==","&&!bracket){split+=[temp]; temp="";}
        else if(char==","&&bracket){temp+=char;}
        else if(char==open){bracket=TRUE;temp+=char;}
        else if(char==close){bracket=FALSE;temp+=char;}
        else{temp+=char;}
    }
    if(temp!=""){split+=[temp];}
    return split;
}

string _replace(list a, string b, string c){return llDumpList2String(llParseStringKeepNulls(c,a,[]),b);}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}

default{

link_message(integer n, integer num, string str, key id){

    if(num==_encode("settings") && str=="FAILED"){llResetScript();}
    if(num==_encode("rebuilt")){//remote
        list values = llParseStringKeepNulls(str,[":#%"],[""]);
        total_growth=(float)llList2String(values,17);
    }
    if(num==-160){
        list data = llParseStringKeepNulls(str,[":?:"],[""]);
        _animate(llList2String(data,0),(integer)llList2String(data,1));
    }
        
    if(num==-43){//common - growth
        list data = llParseStringKeepNulls(str,["?!@"],[""]); 
        total_growth=(float)llList2String(data,0);
    }
}
}
