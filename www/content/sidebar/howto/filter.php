
<?php
print "<p class='widget-line-$odd'>Methods: Filtering values.</p>";
?>

<span style='display:none;'>
            
    	<?php print wtheadline('The filter() method', 'compares two values and only continues traversing the methods string if result is TRUE. If result is FALSE, the filter() method blocks subsequent methods and toggles a callback. The reverse occurs with rfilter() where TRUE conditions return the callback and false continues traversing.'); ?>
        
        	<?php print method_profile(
			'filter',
			'condition [ , callback [ , condition [ , callback ... ] ] ]',
			array(
				'condition','two values separated by a single digit operator:'.big_code('<	less than
>	greater than
=	equal to
!	not equal
^	list contains
~	string contains'),
				'callback','the event that is toggled when result is FALSE.'
			),
			actions_code('"start", 
"bind(touch,all,check)",

"check",
"filter(%touch_name%=owner,is_false, %touch_key%=group, wrong_group) 
say(You are my owner and in my group, %owner_name%)",

"wrong_group",
"say(You are my owner, %touch_name%, but not in my group)",

"is_false",
"say(You are not my owner, %touch_name%)"'),
			"This example uses the bind() method to set a public touch event named 'check'. When touched by an avatar, the filter() method diverts non-owners to the 'is_false' event or when touched by owner it will check if the owner is active under the same group tag as the breed-object. If TRUE the core code continues traversing the method string.",
			actions_code('"start", 
"prop(Friends[n], Me, You)
 filter(%Friends% ^ You, not_found)
 say(\'You\' was found in list \'Friends\')",

"not_found",
"say(\'You\' was NOT found in list \'Friends\')"'),
			"This example creates a list called \"Friends\" and adds the values \"Me\" and \"You\". The filter checks if \"You\" is in the list \"Friends\" by calling the list identifier as an expression and comparing values using the 'list contains' operator \"^\". The result is the breed object saying \" 'You' was found in list 'Friends' \" in local chat."
			);?>
            <?php print method_profile(
			'rfilter',
			'condition [ , callback [ , condition [ , callback ... ] ] ]',
			array(
				'condition','two values separated by a single digit operator. (see above)',
				'callback','the event that is toggled when result is TRUE.'
			),
			actions_code('"start", 
"bind(touch,all,check)",

"check",
"rfilter(%touch_name%=owner, is_owner, %touch_key%=group, in_group)
 say(You are not my owner or in my group, %touch_name%.)",

"is_owner",
"say(You are my owner, %owner_name%.)",

"in_group",
"say(You are in my group, %touch_name%.)"'),
			'This is the reverse application of the example shown for filter()'
			);?>            
</span>