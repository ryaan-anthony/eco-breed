
<?php
print "<p class='widget-line-$odd'>Ageing Physical Features.</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('Age shows character',' and is demonstrated by visual growth. This snippet shows how easy it is to apply visual features to breeds based on age:'); ?>
        <div style='padding:0 20px;'>            
        	<?php print videolink('Ageing features', 'kRoyw_j-7cA');?>
        	<p class='sub-in'>When the breed ages and grows, this video shows you how to set age-based physical features for your breed.</p>
        	<?php print actions_code('"start",
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
 uncache(Adult)"');?>
 		</div>
</span>