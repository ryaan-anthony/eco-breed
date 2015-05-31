
<p>To assign happiness to a single breed, additional changes must be made.</p>

<p style='font-weight:bold'>"Home" Object</p>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

//set a timer cycle to 20 minutes (1200 seconds)
"start",
"toggle(text)
bind(timer,1200,check_happiness)", 

//enable breeding if "Happiness" is greater than 50% (sets to 20 minute cycles)
"check_happiness",
"filter(%Happiness%&gt;50,disable_breeding)
val(Breed_Time,20)
toggle(assign_happiness)",

//disable breeding if "Happiness" is 50% or less
"disable_breeding",
"val(Breed_Time,0)
toggle(assign_happiness)",

//set filter
"assign_happiness",
"filter(%Happy_Points%&gt;0,reduce_happiness)
toggle(add_happiness)",

//add to "Happiness" value and reduce from points total
"add_happiness",
"prop(Happy_Points,-5)
prop(Happiness,+5)
filter(%Happiness%&gt;100,text)
prop(Happiness,100)
toggle(text)",

//reduce happiness if no points remain
"reduce_happiness",
"prop(Happiness,-5)
filter(%Happiness%&lt;0,text)
prop(Happiness,0)
toggle(text)",

//set hover text
"text",
"text(Happiness: %Happiness%%)"

];
</pre></div>


<p style='font-weight:bold'>"Power-Up" Object</p>
<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[

//set start "Happiness" to 50
//set total points ("Happy_Points") to 200
//destroy object to prevent reuse
"start",
"prop(Happiness,50)
prop(Happy_Points,200)
@delete()"

];
</pre></div>

<p style='font-size:0.9em;margin-bottom:0;'>Add this script to the "Power-Up" object ONLY:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
_extend(string function, string attributes){
    if(function=="@delete"){
       llDie();//destroys the object when this method is called
       llRemoveInventory("action-events");//removes main script to prevent attachment exploit of llDie()
    }
}

default{
link_message(integer a, integer b, string c, key d){if(b==-220){_extend(c,(string)d);}}
}
</pre></div>
<p style='margin-top:0;font-size:0.9em;'>This extension kills the disposable action object.</p>