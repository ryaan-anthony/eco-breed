<?php //die('die');
$Unknown_Family="Undefined";
$Unknown_Breed="Undefined";
$saved_categories=array();
$saved_skins=array();
$check_categories=array();


	$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
	if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}

	
	function getAnims($chan,$creator,$cached){ 
		global $link;
		$result=mysql_query("select * from species where species_chan='".$chan."' AND species_creator='".$creator."'", $link);
		if(mysql_num_rows($result)==0){return "";}
		$row=mysql_fetch_array($result);
		$result=mysql_query("select * from anims where anim_species='".$row['id']."'", $link);
		$results = array();
		while($row=mysql_fetch_array($result)){
			if(array_search($row['anim_name'],$cached)!==false){
				$results=array_merge($results,array($row['anim_name']."#"."stages(".$row['anim_frames'].")repeat(".$row['anim_repeat'].")delay(".$row['anim_delay'].")".$row['anim_params']));
			}
		}
		$return_values = implode("#",$results);
		$orig = array('size(','pos(','rot(','sculpt(','texture(','color(','repeat(','delay(','type(','alpha(','shine(','glow(','stages(');
		$new = array(	 '0(',  '1(',  '2(',     '3(',      '4(',    '5(',     '6(',    '7(',   '8(',    '9(',   '10(',  '11(',    '12(');
		$return_values = str_replace($orig,$new,$return_values);
		return $return_values;
	}	
	function getSkins($chan,$creator){
		global $link;
		$result=mysql_query("select * from species where species_chan='".$chan."' AND species_creator='".$creator."'", $link);
		if(mysql_num_rows($result)==0){return "";}
		$row=mysql_fetch_array($result);
		$result=mysql_query("select * from skins where skin_species='".$row['id']."'", $link);
		$params = array();
		while($row=mysql_fetch_array($result)){
			$params = array_merge($params,array(implode(":#:",array($row['skin_name'],$row['skin_category'],$row['skin_gen'],$row['skin_odds'],$row['skin_params'],$row['skin_limit']))));
		}
		return implode(":#%",$params);
	}

function findFamily($owner){
global $link;
$result=mysql_query("select * from breed where owner_name='".$owner."' limit 1", $link);
$row=mysql_fetch_array($result);
return $row['breed_family'];
}

function Key2Value($id,$val){
global $link;
$result=mysql_query("select * from breed where breed_id='".$id."'", $link);
if(!$result){return "";}
if(mysql_num_rows($result)==0){return "";}
$row=mysql_fetch_array($result);
return $row[$val];
}

function findSpecies($chan,$creator){
global $link,$Unknown_Breed;
$result=mysql_query("select * from species where species_chan='".$chan."' AND species_creator='".$creator."'", $link);
if(mysql_num_rows($result)==0){
	mysql_query("INSERT INTO species (species_chan,species_creator,species_name) VALUES ('$chan','$creator','$Unknown_Breed')", $link);
	return $Unknown_Breed;
}
$row=mysql_fetch_array($result);
return $row['species_name'];
}

function breedExists($id){
global $link;
$result=mysql_query("select * from breed where breed_id='".$id."'", $link);
if(mysql_num_rows($result)==0){return false;}
return true;
}

function duplicateBreed($uuid,$id){
global $link;
$result=mysql_query("select * from breed where breed_id='".$id."'", $link);
if(mysql_num_rows($result)==0){return FALSE;}
$row=mysql_fetch_array($result);
if($row['breed_key']!=$uuid){return TRUE;}
return FALSE;
}

function findVal($class,$category,$list,$index){
for($i=0;$i<count($list);$i++){
	$data=explode(":#:",$list[$i]);
	if(trim($data[0])==trim($class) && trim($data[1])==trim($category)){return trim($data[$index]);}
}
if($index==4){return "";}
return 0;
}

function isAvailable($mygen,$gen,$odds,$used){
if(rand(0,$odds)!=0){return 0;}
if($mygen>=$gen&&$used===false){return 2;}
return 1;
}

