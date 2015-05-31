

<p style='font-size:0.9em;margin-bottom:0;'>Add this script to your breed or action object and set it accordingly:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
////Greeter Extension for eco-breeds 
//  When a new avatar arrives and is greeted, it will create an event 
//  called "greeted" which will be relayed to all breeds. Adding multiple 
//  messages will tell the script to pick a random message to display.
//  Otherwise just set one message. Owner is ignored and not greeted.
//
list messages=["Welcome to my parcel!","Hello, welcome!"];//set messages here
integer Breed_Object = TRUE; //TRUE = goes in breed-object | FALSE = goes in action object
integer Alert_Online_Only = TRUE;//TRUE = alerts owner only when owner is online
list visitors;
list here_now;
key owner_result;
string str_msg;

send_msg(){
owner_result = llRequestAgentData(llGetOwner(), DATA_ONLINE);
}

_checkgone(){
    integer i;
    string this_parcel=(string)llGetParcelDetails(llGetPos(),[PARCEL_DETAILS_NAME]);
    for(i=0;i&lt;llGetListLength(here_now);i+=2){
        key id = llList2String(here_now,i);
        string name=llList2String(here_now,i+1);
        vector pos = (vector)((string)llGetObjectDetails(id, [OBJECT_POS]));
        string detected_parcel=(string)llGetParcelDetails(pos,[PARCEL_DETAILS_NAME]);
        if(detected_parcel!=this_parcel){
            str_msg=name+" has left."; 
            here_now=llDeleteSubList(here_now,i,i+1);
            jump send;
        }
    }
    jump skip;
    @send;
    send_msg();
    @skip;
}

toggle(string class){if(Breed_Object){_link(2,class);}else{_link(211,class);}}

_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 

default{

state_entry(){
    llSensorRepeat("","",AGENT,90,PI,2);   
}

no_sensor(){
    _checkgone();
}

sensor(integer n){
    string this_parcel=(string)llGetParcelDetails(llGetPos(),[PARCEL_DETAILS_NAME]);
    integer i;
    for(i=0;i&lt;n;i++){
        string detected_parcel=(string)llGetParcelDetails(llDetectedPos(i),[PARCEL_DETAILS_NAME]);
        key id = llDetectedKey(i);
        string name=llDetectedName(i);        
        if(detected_parcel==this_parcel&&llListFindList(here_now,[id])==-1&&llGetOwner()!=id){
            string greeted;
            if(llListFindList(visitors,[id])==-1){
                llInstantMessage(id,llList2String(messages,(integer)llFrand(llGetListLength(messages))));
                visitors+=[id];
                greeted = " and was greeted";
                toggle("greeted");
            }
            here_now+=[id,name];
            if(llGetListLength(visitors)>=400){visitors=llDeleteSubList(visitors,0,5);}
            str_msg=name+" arrived"+greeted+".";
            jump send;
        }        
    }
    _checkgone();
    jump skip;
    @send;
    send_msg();
    @skip;
}

dataserver(key res, string data){
    if(((integer)data||!Alert_Online_Only) && res==owner_result){llInstantMessage(llGetOwner(),str_msg);}
}
}
</pre></div>

<p style='font-size:0.9em;margin-bottom:0;'>You can now call the "greeted" event from the action-object's Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"greeted",
"say(I just greeted someone!)"

];
</pre></div>
