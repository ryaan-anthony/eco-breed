
<?php
print "<p class='widget-line-$odd'>Master Key Commands</p>";
?>

<span style='display:none;'>
<?php print wtheadline('Master key commands','allow creators to append the following to the key that is set in the OBJECT DESCRIPTION of the breed object. Multiple commands can be used at once, and commands which are marked "persist" remain in the description field while the condition is desired to persist. Eco breeds can be distributed with key commands, no modify is suggested where blocking 3rd party use of key commands is desired.');?>


    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-local</p>
    <p class='description'>block breed from saving records on webserver</p>
    </div>

    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-child</p>
    <p class='description'>set breed as child. use with parent configurations to prepare breed as a child replicate of parents</p>
    </div>

    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-alt</p>
    <p class='description'>allow breed to bypass the creator reset to simulate your avatar as the end user (breed resets for creator, not subsequent owners unless tagged '-alt')</p>
    </div>

    <div class='entry'>
    <p class='title'>-debug</p>
    <p class='description'>print debug code in local chat</p>
    </div>

    <div class='entry'>
    <p class='title'>-start</p>
    <p class='description'>restart connection to all action objects</p>
    </div>

    <div class='entry'>
    <p class='title'>-stop</p>
    <p class='description'>stop all anims, binds, movement, and other loops</p>
    </div>

    <div class='entry'>
    <p class='title'>-reset</p>
    <p class='description'>set breed completely</p>
    </div>

    <div class='entry'>
    <p class='title'>-rebuild</p>
    <p class='description'>rebuild breed to last known values</p>
    </div>

    <div class='entry'>
    <p class='title'>-refresh</p>
    <p class='description'>(works for action and breed) gets settings from webserver without overwriting current values</p>
    </div>

    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-dump</p>
    <p class='description'>dump all expressions and their values to local chat</p>
    </div>

    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-male</p>
    <p class='description'>force male on creation</p>
    </div>

    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-female</p>
    <p class='description'>force female on creation</p>
    </div>

    <div class='entry'>
    <p class='tags'>persist</p><p class='title'>-link</p>
    <p class='description'>force allow link/unlink without script reset</p>
    </div>
    
</span>