function pickSkin($generation,$skins){
global $saved_categories, $saved_skins, $check_categories;
$saved=FALSE;
$attempts=30;
do{
	$used=false;
	$try=explode(":#:",trim($skins[rand(0,count($skins)-1)]));
	if(count($saved_categories)==0 && count($saved_skins)==0){$run=TRUE;}
	else{
		$used=array_search($try[1],$saved_categories);
		$skin=strstr(implode("|",$saved_skins),$try[0]."~".$try[1]);
		if($skin===FALSE){$run=TRUE;}
	}
	if($run){  
		$apply=isAvailable($generation,$try[2],$try[3],$used);
		$found = array_search($try[1],$check_categories);		
		$push = FALSE;
		if($found!==FALSE && $apply>0){unset($check_categories[$found]);$push = TRUE;}
		if(count($check_categories)>0&&!$push){$apply=0;}
		if($apply>0){
			if(empty($saved_categories)){$saved_categories=array($try[1]);}
			else{array_push($saved_categories,$try[1]);}
			if(empty($saved_skins)){$saved_skins=array($try[0]."~".$try[1]."~".$apply);}
			else{array_push($saved_skins,$try[0]."~".$try[1]."~".$apply);}
			$saved=TRUE;			
		}	
	}
	$attempts--;
	if($attempts==0){$saved=TRUE;}
}while($saved==FALSE);
}

function findSkin($generation,$number,$skins,$all_skins){
global $saved_categories, $saved_skins,$check_categories;
$saved=FALSE;
$attempts=30;
do{
	$used=false;
	$try=explode("~",trim($skins[rand(0,count($skins)-1)]));
	if(count($saved_categories)==0 && count($saved_skins)==0){$run=TRUE;}
	else{
		$used=array_search($try[1],$saved_categories);
		$skin=strstr(implode("|",$saved_skins),$try[0]."~".$try[1]);
		if($skin===FALSE){$run=TRUE;}
	}
	if($run){  
		$apply=isAvailable($generation,findVal($try[0],$try[1],$all_skins,2),findVal($try[0],$try[1],$all_skins,3),$used);
		$found = array_search($try[1],$check_categories);
		$push = FALSE;
		if($found!==FALSE && $apply>0){unset($check_categories[$found]);$push = TRUE;}
		if(count($check_categories)>0&&!$push){$apply=0;}
		if($apply>0){
			if(empty($saved_categories)){$saved_categories=array($try[1]);}
			else{array_push($saved_categories,$try[1]);}
			if(empty($saved_skins)){$saved_skins=array($try[0]."~".$try[1]."~".$apply);}
			else{array_push($saved_skins,$try[0]."~".$try[1]."~".$apply);}
			$saved=TRUE;			
		}	
	}
	$attempts--;
	if($attempts==0){$saved=TRUE;}
}while($saved==FALSE);
}

function randomSkins($num,$generation,$creator,$channel){
global $saved_skins,$check_categories;
$skins=explode(":#%",getSkins($channel,$creator));
$check_categories=numCategories($skins,":#:",$generation,$skins);
for($i=0; $i<$num; $i++){pickSkin($generation,$skins);}
return implode("|",$saved_skins);
}

function createSkins($breedstring,$generation,$number,$creator,$channel){
	global $saved_skins,$check_categories;
	$skins=explode("&&",$breedstring);
	$all=array();
	for($i=0;$i<count($skins);$i++){$all=array_merge($all, array_slice(explode("|",$skins[$i]), 5));}
	$check_categories=numCategories($all,"~",$generation,explode(":#%",getSkins($channel,$creator)));
	for($i=0;$i<$number;$i++){findSkin($generation,$number,$all,explode(":#%",getSkins($channel,$creator)));}
	return implode("|",$saved_skins);
}

function getParams($skins,$creator,$channel){
	$params="";
	$Skins_Used=explode("|",$skins);
	$Skins_All=explode(":#%",getSkins($channel,$creator));
	for($i=0;$i<count($Skins_Used);$i++){
		$data=explode("~",$Skins_Used[$i]);
		if($data[2]=="2"){$params.=findVal($data[0],$data[1],$Skins_All,4);}
	}
	return $params;
}

function numCategories($skins,$parse,$generation,$species_skins){
	$list=array();
	for($i=0;$i<count($skins);$i++){
		$data=explode($parse,$skins[$i]);
		$category = $data[1];
		$gen = $data[2];
		if($parse=="~"){$gen=getGeneration($species_skins,$data[0],$data[1]);}/////////////////////////////FIND AND SET GEN
		if(array_search($category,$list)===false && $generation>=(int)$gen){
			if(empty($list)){$list=array($category);}
			else{array_push($list,$category);}
		}
	}
	return $list;
}

function getGeneration($skins, $identifier, $category){
	for($i=0;$i<count($skins);$i++){
		$data=explode(":#:",$skins[$i]);
		if($identifier==$data[0] && $category==$data[1]){return $data[2];}
	}
	return 1;
}

