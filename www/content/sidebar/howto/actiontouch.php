
<?php
print "<p class='widget-line-$odd'>Action Setup: Identifying action-touch events.</p>";
?>

<span style='display:none;'>
		<?php print wtheadline('Action Touch Events',' can be created and toggled based on the name or description of the prim touched or it\'s link number; find the action setting \'Touch_Events\' to enable them. This event will trigger all breeds synced with this action object. These events must be enabled in the advanced settings section under "Define action touch events". These events are very useful for building HUDs and other objects which require multiple prims to be touched.'); ?>
            <div class='entry sub-pad'> 
                <?php print actions_comment('Name one of the prims in your action object','"Help"','and click it.');?>
                <?php print actions_code('"touch-Help",
"say(Help touched!)"');?>
				<?php print actions_comment('Define <strong>action touch events</strong> as','Object Name','to detect the touched prim\'s name.');?>
            </div>
            <div class='entry sub-pad'> 
                <?php print actions_comment('Also try','"Say", "Shout","Whisper"','in the object descriptions and click each one.');?>
                <?php print actions_code('"touch-Say",
"say(%action% touched!)",

"touch-Shout",
"shout(%action% touched!)",

"touch-Whisper",
"whisper(%action% touched!)"');?>
				<?php print actions_comment('Define <strong>action touch events</strong> as','Object Desc','to detect the touched prim\'s description.');?>
            </div>
            <div class='entry sub-pad'> 
                <?php print actions_comment('If you want to use the','link number','just try the following.');?>
                <?php print actions_code('"touch-0",
"say(%this%)",

"touch-1",
"say(%this%)",

"touch-2",
"say(%this%)",

"touch-3",
"say(%this%)"');?>
				<?php print actions_comment('Define <strong>action touch events</strong> as','Link Number','to detect the touched prim\'s link number.');?>
            </div>
</span>