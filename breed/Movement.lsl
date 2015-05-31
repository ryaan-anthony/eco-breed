////////////////////////////////*///breed physics///*/////////////////////////
vector AXIS_FWD = <1,0,0>;
//float strength = 0.2;//turning strength 
//float damping = 0.2;//turning damping 
list movecache;
float Move_Timer;
float movewalk;
float moverun;
float movejump;
float moveswim;
float movehop;
float movehover;
float movefly;
float movefloat;
float movesetpos;
integer Move_Attempts;
integer thottle_water_start;
integer out_of_water=FALSE;
integer Attempts;
vector Last;
float nonphys;
float nonphysUp;
float Target_Dist_Min;
integer Finish_Move;
integer Allow_Drift;
float Turning_Efficiency;
float Turning_Time;
integer Legacy_Prims;
integer Growing;
float Gravity_walk;
float Gravity_run;
float Gravity_jump;
float Gravity_hop;
float Gravity_swim;
float Gravity_float;
float Gravity_hover;
float Gravity_fly;
float Ground_Friction;
integer Pause_Move;
integer Anim_Each_Move;
integer End_Move_Physics;


_anim(integer num, list data){
    string start =_trim(llList2String(data,1));
    string end =_trim(llList2String(data,2));
    if(num==-5 && start!=""){_link(-5,start);}
    if(num==-6 && start!=""){_link(-6,start);if(end!=""){_link(-5,end);}}
}
_move(){
    if(Growing){return;};
    integer framed;
    integer failed;
    vector dest = llList2Vector(movecache,0);
    string type = llList2String(movecache,1);
    float speed = llList2Float(movecache,2);
    string complete = llList2String(movecache,3);
    float dist = llVecDist(llGetPos(), dest);
    if(out_of_water){
        if(_inWater()){out_of_water=FALSE;_link(2,"water_start");}
        else if(type==""){return;}
    }
    list data = llParseString2List(type,["|"],[]);
    type = _trim(llList2String(data,0));
    if(Anim_Each_Move){_anim(-5,data);}
    if(llListFindList(["setpos","warp","nonphys","nonphysUp"],[type])==-1){
        if(dist < Target_Dist_Min && !Allow_Drift){speed=0;}
        _params(type,llRound(dist));
        llRotLookAt(_axis2rot(AXIS_FWD, dest), Turning_Efficiency, Turning_Time);
        llSleep(0.1);
        llStopLookAt();
        if(type=="jump"||type=="hop"){_jump(speed);speed*=0.05;}
        llSetVehicleVectorParam(VEHICLE_LINEAR_MOTOR_DIRECTION, <speed,0,0>);
    }
    else if(~llListFindList(["nonphys","nonphysUp"],[type]) && !Legacy_Prims){
        framed=TRUE;
        llSetStatus(STATUS_PHYSICS,FALSE);
        vector pos = llGetPos();
        vector distance = (pos-dest)*-1;
        if(speed<0.1){speed=0.1;}
        rotation rot = llRotBetween(AXIS_FWD, llVecNorm(<dest.x,dest.y,pos.z>-pos));
        if(type=="nonphysUp"){rot = llRotBetween(AXIS_FWD, llVecNorm(<dest.x,dest.y,dest.z>-pos));}
        llSetKeyframedMotion([] ,[KFM_COMMAND, KFM_CMD_STOP]);
        llSetLocalRot(rot);
        llSetKeyframedMotion([distance,speed], [KFM_DATA, KFM_TRANSLATION, KFM_MODE,KFM_FORWARD]);    
    }
    else{
        llSetStatus(STATUS_PHYSICS,FALSE);
        if(type=="warp"){if(!llSetRegionPos(dest)){failed = TRUE;}}
        else{
            vector pos = llGetPos();
            rotation rot = llRotBetween(AXIS_FWD, llVecNorm(<dest.x,dest.y,pos.z>-pos));
            llRotLookAt(rot,1.0,0.4);
            llSetPos(<speed,0,0>*rot+pos);
        }
    }
    if(llVecDist(Last,llGetPos())<1){Attempts++;}
    else{Attempts=0;Last=llGetPos();}
    if(failed || (framed&&dist<0.5) || (!framed &&dist < Target_Dist_Min) || (Attempts>= Move_Attempts && ~Move_Attempts)){
        llSetTimerEvent(0);
        if(complete!=""&&complete!="true"){_link(2,complete);}
        Attempts=0;
        _anim(-6,data);
        movecache=[];
        if(llGetStatus(STATUS_PHYSICS) && !End_Move_Physics){llSetStatus(STATUS_PHYSICS,FALSE);}
        if(!llGetStatus(STATUS_PHYSICS)&&!Legacy_Prims){llSetKeyframedMotion([] ,[KFM_COMMAND, KFM_CMD_STOP]);}
        return;
    }
    llSetTimerEvent(Move_Timer);
}
 
 

