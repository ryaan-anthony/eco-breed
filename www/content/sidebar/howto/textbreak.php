
<?php
print "<p class='widget-line-$odd'>Using text breaks to create dynamic messages.</p>";
?>

<span style='display:none;'>

<?php print wtheadline('Create dynamic messages','using expressions and text breaks.'); ?>
        <div style='padding:20px;'>
	    	<h3>Expressions: <a class='external' href='http://eco.takecopy.com/?e=expressions' target="_blank">Complete list of expressions.</a></h3>
            <p class='sub-in sit'>Most values can be added to message strings by using "expressions". Expression codes are replaced within the string with their associated value. If the expression contains a broken or <t class='bool'>Undefined</t> value, it replaces the expression with the Undefined_Value setting:</p>
        	<?php print breedSetting(
		'Undefined_Value',
		'"Undefined"',
		'Any undefined expressions will return this string.',
		'Undefined_Value = "not set";',
		'Any expressions that arent defined will return "not set" to indicate their values have not been set.'
		); ?>
        	
        </div>
        <div style='padding:20px;'>
	    	<h3>Text Breaks:</h3>
            <p class='sub-in'>Text breaks or '/' (forward slashes) can be inserted <strong>at the begining and end</strong> of a section of text to mark it, which adds a condition where there marked section of text <strong>must not contain an undefined expression</strong> or it will be removed from the message string.</p>
    		<?php print actions_code('"start",
"say(Hello %owner%, My name is %MyName%/, and my parents are %MyParents%/!)"'); ?> 
			<p class='sub-in'>In this example, when the breed is first created, it will say: <em>"Hello Dev Khaos, My name is eco-breed!"</em> and when a child is born the offspring will say: <em>"Hello Dev Khaos, My name is eco-breed, and my parents are Alpha and Beta!"</em></p> 
        </div>