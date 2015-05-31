<pre>
Takecopy eco-breeds : daily developer notes.

============================
	NEXT VERSION:
============================

 version 1.0
*new: user friendly interface
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


docs:
 version 0.222 
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


Allow_Throttling

-add to docs-
+*added: toggle() method now supports expressions
+*added: optional 5th value for bind() : set %actionid% for limiting callbacks to sender objects only
+*added: combine toggles by separating callbacks with vertical line '|' 
+*added: 'Lineage_Globals' to pass on globals to offspring and 'Lineage_Selection' to select which parent
+*added: Gravity_* settings for each movement type
+*added: 'Prim_Material' setting : for fine tuning friction behavior
+*added: 'Ground_Friction' setting : for fine tuning friction behavior for ground objects
+*added: 'Preferred_Skins' setting : apply only these skins if available

Gravity_walk
Gravity_run
Gravity_jump
Gravity_hop
Gravity_swim
Gravity_float
Gravity_hover
Gravity_fly
Pause_Anims,Pause_Move,Pause_Core,Pause_Action

============================
	IN PROGRESS:
============================

to do before release:
 => Limitations/Subscriptions : skins|anims|action|breed
 => Compatibility/Conversion
 => MYSQL INJECTION : editval
 => version control - redeliver link
 
 js|editval => newline \n bug fix
 
fix: multiple start event calls
test: #method() extension calls 
test: 'breed_dead' after revive on DB
inworld:
    data injection:
        Action 'Food_Value' injection (spoiling food extension)
    anim timer : speed up anims
	core event timeout expression

docs: 
	references within account page
    clean up & redirect old pages

front page:
	sales teaser : 6 emotions { security(safe|powerful), fun(toys|games), wonder(inspire), love(paternal), ownership(rights), lust(money) }
    videos ^
    buy link : after teaser
    stats : creators, breeds|active, species|active, skins, anims, action_configs, breed_configs

sidebar:
	forum feed
    
extensions/add-ons:
	create page








	CONTINUED =>

-schedule-
* inworld coding through 18 or 19
* videos on 20/21 
* week of extensions and examples until 25/26 where i can take on self-hosting and upgrade the API
* finish the month off with a new parcel design and a new release to roll out

SIDEBAR: forum.feed
API: accounts.results => daemon | long cron
CRON: premium.webextension => trait injection
CONSOLE: premium.webextension => method injection

-extension-
[free] Version Control
[free] data injection extension: movement params
control movement extension
spoiling food extension
particle up extension
solar panels
anim: ALL PARAMS flexi-light-etc
trouble shooting syntax
////ECO-CHAMBER
-local-
authenticate : update timer
"insert" breeds : limit breeds 
rebuild breeds : name or ALL
rez offspring : from command
transfer ownership : re-auth on-rez
show stats : name, age, family, gender, generation, skins, parents, partner, hunger

-remote-
send => settings & breed keys
handle => hunger, growth, ageing, and breeding
return => breed "stats" based on settings & breeding/food commands

-todo-
remove name from menu once rebuilt (check rebuild key & update)
web: max timer, if breeds stay in too long, they get rebuilt automatically
update food level (based on consumed) via cached result [if not -1 : existing - consumed]
//CRATE
add: rebuild crated breeds
add: eco-crate menu
//PREMIUM ADD-ONS:
easy trait: range(happiness, min|max) threshold(happiness>50,callback [,once]) increase(value, min|max, min|max) decrease(value, min|max, min|max)
action: version control : lower version + throttle type = die
breed: fighting extension : via prop() value insertion
action: breeding chamber.. add NUM breeds (HYBRID ADD-ON)
breed: remote method uploader (email or secure chan)
action: action toggle text - action.menu addon | show throttle breed names
breed: #fadeText() for breeds

-walkthrough-
page : Automatic Hide/Show - core:rebuild
page : Manipulating food levels - core:food
page : Food spoilage - core:food
page : Creating limited food sources - core:food
page : Starvation - core:food
page : name generator library - core:names
page : Create values that pass down through the lineage - core:breeding
page : "Domestication" - core:breeding
page : PACKAGING/SELLING (5:59)
page : ACTION MENU PLUGIN W/ EXAMPLE FUNCTIONALITY (7:42)
page : AUTO-PILOT FLIGHT SIMULATION (6:05)
page : A GAME OF FETCH (6:49)

-WEB-
front page stats
extensions pages
	page : action menu - core:action 
	page : SETTING UP THE ECO-CRATE (11:26)
