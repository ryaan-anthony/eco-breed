
<p style='font-size:0.9em;margin-bottom:0;font-weight:bold;'>Basic "Kill" Example:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
//This example expires on Christmas 2011.
string expired = "2011-12-25"; //YYYY-MM-DD

_die(){
    llDie();
}
default{
    
state_entry(){
    llSetTimerEvent(10);
}

timer(){
    if(llGetDate()==expired){
        _die();
    }
    else{
        list date = llParseString2List(llGetDate(),["-"],[]);
        integer year = (integer)llList2String(date,0);
        integer month = (integer)llList2String(date,1);
        integer day = (integer)llList2String(date,2);
        list exp_date = llParseString2List(expired,["-"],[]);
        integer exp_year = (integer)llList2String(exp_date,0);
        integer exp_month = (integer)llList2String(exp_date,1);
        integer exp_day = (integer)llList2String(exp_date,2);
        if(year>exp_year){_die();}
        else if(year==exp_year && month>exp_month){_die();}
        else if(year==exp_year && month=exp_month && day>exp_day){_die();}
    }
}

}
</pre></div>
<p style='font-size:0.9em;margin-bottom:0;font-weight:bold;'>Extended Example for Breed-Objects:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
//On or After Christmas 2011, this example toggles the event "Expired" as defined in your Action-Classes

string expired = "2011-12-25"; //YYYY-MM-DD

toggle(string class){_link(2,class);}
_link(integer n, string str){llMessageLinked(LINK_THIS, n, str, "");} 
_expired(){
    toggle("Expired");
    llSetTimerEvent(0);
}
default{
    
state_entry(){
    llSetTimerEvent(10);
}

timer(){
    if(llGetDate()==expired){
        _expired();
    }
    else{
        list date = llParseString2List(llGetDate(),["-"],[]);
        integer year = (integer)llList2String(date,0);
        integer month = (integer)llList2String(date,1);
        integer day = (integer)llList2String(date,2);
        list exp_date = llParseString2List(expired,["-"],[]);
        integer exp_year = (integer)llList2String(exp_date,0);
        integer exp_month = (integer)llList2String(exp_date,1);
        integer exp_day = (integer)llList2String(exp_date,2);
        if(year>exp_year){_expired();}
        else if(year==exp_year && month>exp_month){_expired();}
        else if(year==exp_year && month=exp_month && day>exp_day){_expired();}
    }
}

}
</pre></div>
<p style='font-size:0.9em;margin-bottom:0;'>Put this is your Action-Class List:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

"Expired",
"message(%ownerkey%, Merry Christmas!)"

];
</pre></div>
<p>This example says "Merry Christmas!" when the date is expired. The timer is removed so the event is only toggled once.</p>
