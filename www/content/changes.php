<pre style='font-size:0.9em;letter-spacing: -0.09em;'>

 work in progress: 
* videos and tutorials
* stats visualizations

 version 1.013 (3/19/2012)
changed: numbered scripts for easy installation
added: '-link' master command for allowing link/unlink extensions
fixed: action object now resets queue when rez attempt fails
added: %failed_births% to display rez attempt fail count
added: Growth_Offset setting to help creators fine tune position after growth

 version 1.012 (testing: 3/16/12)
*fixed: large breedstrings truncated by SL chat limit : removed local skin data from string
*fixed: animation request key mishandled during iteration of payloads greater than 1024 char.
*changed: val() key is now case insensitive
*added: %partner_owner%
*added: '-male' '-female' master commands (requires reset)
*changed: bind() events are now case insensitive
*added: '-refresh' master command for action object to reset settings without resetting values
*fixed: added filters to ownership reset for creators, for security and consistency
*fixed : "Delta times must be >0.1s" error 
*changed: objects without keys now auto-detect when key is added

 version 1.011 (testing: 3/14/2012)
*changed: '/' undefined wrapper to curly braces
*added: texture flags for offset and repeat
*fixed: skin params unset early

 version 1.01 (open testing: 3/13/2012)
*added: master commands : '-alt' '-skin' 
*fixed: stabilized ownership and identity
*changed: '-refresh' now also refreshes settings!

 version 1.0 (closed testing: 3/12/2012)
*new: user friendly interface
*redefined expressions for uniformity
*optimized all requests and functions: avg exec time 0.05 to 0.005 sec
*optimized for performance: task-oriented procedural php | associative mysql
*changed: new prop values can be self referenced without returning null values
*changed: non-physical growth into ground : compensated using bounding box formula
*added: boolean conditions in filter() and rfilter()
*added: pos/rot anims : pos(prim, vector|rotation, vector|rotation, ...)
*added: prim methods accept '0' to define zero_vector or zero_rotation
*added: toggle flag for bind() 'timer' event:  bind(timer|toggle, 20, event)
*added: channel flag for bind() 'listen' event: bind(listen|3, owner, event)
*added: support for external breed hosting 
*added: support for remote method injection
*added: support for remote global injection
*added: authorized users for easy co-op
*added: debugging console for active breeds
*added: %rand% : random true/false
*added: %time% : unix timestamp
*added: %hour% : hours since midnight
*added: %chan% : hidden channel
*added: %appetite% : time until hungry
*added: %maturity% : time until ready to breed
*added: %appetite_raw% : unix time until hungry
*added: %maturity_raw% : unix time until ready to breed
*added: %pregnant_raw% : unix time until giving birth
*added master commands: '-local' '-child' (requires reset) '-debug' '-start' '-stop' '-reset' '-rebuild' '-refresh' '-dump'
*added: %species_id% and %config_id% : for sub-species identification

 version 0.222 [stable] (1/25/2012)
*fixed: eco-crate born breeds not growing : growth_stages were set to 0
*changed: eco-crate born breed's MyPartner set to Undefined_Value instead of "None"
*changed: 'Food_Empty_Die' to 'Food_Threshold' to destroy food objects below certain level
*changed: bind() timer will now reset timeout for subsequent requests
*changed: 'listen' bind() now accepts custom channels : default = 0
*changed: move() type can include anim names separated by '|' vertical bar to sync move w/ anims
*added: 'Event_Overflow' action setting to throttle requests to prevent overflow
*added: support for eco-chamber
*added: 2-way throttle to more precisely limit breeds to action objects
*added: 'Action_Sync_Timeout' setting to support 2-way throttles
*added: 'Reserve_Food' and 'Reserve_Breeding' to assign food/breeding source for extensions only
*added: 'Auto_Activate' to action object for secure rezzing
*added: Pause_* settings to control what functions are paused using the pause() method
*added: 'End_Move_Physics' setting : disable physics after movement is complete
*added: 'Anim_Each_Move' setting : control synced anims 

 version 0.221 (1/15/2012)
*fixed: bind() timer was accidentally disabled in version 0.220
*added: toggle() method now supports expressions

 version 0.22 (1/14/2012)
