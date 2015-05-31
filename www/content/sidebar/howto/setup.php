
<?php
print "<p class='widget-line-$odd'>Getting Started: Create a species.</p>";
?>

<span style='display:none;'>

	<?php print wtheadline('Creating a species','is as simple as creating a name. Select *Create New* from the species dropdown. It will ask you to name your species. The species name can be changed at any time, but the system refuses to allow duplicate names in an effort to give value to the naming process and help protect creators from imitation.'); ?>
    <h3>Each species has the following options:</h3>
<?php print listItem('Delete','Destroy the species and remove all associated skins, anims, breed records, and configurations.'); ?>
<?php print listItem('Refresh id (or convert species from 0.2x)','Destroy all breed records but preserve all associated anims, skins, and configurations.'); ?>
<?php print listItem('Skinsets','Skins are defined here and can be modified at any time. Changes to skinsets are not applied to existing breeds.'); ?>
<?php print listItem('Animations','Anims are defined here and can be modified at any time. Changes to animations are re-applied if the animation is set() again after the change is made.'); ?>
<?php print listItem('Breed Settings','One configuration needs to be made for all breeds, and alternates can be made to define variations which require different configurations. Adding the master command \'-child\' to a parent config ID will force the code to act as a child thus allowing you to create children from a parent configuration. These settings determine the overall behavior of a breed object and can modified at any time. Changes do not affect existing breeds (to protect against mistakes and allow for multi-tiered configurations without repetition) unless a refresh command is triggered locally using \'-refresh\' or remotely by clicking \'refresh all breeds\'. The config ID is used to request the configuration from the server. The avatar who compiles these settings must be the creator or an authorized user otherwise the request fails. '); ?>
<?php print listItem('Action Settings','Multiple action objects can be defined to create homes, food, toys, and other accesories such as huds and even other species. These settings determine the type of object and limitations regarding how many breeds can interact with it and how to handle rebuilding and birthing breeds. Action objects also distribute action methods to the breed objects upon event requests. This allows you to define custom interactions with your breed using the built in methods or even create your own using the eco extensions! Changes to the settings do not affect existing action objects (to protect against mistakes and allow for multi-tiered configurations without repetition) unless a refresh command is triggered locally using \'-refresh\' or remotely by clicking \'refresh all actions\'. The config ID is used to request the configuration from the server. The avatar who compiles these settings must be the creator or an authorized user otherwise the request fails. '); ?>

</span>