_clearParams(){
    llSetVehicleType(VEHICLE_TYPE_NONE);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_EFFICIENCY, 0); 
    llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_EFFICIENCY, 0);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_TIMESCALE, 0);
    llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_TIMESCALE, 0);
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_TIMESCALE, 0);
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_DECAY_TIMESCALE, 1000);//
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_TIMESCALE,0);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_DECAY_TIMESCALE, 0);
    llSetVehicleVectorParam(VEHICLE_LINEAR_FRICTION_TIMESCALE, <0,0,0>);
    llSetVehicleVectorParam(VEHICLE_ANGULAR_FRICTION_TIMESCALE, <0,0,0>);
    llSetVehicleFloatParam(VEHICLE_VERTICAL_ATTRACTION_EFFICIENCY, 0);
    llSetVehicleFloatParam(VEHICLE_VERTICAL_ATTRACTION_TIMESCALE, 0);
    llSetVehicleFloatParam(VEHICLE_BANKING_TIMESCALE, 0);
    llSetVehicleFloatParam(VEHICLE_BANKING_EFFICIENCY, 0);//static
    llSetVehicleFloatParam(VEHICLE_BANKING_MIX, 0);//static
}

_params(string type,integer dist){
llSetStatus(STATUS_PHYSICS,TRUE);
if(~llListFindList(["walk","run","jump","hop"],[type])){
    llSetVehicleType(VEHICLE_TYPE_CAR);
    llRemoveVehicleFlags(VEHICLE_FLAG_LIMIT_MOTOR_UP | VEHICLE_FLAG_LIMIT_ROLL_ONLY);
    //llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_EFFICIENCY, 0.8); 
    //llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_EFFICIENCY, 0.8);
    //llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_TIMESCALE, .1);
    //llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_TIMESCALE, .1);
        llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_EFFICIENCY, 0.8);
        llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_EFFICIENCY, 0.40);
        llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_TIMESCALE, 0.1);
        llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_TIMESCALE, 0.8);
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_TIMESCALE, .1);
    float motor_decay = 0.6;
    if(dist<Target_Dist_Min){motor_decay=.1;}
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_DECAY_TIMESCALE, motor_decay);//
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_TIMESCALE, 10);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_DECAY_TIMESCALE, 0);
    vector friction = <Ground_Friction, 0, 1000>;
     if(type=="jump"||type=="hop"){friction=<0,0,0>;}
    llSetVehicleVectorParam(VEHICLE_LINEAR_FRICTION_TIMESCALE, friction);
    llSetVehicleVectorParam(VEHICLE_ANGULAR_FRICTION_TIMESCALE, <0.1, 0.1, 0.1>);
    llSetVehicleFloatParam(VEHICLE_VERTICAL_ATTRACTION_EFFICIENCY, 0.75);
    llSetVehicleFloatParam(VEHICLE_VERTICAL_ATTRACTION_TIMESCALE, 0.1);
    llSetVehicleFloatParam(VEHICLE_BANKING_EFFICIENCY, 0);//static
    llSetVehicleFloatParam(VEHICLE_BUOYANCY, 0); 
return;
}

