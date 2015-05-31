


<p style='font-size:0.9em;margin-bottom:0;'>Add this to the Action_Classes list:</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
list Action_Classes=[ 

"start",
"text(Age: %MyAge%)
 cache(Child,Teen,Adult)
 bind(timer,10,age_check)",

"age_check",
"text(Age: %MyAge%)
 filter(%MyAge%=1,not1)
 set(Child)
 uncache(Child)",

"not1",
"filter(%MyAge%=2,not2)
 set(Teen)
 uncache(Teen)",

"not2",
"filter(%MyAge%=3)
 set(Adult)
 uncache(Adult)"

];
</pre></div>