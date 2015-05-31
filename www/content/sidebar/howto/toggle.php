
<?php
print "<p class='widget-line-$odd'>Methods: Toggling events</p>";
?>

<span style='display:none;'>
    	<?php print wtheadline('To toggle a specific event', 'in the Actions list, use the toggle() method with the user-defined or native event as the value.'); ?>
        
        	<?php print method_profile(
			'toggle',
			'event [ , event [ , event ... ] ]',
			array(),
			actions_code('"start",
"bind(touch,owner,touched)",

"touched",
"say(Touched)
toggle(toggled)",

"toggled",
"say(Toggled!)"'),
			"When touched by the object's owner displays a 'Touched' message in local chat then toggles the event named 'toggled' which displays a 'Toggled!' message in local chat.",
			'<p><strong>Random toggle :</strong> supply additional events and a random event will be selected, the rest are discarded.</p>'.actions_code('"start",
"toggle(A, B, C)",

"A",
"say(Event A was chosen!)",

"B",
"say(Event B was chosen!)",

"C",
"say(Event C was chosen!)"'),
			"This example toggles a random event: A, B, or C.",
			'<p><strong>Random group toggle :</strong> link events using vertical bars \'|\' and each event will be toggled.</p>'.actions_code('"start",
"toggle(A|b|c, a|B|c, a|b|C)",

"A",
"say(%this%)",

"B",
"say(%this%)",

"C",
"say(%this%)",

"a",
"say(%this%)",

"b",
"say(%this%)",

"c",
"say(%this%)"'),
			"This example toggles one group of 3 events, selected at random. One capital and two lowercase events are chosen."
			);?>
</span>