if(~llListFindList(["fly","hover","swim"],[type])){
    integer attempts;
    @retry;
    llSetVehicleType(VEHICLE_TYPE_AIRPLANE);
    //llRemoveVehicleFlags(VEHICLE_FLAG_LIMIT_MOTOR_UP | VEHICLE_FLAG_LIMIT_ROLL_ONLY);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_EFFICIENCY, 0); 
    llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_EFFICIENCY, 0.8);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_TIMESCALE, .1);
    llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_TIMESCALE, .1);
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_TIMESCALE, 0.1);
    float motor_decay = .6;
    if(dist<Target_Dist_Min){motor_decay=0.1;}
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_DECAY_TIMESCALE, motor_decay);//
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_TIMESCALE,10);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_DECAY_TIMESCALE, 0);
    llSetVehicleVectorParam(VEHICLE_LINEAR_FRICTION_TIMESCALE, <10,0,0>);
    llSetVehicleVectorParam(VEHICLE_ANGULAR_FRICTION_TIMESCALE, <.1, .1, .1>);
    llSetVehicleFloatParam(VEHICLE_VERTICAL_ATTRACTION_EFFICIENCY, .75);
    llSetVehicleFloatParam(VEHICLE_VERTICAL_ATTRACTION_TIMESCALE, .1);
    llSetVehicleFloatParam(VEHICLE_BANKING_TIMESCALE, 0.01);
    llSetVehicleFloatParam(VEHICLE_BANKING_EFFICIENCY, 1);//static
    llSetVehicleFloatParam(VEHICLE_BANKING_MIX, .25);//static
    if(type=="swim"){//breach limiter
        float buoyancy = 0.977;   
        if (!_inWater() && type=="swim"){
            llSetVehicleFloatParam(VEHICLE_BUOYANCY, -1); 
            _clearParams(); 
            if(attempts>=thottle_water_start){_stop("water_end",1);return;} 
            attempts++;
            llSleep(0.25);
            jump retry;
        }
    }
    llSetVehicleFloatParam(VEHICLE_BUOYANCY, .977);
return;
}
if(type=="float"){    
    llSetVehicleType(VEHICLE_TYPE_BOAT);
    llSetVehicleVectorParam(VEHICLE_LINEAR_FRICTION_TIMESCALE, <20, 1, 5>);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_FRICTION_TIMESCALE, 0.1);
    llSetVehicleVectorParam(VEHICLE_LINEAR_MOTOR_DIRECTION, <0, 0, 0>);
    float motor_time = 0.1;
    if(dist<Target_Dist_Min*.5){motor_time=3;}
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_TIMESCALE, motor_time);
    float motor_decay = 10;
    if(dist<Target_Dist_Min){motor_decay=0.1;}
    llSetVehicleFloatParam(VEHICLE_LINEAR_MOTOR_DECAY_TIMESCALE, motor_decay);
    llSetVehicleVectorParam(VEHICLE_ANGULAR_MOTOR_DIRECTION, <0, 0, 0>);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_TIMESCALE, 0.1);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_MOTOR_DECAY_TIMESCALE, 0.2);
    vector center = llGetGeometricCenter();
    llSetVehicleFloatParam(VEHICLE_HOVER_HEIGHT, center.z);
    llSetVehicleFloatParam(VEHICLE_HOVER_EFFICIENCY, 0.2);
    llSetVehicleFloatParam(VEHICLE_HOVER_TIMESCALE, 0.4);
    llSetVehicleFloatParam(VEHICLE_BUOYANCY, 1.0);
    llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_EFFICIENCY, 0.1);
    llSetVehicleFloatParam(VEHICLE_LINEAR_DEFLECTION_TIMESCALE, 1);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_EFFICIENCY, 0.1);
    llSetVehicleFloatParam(VEHICLE_ANGULAR_DEFLECTION_TIMESCALE, 6);
    llSetVehicleFloatParam( VEHICLE_VERTICAL_ATTRACTION_EFFICIENCY, .5 );
    llSetVehicleFloatParam( VEHICLE_VERTICAL_ATTRACTION_TIMESCALE, .5 );
