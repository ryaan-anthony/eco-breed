<?php

//globals
include('../preload.php');
function get_ip_address() {foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }}
$cookie_location = str_replace(".","_",get_ip_address())."_takecopy_login";
$encryption_key = "sdfoNnliuLsnl89NjknO8nuilb89BJBd";
//putenv('TZ=PST'); 
//apache_setenv('TZ=PST');
date_default_timezone_set('America/Los_Angeles');
ini_set('memory_limit', '-1');
$timeout=330;//seconds until NOT RESPONDING
$Basic_Breed_Limit=10000;
$Premium_Breed_Limit=50000;
$Basic_Species_Limit=5;
$Premium_Species_Limit=15;
$Version = 0.0;
$ecoVersion = 1.00;

	$master_request= "ecoMASTERtoken8811";
//verify login credentials && open link
$link = mysql_connect("localhost","takecopy", "devTR1420");
if(!mysql_select_db("takecopy_vendors",$link)){die(unsetcookie());}
$params = unserialize(decrypt($_COOKIE[$cookie_location]));
$username=mysql_real_escape_string($params['name']);
$password=$params['pw'];
$result=mysql_query("select * from user where name='$username'", $link);
if(!$result || $password == "" || !mysql_num_rows($result)){die(unsetcookie());}
$row=mysql_fetch_array($result);
if($password!=$row['password']){die(unsetcookie());}
if($username==""){die(unsetcookie());}
if(!mysql_select_db("takecopy_eco",$link)){die(unsetcookie());}
$result=mysql_query("select * from user where name='$username'", $link);
if(!$result || !mysql_num_rows($result)){die(unsetcookie());}
//if($username!="dev khaos"){die("This page is temporarily unavailable. <br> <em>Down for maintenance 03/09/2012 1:30am EST</em>");}
	$_GET['api']=$master_request;
	$_GET['user']=$username;
	include('../../api/index.php');
	$json = json_decode($json_raw,true);
	if(count($json['error'])){die($json['error']['message']);};
	$my_stats = $json['eco']['user'][0];
	$my_species = $json['eco']['species'];
	$all_breeds = $json['eco']['breeds'];
	$Version = $my_stats['version'];

//functions

function unsetcookie(){
	global $cookie_location;
	unset($_COOKIE[$cookie_location]);
	setcookie($cookie_location, NULL,-1);
	setcookie($cookie_location, "end",-1,'/');
	return "Login Failed <script>function reload(){window.location.href='http://eco.takecopy.com/?e=legacy';} setTimeout('reload()',2500);</script>";
}

