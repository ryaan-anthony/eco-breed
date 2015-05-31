
<?php
print "<p class='widget-line-$odd'>Action Setup: Understanding methods w/ simple examples.</p>";
?>

<span style='display:none;'>

		<?php print wtheadline('Methods','are used to trigger built-in functions. With each event that is called, you can run dozens of methods for your simulation.'); ?>  
  
            <div class='entry sub-pad'>
            	<?php print actions_comment('Methods are run in order','', 'from first to last.');?>
			<?php print actions_code('"start", 
"say(One)
say(Two)
say(Three)"');?>
                <p class='action-result-head'>RESULTS:</p>    
                <p class='action-result'>One</p>
                <p class='action-result'>Two</p>
                <p class='action-result'>Three</p>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('This order continues based on','', 'the methods you use.');?>
            	<?php print actions_code('"start", 
"say(One)
toggle(next)
say(Three)",

"next",
"say(Two)"');?>
                <p class='action-result-head'>RESULTS:</p>  
                <p class='action-result'>One</p>
                <p class='action-result'>Two</p>
                <p class='action-result'>Three</p>
            </div> 
            <div class='entry sub-pad'>
            	<?php print actions_comment('Now try a more advanced ','', ' event flow.');?>
            	<?php print actions_code('"start", 
"say(Start)
toggle(One|Two|Three)
say(End)",

"One",
"say(%this%)",

"Two",
"say(%this%)",

"Three",
"say(%this%)"');?>
                <p class='action-result-head'>RESULTS:</p>   
                <p class='action-result'>Start</p>
                <p class='action-result'>One</p>
                <p class='action-result'>Two</p>
                <p class='action-result'>Three</p>
                <p class='action-result'>End</p>
            </div>   
            <div class='entry sub-pad'>
            	<?php print actions_comment('Now to include filters ','', 'and custom values.');?>
			<?php print actions_code('"start", 
"say(%this%)
prop(Num,1)
toggle(say|next)",

"say",
"say(%Num%)",

"next",
"prop(Num,+1)
filter(%Num%<3, end)
toggle(say|next)",

"end",
"toggle(say)
say(%this%)"');?>
                <p class='action-result-head'>RESULTS:</p>  
                <p class='action-result'>start</p>
                <p class='action-result'>1</p>
                <p class='action-result'>2</p>
                <p class='action-result'>3</p>
                <p class='action-result'>end</p>
            </div>   
     
</span>