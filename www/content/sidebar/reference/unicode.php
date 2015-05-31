
<?php
print "<p class='widget-line-$odd'>Special characters</p>";
?>

<span style='display:none;'>

    	<?php print wtheadline('Reserved and special characters','require special formatting to be applied without causing error. '); ?>
        <div style='padding:20px;'>
	    	<h3>Reserved Characters:</h3>
            <p class='sub-in'>The following characters are <strong>RESERVED</strong> for use within method strings to define order and association. To use these characters in method strings, use the following codes to substitute for the reserved character.</p>
            <div title='Percent' style='position: relative;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>%</div> <div class='codeblock sideblock'>&amp;#37</div></div>
            <div title='Left Parenthesis' style='position: relative;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>(</div> <div class='codeblock sideblock'>&amp;#40</div></div>
            <div title='Right Parenthesis' style='position: relative;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>)</div> <div class='codeblock sideblock'>&amp;#41</div></div>
            <div title='Comma' style='position: relative;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'>,</div> <div class='codeblock sideblock'>&amp;#44</div></div>
        </div>
        <div style='padding:20px;'>
	    	<h3>Special Characters:</h3>
            <p class='sub-in'>These are useful characters for formatting strings to include quotes, tabs, and line breaks.</p>
            <div title='Tab' style='position: relative;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'><em>tab</em></div> <div class='codeblock sideblock'>\t</div></div>
            <div title='Line Break' style='position: relative;padding:20px;'><div class='sideblock sb1' style='font-size:1.3em;'><em>line<br />break</em></div> <div class='codeblock sideblock'>\n</div></div>
        </div>
        
</span>