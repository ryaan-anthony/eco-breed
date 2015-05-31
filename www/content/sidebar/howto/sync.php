
<?php
print "<p class='widget-line-$odd'>Action Setup: Sync, throttle, limit breeds.</p>";
?>

<span style='display:none;'>
    
    <?php print wtheadline('Syncing is easy!','Throttles, limits, and filters provide a wide range of tools to allow you to decide how the breeds interact with their actions. Limit the total number of breeds and/or sync by comparing keywords. '); ?>
        <h3>Explore these advanced <a class='title inline'>action settings</a> values:</h3>
            <?php print actionSetting(
        'Limit number of breeds',
        '-1',
        'Limit the number of breeds that can interact with this object. -1 for unlimited.'
        ); ?>
            <?php print actionSetting(
        'Breed Timeout',
        '60',
        'Time in seconds for a breed to respond before allowing other breeds to interact.'
        ); ?>
            <?php print actionSetting(
        'Match keyword: (optional)',
        'null',
        'Ignore breeds that do not have a matching keyword in their object description field. Leave blank to disable this filter. For example, if set to "Friendly", only breed objects with the word "Friendly" in their object description will be able to use this action object.'
         ); ?>
            <?php print actionSetting(
        'Action_Type',
        'null',
        'Define each Action Object with a single word or short phrase. Breeds will be limited to one of each type unless blank. For example, if set to "Food", breed objects will be able to communicate with just one action object with this <strong>type</strong>.'
        ); ?>
        
        <h3>Explore these advanced <a class='title inline'>breed settings</a> values:</h3>
            <?php print breedSetting(
        'Sync to Action objects?',
        'NO',
        'Sync communications with Action Objects? Syncing allows you to focus communications with a select range of action objects instead of allowing all actions to be triggered for all breeds..'
       ); ?>
            <?php print breedSetting(
        'Set a timeout for missing action objects',
        '0',
        'If action object is removed, set a timeout for breed to look for replacement. If the last response from each action object is older than this limit, in seconds,the connection is expired.'
        ); ?>
            <?php print breedSetting(
        'Retry the connection after this many seconds',
        '20',
        'If all connections fail, retry the connection after this many seconds.'
        ); ?>
            <?php print breedSetting(
        'Select action objects to sync with',
        'null',
        'Allow action objects that contain these keywords (may contain expressions). Useful for having multiple groups of breeds. For example, if you set the types "Friendly" and "Happy" and have a <strong>food source</strong> with and Action Type "Friendly Food" and a <strong>home object</strong> with the Action Type "Happy Home" the breed object will interact with both of the above action objects, but it will ignore types like "Regular Food" or "Normal Home". However, a breed would eat both \'Food\' sources and use any \'Home\' object if the breed was configured to sync with "Food" and "Home". This is very useful for segregating breeds from certain types of action objects.'
        ); ?>
        
		<h3>This value is optional for <a class='title inline sub-up'>both objects</a>:</h3>
            <?php print normalSetting(
            'Restrict communications to owner-only?',
            'YES',
            'Limit interactions between with same-owner objects.'
            ); ?>
</span>