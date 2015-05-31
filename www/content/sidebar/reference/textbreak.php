
<?php
print "<p class='widget-line-$odd'>Using text breaks to create dynamic messages.</p>";
?>

<span style='display:none;'>
    
    <?php print wtheadline('Create dynamic messages','using expressions and text breaks.'); ?>
    
    <p class='sub-in sit'>Most values can be added to message strings by using "expressions". Expression codes are replaced within the string with their associated value. If the expression contains a broken or <t class='bool'>Undefined</t> value, it replaces the expression with the Undefined_Value setting:</p>
    <?php print breedSetting(
    'Undefined_Value',
    '"Undefined"',
    'Any undefined expressions will return this string.',
    'Undefined_Value = "not set";',
    'Any expressions that arent defined will return "not set" to indicate their values have not been set.'
    ); ?>
    
    <h3>Text Breaks:</h3>
    <p class='sub-in'>Text breaks or '/' (forward slashes) can be inserted <strong>at the begining and end</strong> of a section of text to mark it, which adds a condition where there marked section of text <strong>must not contain an undefined expression</strong> or it will be removed from the message string.</p>
    <?php print actions_code('"start",
    "say(Hello %owner%, My name is %MyName%/, and my parents are %MyParents%/!)"'); ?> 
    <p class='sub-in'>In this example, when the breed is first created, it will say: <em>"Hello Dev Khaos, My name is eco-breed!"</em> and when a child is born the offspring will say: <em>"Hello Dev Khaos, My name is eco-breed, and my parents are Alpha and Beta!"</em></p> 
    
    
    
    <h3>Temporary pregnancy text.</h3>
    <?php print actions_code('"start",
    "bind(timer|toggle, 20, text)",
    
    "text",
    "text( { Pregnant: %Pregnant% \n } %breed_name% \n Age: %age% )"');?>    
    <p class='description'>Sections of the text can include text-breaks '{' '}' (curly braces) which indicate that the section of text within cannot contain an Undefined value or it will be removed. Multiple instances of text-breaks can be used. This example will display "Pregnant: [time until birth], Name, and Age" while pregnant and otherwise displays only the name and age.</p>

</span>