return;
}
//
}



list _speeds(){
return ["nonphys",nonphys,"nonphysUp",nonphysUp,"walk",movewalk,"setpos",movesetpos,"run",moverun,"jump",movejump,"swim",moveswim,"hop",movehop,"hover",movehover,"fly",movefly,"float",movefloat];
}

float _moveSpeed(string type){
list find = _speeds();
integer found = llListFindList(find,[type]);
if(found==-1){return 1;}
return llList2Float(find,found+1);
}

integer _inWater(){
vector pos = llGetPos(); 
if((pos.z - llWater(ZERO_VECTOR)) > 0){return FALSE;}
return TRUE;
}

_disable(integer callback){
    llSetTimerEvent(0);
    llSetStatus(STATUS_PHYSICS,FALSE);
    if(!Legacy_Prims){
        llSetKeyframedMotion([] ,[KFM_COMMAND, KFM_CMD_STOP]);
    }
    if(callback){_link(2,llList2String(movecache,3));}
    _anim(-6,llParseString2List(llList2String(movecache,1),["|"],[]));
    movecache=[];
}

_stop(string callback,integer OoW){
if(callback!=""){_link(2,callback);} 
if(!OoW&&!out_of_water){llSetTimerEvent(0);}
else{out_of_water=TRUE;}
_disable(FALSE);
}

_jump(float force){llApplyImpulse(<force*1.5,0,force> * llGetMass(), TRUE);} 
rotation _axis2rot(vector axis, vector target) {return llGetRot() * llRotBetween(axis * llGetRot(), target - llGetPos());}
string _trim(string str){return llStringTrim(str,STRING_TRIM);}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");}
integer _encode(string val){
    return (((integer)("0x"+llGetSubString(llMD5String(val,0),0,6)) & 0x3FFFFFFF) ^ 0xBFFFFFFF);
}

