
<button num='4b' class='sub-tab sub-howto'><span class='subCap'>a</span> Communication</button>
<button num='4c' class='sub-tab sub-howto'><span class='subCap'>b</span> Movement</button>
<button num='4d' class='sub-tab sub-howto'><span class='subCap'>c</span> Inventory</button>
<button num='4e' class='sub-tab sub-howto'><span class='subCap'>d</span> Event Flow</button>
<button num='4f' class='sub-tab sub-howto'><span class='subCap'>e</span> Manipulation</button>

<!--Start-->
<div class='sub-content sub-default'>
	<?php print subButton('4b','Continue'); ?>
    <?php print wttabline('<strong>add</strong> functionality.','events, levels, movement, and more..',true); ?>
    <?php print insertlogo(); ?>
    <div class='sub-info'>
        <p>This section covers...</p>
        <ul>
            <li num='4b'>Display <strong>statistics</strong> and allow user input.</li>
            <li num='4b'>Custom messages and <strong>alerts</strong>.</li>
            <li num='4c'><strong>Movement</strong> types and behaviors.</li>
            <li num='4c'>How to <strong>avoid obstacles</strong> during movement.</li>
            <li num='4d'>Give and rez <strong>inventory</strong>.</li>
            <li num='4d'>Play and loop <strong>sounds</strong>.</li>
            <li num='4e'>How to use <strong>filters</strong> to regulate functionality.</li>
            <li num='4f'>Create, modify, and disable <strong>global values</strong>.</li>
        </ul>
    </div>
</div>

<!--Communication-->
<div num='4b' class='sub-content' style='display:none;'>
	<div class='frame-4b'>
        <?php print subButton('4c','Continue to Next'); ?>
    	<?php print wtheadline('Messages and statistics','can be created and displayed using various built-in methods. Global values can be inserted into these message strings and segments of text can be hidden based on pre-defined conditions.'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Special characters in message strings:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Add dynamic values to a message string:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Local chat and private messages:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Configure hover text:</strong> <button num='4' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Menus with buttons and input fields:</strong> <button num='5' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-4b' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Reserved and special characters','require special formatting to be applied without causing error. '); ?>
        <div style='padding:20px;'>
	    	<h3>Reserved Characters:</h3>
            <p class='sub-in'>The following characters are <strong>RESERVED</strong> for use within method strings to define order and association. To use these characters in method strings, use the following codes to substitute for the reserved character.</p>
            <div title='Percent' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>%</div> <div class='codeblock sideblock'>&amp;#37</div></div>
            <div title='Left Parenthesis' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>(</div> <div class='codeblock sideblock'>&amp;#40</div></div>
            <div title='Right Parenthesis' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>)</div> <div class='codeblock sideblock'>&amp;#41</div></div>
            <div title='Comma' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>,</div> <div class='codeblock sideblock'>&amp;#44</div></div>
        </div>
        <div style='padding:20px;'>
	    	<h3>Special Characters:</h3>
            <p class='sub-in'>These are useful characters for formatting strings to include quotes, tabs, and line breaks.</p>
            <div title='Tab' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'><em>tab</em></div> <div class='codeblock sideblock'>\t</div></div>
            <div title='Line Break' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'><em>line<br />break</em></div> <div class='codeblock sideblock'>\n</div></div>
            <div title='Quote' style='position: relative;height:60px;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>"</div> <div class='codeblock sideblock'>\"</div></div>
        </div>
    </div>
    <div num='2' class='frame-4b' style='display:none;'> 
    	<?php print backButton('Go Back',3); ?>    
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
    </div>
    <div num='3' class='frame-4b' style='display:none;'>
    	<?php print backButton('Go Back',4); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='4' class='frame-4b' style='display:none;'>
    	<?php print backButton('Go Back',5); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='5' class='frame-4b' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
</div>

<!--Movement-->
<div num='4c' class='sub-content' style='display:none;'>
	<div class='frame-4c'>
        <?php print subButton('4d','Continue to Next'); ?>
        <?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Settings:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Configurations:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Extension:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-4c' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='2' class='frame-4c' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='3' class='frame-4c' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
</div>

<!--Inventory-->
<div num='4d' class='sub-content' style='display:none;'>
	<div class='frame-4d'>
        <?php print subButton('4e','Continue to Next'); ?>
        <?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Settings:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Configurations:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Extension:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-4d' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='2' class='frame-4d' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='3' class='frame-4d' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
</div>

<!--Event Flow-->
<div num='4e' class='sub-content' style='display:none;'>
	<div class='frame-4e'>
        <?php print subButton('4f','Continue to Next'); ?>
        <?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Settings:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Configurations:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Extension:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-4e' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='2' class='frame-4e' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='3' class='frame-4e' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
</div>

<!--Manipulation-->
<div num='4f' class='sub-content' style='display:none;'>
	<div class='frame-4f'>
		<?php print pageButton('e-howto5','Continue'); ?>
        <?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
            <p class='sub-in'><strong>Settings:</strong> <button num='1' class='sub-in-btn'>Try It</button></p>
            <hr />
            <p class='sub-in'><strong>Configurations:</strong> <button num='2' class='sub-in-btn'>Try It</button></p>
            <p class='sub-in'><strong>Extension:</strong> <button num='3' class='sub-in-btn'>Try It</button></p>
        </div>
    </div>
    <div num='1' class='frame-4f' style='display:none;'>
    	<?php print backButton('Go Back',2); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='2' class='frame-4f' style='display:none;'>
    	<?php print backButton('Go Back',3); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
    <div num='3' class='frame-4f' style='display:none;'>
    	<?php print backButton('Go Back'); ?>    
    	<?php print wtheadline('Coming', 'soon'); ?>
        <div style='padding:20px;'>
        </div>
    </div>
</div>
