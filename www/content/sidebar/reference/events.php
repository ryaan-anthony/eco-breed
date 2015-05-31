
<?php
print "<p class='widget-line-$odd'>Events List</p>";
?>

<span style='display:none;'> 
		<?php print wtheadline('Native events','are are toggled when specific conditions are met.'); ?>
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />birth</p>
        <span><p class='description'>This event is triggered when breeding is completed, after children are rezzed. </p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />dead</p>
        <span><p class='description'>This event is triggered when dead or when an unauthorized copy or modification has been made.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />food</p>
        <span><p class='description'>This event is triggered when food is successfully consumed (ie. not during a failed hunger cycle as determined by the Hunger_Consume_Odds <a show='settings'>setting</a>).</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />growth</p>
        <span><p class='description'>This event is triggered when a growth cycle is successfully occurs (ie. not during a failed growth cycle as determined by the Growth_Stunted_Odds <a show='settings'>setting</a>).</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />pregnant</p>
        <span><p class='description'>This event which is raised prior to 'birth' when <a show='settings'>Pregnancy_Timeout</a> is set.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />start</p>
        <span><p class='description'>This event is triggered when a new eco-breed or action-object is rezzed.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />water_end</p>
        <span><p class='description'>This event is triggered when object is removed from water -- occurs only when 'swim' type is used in the move() <a show='methods'>method</a>.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />water_start</p>
        <span><p class='description'>This event is triggered after returned to water (occurs only once after 'water_end' is triggered).</p></span>
        </div>

		<?php print wtheadline('Bind events','are events that are triggered when certain conditions are met and must be activated using the bind() <a show="methods">method</a>.'); ?>             
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />timer</p>
        <span><p class='description'>This event is triggered when a user-defined timer expires. Accepted filter values can be a float or integer. The filter value for 'timer' events accept the 'r' modifier for randomized timing (example: 5r = a random number between 0.0 and 5.0) for each time the event is called. Filter value can <strong>not</strong> be "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />touch</p>
        <span><p class='description'>This event is triggered when eco-object is touched. Accepted filter values can be a name or key defined by a static value or a bind() <a show='attr'>attribute</a>. Otherwise, filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />hold</p>
        <span><p class='description'>This event is triggered when eco-object is touched and held for longer than 3 seconds. Accepted filter values can be a name or key defined by a static value or a bind() <a show='attr'>attribute</a>. Otherwise, filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />region</p>
        <span><p class='description'>This event is triggered when eco-object has changed regions. Filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />collide</p>
        <span><p class='description'>This event is triggered when an eco-object collides with an object, land, or avatar. Accepted filter values can be a name, description, or key defined by a static value or a bind() <a show='attr'>attribute</a>. Otherwise, filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />listen</p>
        <span><p class='description'>This event is triggered when a chat message is displayed in local chat (channel 0). Accepted filter values can be a name, description, or key defined by a static value or a bind() <a show='attr'>attribute</a>. Otherwise, filter value can be "null". This event returns %chatname%, %chatid%, %chatpos%, and %chatmsg% <a show='expressions'>expressions</a>.</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />attach</p>
        <span><p class='description'>This event is triggered when eco-object is attached to it's owner. Accepted filter values include <a href='http://lslwiki.net/lslwiki/wakka.php?wakka=llAttachToAvatar' target='_blank'>attachment points</a>, otherwise "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />detach</p>
        <span><p class='description'>This event is triggered when eco-object is detached to it's owner. Filter value is "null".</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />day</p>
        <span><p class='description'>This event is triggered when it is daytime. Filter value can be "SL" for region-based time, where a regions have 6 days in one regular day. A Second Life day is 4 hours long. You can also use "RL" as a filter for PST-based time, where the sun is up between 6am and 6pm in PST time and sets after 6pm.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />night</p>
        <span><p class='description'>This event is triggered when it is nighttime. Filter value can be "SL" for region-based time, where a regions have 6 days in one regular day. A Second Life day is 4 hours long. You can also use "RL" as a filter for PST-based time, where the sun is up between 6am and 6pm in PST time and sets after 6pm.</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />online</p>
        <span><p class='description'>This event is triggered when owner comes online, or after the object initiates and the owner is online. Filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />offline</p>
        <span><p class='description'>This event is triggered when owner goes offline, or after the object initiates and the owner is offline. Filter value is "null".</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />land</p>
        <span><p class='description'>This event is triggered when eco-object is above the water level. Filter value can be a positive or negative float height offset or otherwise "null" but must match the "water" event bind.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />water</p>
        <span><p class='description'>This event is triggered when eco-object is below the water level. Filter value can be a positive or negative float height offset or otherwise "null" but must match the "land" event bind.</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />moving</p>
        <span><p class='description'>This event is triggered when eco-object is moving. Filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />stopped</p>
        <span><p class='description'>This event is triggered when eco-object stopped moving. Filter value is "null".</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />sensor</p>
        <span><p class='description'>This event is triggered when avatars are detected within a set range. Filter value is the range as a float value, if used with nosensor, ranges must match.</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />nosensor</p>
        <span><p class='description'>This event is triggered when no avatars are detected within a set range. Filter value is the range as a float value, if used with sensor, ranges must match.</p></span>
        </div>
        
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />sit</p>
        <span><p class='description'>This event is triggered when eco-object is being sat on. Accepted filter values can be a name or key defined by a static value or a bind() <a show='attr'>attribute</a>. Otherwise, filter value is "null".</p></span>
        </div>
        
        <div class='expand entry'>
        <p class='title'><img src='img/expand.gif' class='icon' />unsit</p>
        <span><p class='description'>This event is triggered when a previous seated avatar stands up. Accepted filter values can be a name or key defined by a static value or a bind() <a show='attr'>attribute</a>. Otherwise, filter value is "null".</p></span>
        </div>

</span>