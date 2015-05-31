<!--<p>Expressions are only able to be used as values in certain methods. See the <a show='methods'>methods documentation</a> to determine which methods accept expressions. Expressions pull global value data that is created or stored by the breed and action objects. They must be surrounded by percent characters '%' such as: %example%. These expressions can also be used with custom action and breed <a show='extend'>extensions</a>.</p>-->
<!--<p align='center'><strong style='color:red'>If you need to use a % character in your values, use unicode:</strong> &amp;#37</p>
<p style='margin-bottom:0; font-weight:bold;'>Hide/Show Undefined Expressions from Text:</p>
<p style='margin:0; font-size:0.8em;'>If you have text that may or may not have an expression that is defined you can parse the text with a ' / ' character to remove that segment of text. Below is an example where "%MyPartner%" has yet to be defined:</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
say(My name is %MyName%/ and my partner is %MyPartner%/!)
</pre></div>
<p style='margin-top:0; font-size:0.8em;'>The resulting chat message would show: "My name is Eco-Breed!" until a partner is selected.</p>-->


<div style='padding:0 20px;'>

    <h3 style='color: #0F67A1;'>ACTION VALUES</h3>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%action%</p>
    <span><p class='description'>returns the action object name</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%actiondesc%</p>
    <span><p class='description'>returns the action object description</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />%actiondist%</p>
    <span><p class='description'>returns the action object's current distance in float meters from the breed-object</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>key</p><p class='title'><img src='img/expand.gif' class='icon' />%actionid%</p>
    <span><p class='description'>returns the action object uuid</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%actionpos%</p>
    <span><p class='description'>returns the action object's current position</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%action-toucher%</p>
    <span><p class='description'>returns the name of the avatar that last touched the action object</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>key</p><p class='title'><img src='img/expand.gif' class='icon' />%action-touchkey%</p>
    <span><p class='description'>returns the key of the avatar that last touched the action object</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%action-touchpos%</p>
    <span><p class='description'>returns the position of the avatar that last touched the action object</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%Breed_Created%</p>
    <span><p class='description'>number of children the Action Object has rezzed</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%Breed_Pair%</p>
    <span><p class='description'>the name of the Breed_Pair assigned to an action-object when Breed_One_Family is set to TRUE in the action-object's <a show='settings'>settings</a></p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%Food_Level%</p>
    <span><p class='description'>food units remaining in the Action Object</p></span>
    </div>
    
    <h3 style='color: #0F67A1;'>BREED VALUES</h3>   
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%Dead%</p>
    <span><p class='description'>returns 'true' or 'false'</p></span>
    </div>     
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%Growth_Stages%</p>
    <span><p class='description'>returns the remaining growth stages</p></span>
    </div>   
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%MyAge%</p>
    <span><p class='description'>returns the current age</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyDormantSkins%</p>
    <span><p class='description'>returns the dormant skins. displays "SkinName - Category" separated by vertical bar "|" characters.</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyFamily%</p>
    <span><p class='description'>returns the family name (set using the <a show='api'>API</a> or the <a show='myaccount'>My Account</a> page)</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyGender%</p>
    <span><p class='description'>returns the gender</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%MyGeneration%</p>
    <span><p class='description'>returns the generation</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%MyHome%</p>
    <span><p class='description'>returns the previously saved home vector</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%MyHunger%</p>
    <span><p class='description'>returns the current hunger percent</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyKey%</p>
    <span><p class='description'>returns the eco-key (the identifier used to individualize the breed)</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>integer</p><p class='title'><img src='img/expand.gif' class='icon' />%MyLitters%</p>
    <span><p class='description'>returns the number of litters</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyName%</p>
    <span><p class='description'>returns the breed's name (set using the <a show='settings'>Name_Generator</a> or by using the <a show='api'>API</a> or the <a show='myaccount'>My Account</a> page)</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyParents%</p>
    <span><p class='description'>returns the breed's parents. for example "Mom and Dad"</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyParentsRaw%</p>
    <span><p class='description'>returns the breed's parents in raw format. values separated by vertical bar " | ", breeds separated by " && " <br> for example: breed_id|breed_name|breed_generation|breed_gender|breed_traits|breed_skins</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MyPartner%</p>
    <span><p class='description'>returns the breed object's partner (if <a show='settings'>Require_Partners</a> is set to TRUE)</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MySkins%</p>
    <span><p class='description'>returns the breed object's skinset. displays "SkinName - Category" separated by vertical bar "|" characters.</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%MySpecies%</p>
    <span><p class='description'>returns the species name (set by the creator using the <a show='api'>API</a> or the <a show='myaccount'>My Account</a> page)</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%Pregnant%</p>
    <span><p class='description'>returns the time remaining if 'Pregnancy_Timeout' is set, in readable format for example: "3 minutes 25 seconds".</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%Text_Color%</p>
    <span><p class='description'>returns the current hover text color <a show='settings'>setting</a> which can also be set using the val() <a show='methods'>method</a> with the "Text_Color" <a show='attr'>attribute</a>.</p></span>
    </div>
            
    <h3 style='color: #0F67A1;'>ENVIRONMENTAL VALUES</h3>
    <div class='expand entry'>
    <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />%height%</p>
    <span><p class='description'>current height</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%pos%</p>
    <span><p class='description'>current position</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%region%</p>
    <span><p class='description'>current region name</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />%speed% </p>
    <span><p class='description'>current velocity</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>float</p><p class='title'><img src='img/expand.gif' class='icon' />%water%</p>
    <span><p class='description'>water height</p></span>
    </div>
            
    <h3 style='color: #0F67A1;'>INTERACTIONS</h3>
    <div class='expand entry'>
    <p class='tags'>key</p><p class='title'><img src='img/expand.gif' class='icon' />%chatid%</p>
    <span><p class='description'>returns the avatar's uuid from the last menu() or textbox() response or returned from the 'listen' bind() <a show='events'>event</a>.</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%chatmsg%</p>
    <span><p class='description'>returns the message supplied from the last textbox() response or returned from the 'listen' bind() <a show='events'>event</a>.</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%chatname%</p>
    <span><p class='description'>returns the avatar's name from the last menu() or textbox() response or returned from the 'listen' bind() <a show='events'>event</a>.</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%chatpos%</p>
    <span><p class='description'>returns the avatar's position from the last menu() or textbox() response or returned from the 'listen' bind() <a show='events'>event</a>.</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%owner%</p>
    <span><p class='description'>returns the object owner's name</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>key</p><p class='title'><img src='img/expand.gif' class='icon' />%ownerkey%</p>
    <span><p class='description'>returns the object owner's key</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%ownerpos%</p>
    <span><p class='description'>returns the owner's current position</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%sitter%</p>
    <span><p class='description'>returns the sitter's name</p></span>
    </div>	
    <div class='expand entry'>
    <p class='tags'>key</p><p class='title'><img src='img/expand.gif' class='icon' />%sitterkey%</p>
    <span><p class='description'>returns the sitter's key</p></span>
    </div>	
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%toucher%</p>
    <span><p class='description'>returns the toucher's name</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>key</p><p class='title'><img src='img/expand.gif' class='icon' />%touchkey%</p>
    <span><p class='description'>returns the toucher's key</p></span>
    </div>	
    <div class='expand entry'>
    <p class='tags'>vector</p><p class='title'><img src='img/expand.gif' class='icon' />%touchpos%</p>
    <span><p class='description'>returns the toucher's current position</p></span>
    </div>
    
    <h3 style='color: #0F67A1;'>DEBUG VALUES</h3>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%Memory%</p>
    <span><p class='description'>returns the memory in bytes remaining in the regex script</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%this%</p>
    <span><p class='description'>returns the name of the event where this expression is defined</p></span>
    </div>
    <div class='expand entry'>
    <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%Undefined%</p>
    <span><p class='description'>returns the Undefined string, useful to check if another value is set</p></span>
    </div>
    
    <h3 style='color: #0F67A1;'>CUSTOM EXPRESSIONS</h3>
    <p class='sub-in'>Custom expressions are created by user-defined key/name values.</p>
    <div class='expand entry'>
        <p class='tags' title='the results could be a string, vector, integer, list, or float'>mixed</p><p class='title'><img src='img/expand.gif' class='icon' />%prop_identifier%</p>
        <span><p class='description'>To access information created using the prop() <a show='methods'>method</a>, call the identifier as an expression.</p>
        <p style='font-weight:bold;margin:0;'>Example: </p>
        <div class='codeblock'><pre style='font-size:1.2em;'>prop(Happy,100)
        text(Happiness: %Happy%)</pre></div>
        <p class='description'>This example uses the prop() <a show='methods'>method</a> to set "Happy" to 100 then displays the results in hover text similar to:</p>
        <div class='codeblock'><pre style='font-size:1.2em;' align='center'>
        Happiness: 100</pre></div>
        </span>
    </div>
    <div class='expand entry'>
        <p class='tags'>string</p><p class='title'><img src='img/expand.gif' class='icon' />%skin_category%</p>
        <span><p class='description'>To access specific active skins by their category (set from the <a show='api'>API</a> or the <a show='myaccount'>My Account</a> page), call the category as an expression.</p>
        <p style='font-weight:bold;margin:0;'>Example: </p>
        <div class='codeblock'><pre style='font-size:1.2em;'>text(Fur: %Fur%\\nEyes: %Eyes%\\nTail: %Tail%)</pre></div>
        <p class='description'>This example assumes you have the skin categories of "Fur", "Eyes", and "Tail" with skin names "Brown", "Green", and "Long and Bushy" respectively. The core code will parse the information and display the results in hover text similar to:</p>
        <div class='codeblock'><pre style='font-size:1.2em;' align='center'>
        Fur: Brown
        Eyes: Green
        Tail: Long and Bushy</pre></div>
        </span>
    </div>

</div>

<div style='height:50px'></div>