<?php


//KEEP FOR THE API PAGE
//		$my_stats['api_key']="";////////////////////////////////////////////////////////////////DEBUG
//		if($my_stats['api_key']==""){
//			print "<div id='api_key'><p><strong style='color:#666;'>API key:</strong><a id='get_api' style='font-size:1.0em;'>Click here to create one.</a> <img src='img/help.png' title='The eco API gives you remote access to breed data for web/app development.' style='margin-bottom: -2px;'/></p></div>";
//		}
//		else{
//			print "<p><strong style='color:#666;'>API key:</strong><input readonly class='disabled-input wide-input' value='".$my_stats['api_key']."'/></p>";
//		}

?>

<p>All eco-breeds connect to a webserver to store their unique values. This data can be accessed using the API which returns <a href='http://json.org/example.html' target='_blank'>JSON</a> results for all existing breeds linked to your account, as well as 'species' data which defines the skins and animations for all of your breeds.</p>


<!--<p style='font-weight:bold;margin:0;margin-top:30px;font-size:0.85em;'>EXAMPLE JSON RESULTS</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;height:250px;'><pre>
{
   "eco":{
      "user":"dev khaos",
      "uuid":"1ea7db73-9be2-44b1-9227-b810f341c4a7",
      "version":"0.2",
      "grid":"Second Life",
      "species":[
         {
            "species_name":"Default",
            "species_chan":"-123456",
            "species_skins":"Red:#:Fur:#:1:#:0:#:color(-1,-1,&lt;1,0,0&gt;):#%White:#:Fur:#:1:#:0:#:color(-1,-1,&lt;1.000,1.000,1.000&gt;):#%Blue:#:Fur:#:1:#:0:#:color(-1,-1,&lt;0.000,0.000,1.000&gt;)",
            "species_anims":"Flashing Collar:#:-1:#:2:#:color(9,-1,&lt;1,0,1&gt;,&lt;0.5,0,0.5&gt;):#%Black Collar:#:0:#:0:#:color(9,-1,&lt;0,0,0&gt;):#%Walk:#:-1:#:0.35:#:rot(12,&lt;0.000,0.156,0.000,0.987&gt;,&lt;0.000,-0.130,0.000,0.991&gt;)rot(13,&lt;0.000,0.190,0.000,0.981&gt;,&lt;0.000,-0.224,0.000,0.974&gt;)rot(14,&lt;0.000,-0.224,0.000,0.974&gt;,&lt;0.000,0.207,0.000,0.978&gt;)rot(15,&lt;0.000,-0.190,0.000,0.981&gt;,&lt;0.000,0.173,0.000,0.984&gt;)"
         }
      ],
      "breeds":[
         {
            "breed_id":"2818eD5BF19c1A8e19fC353c",
            "breed_name":"Test Name",
            "breed_owner":"dev khaos",
            "breed_family":"Test Family",
            "breed_gender":"Female",
            "breed_born":"1321583792",
            "breed_dead":"1321584992",
            "breed_age":"20",
            "breed_species":"Default",
            "breed_skins":"Red~Fur~2|White~Fur~1|Blue~Fur~1",
            "breed_hunger":"40",
            "breed_parents":"None",
            "breed_generation":"1",
            "breed_grid":"Second Life",
            "breed_chan":"-123456",
            "breed_creator":"dev khaos",
            "breed_pos":"&lt;91.821281, 48.415848, 38.654415&gt;",
            "breed_region":"Crimson",
            "breed_litters":"5",
            "breed_anims":"",
            "breed_growth_total":"1.000000",
            "growth_stages":"0",
            "breed_version":"0.2",
            "breed_update":"1321587572",
            "breed_partner":"78E72E203a3Eae400BA05b0FA"
         }
      ]
   }
}
</pre></div>-->
<!--<p class='api_data'>PARSING REQUIREMENTS</p>
<p style='margin-top:0;margin-bottom:25px;font-size:0.75em;'>
<strong>species_skins:</strong> <em style='margin-left:5px;'>Name, Category, Generation, Odds, Params</em>  
<br />
These values are dumped to a string using ":#:" as a separator. When combined to a list with other skin strings, they are then dumped to a string using ":#%" as a seperator.
<br /><br />

<strong>breed_skins:</strong> <em style='margin-left:5px;'>Name, Category, Applied</em>
<br />
These values are dumped to a string using "~" as a separator. When combined to a list with other skin strings, they are then dumped to a string using "|" as a seperator. Where "Applied" is "2" for applied and "1" for dormant.
<br /><br />

<strong>species_anims:</strong> <em style='margin-left:5px;'>Name, Repeat, Delay, Params</em>
<br />
These values are dumped to a string using ":#:" as a separator. When combined to a list with other anim strings, they are then dumped to a string using ":#%" as a seperator.
<br /><br />

<strong>breed_anims:</strong> <em style='margin-left:5px;'>Anim_Identifier</em>
<br />
These values are dumped to a string using "|" as a separator.
</p>-->



<p style='font-weight:bold;margin:0;font-size:0.85em;'>REQUEST URL</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
http://eco.takecopy.com/api/?api=API_KEY
</pre></div>
<p style='margin-top:0;margin-bottom:25px;font-size:0.75em;'>
Maximum 60 requests per minute.
</p>

<p style='margin:0;font-size:0.75em;font-weight:bold;'>
You can also use POST to view your results, such as this php|curl example:
</p>

<div class='codeblock' style='overflow:auto;font-size:0.9em;'>&lt;?php<pre>
	$api_key = "YOUR_API_KEY_HERE";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://eco.takecopy.com/api/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "api=".$api_key);
	$json = json_decode(curl_exec($ch),true);
	curl_close($ch);
	$name = $my_stats = $json['eco']['user'][0]['name'];//your name
	$species = $json['eco']['species'];//array of your species
	$breeds = $json['eco']['breeds'];//array of your breeds
	$breed_name = $json['eco']['breeds'][0]['breed_name'];//name of the first breed in the array
</pre>?></div>


<p class='description'>Note: You must have an API_KEY to send valid requests. Get one on the <a show='myaccount'>My Account</a> page.</p>
<!--<p class='api_data'>RENAME THE BREED</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&breed=KEY&name=STRING&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>RENAME THE FAMILY</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&breed=KEY&family=STRING&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>RENAME THE SPECIES</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&channel=CHANNEL&species=STRING&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>DELETE THE BREED RECORD</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&breed=KEY&remove=TRUE&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>DELETE THE SPECIES RECORD</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&channel=CHANNEL&remove=TRUE&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>REBUILD THE BREED</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&breed=KEY&rebuild=TRUE&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>SET THE SPECIES_SKINS</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&channel=CHANNEL&skins=STRING&api=API_KEY&token=TOKENID
</pre></div>

<p class='api_data'>SET THE SPECIES_ANIMS</p>
<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre>
type=edit&channel=CHANNEL&anims=STRING&api=API_KEY&token=TOKENID
</pre></div>-->



<div style='height:50px'></div>