if(isset($_GET['mybreeds'])){
//ACTION// (timed request) => GET related breeds && publish 'rebuild' queues (LIMIT 1)
//request - ?mybreeds=channel:#%ownername
//receive - breed_name|breed_id:#:breed_name|breed_id(&)breed_id
$data = explode(":#%",mysql_real_escape_string ( $_GET['mybreeds']));
$channel = $data[0];
$owner = $data[1];
$result = mysql_query("SELECT * FROM breed WHERE breed_chan='$channel' AND owner_name='$owner'",$link);
if(mysql_num_rows($result)==0){return;}
$arr = array();
while($row=mysql_fetch_array($result)){array_push($arr, substr($row['breed_name'],0,20)."|".$row['breed_id']);}
print implode(":#:",$arr);//display all associated breeds for [same: owner/channel]
$result = mysql_query("SELECT * FROM rebuild WHERE breed_chan='$channel' AND owner_name='$owner' LIMIT 1",$link);
if(mysql_num_rows($result)==0){return;}
$row=mysql_fetch_array($result);
mysql_query("DELETE FROM rebuild WHERE id='".$row['id']."'",$link);
print "(&)".$row['breed_id'];//rebuild queue 
}

elseif(isset($_GET['rebuild'])){
//BREED//(rebuilt) => GET data && publish web skins/web anims
//request - ?rebuild=breed_id:#%breed_key
//if record exists : publish (most) breed_* values : update (other) breed_* data
//receive - webanims:#:PARSE:#%DATA
//print $_GET['rebuild'];
$data = explode(":#%",mysql_real_escape_string ( $_GET['rebuild']));
$breed_id = $data[0];
$breed_key = $data[1];//update
$owner_name = $data[2];
$breed_creator =$data[3];
$breed_version = $data[4];//update
$breed_pos = $data[5];//update
$breed_region = $data[6];//update
$breed_update = $data[7];//update
$breed_chan = $data[8];
$result = mysql_query("SELECT breed_name,breed_family,breed_gender,breed_age,breed_species,breed_skins,breed_hunger,breed_parents,breed_traits,breed_generation,timer_breed,timer_age,timer_grow,timer_hunger,breed_notdead,breed_litters,breed_anims,breed_growth_total,growth_stages,breed_physics,breed_born,breed_dead,breed_id,breed_partner,breed_globals FROM breed WHERE breed_id='$breed_id' AND owner_name='$owner_name' AND breed_creator='$breed_creator' AND breed_chan='$breed_chan'",$link);
if(mysql_num_rows($result)==0){return;}
$row=mysql_fetch_array($result,MYSQL_ASSOC);
mysql_query("UPDATE breed SET
breed_update='$breed_update', 
breed_pos='$breed_pos', 
breed_region='$breed_region', 
breed_version='$breed_version',
breed_key='$breed_key'
WHERE breed_id='$breed_id'", $link);
print implode(":#%",$row).":#:".getAnims($breed_chan,$breed_creator);
}

elseif(isset($_GET['values'])){//////////////////////////////NOTFINISHED//////////////change 'died' to 'die'
//BREED//(auto or child) => PUT data && publish web skins/web anims
//request - ?values=PARSE:#%DATA
//receive - webanims:#:myspecies
$input = str_replace(array("'",'"','\\'),"",$_GET['values']);
$data = explode(":#%",mysql_real_escape_string ( $input));
$secure_channel=$data[0];
$breed_creator=$data[1];
$breed_uuid=$data[2];//compare, queue deletion if IDs dont match
$last_update=$data[3];//update
$curr_pos=$data[4];//update
$curr_region=$data[5];//update
$MyGeneration=$data[6];
$MySkins=$data[7];
$MyParents=$data[8];
$MyGender=$data[9];
$MyKey=trim($data[10]);
$MyName=$data[11];//update
//if(str_replace("mysql","",$MyName)!=$MyName){$MyName="INVALID";}
$MyTraits=$data[12];//update
$notDead=$data[13];//update
$Timer_Age=$data[14];//update
$Timer_Breed=$data[15];//update
$Timer_Grow=$data[16];//update
$Timer_Hunger=$data[17];//update
$MyAge=$data[18];//update
$MyLitters=$data[19];//update
$MyHunger=$data[20];//update
$breed_owner=$data[21];//update
$saved_anims=$data[22];//update
$total_growth=$data[23];//update
$Growth_Stages=$data[24];//update
$prim_status=$data[25];//update
$version=$data[26];//update
$timeofBirth=$data[27];
$timeofDeath=$data[28];//update
$MyFamily=$data[29];//update
$MyPartner=$data[30];//update
$UpdateKey=$data[31];
$globals=$data[32];//update
if($MyFamily==""){$MyFamily=$Unknown_Family;}
$MySpecies = findSpecies($secure_channel,$breed_creator);//find species name -- same creator/channel
if($UpdateKey!="1" && duplicateBreed($breed_uuid,$MyKey)){die("die");}//queue deletion if uuids dont match
if(breedExists($MyKey)){//if record exists : update  record
	if((int)Key2Value($MyKey,'web_update')==0){$updatenames = "breed_name='$MyName', breed_family='$MyFamily'," ;}
	else{mysql_query("UPDATE breed SET web_update='0' WHERE breed_id='$MyKey'", $link);}
	mysql_query("UPDATE breed SET
	breed_key='$breed_uuid',
	".$updatenames."
	breed_update='$last_update', 
	breed_pos='$curr_pos', 
	breed_region='$curr_region', 
	breed_traits='$MyTraits', 
	breed_notdead='$notDead', 
	timer_age='$Timer_Age', 
	timer_breed='$Timer_Breed', 
	timer_grow='$Timer_Grow', 
	timer_hunger='$Timer_Hunger', 
	breed_age='$MyAge', 
	breed_litters='$MyLitters', 
	breed_hunger='$MyHunger', 
	owner_name='$breed_owner', 
	breed_anims='$saved_anims', 
	breed_growth_total='$total_growth', 
	growth_stages='$Growth_Stages', 
	breed_physics='$prim_status', 
	breed_version='$version', 
	breed_dead='$timeofDeath',
	breed_globals='$globals',
	breed_partner='$MyPartner'
	WHERE breed_id='$MyKey'", $link);
}
else{//	else : create record
	$MyFamily = findFamily($breed_owner);
	if($MyFamily==""){$MyFamily=$Unknown_Family;}
	mysql_query("INSERT INTO breed (
owner_name,
breed_id,
breed_name,
breed_gender,
breed_born,
breed_dead,
breed_age,
breed_species,
breed_family,
breed_skins,
breed_hunger,
breed_parents,
breed_traits,
breed_generation,
timer_breed,
timer_age,
timer_grow,
timer_hunger,
breed_key,
breed_update,
breed_chan,
breed_creator,
breed_pos,
breed_region,
breed_notdead,
breed_litters,
breed_anims,
breed_growth_total,
growth_stages,
breed_physics,
breed_version,
breed_globals, 
breed_partner
) VALUES (
'$breed_owner',
'$MyKey',
'$MyName',
'$MyGender',
'$timeofBirth',
'$timeofDeath',
'$MyAge',
'$MySpecies',
'$MyFamily',
'$MySkins',
'$MyHunger',
'$MyParents',
'$MyTraits',
'$MyGeneration',
'$Timer_Breed',
'$Timer_Age',
'$Timer_Grow',
'$Timer_Hunger',
'$breed_uuid',
'$last_update',
'$secure_channel',
'$breed_creator',
'$curr_pos',
'$curr_region',
'$notDead',
'$MyLitters',
'$saved_anims',
'$total_growth',
'$Growth_Stages',
'$prim_status',
'$version',
'$globals',
'$MyPartner')", $link);
}
$send_anims = getAnims($secure_channel,$breed_creator);
$send_species = $MySpecies;
$send_skins = Key2Value($MyKey,'breed_skins');
$send_family = Key2Value($MyKey,'breed_family');
$send_name = Key2Value($MyKey,'breed_name');
print implode(':%:',array($send_name,$send_family,$send_species,$send_skins,$send_anims));
}

elseif(isset($_GET['skin_type'])){
$creator = $_GET['skin_creator'];
$channel = $_GET['skin_channel'];
$value = $_GET['skin_string'];
$number = $_GET['skin_num'];
$generation = $_GET['skin_gen'];
$skins="None";
$params="";
if($_GET['skin_type']=="child"){//genetic string
	$skins=createSkins($value,$generation,$number,$creator,$channel);
	$params=getParams($skins,$creator,$channel);
}
if($_GET['skin_type']=="parent"){//random string (skin_string=total_num skins)
	$skins=randomSkins($number,$generation,$creator,$channel);
	$params=getParams($skins,$creator,$channel);
}
if($_GET['skin_type']=="rebuild"){//literal string
	$skins=$value;
	$params=getParams($skins,$creator,$channel);
}

$orig = array('texture(','color(','shine(','glow(','sculpt(','gen(','odds(');
$new = array('0(','1(','2(','3(','4(','5(','6(');
$params = str_replace($orig,$new,$params);

print $skins.":#%".$params;//publish skinset
}


?>