*fixed: authentication protocol sometimes fails when re-rezzed
*fixed: growth during movement sometimes causes a conflict in physics
*fixed: a new bind() timer resets all timers, reducing accuracy : changed to independent unix timers
*fixed: 'pregnant' event only raised in action object where birth will occur
*changed: reduced overhead memory in several breed/action scripts
*added: %actionid% expression
*added: optional 5th value for bind() : set %actionid% for limiting callbacks to sender objects only
*added: combine toggles by separating callbacks with vertical line '|' 
*added: 'Lineage_Globals' to pass on globals to offspring : 'Lineage_Selection' to select which parent
*added: Gravity_* settings for each movement type : for fine tuning effect of gravity
*added: 'Prim_Material' setting : for fine tuning friction behavior
*added: 'Ground_Friction' setting : for fine tuning friction behavior for ground objects
*added: 'Preferred_Skins' setting : apply only these skins if available
*added: "Limit" filter for skins on the user dashboard

 version 0.218 (1/9/2012)
*fixed: prop() values fail for crate-born breeds
*fixed: empty val() values return Undefined_Value
*fixed: reset 'MyPartnerName' for rebuilt breeds
*fixed: uncache non-cached saved animations when rebuilt (say it 5x fast)
*fixed: unlimited food_level = -1 not working
*fixed: timestamps re-calibrated when revived
*fixed: prevent html injection during server downtime
*fixed: Object_Rez_Radius minimum value accepted is 0.01 to avoid math error
*fixed: if filter() is last method, cached methods in next event are lost
*changed: 'food' event will now only trigger from food object consumed from
*changed: core ageing algorithm to be more precise : comparing unix timestamp to date of birth
*changed: Lifespan_Age_Max : -1 allows breed to age indefinitely
*changed: dead breeds will now raise a 'dead' event instead of 'start' 
*changed: prim methods now accept 'null' values to skip frames for more advanced animsets
*changed: Debug_Mode to 'Save_Records' for clarity
*added: 'Dead' attribute to val() method : 0 = dead | 1 = alive
*added: 'Globals' list setting : creates prop() start values when breed is born/created
*added: Gender label settings
*added: Object_Rez_Pattern setting to set number of rez locations : 0 = standard
*added: Object_Rez_Arc setting to give rez radius a custom arc
*added: Object_Rez_Offset setting to offset the rez position from the root prim's center
*added: 'Text_Prim' and 'Text_Alpha' settings for more control over the hover text

 version 0.217 (1/1/2012)
*fixed: sound() method using uuid not triggering
*fixed: 'Hunger_Start' not being passed to crate-birthed breeds
*fixed: increased event queue capacity by 40%
*fixed: non-attribute move() speed accurracy 
*fixed: method strings starting with toggle() silently failing
*fixed: throttle slots filling prematurely | some breeds not activating when rapidly introduced
*fixed: fail-safe resize error when avatar(s) sitting during growth event
*changed: 'Auto_Activate' may contain a secure start_param for secure rezzing of 1st gen breeds
*changed: Female_Odds : -1 = male
*changed: 'Move_Attempts' : -1 = unlimited attempts
*added: 'Event_Throttle' and 'Allow_Duplicates' settings : for event queue management 
*added: 'Allow_Drift' setting : allow to drift beyond destination point
*added: 'Turning_Efficiency' and 'Turning_Time' settings: more control over turning
*added: 'Legacy_Prims' setting : determine which prim system to use for your objects
*added: 'Cam_Pos' and 'Cam_Look' settings : to set the camera position when sat on
*added: 'Action_Retry_Timeout' setting : timeout for breed to check for open action slots
*added: 'Allowed_Keywords' setting : Allow Throttle_Types that contain these keywords/expressions
*added: 'Owner_Only' setting to Action and Breed objects to allow cross-owner communications
*added: 'Sit_Adjust' and 'Cam_Adjust' setting : adjust sitpos and camera during growth
*added: Seventeen (17) settings to the val() method for more dynamic control of breeds

 version 0.216 (12/27/2011)