slow skins - adjust skin-num for max skins
redo the API
cookies-web: [08:04]  chengs Kidd: i relog because sometimes it doesnt show anything.
TEST|FIX: count number of skins APPLIED and count for children as well
cron: subscription expiration : alter user table AND delete old record AND warn 1 month & daily 1 week in advance
throttle breeds based on creation limits : requires breed_creator  
add: record throttled : notify user option
web: mom profile: NUM litters / NUM children [list children names & links]
web: "destroy breed"
database backup protection
fork configs
change: re-minify js
//API
test: API (BUGS w/ names etc)
web: API usage page: throttle_count / total_requests


-VIDEOS-
test & video: (1 hr) Predator/Prey
video: *Rebuilding (hide/show or missing pets - auto delete extras)
*Feed the fishes
*Hunting - to kill a mockingbird
*Ride the Minnow: Three Hour Tour
*conditional filters - sleep, play sounds, etc
*hand-feedable fish
*wandering bird (advanced animations/movement) + home + birdbath + feeder
*teleportation
*greeter bot

-FINISHED-
backup/update/release

<!--

"start",
"say(Hello %owner%, I am %MyName%)
 bind(timer, 20, text)
 bind(touch, all, touched)",
 
"touched",
"say(Hello %toucher%, I am %MyName%)",

"text",
"text(
Name:%MyName%
Gender:%MyGender%
Age:%MyAge%
Health:%MyHunger%
Dead:%Dead%
)"
<!--Some may have developed certain emotions such as fear, some may be social and others territorial. You may have species that tend to form hierarchies, and others who seem to have the sociatal position. Their sleep patterns, metabolism, sexual preferences, and overall idle behavior may vary. The Eco was designed to interpret and simulate all species, from flighted birds to ground mammals, insects, tree-dwellers, and fish. For each species, sub-groups can be created with different body shapes and skins, as well as preferences for types of homes and food sources, with their own unique behaviors, personalities, and other traits.-- >


 -requests-
Jamie: TEDDY BEARS <!--

Traits (1 per breed)

Attributes: [Learned within first month, limited to leveling 2 attributes per bear, passed on through breeding but reduced by percent]
Speed (speed boost)
Agility (move timer boost)
Stamina (length of speed boost)
Health (length of lifespan)
Potency (breeding: large litter rarity, failed births, birthrate)

Action Object: [allow action object to handle more specific simulations]
	Medicine - Can see if pet is sterile. 
//x//Breeding - Allow forced breeding
!Farming - Allows pets with certain traits to increase food levels
	Education - Applies attributes & traits based on predefined settings
	Group/Clan - Home (family or clan home), Attention (increases individual or clan levels)
	Divorce - forced unpairing
	Special-Food - Revives from "Death" event
	Rebuild - User places bear next to hutch and clicks on hutch to take it inside. 
    !HUD - Extend to touch:link interactions w/ specific bears to trigger actions

 -- >
Moden: FULL PERM SCRIPT
Lexx: AIRSHIP 

 
-later ideas-
web: sync skinsets / blend parents / combo skins
extension: web control breeds: chat, etc
vendor extension : display content's stats | owners can kill off breeds and get credits added to their account 
breed|web : set species in script & remove set species name on server
add: texture scale
add: age difference max
takecopy global : web api, credits, future releases, automatic updating
eco payment plan

-star-
sound/heat sensors
face/gesture recognition
alert levels/visitor priority icons
visitor patterns
Grid Star: compress static imagery to 3d renderings. cache hd, display false avatars,
RedditUps - Contact List

--TABS--
unlimited => silverdown seetan  (paid L$5200) (owes L$25300) (start 02/04/2012) (expires 02/05/2013)
ecopackage => kyle278 Chrome (paid L$10500) (owes L$4750) (start 02/09/2012)
ecopackage => kyle278 Chrome (paid L$2000) (owes L$2750) (on 03/05/2012)
//"start", 
//"say(Hello, Eco!)
// text(eco-Breeds v%Version%)"






Price Margin for Recurring Services
	
    Treat each business like an individual. According to trends in consumer spending, the average consumer has a comfort level of about 1 day's worth of income per year for a quality service, for example a $15/mo subscription service. Many others will pay up to 1 day's worth of income per month for more important services, such as for phone, tv, lawn care, etc. 
    When you compare the income levels of the average consumer with the average small business, these trends give us a price margin of about $2k to $10k per year.
    This is helpful for understanding the psychology of consumer commitment to a recurring service.
    
-->
<!--
    ..........................................................................
    ///////Tohickon Valley Park: http://imgur.com/a/6NjG2 215 297 5625 ///////
    ..........................................................................