function decrypt($str){
	global $encryption_key;
	$str = base64_decode($str);
	$result = '';
	for($i=0; $i<strlen($str); $i++) {
		$char = substr($str, $i, 1);
		$keychar = substr($encryption_key, ($i % strlen($encryption_key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}

function numFamilies($chan){
	global $json;
	$num = count($json['eco']['breeds']);
	$count=array();
	for($i=0;$i<$num;$i++){
		if($json['eco']['breeds'][$i]['breed_chan']==$chan){
			$owner = $json['eco']['breeds'][$i]['owner_name'];
			if(array_search($owner,$count)===false){	
				if(count($count)==0){$count=array($owner);}
				else{array_push($count,$owner);}
			}
		}
	}
	return count($count);
}

function numLiveBreeds($chan){
global $json, $timeout;
$num = count($json['eco']['breeds']);
$count=0;
$breed=$json['eco']['breeds'];
for($i=0;$i<$num;$i++){
	if($breed[$i]['breed_chan']==$chan&&(int)($breed[$i]['breed_dead'])==0&&(time()-(int)$breed[$i]['breed_update'])<$timeout){$count++;}
}
return $count;
}

function numBreeds($chan){
global $json;
$num = count($json['eco']['breeds']);
$count=0;
for($i=0;$i<$num;$i++){
	if($json['eco']['breeds'][$i]['breed_chan']==$chan){$count++;}
}
return $count;
}

function splitSkins($skins){
$skinsets=explode("|",$skins);
$active=array();
$dormant=array();
for($i=0;$i<count($skinsets);$i++){
	$current=explode("~",$skinsets[$i]);
	$save = "<strong>".$current[1].":</strong> ".$current[0];
	if($current[0]!=""){
		if($current[2]=="2"){
			if(count($active)){array_push($active,$save);}
			else{$active=array($save);}
		}
		else if($current[2]=="1"){
			if(count($dormant)){array_push($dormant,$save);}
			else{$dormant=array($save);}
		}
	}
}
return array(implode("<br />",$active),implode("<br />",$dormant));
}

function Gen($gen){
$num=substr($gen, -1);
if($num=="1"){return $gen."st";}
if($num=="2"){return $gen."nd";}
if($num=="3"){return $gen."rd";}
return $gen."th";
}

function pullNames($parents){
$list = explode("&&",$parents);
$mom_data = explode("|",$list[0]);
$mom = $mom_data[1];
$dad_data = explode("|",$list[1]);
$dad = $dad_data[1];
$found = findBreedIndex($mom_data[0]);
if($found!=-1){$mom = "<a b='$found'>".$mom."</a>";}
$found = findBreedIndex($dad_data[0]);
if($found!=-1){$dad = "<a b='$found'>".$dad."</a>";}
if($mom==""&&$dad==""){return "None";}
if($dad==""){return $mom;}
return  $mom." and ".$dad;
}

function findName($partner){
global $link;
$partner=mysql_real_escape_string($partner);
$result=mysql_query("select * from breed where breed_id='$partner'", $link);
if(!$result){return "None";}
$row=mysql_fetch_array($result);
$found = findBreedIndex($partner);
if($found!=-1){return "<a a='$found'>".$row['breed_name']."</a>";}
return $row['breed_name'];
}

function findBreedIndex($id){
global $json, $all_breeds;
//$my_breeds = $json['eco']['all_breeds'];
for($i=0;$i<count($all_breeds);$i++){
	if($all_breeds[$i]['breed_id']==$id){return $i;}
}
return -1;
}

function dropdown_type($list,$type){
	$data = array();
	$options="";
	for($i=0;$i<count($list);$i++){
		$val = $list[$i]['breed_'.$type];
		if(array_search($val,$data)===FALSE){
			$data[$i]=$val;
			$options.= "<option class='filter-".$type."-".implode("_",explode(" ",$val))."'>".$val."</option>";
		}
	}
	return $options;
}

function Time_Array($number){
if($number==0){return array("","never");}
$monthsDiff = floor($number/60/60/24/30);
if($monthsDiff>0){return array($monthsDiff,"months");}
$daysDiff = floor($number/60/60/24);
if($daysDiff>0){return array($daysDiff,"days");}
$hrsDiff = floor($number/60/60);
if($hrsDiff>0){return array($hrsDiff,"hours");}
$minsDiff = floor($number/60);
if($minsDiff>0){return array($minsDiff,"minutes");}
return array($number,"seconds");
}

function dropDown($val){
$options = "<option selected>FALSE</option><option>TRUE</option>";
if($val){$options = "<option selected>TRUE</option><option>FALSE</option>";}
return $options;
}
function hasChambers($species, $channel){
global $link, $username;
$result = mysql_query("SELECT * FROM species WHERE species_creator='$username' AND species_chan='$channel' AND species_name='$species'",$link);
if(!$result || mysql_num_rows($result)==0){return "";}
$row=mysql_fetch_array($result);
if($row['species_chamber']==""){return "";}
return $row['species_chamber'].",".$row['id'];
}

//Legacy User Interface

////MY_SPECIES DATA
if(isset($_POST['s'])){
$val = (int)$_POST['s'];
print "<div style='text-align:center;height:35px;'><a id='species_delete' s='".$val."' style='color:orangered;'>delete this species</a></div>";
//SPECIES NAME
$species = $json['eco']['species'][$val]['species_name'];
$channel = $json['eco']['species'][$val]['species_number'];
print "<div class='seperator'>
<div class='label' style='display: inline;'>Species:</div>
<input id='species_name' class='wide-input' style='margin-left: 10px;font-size:1.3em;font-weight:bold;position: initial;' value='$species' />
<button id='species_name_save' s='".$val."' disabled style='padding:5px 10px;'>Set Name</button>
</div>";

if(is_numeric($channel)){
//SKIN PARAMS
$SKIN = (int)$_POST['skin_index'];
	$skinsets = $my_species[$val]['species_skins'];
	$selected = $skinsets[$SKIN];
//$skins = $json['eco']['species'][$val]['species_skins'];
//$skinsets = explode(":#%",$skins);
//$selected = explode(":#:",$skinsets[$SKIN]);
$available = $selected['skin_limit'];
if($available==""){$available="-1";}
if(count($skinsets)){$show_select="";$show_input="display:none;";}
else{$show_select="display:none;";$show_input="";}
print "<div class='seperator' style='height: 250px;'>";
/*SIDEBAR*/
print "<div class='label' style='margin-top: 0px;'>Skins: ";
if(count($skinsets)){print "<a style='text-decoration:none;' id='skins-add-new' next=".count($skinsets).">(new)</a>";}
print "<div class='codeblock' style='height: 220px;margin-top:0px;background: #FCFCFC;'>
<ul style='list-style-image: none;margin-left: 0.2em;font-weight:normal;'>
<strong>Gen:</strong>
<li class='hover-help' title='Must be greater than this generation. Example: 3 = must be 3rd generation or higher to use this skin'>&gt;0 = Minimum Gen</li>
<li class='hover-help' title='Only this generation. Example: -3 = only 3rd generation can use this skin.'>&lt;0 = Only This</li>
<br />
<strong>Odds:</strong>
<li class='hover-help' title='Depreciated skins will still be applied to offspring of parent breeds who already have the skin. Use this for limited release skins to depreciate the skinset so it will not be applied to 1st generation breeds.'>-1 = Depreciated</li>
<li class='hover-help' title='Common skin, will be applied if randomly selected.'>&nbsp;0 = Common</li>
<li class='hover-help' title='The higher the number, the more rare the skin.'>&gt;0 = Rare</li>
<br />
<strong>Limit:</strong>
<li class='hover-help' title='Unlimited number of breeds can apply this skin.'>-1 = Unlimited</li>
<li class='hover-help' title='Depreciated, no new breeds can access this skin.'>&nbsp;0 = Depreciated</li>
<li class='hover-help' title='Only X number of breeds can have this skin. This number will dynamically decrease until it reaches zero as breeds apply this skin.'>&gt;0 = Fixed</li>
</ul>
</div>";
print "</div>";

print "<div class='params_box' align='center' style='padding:10px 0;'>";

/*SKIN SELECT*/
print "<div class='input_box'>";
print "<p>Skin Name: ";
if(count($skinsets)){print "<a id='skin-name-edit' style='text-decoration:none;'>(edit)</a>";}
print "</p>";
print "<span id='skin-name-show'>
<select s='$val' id='skin-name' style='".$show_select."width:155px;padding:3px;'>";
print "<option skin='$SKIN'>".$selected['skin_name']."</option>";
for($i=0;$i<count($skinsets);$i++){
	if($i!=$SKIN && $skinsets[$i]['skin_category']==$selected['skin_category']){
		print "<option skin='$i'>".$skinsets[$i]['skin_name']."</option>";
	}
}
print "</select>";
print "<input id='skin-name-new' value='".$selected['skin_name']."' style='".$show_input."width:145px;padding:3px;'/>";
print "</span>";
print "</div>";

/*CATEGORY SELECT*/
$displayed_categories=array($selected['skin_category']);
print "<div class='input_box'>";
print "<p>Category: ";
if(count($skinsets)){print "<a id='cat-name-edit' style='text-decoration:none;'>(edit)</a>";}
print "</p>";
print "<span id='skin-name-show'>
<select c='$val' id='cat-name' style='".$show_select."width:150px;padding:3px;'>";
print "<option cat='$SKIN'>".$selected['skin_category']."</option>";
for($i=0;$i<count($skinsets);$i++){
	$category = $skinsets[$i]['skin_category'];
	if($i!=$SKIN && array_search($category,$displayed_categories)===false){
		$displayed_categories = array_merge($displayed_categories,array($category));
		print "<option cat='$i'>".$category."</option>";
	}
}
print "</select>";
print "<input id='cat-name-new' value='".$selected['skin_category']."' style='".$show_input."width:140px;padding:3px;'/>";
print "</span>";
print "</div>";

/*FILTERS & PARAMS*/
print "<div class='input_box'><p>Gen:</p><input id='skin-gen' type='number' style='width:35px;padding:3px;' value='".$selected['skin_gen']."' /></div>";
print "<div class='input_box'><p>Odds:</p><input id='skin-odds' type='number' style='width:35px;padding:3px;' value='".$selected['skin_odds']."' /></div>";
print "<div class='input_box'><p>Limit:</p><input id='skin-limit' type='number' style='width:35px;padding:3px;' value='".$available."' /></div>";
print "<p>Skin Methods: <a href='http://eco.takecopy.com/?e=methods' target='_blank' style='text-decoration:none;'>(help)</a></p>";
print "<textarea placeholder='Supply Skin Methods Here...' id='skin-params' class='mod-code'>".str_replace(")",")\n",$selected['skin_params'])."</textarea>";
if(count($skinsets)){print "<p><a id='skin_delete' s='$val' skin='$SKIN' style='color:orangered;'>delete this skin</a></p>";}
print "<button id='skin_save' s='$val' skin='$SKIN' style='float:right;padding:5px 10px;' disabled>Save Changes</button>
<button id='skin_cancel' s='$val' skin='$SKIN' style='float:right;padding:5px 10px;'>Cancel</button>
</div>
</div>";

print "<div style='height:30px;'></div>";

//ANIM PARAMS
$ANIM = (int)$_POST['anim_index'];
$animsets = $my_species[$val]['species_anims'];
$selected = $animsets[$ANIM];
if(count($animsets)){$show_select="";$show_input="display:none;";}
else{$show_select="display:none;";$show_input="";}
print "<div class='seperator' style='height: 250px;'>
	<div class='label' style='margin-top: 0px;'>Anims: ";
		if(count($animsets)){print "<a style='text-decoration:none;' id='anims-add-new' next=".count($animsets).">(new)</a>";}
		print "<div class='codeblock' style='margin-top:5px;height: 210px;background: #FCFCFC;'>
			<ul style='list-style-image: none;margin-left: 0.2em;font-weight:normal;margin-top: 10px;'>
				<strong>Frames:</strong>
				<li class='hover-help' title='Only set first frame.'>&nbsp;1 = Pose</li>
				<li class='hover-help' title='Set two or more frames in a sequence.'>&gt;1 = Animation</li>
				<br />
				<strong>Repeat:</strong>
				<li class='hover-help' title='Loops the sequence infinitely.'>-1 = Infinite</li>
				<li class='hover-help' title='Triggers the sequence once.'>&nbsp;0 = Once</li>
				<li class='hover-help' title='Repeats the sequence this number of times.'>&gt;1 = Num Repeats</li>
				<br />
				<strong>Delay:</strong>
				<li class='hover-help' title='Delays the animation for this many seconds between each frame and each sequence.'>&gt;0.0 = Seconds</li>
			</ul>
		</div>";
	print "</div>
	<div class='params_box' align='center' style='padding:10px 0;'>
		<div class='input_box'>
			<p>Anim Name: ";
			if(count($animsets)){print "<a id='anim-name-edit' style='text-decoration:none;'>(edit)</a>";}
			print "</p>
			<span id='anim-name-show'>
				<select s='$val' id='anim-name' style='".$show_select."width:225px;padding:3px;'>";
					print "<option anim='$ANIM'>".$selected['anim_name']."</option>";
					for($i=0;$i<count($animsets);$i++){
						if($i!=$ANIM){print "<option anim='$i'>".$animsets[$i]['anim_name']."</option>";}
					}
					$stages = $selected['anim_frames'];
					if($stages==""){$stages="0";}
				print "</select>
				<input id='anim-name-new' value='".$selected['anim_name']."' style='".$show_input."width:225px;padding:3px;'/>
			</span>
		</div>
		<div class='input_box'>
			<p>Frames:</p>
			<input id='anim-stages' type='number' style='width:55px;padding:3px;' value='".$stages."' />
		</div>
		<div class='input_box'>
			<p>Repeat:</p>
			<input id='anim-repeat' type='number' style='width:55px;padding:3px;' value='".$selected['anim_repeat']."' />
		</div>
		<div class='input_box'>
			<p>Delay:</p>
			<input id='anim-delay' type='number' style='width:55px;padding:3px;' value='".$selected['anim_delay']."' />
			</div>
			<p>Anim Methods: <a href='http://eco.takecopy.com/?e=methods' target='_blank' style='text-decoration:none;'>(help)</a></p>
			<textarea placeholder='Supply Anim Methods Here...' id='anim-params' class='mod-code'>".str_replace(")",")\n",$selected['anim_params'])."</textarea>";
			if(count($animsets)){print "<p><a id='anim_delete' s='$val' anim='$ANIM' style='color:orangered;'>delete this anim</a></p>";}
			print "<button id='anim_save' s='$val' anim='$ANIM' style='float:right;padding:5px 10px;' disabled>Save Changes</button>
			<button id='anim_cancel' s='$val' anim='$ANIM' style='float:right;padding:5px 10px;'>Cancel</button>
		</div>
	</div>
</div>";
}
else{print "<h2 style='color:#E6E6E6;' align='center'>This species cannot be modified from this interface.</h2>";}
print "<div style='height:30px;'></div>";

}
//depreciated////MY_BREEDS DATA //elseif(isset($_POST['b'])){
//$val = (int)$_POST['b'];
//$breed = $json['eco']['my_breeds'][$val];
//$name = $breed['breed_name'];
//$breed_id = $breed['breed_id'];
//print "<div style='text-align:center;height:35px;'>
//<a id='breed_rebuild' b='$val' >rebuild this breed</a>
//|
//<a id='breed_delete' b='$val' class='$breed_id' style='color:orangered;'>delete this breed</a>
//</div>";
//print "<div class='seperator'><div class='label'>Name:</div> <input id='breed_name' class='wide-input' style='font-size:1.3em;font-weight:bold;' value='$name' /><button id='breed_name_save' b='$val' class='$breed_id' disabled style='padding:5px 10px;'>Set Name</button></div>";
//$species = $breed['breed_species'];
//$creator = $breed['breed_creator'];
//$grid = $breed['breed_grid'];
//print "<div class='seperator'><div class='label' style='margin:0;'>Variety:</div>$species by ".ucwords($creator)."</div>";
//if($grid=="Second Life"){
//$pos = $breed['breed_pos'];
//$pos=str_replace(array("<",">"),"",$pos);
//$vec=explode(", ",$pos);
//$region = urlencode($breed['breed_region']);
//$slurl = "http://slurl.com/secondlife/".$region."/".number_format($vec[0])."/".number_format($vec[1])."/".number_format($vec[2]);
//print "<div class='seperator'><div class='label' style='margin:0;'>Location:</div><a href='$slurl' target='_blank'>$slurl</a></div>";
//}
//$owner = $breed['breed_owner'];
//$family = $breed['breed_family'];
//print "<div class='seperator'><div class='label' style='margin:0;'>Owner:</div>".ucwords($owner)." ($family)</div>";
//$gender = $breed['breed_gender'];
//$generation = $breed['breed_generation'];
//print "<div class='seperator'><div class='label' style='margin:0;'>Gender:</div>".Gen($generation)." Generation $gender</div>";
//$age = number_format($breed['breed_age']);
//$born = $breed['breed_born'];
//$time =date("g:i A T",$born);
//$then =date("M d, Y",$born);
//$now =date("M d, Y",time());
//if($born=="0"){print "<div class='seperator'><div class='label' style='margin:0;'>Age:</div>Unborn</div>";}
//else{
//$born="on ".$then;
//if($then==$now){$born="Today";}
//print "<div class='seperator'><div class='label' style='margin:0;'>Age:</div>$age years old. Born ".$born." at $time</div>";
//}
//$partner = $breed['breed_partner'];
//if($partner!=""){
//	print "<div class='seperator'><div class='label' style='margin:0;'>Partner:</div>".findName($partner)."</div>";
//}	
//if((int)$generation>1){
//	$parents = $breed['breed_parents'];
//	print "<div class='seperator'><div class='label' style='margin:0;'>Parents:</div>".pullNames($parents)."</div>";
//}
//if($gender!="Male"){
//$litters = $breed['breed_litters'];
//print "<div class='seperator'><div class='label' style='margin:0;'>Litters:</div>$litters</div>";
//}
//$hunger = $breed['breed_hunger'];
////print "<div class='seperator'><div class='label' style='margin:0;'>Hunger:</div>".(100-(int)$hunger)."%</div>";
//$skins = splitSkins($breed['breed_skins']);
//if($skins[0]!=""&&$skins[0]!="None"){print "<div class='seperator'><div class='label' style='margin:0;'>Skins:</div><div style='display: inline-block;'>".$skins[0]."</div></div>";}
//if($skins[1]!=""&&$skins[1]!="None"){print "<div class='seperator'><div class='label' style='margin:0;'>Dormant:</div><div style='display: inline-block;'>".$skins[1]."</div></div>";}
//}

////ALL_BREEDS DATA
elseif(isset($_POST['a'])){
	$val = (int)$_POST['a'];
	$breed = $json['eco']['breeds'][$val];
	$name = $breed['breed_name'];
	$breed_id = $breed['breed_id'];
	print "<div style='text-align:center;height:35px;'>
	<a id='all_breed_rebuild' a='$val' >rebuild this breed</a>
	|
	<a id='all_breed_delete' a='$val' class='$breed_id' style='color:orangered;'>delete this breed</a>
	</div>";
	print "<div class='seperator'><div class='label'>Name:</div> <input id='all_breed_name' class='wide-input' style='font-size:1.3em;font-weight:bold;' value='$name' /><button id='all_breed_name_save' a='$val' class='$breed_id' disabled style='float:right;padding:5px 10px;'>Set Name</button></div>";
	$species = $breed['breed_species'];
	$creator = $breed['breed_creator'];
	print "<div class='seperator'><div class='label' style='margin:0;'>Variety:</div>$species by ".ucwords($creator)."</div>";
	$pos = $breed['breed_pos'];
	$pos=str_replace(array("<",">"),"",$pos);
	$vec=explode(", ",$pos);
	$region = urlencode($breed['breed_region']);
	$slurl = "http://slurl.com/secondlife/".$region."/".number_format($vec[0])."/".number_format($vec[1])."/".number_format($vec[2]);
	print "<div class='seperator'><div class='label' style='margin:0;'>Location:</div><a href='$slurl' target='_blank'>$slurl</a></div>";
	
	$owner = $breed['breed_owner'];
	$family = $breed['breed_family'];
	print "<div class='seperator'><div class='label' style='margin:0;'>Owner:</div>".ucwords($owner)." ($family)</div>";
	$gender = $breed['breed_gender'];
	$generation = $breed['breed_generation'];
	print "<div class='seperator'><div class='label' style='margin:0;'>Gender:</div>".Gen($generation)." Generation $gender</div>";
	$age = number_format($breed['breed_age']);
	$born = $breed['breed_born'];
	$time =date("g:i A T",$born);
	$then =date("M d, Y",$born);
	$now =date("M d, Y",time());
	if($born=="0"){print "<div class='seperator'><div class='label' style='margin:0;'>Age:</div>Unborn</div>";}
	else{
	$born="on ".$then;
	if($then==$now){$born="Today";}
	print "<div class='seperator'><div class='label' style='margin:0;'>Age:</div>$age years old. Born ".$born." at $time</div>";
	}
	$partner = $breed['breed_partner'];
	if($partner!=""){
		print "<div class='seperator'><div class='label' style='margin:0;'>Partner:</div>".findName($partner)."</div>";
	}	
	if((int)$generation>1){
		$parents = $breed['breed_parents'];
		print "<div class='seperator'><div class='label' style='margin:0;'>Parents:</div>".pullNames($parents)."</div>";
	}
	if($gender!="Male"){
	$litters = $breed['breed_litters'];
	print "<div class='seperator'><div class='label' style='margin:0;'>Litters:</div>$litters</div>";
	}
	$hunger = $breed['breed_hunger'];
	//print "<div class='seperator'><div class='label' style='margin:0;'>Hunger:</div>".(100-(int)$hunger)."%</div>";
	$skins = splitSkins($breed['breed_skins']);
	if($skins[0]!=""&&$skins[0]!="None"){print "<div class='seperator'><div class='label' style='margin:0;'>Skins:</div><div style='display: inline-block;'>".$skins[0]."</div></div>";}
	if($skins[1]!=""&&$skins[1]!="None"){print "<div class='seperator'><div class='label' style='margin:0;'>Dormant:</div><div style='display: inline-block;'>".$skins[1]."</div></div>";}
}
////PAGE COMPILE
else{
?><script>$('#content-data').prepend('<span class="description" style="position: absolute;top: 0px;right: 0px;margin: 10px 20px 0 0;"> You are logged in as <strong><?php print $username; ?></strong>. <a id="eco_logout" style="font-size:1.0em;color: #0F67A1;cursor:pointer;">Click here</a> to log out.</span>');</script><?php
//info
//print "<P align='center' style='font-weight:bold;color:red;'>1:00AM PST December 10th, 2011<br/>  This page is undergoing maintenance. <br> DO NOT MAKE ANY CHANGES AT THIS TIME!</P>";
//print '<img id="eco-breed-object" src="img/eco-big0.png" style="float: left;height: 150px;padding-right: 30px;">';
//print "<p style='padding-top: 50px;padding-right: 20px;'>This page uses the <a show='api'>eco-web API</a> to display and modify breed data. The raw data used on this page and all functionality herein is built into the API for your convenience.</p>";

//user logout
//print "<p align='center' class='description' style='font-size:1.0em;clear: both;padding-top: 20px;'>You are logged in as <strong>$username</strong>. <a id='eco_logout' style='font-size:1.0em;'>Click here</a> to log out.</p>"; 

//menu
//print "<h4 style='color:orangered;' align='center'>[11/21/2011]<br>THIS PAGE IS UNDERGOING MAINTANANCE<br><span style='font-size:0.8em;'>(errors have been detected with the API, stay tuned)</span></h4>";
//print "<div align='center' style='width:590px;'>";
//print "<div id='e-species' class='tabs'>my_species</div>"; 
//print "<div id='e-breeds' class='tabs'>my_breeds</div>"; 
//print "<div id='e-all' class='tabs'>breeds</div>"; 
//print "<div id='e-api' class='tabs'>my_settings</div>"; 
//print "</div>";
print '
<div style="width:590px;">
<button id="e-species" class="tabs howto-btn" >Configure Species</button>
<button id="e-all" class="tabs howto-btn">Manage Breeds</button>
<button id="e-api" class="tabs howto-btn">Adjust Settings</button>
</div>
';

//species
print "<div id='content-e-species' class='content-tabs' style='padding: 10px;'>";
if(!count($my_species)){print "<div style='text-align:center;margin-top:40px;'>You have not created any breeds. <a show='purchase' style='font-size:1em;'>Click here</a> to learn more about eco-breeds.</div>";}
else{
	print "<table style='width:588px;margin-left:-10px;' class='my-species'>
	<tr style='height: 35px;'>
	<th id='my-species-name' class='my-species'>Breed Species</th>
	<th id='my-species-families' class='my-species'># Families</th>
	<th id='my-species-live' class='my-species'># Living Breeds</th>
	<th id='my-species-total' class='my-species'># Total Breeds</th>
	</tr>";
	for($i=0;$i<count($my_species);$i++){
		$chan = $my_species[$i]['species_number'];
		$species = $my_species[$i]['species_name'];
		$family=numFamilies($chan);
		$live=numLiveBreeds($chan);
		$total=numBreeds($chan);
		print "<tr style='height:30px;'
		class='my-species-sortable' 
		my-species-name='$species'
		my-species-families='$family'
		my-species-live='$live'
		my-species-total='$total'
		my-species-index='$i'
		>";
		print "<td style='width:20%;'><a s='$i' style='margin-left:10px;font-weight:bold;text-decoration:none;'>$species</a></td>";
		print "<td style='text-align:center;'>$family</td>";
		print "<td style='text-align:center;'>$live</td>";
		print "<td style='text-align:center;'>$total</td>";
		print "</tr>";
	}
	print "</table>";
}
print "</div>";

//all
print "<div id='content-e-all' class='content-tabs' style='display:none;padding: 10px;'>";
if(stristr($data,'error: ')||!count($all_breeds)){print "<div style='text-align:center;margin-top:40px;'>You have not created any breeds. <a show='purchase' style='font-size:1em;'>Click here</a> to learn more about eco-breeds.</div>";}
else{
	
	?>
	<div class='seperator'>
	<span style='font-size:1.1em;font-weight:bold;color:#666;'>Display:</span>
	<select class='filter'>
	<option class='filter-breeds-all'>All Breeds</option>
	<option class='filter-breeds-alive'>Alive Breeds</option>
	<option class='filter-breeds-dead'>Dead Breeds</option>
	<option class='filter-breeds-inactive'>Inactive Breeds</option>
	</select>
	
	<select class='filter'>
	<option class='filter-species-all'>All Species</option>
	<?php  print dropdown_type($all_breeds,"species");?>
	</select>
	
	<select class='filter'>
	<option class='filter-owner-all'>All Owners</option>
	<?php  print dropdown_type($all_breeds,"owner");?>
	</select>
	</div>
	<?php
	print "<table style='width:588px;margin-left:-10px;margin-bottom: 20px;' class='all-breed'>
	<tr style='height: 35px;'>
	<th id='all-breed-name' class='all-breed'>Breed Name</th>
	<th id='all-breed-gender' class='all-breed'>Gender</th>
	<th id='all-breed-age' class='all-breed'>Age</th>
	<th id='all-breed-status' class='all-breed'>Status</th>
	</tr>";
	for($i=0;$i<count($all_breeds);$i++){
	$name = $all_breeds[$i]['breed_name'];
	if($name==""){$name="None";}
	$breed_id = $all_breeds[$i]['breed_id'];
	$skins = $all_breeds[$i]['breed_skins'];
	$age = $all_breeds[$i]['breed_age'];
	$gender = $all_breeds[$i]['breed_gender'];
	$owner = implode("_",explode(" ",$all_breeds[$i]['breed_owner']));
	$species = implode("_",explode(" ",$all_breeds[$i]['breed_species']));
	$last_update = $all_breeds[$i]['breed_update'];
	$dead = (int)$all_breeds[$i]['breed_dead'];
	$died = "LIVE";
	$breeds = "alive";
	if($dead>0){$died="Died: ".date("M d, Y",$dead);$breeds = "dead";}
	elseif((time()-(int)$last_update)>$timeout){$died="Not Responding";$breeds = "inactive";}
	print "<tr style='height:30px;' 
	class='all-breed-sortable' 
	all-breed-name='$name'
	all-breed-gender='$gender'
	all-breed-age='$age'
	all-breed-status='$died'
	all-breed-index='$i'
	breeds='$breeds'
	species='$species'
	owner='$owner'
	>";
	print "<td style='width:35%;'><input a='$i' class='checkbox' type='checkbox' /><a a='$i' breed_id='$breed_id' class='all_breed_index' style='margin-left:10px;font-weight:bold;text-decoration:none;'>".str_replace(" ","&nbsp;",$name)."</a></td>";
	print "<td style='text-align:center;'>$gender</td>";
	print "<td style='text-align:center;'>$age</td>";
	print "<td style='text-align:center;'>$died</td>";
	print "</tr>";
	}
	print "</table>";
	print "<div style='height:20px;position:absolute;bottom:10px;'>
	<img src='img/arrow_acct.png' style='margin-left: -8px;'/>
	<a class='check-all' style='font-size:1.0em;margin-right:5px;' type='a'>Select All</a> / 
	<a class='check-none' style='font-size:1.0em;margin-left:5px;' type='a'>Select None</a> 
	<a style='margin-left:20px;text-decoration:none;color:red;font-weight:bold;' class='check-del' type='a' onmouseover=\"this.style.color='orangered';\" onmouseout=\"this.style.color='red';\" >Delete Selected</a> 
	</div>";
}
print "</div>";

//my settings
print "<div id='content-e-api' class='content-tabs' style='display:none;padding: 10px;'>";
	$options=array("months","days","hours","minutes","never");
	//$inactive_data = Time_Array($my_stats['inactive_remove']);
	//$dead_data = Time_Array($my_stats['dead_remove']);
	$subscription = $my_stats['host_plan'];
	$increase = " <a show='purchase' style='text-decoration:none;'>increase this limit</a>";
	$breed_limit="of ".number_format($Basic_Breed_Limit)." $increase";
	$species_limit="of ".$Basic_Species_Limit." $increase";
	if($subscription=="Premium"){
		$breed_limit="of ".number_format($Premium_Breed_Limit)." $increase";
		$species_limit="of ".$Premium_Species_Limit." $increase";
		$expires="(Expires: ".date("l F d, Y",$my_stats['host_expire']).")";
	}
	if($subscription=="Unlimited"){
		$breed_limit="";
		$species_limit="";
		$expires="(Expires: ".date("l F d, Y",$my_stats['host_expire']).")";
	}
print "<div style='white-space:pre;padding-left:20px;'>";
print "<p><strong>Hosting Plan:</strong> 		$subscription $expires</p>";
print "<p><strong>Breed Records:</strong>	".$my_stats['breed_count']." $breed_limit</p>";
print "<p><strong>Species Records:</strong> 	".$my_stats['species_count']." $species_limit</p>";
//inactive records
//print "<p><strong>Manage Inactive:</strong>	Delete after &nbsp; <input id='inactive-time' style='width:60px;' value='".$inactive_data[0]."'/> ";
//print "<select id='inactive-type'>";
//print "<option selected>".$inactive_data[1]."</option>";
//for($i=0;$i<count($options);$i++){
//	if($inactive_data[1]!=$options[$i]){print "<option>".$options[$i]."</option>";}
//}
//print "</select>";
//print "<button id='inactive-set' disabled='disabled'>Set</button> <img src='img/help.png' title='This setting allows you to automatically delete the records of breeds that stop responding after this amount of time. If the breed reconnects to the grid after the record is destroyed, it will create a new record.' style='margin-bottom: -2px;'/>";
////Dead records
//print "<p><strong>Manage Dead:</strong>		Delete after &nbsp; <input id='dead-time' style='width:60px;' value='".$dead_data[0]."'/> ";
//print "<select id='dead-type'>";
//print "<option selected>".$dead_data[1]."</option>";
//for($i=0;$i<count($options);$i++){
//	if($dead_data[1]!=$options[$i]){print "<option>".$options[$i]."</option>";}
//}
//print "</select>";
//print "<button id='dead-set' disabled='disabled'>Set</button> <img src='img/help.png' title='This setting allows you to automatically delete the records of dead breeds after this amount of time. If the breed reconnects to the grid after the record is destroyed, it will create a new record.' style='margin-bottom: -2px;'/>";

//if($my_stats['api_key']==""){print "<div id='api_key'><p><strong>Your API key:</strong>		<a id='get_api' style='font-size:1.0em;'>Click here to create one.</a></p></div>";}
//else{print "<p><strong>Your API key:</strong> 		<input class='wide-input' value='".$my_stats['api_key']."'/></p>";}
if($json_raw!=""){print "<p><strong>Your results:</strong> 		<a id='toggle-json' style='text-decoration:none;'>Toggle Results</a></p>";}
print "</div>";
if($json_raw!=""){print "<div id='json-container' style='height:500px;overflow:scroll;display:none;'>".big_code($json_raw)."</div>";}
print "</div>";

//temp
print "<div id='content-temp' class='content-tabs' style='display:none;padding: 10px;'></div>";
}
?>