*fixed: multiple simultaneous filter() calls result in data loss 
*fixed: action-object event queue optimization
*fixed: sound() method not escaping event flow
*fixed: bind() method not escaping event flow
*fixed: Lifespan_Age_Start not updating Age at birth
*added: expressions to cache() method
*added: rez() fail-callback for invalid rez positions and objects
*added: %this% expression to return current event
*added: minimum bind() timer event limit is 0.1 to avoid math error
*added: 'Throttle_Type' setting : breeds limited to 1 action-object of each type unless blank
*added: 'Select_Highest_Gen' setting : if TRUE find highest parent generation +1 | else lowest +1
*added: 'Preserve_Lineage' setting : determine how offspring choose their skins
*changed: truncated "rebuild" button length and added dialog fail-safe
*added: multiple callbacks within bind() separated by vertical bar '|'
*changed: Lifespan_Survival_Odds when set to -1 will allow breed to age indefinitely
*added: fail-safe to menu() and textbox() to avoid invalid arguements
*added: rfilter() : returns callback if condition is TRUE | continues method string if FALSE
*added: randomized '~' modifier to prop() method to create a random number between 0 and NUM
*added: 'Target_Dist_Min' settting : how close it must get to the target position
*added: 'nonphys' and 'nonphysUp' movement behaviors for smooth nonphysical movement
*added: 'Move_Speed_nonphys' and 'Move_Speed_nonphysUp' movement type speed settings
*added: 'Finish_Move' setting : finish move before taking new position | interupt current move
*added: inString '~' operator for filter() method to check if VALUE is in ATTRIBUTE string
*added: '/' special character : removes segments of text where expressions are not defined
*added: 'Partner_Timeout' setting : num breed cycles without partner before becoming single
*added: 'Pregnancy_Timeout' setting : Time in minutes between breeding and birth
*added: 'pregnant' event which is raised prior to 'birth' when Pregnancy_Timeout is set
*added: %Pregnant% expression, time remaining for pregnancy
*changed: 'Breed_Age_Max' setting can now be -1 for no max age limit
*added: 'Initializing_Text' setting : display custom message during load

 version 0.215 (12/08/2011)
*fixed: found a bug when unsetting multiple cached animations
*changed: animations will no longer stop when breed dies, use "dead" event to unset anims
     
 version 0.214 (12/08/2011)
*fixed: Hunger_Death_Odds when set to -1 : never dies from hunger
*fixed: skin/anim 1024 character limit : repeats request until all results are read
*fixed: action-extension methods not being toggled every time : channel sent with custom method
*fixed: 'start' event of new action-object no longer toggles other action-objects
*fixed: web-skin algo : force select one skin from each category
*changed: skin/anim params are now interchangable : now known as 'Prim Methods'
*changed: split expressions script from methods script to increase memory for each
*changed: moved non event-flow methods to methods script to increase memory for events
*changed: move() method can be stopped and physics disabled by calling an empty method
*changed: Breed_Desc_Filter can now be compared against current action object desc
*added: cache(anim,anim ...) method to select anims to load before running : must load each anim
*added: release cached animations to maintain resources : uncache(value,value ...)
*added: set/unset multiple anims using vertical bar '|' : set/unset(anim|anim|...)
*added: offset for bind() events 'water' and 'land'
*added: move() flags : avoid obstacles and hazards with callback
*added: prop() operators '*' and '/' for multiply and divide
*added: 'frames' to unlimit the anim frames : method(prim, [face,] value, value, value ...)

 version 0.213 (12/03/2011)
*fixed: event expiration when callback is not found
*fixed: trimed whitespace in rez() method values
*added: expressions to move() offset values to allow user-defined radius

 version 0.212 (12/03/2011)
*fixed: single prim objects not growing correctly
*fixed: reset time when timer-based val() attributes are applied
*fixed: action-extension methods repeating
*moved: action event handling into action-handle to free up script memory for more functionality
*changed: Name_Set_Object to string with expression value
*changed: Breed_Litters can now be set to -1 for infinite
*changed: toggle() now accepts multiple callbacks, only one random callback is toggled
*changed: selects available food sources more randomly
*changed: moved bind protocol from "breed-events" to "breed-setbind" to expand functionality
*changed: unbind() with no value now unbinds all previous binds
*changed: enabled full functionality after death, only lifespan, hunger, breeding, and growth stops.
*changed: unbind() multiple events by seperating their handles with a comma
*changed: added on_rez param to rez() method as 3rd value
*added: 'action-classes' add-on script : unlimit events/methods
*added: bind events 'day' and 'night' bind events  filter = 'RL' and 'SL' 
*added: bind events 'online' and 'offline'  filter = null  (checks owner)
*added: bind events 'sensor' and 'nosensor' filter = range  (type = avatar)
*added: bind event 'listen' filter = attribute (channel = 0)  returns %chat***% expressions
*added: native event 'growth' when growth occurs during growth cycle, not during rebuilding
*added: prim animation alpha() to set prim animations using transparency (float value)
*added: %Dead% expression to check whether breed is alive or dead : returns 'true' or 'false'
*added: %actiondist% expression to check distance in float meters from action-object
*added: %Undefined% expression : useful to check if another value is set
*added: %Growth_Stages% expression to determine current growth stage
*added: 'Object_Rez_Radius', 'Object_Rez_Height', 'Object_Rez_Rot' offsets for rezzing breeds
*added: 'Num_Breeds', 'Breed_Timeout', 'Breed_Desc_Filter' to limit num breeds per action object
*added: 'Text_Limit_Breeds' Show remaining slots available for breed functionality

 version 0.211 (11/24/2011)