-->
</pre>
<!--$integer = 'An integer is a is a whole number (no decimals) with valid range from -2147483648 to 2147483647 or a TRUE | FALSE value';
$float = 'A float is a number (positive or negative) with or without a decimal point';
$vector = 'Vector literals are formatted as <x,y,z>. A vector can be used to represent a 3-dimensional position, direction, velocity, force, impulse, scale, color, or rotation (in Euler format)';
$rotation = 'A rotation is a variable type comprising 4 floats used together as a single item. This data is interpreted as a quaternion.';
$string = 'A string is a sequence of characters limited in length only by available memory. Strings are enclosed in quotation marks (").';
$list = 'Lists are created via comma-separated values (CSV) of the other data types. enclosed by square brackets: "[" and "]".';-->

<!--* Support 7 Days a Week.
* Go to http://eco.takecopy.com for more info.

This project was built for everyone from beginners to advanced programmers. The eco stack 
provides a fast and concise LSL library that simplifies event handling, prim animations, and 
avatar interactions for rapid virtual pet development. This full featured LSL framework is lightweight 
and built with progressive enhancement, and has a flexible, easily scale-able design for adding 
features to physical and non-physical animals, pets, and other creations. 

All features are optional and extendable!

ACTIONS: Define what your breeds do, how they behave, and when various events are triggered. An extensive library of methods have been created to give creators a vast resource of feature-rich functionality that help to make their breeds truely unique. Multiple food sources, homes, toys, and other interactions can easily be created. Each "action object" can also limit the total number and type of breeds allowed to interact with it.

BREEDING: There are hundreds of possible breeding configurations to cover all possible mating/breeding/pregnancy behaviors ranging from gender and partner filters, such as asexual, same-sex, monogamous, polygamous breeding with incest filters as well as a variety of timers and limiters including timeout queues for lost/missing partners, pregnancy time, min/max breeding age and litter sizes, number of births and odds filters that detrmine genders, failed births, and rare litter sizes. Skins and traits can also be configured to pass on through the genetic string to all or select offspring.

COMMUNICATION: Easily configurable menus, text-inputs, hover text, and local/private chat methods allow your breeds to communicate with other avatars with a variety of expressions which allow you to insert dynamic values such as breed stats and other important data.

CUSTOMIZATION: Breeds and action objects can be extended using LSL plugins to add your own personal touch to the project. An API has been created to give web developers the ability to integrate their breeds on their own site. This API is simply a data feed for all information related to an individual avatar and is the same array used for inworld and front-end data requests.

EVENT FLOW: The eco stack is progressive which means you may bind/unbind dozens of events with customizable filters such as owner-only/non-owner/group touches or pre-specified timers as well as listen/sensor and environmental conditions. You may also use a variety of filter methods to determine the course of the event flow. Events can also be paused, toggled, and disabled/enabled entirely.

GROWTH: Growth is a timed event which is defined by growth stages, rate, and scale. All prims are scaled and repositioned, the scale is saved to be applied in conjunction with prim animations to ensure growth and prim manipulation works seemlessly together.

HUNGER: Food can be provided with different levels and qualities as well as limitations to number of breeds it can feed. Multiple sources can be provided and food can be "farmed" or produced as a trade item that maintains it's value until consumed by your breeds. Food can not be exploited unless the creator gives the secure key and the 3rd party is part of the eco-project.

MOVEMENT: Twelve (12) built-in physical AND smooth non-physical movement behaviors encompass ground, flighted, and swimming motions which can be used together or individually to allow you to have animals and objects that behave naturally based on environmental or toggled conditions. Breeds can be configured to be environmentally aware to avoid obstacles and hazards such as objects, avatars, slopes, water, and region/parcel crossing. 

PRIM ANIMATIONS: Prim methods allow you to easily trigger poses and multi-frame animations at any time with a configurable delay. These methods also allow you to create accessories and other physical attributes which can be applied during event flow or as a separate add-on like hats and wearables.

REBUILDING: Lost/missing breeds can be rebuilt using an action object; breeds maintain their last known definitions such as skinset, age/hunger, and add-ons like accessories or custom traits. This is also useful for updating your customers if/when changes are made.

SKINS: Lineage can be preserved throughout generations and allow breeders to create unique breeds. Rare, unlockable, or limited edition skins can be created, as well as skin-specific animations that are useful when one skinset uses different prim configurations than another. Dormant and active skins can be displayed individually or as their set when accessed as an expression. You can apply separate categories which allows you to mix and match features or pure breeds that are all-inlusive skinsets.-->