default{
state_entry(){llSetStatus(STATUS_PHYSICS,FALSE);}
timer(){_move();}
link_message(integer n, integer num, string str, key id){


    if(num==_encode("stop")){
        llSetStatus(STATUS_PHYSICS,FALSE);
        if(!Legacy_Prims){
            llSetKeyframedMotion([] ,[KFM_COMMAND, KFM_CMD_STOP]);
        }
        movecache=[];
        llSetTimerEvent(0);        
        llOwnerSay("Movement stopped.");
    }
    if(num==_encode("settings")){
        if(str=="FAILED"){llResetScript();}
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        Move_Timer=(float)llList2String(data,5);
        movewalk=(float)llList2String(data,6);
        moverun=(float)llList2String(data,7);
        movejump=(float)llList2String(data,8);
        moveswim=(float)llList2String(data,9);
        movehop=(float)llList2String(data,10);
        movehover=(float)llList2String(data,11);
        movefly=(float)llList2String(data,12);
        movefloat=(float)llList2String(data,13);
        thottle_water_start=(integer)llList2String(data,14);
        movesetpos=(float)llList2String(data,16);
        Move_Attempts=(integer)llList2String(data,17);
        nonphys=(float)llList2String(data,67);
        nonphysUp=(float)llList2String(data,68);
        Target_Dist_Min=(float)llList2String(data,69);
        Finish_Move=(integer)llList2String(data,70);
        Allow_Drift=(integer)llList2String(data,76);
        Turning_Efficiency=(float)llList2String(data,77);
        Turning_Time=(float)llList2String(data,78);
        Legacy_Prims=(integer)llList2String(data,79);
        Gravity_walk=(float)llList2String(data,95);
        Gravity_run=(float)llList2String(data,96);
        Gravity_jump=(float)llList2String(data,97);
        Gravity_hop=(float)llList2String(data,98);
        Gravity_swim=(float)llList2String(data,99);
        Gravity_float=(float)llList2String(data,100);
        Gravity_hover=(float)llList2String(data,101);
        Gravity_fly=(float)llList2String(data,102);
        Ground_Friction=(float)llList2String(data,103);
        Pause_Move=(integer)llList2String(data,107);
        Anim_Each_Move=(integer)llList2String(data,110);
        End_Move_Physics=(integer)llList2String(data,111);
        if(!Legacy_Prims){  
            llSetLinkPrimitiveParamsFast(LINK_SET, [PRIM_PHYSICS_SHAPE_TYPE, PRIM_PHYSICS_SHAPE_CONVEX, PRIM_MATERIAL, (integer)llList2String(data,104)]);
            llSleep(0.1);
            llSetKeyframedMotion([], [KFM_DATA, KFM_TRANSLATION]);
        }
        else{
            llSetLinkPrimitiveParamsFast(LINK_SET, [PRIM_PHYSICS_SHAPE_TYPE, PRIM_PHYSICS_SHAPE_PRIM, PRIM_MATERIAL, (integer)llList2String(data,104)]);
        }   
        return;
    }
    
    
    if(num==150 && Pause_Move){
        integer status = llGetStatus(STATUS_PHYSICS);
        llSetStatus(STATUS_PHYSICS,FALSE);
        llSleep((float)str);
        llSetStatus(STATUS_PHYSICS,status);
    }
    //modified values
    if(num==-11){Growing=TRUE;}
    if(num==11){Growing=FALSE;}
    if(num==121){Turning_Efficiency=(float)str;}
    if(num==122){Turning_Time=(float)str;}
    if(num==125){Finish_Move=(integer)str;}
    if(num==126){Target_Dist_Min=(float)str;}
    if(num==127){Allow_Drift=(integer)str;}
    if(num==-118){Move_Timer=(float)str;}
    if(num==-119){Move_Attempts=(integer)str;}
    //move() function
    if(num==-3){
        list data = llParseStringKeepNulls(str,["+;&"],[""]); 
        if(str=="stop"){_disable(FALSE);return;}
        if(llGetListLength(movecache)){
            if(Finish_Move){return;}
            else{_anim(-6,llParseString2List(llList2String(movecache,1),["|"],[]));}
        }
        string dest = llList2String(data,0);
        string Type = llList2String(data,1);
        string speed = llList2String(data,2);
        string complete = llList2String(data,3);
        list info = llParseString2List(Type,["|"],[]);
        string type = _trim(llList2String(info,0));
        if(!Anim_Each_Move){_anim(-5,info);}
        string callback = llList2String(movecache,3);
        float gravity = 0;
        if(type=="walk"){gravity = Gravity_walk;}
        if(type=="run"){gravity = Gravity_run;}
        if(type=="jump"){gravity = Gravity_jump;}
        if(type=="hop"){gravity = Gravity_hop;}
        if(type=="swim"){gravity = Gravity_swim;}
        if(type=="float"){gravity = Gravity_float;}
        if(type=="hover"){gravity = Gravity_hover;}
        if(type=="fly"){gravity = Gravity_fly;}
        llSetForce(llGetMass() * <0,0,gravity>, FALSE);
        if(dest=="null"||(vector)dest==ZERO_VECTOR){
            if(callback!=""){_stop(callback,0);}
            else if(complete!=""){_stop(complete,0);}
        }
        else{
            if(complete==""||complete=="null"){complete="true";}
            if(~llSubStringIndex(type,"nonphys")){
                if(speed=="fast"){speed="0.5";}
                if(speed=="slow"){speed="1.5";}
                if(speed=="normal"||speed==""||speed=="null"){speed="1.0";}
            }
            else{
                if(speed=="slow"){speed="0.5";}
                if(speed=="fast"){speed="1.5";}
                if(speed=="normal"||speed==""||speed=="null"){speed="1.0";}
            }
            if(type==""){type="setpos";}
            Last=llGetPos();
            float Speed = (float)speed*_moveSpeed(type);
            if((float)llList2String(data,2)>0){Speed = (float)llList2String(data,2);}
            movecache=[(vector)dest,Type,Speed,complete];
            _move();
        }
    }
}
}