*fixed: anims not setting when breed first created via "start" event
*fixed: generations reset when breed is rebuilt
*fixed: set object name/desc when MyName value changes
*fixed: owner not set during breeding while owner offline
*fixed: webskin algorithm : force set all categories (was not 100% accurate)
*fixed: unable to use % character in values, created percent expression &#37
*added: %MyParentsRaw% expression
*added: filter() "^" operator for 'list contains'

 version 0.21 (11/23/2011)
*fixed: filter bug - improperly filtering float/integer values
*fixed: action extension bug - unable to toggle events
*added: cross_region parameter to move() to allow breeds to move between regions
*added: stitch, mirror, and invert flags to sculpt() skin and anim methods
*fixed: enhanced security by requiring Creator_Name to match the user
*fixed: pass null values without data loss
*fixed: skin algo will attempt to apply each skin category 
*fixed: undefined expressions return "Undefined"
*fixed: age was being reset when breed is rebuilt
*added: Lifespan to val() attributes : to disable/enable aging
*added: Lifespan_Age_Min and Lifespan_Age_Max to val() attributes

 version 0.2 (11/19/2011)
*fixed: child breeds prematurely choosing partner & stabilized 'Unique_Partners' filter
*changed: skinset algo to webserver : now allows you to set skin categories
*fixed: color() prim anim method was setting alternate value even though none was given
*fixed: one birth per breed cycle no matter how partnering is set
*changed: ALL prim animations now compatible with growth
*fixed: auto_activated breeds re-compile once for first new owner/recursively for creator 
*added: set(class [,save]) : saves the anim to be reapplied when rebuilt
*added: unset(class [,remove]) : removes saved anims
*added: %MyDormantSkins% expression : view a list of non-applied saved skins 
*added: %MyFamily% expression : view family name
*added: %MyKey% expression : view objects eco-key
*added: %MySpecies% expression : view species name
*added: skin expressions %category_name% for displaying current skin used per category
*removed: Pure_Breed setting to enable categories
*added: shorthand prim methods ->  texture(-1,-1,uuid) or  texture(1|2|3,1|2|3,uuid)
*added: API for web developers for creating a custom UI for their customers
*added: prop() method for creating/editing user-defined values
*added: expressions ->  %Text_Color% %Memory% %MyPartner%
*added: val(global, value [, global, value]) method for setting native global values 
*extended: filter(condition, callback [, condition, callback])
*changed: filter() condition 2nd value property can be attribute
*added: on(event) off(event)  for disabling/re-enabling native events/custom callbacks
*added: give(key/%exp%, inventory_name)  to give inventory
*added: textbox(who/%exp%, msg/%exp%, callback) -
*added: textbox() & menu() result expressions: %chatid% %chatname% %chatmsg% %chatpos%
*added: type() anim method for setting prim type & optional params
*added: revive() method => re-enables breed with years and/or starting hunger level
*added: native action touch-toggle events touch-name-*** touch-desc-*** touch-num-***
*added: action hover text option Text_Breed_Pair : text populated via %value%
*added: extension toggle events and increase food levels
*added: auto-params script for creating skins/anims

 version 0.13 (10/21/2011)
*added: 'hold' bind event for detecting long touches
*changed: auto-remove hover text and physics when script is recompiled
*fixed: stabilized authorization and start procedures
*fixed: stabilized link_message overflow queue 
*changed skin name is now 'None' when Skins are disabled
*changed: starting generation always 1 for parent breeds
*added: set object description to 'debug' to monitor authorization protocol
*fixed: Lifespan death odds normalized

 version 0.12 (10/13/2011)
*fixed: white space trimmed from skin attributes
*fixed: prim animations repeating when they shouldnt
*fixed: action-object die() method was not set
*added: action-extension expressions: %Breed_Created% and %Food_Level%
*fixed: incorrect food unit rates w/ multiple food sources

 version 0.11 (10/10/2011)
*added: action-object extensions

 version 0.1 (10/6/2011)
*release candidate

</pre>