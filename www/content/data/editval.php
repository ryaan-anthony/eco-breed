<?php
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
	ini_set('memory_limit', '-1');
//$Default_Chamber="1,15,-1,0,1,-1,0,1.05,1,0,0,0,5,10,-1,40,5,10,0,0,1,3,0,-1,0,-1,1,1,1,0,0,1,Male,Female,None,1";
$Basic_Species_Limit=5;
$Premium_Species_Limit=15;
	$master_request= "ecoMASTERtoken8811";

function name_exists($name){
	global $link;
	$result = mysql_query("SELECT * FROM species WHERE species_name='$name'",$link);
	if(!$result || mysql_num_rows($result)==0){return FALSE;}
	return TRUE;
}
function number_exists($num){
	global $link;
	$result = mysql_query(
	"SELECT * FROM species WHERE species_chan='$num'
	UNION
	SELECT * FROM breed_rules WHERE Configuration_ID='$num'
	UNION
	SELECT * FROM action_rules WHERE Configuration_ID='$num'
	UNION
	SELECT * FROM breed WHERE breed_id='$num'",$link);
	if(!$result || mysql_num_rows($result)==0){return FALSE;}
	return TRUE;
}
function unsetcookie(){
	global $cookie_location;
	unset($_COOKIE[$cookie_location]);
	setcookie($cookie_location, NULL,-1);
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
function createID(){
	while(!$notset){
		$str = md5(uniqid(mt_rand(), true));
		$result="";
		for($i=0; $i<strlen($str); $i++){
			if((int)rand(0,1)==1){$result.=strtoupper($str[$i]);}	  
			else{$result.=strtolower($str[$i]);}
		}
		$result = substr($result,0,15);
		if(!number_exists($result)){$notset=TRUE;}
	}
	return $result;
}
function get_strided($index){
	global $values;
	$result=array();
	for($i=0;$i<count($values);$i++){
		$data = explode("$:",$values[$i]);
		if($index){
			$result = array_merge($result, array("'".$data[$index]."'"));
		}
		else{
			$result = array_merge($result, array($data[$index]));
		}
	}
	return implode(",",$result);
}
function dump_strided(){
	global $values;
	$result=array();
	for($i=0;$i<count($values);$i++){
		$data = explode("$:",$values[$i]);
		$result = array_merge($result,array($data[0]."='".$data[1]."'"));
	}
	return implode(",",$result);
}

//verify login credentials && open link
$params = unserialize(decrypt($_COOKIE[$cookie_location]));
$username=$params['name'];
$password=$params['pw'];
$link = mysql_connect("localhost","takecopy", "devTR1420");
if(!mysql_select_db("takecopy_vendors",$link)){die(mysql_error());}
$result=mysql_query("select * from user where name='$username'", $link);
if($result){
$row=mysql_fetch_array($result);
mysql_free_result($result);
if($password!=$row['password']){unsetcookie();die("Login Failed");}
}
else{unsetcookie();die("Login Failed");}

if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}

//curl request => $json
	$_GET['api']=$master_request;
	$_GET['user']=$username;
	include('../../api/index.php');
	$json = json_decode($json_raw,true);
	if(count($json['error'])){die($json['error']['message']);};
	$my_stats = $json['eco']['user'][0];
	$my_species = $json['eco']['species'];
	$all_breeds = $json['eco']['breeds'];
	$Version = $my_stats['version'];

////SPECIES RECORDS

//set species name
if(isset($_GET['species_name'])){
	$species_name=mysql_real_escape_string($_GET['species_name']);
	$myspecies = $json['eco']['species'][mysql_real_escape_string($_GET['species_index'])];
	$species_chan = $myspecies['species_number'];
	$species_creator = $myspecies['species_creator'];
	if($species_name==""){die("error: Invalid name!");}
	if(name_exists($species_name)){die("error: Name already exists!");}
	if($species_chan==""){
		$host_plan = $json['eco']['user'][0]['host_plan'];
		$total=(int)$json['eco']['user'][0]['species_count'];
		if(($host_plan=="Basic" && $total>=$Basic_Species_Limit) || ($host_plan=="Premium" && $total>=$Premium_Species_Limit)){
			die("error: Species limit reached. Upgrade your hosting to create new species.");
		}
		$species_chan = createID();		
		mysql_query("INSERT INTO species (species_chan,species_creator,species_name) VALUES ('$species_chan','$username','$species_name')", $link);
		print "added";
	}
	else{
		mysql_query("UPDATE species SET species_name='$species_name' WHERE species_chan='$species_chan' AND species_creator='$species_creator'", $link);
		mysql_query("UPDATE breed SET breed_species='$species_name' WHERE breed_chan='$species_chan' AND breed_creator='$species_creator'", $link);
	}
	return;
}

//set skins
if(isset($_GET['skin_index'])){
	$species = $json['eco']['species'][mysql_real_escape_string($_GET['species_index'])];
	$skinsets = $species['species_skins'];
	$skin = $skinsets[(int)mysql_real_escape_string($_GET['skin_index'])];
	
	//user input : new skin
	$data = explode(":#:",mysql_real_escape_string($_GET['value']));
	$skin_name = $data[0];
	$skin_category = $data[1];
	$skin_gen = $data[2];
	$skin_odds = $data[3];
	$skin_params = $data[4];
	$skin_limit = $data[5];
	
	//json output : old skin
	$old_skin = $skin['skin_name'];
	$old_category = $skin['skin_category'];
	
	$where = "WHERE skin_species='".$skin['skin_species']."' AND id='".$skin['skin_index']."'";
	if($_GET['value']=='DELETE'){mysql_query("DELETE FROM skins ".$where, $link);}
	else{
		if(count($skin)){
			mysql_query("UPDATE skins SET skin_name='$skin_name', skin_category='$skin_category', skin_gen='$skin_gen', skin_odds='$skin_odds', skin_params='$skin_params', skin_limit='$skin_limit' ".$where, $link);
		}
		else{
    	mysql_query("insert into skins (skin_name, skin_category, skin_gen, skin_odds, skin_params, skin_limit, skin_species) values ('$skin_name','$skin_category','$skin_gen','$skin_odds','$skin_params','$skin_limit', '".$species['species_index']."')");
		}
	}
	
	//set existing breed_skins to new values
	$all_breeds=$json['eco']['breeds'];
	for($i=0;$i<count($all_breeds);$i++){
		$save=false;
		$breed_skins = $all_breeds[$i]['breed_skins'];
		$breed_id = $all_breeds[$i]['breed_id'];
		$skins = explode("|",$breed_skins);
		for($n=0;$n<count($skins);$n++){
			$changed=false;
			$skinset = explode("~",$skins[$n]);
			if($skinset[0]==$old_skin && $skinset[1]==$old_category){//if old skin names && categories match
				if($skinset[0]!=$new_skin){$skinset[0]=$new_skin;$changed=true;}
				if($skinset[1]!=$new_category){$skinset[1]=$new_category;$changed=true;}
			}
			if($changed){
				if($val!='DELETE'){$skins[$n]=implode("~",$skinset);$save=true;}
				else{unset($skins[$n]);$save=true;}
			}
		}
		if($save){mysql_query("UPDATE breed SET breed_skins='".implode("|",$skins)."' WHERE breed_id='$breed_id'", $link);}
	}
	die();
}

//set anims
if(isset($_GET['anim_index'])){
	$species = $json['eco']['species'][mysql_real_escape_string($_GET['species_index'])];
	$animsets =$species['species_anims'];
	$anim = $animsets[mysql_real_escape_string($_GET['anim_index'])];
	
	//user input : new anim
	$data = explode(":#:",mysql_real_escape_string($_GET['value']));
	$anim_name = $data[0];
	$anim_repeat = $data[1];
	$anim_delay = $data[2];
	$anim_params = $data[3];
	$anim_frames = $data[4];
	
	//json output : old skin
	$old_anim = $anim['anim_name'];
	
	$where = "WHERE anim_species='".$anim['anim_species']."' AND id='".$anim['anim_index']."'";
	if($_GET['value']=='DELETE'){mysql_query("DELETE FROM anims ".$where, $link);}
	else{mysql_query("UPDATE anims SET anim_name='$anim_name', anim_repeat='$anim_repeat', anim_delay='$anim_delay', anim_params='$anim_params', anim_frames='$anim_frames' ".$where, $link);
	if (mysql_affected_rows()==0) {
    	mysql_query("insert into anims (anim_name, anim_repeat, anim_delay, anim_params, anim_frames, anim_species) values ('$anim_name','$anim_repeat','$anim_delay','$anim_params','$anim_frames', '".$species['species_index']."');");
	}
	}
	
	//update breed-cached
	$all_breeds=$json['eco']['breeds'];
	for($i=0;$i<count($all_breeds);$i++){
		$index = $all_breeds[$i]['breed_index'];
		$data = explode("||",$all_breeds[$i]['breed_cached']);
		if(!count($animsets)){if(count($data)){mysql_query("UPDATE breed SET breed_cached='' WHERE id='$index'", $link);}}//remove unneccesary cache
		else{
			$found = array_search($old_anim,$data);
			if($found!==false){
				unset($data[$found]);
				mysql_query("UPDATE breed SET breed_cached='".implode("||",$data)."' WHERE id='$index'", $link);
			}
		}
	}	
	die();
}

//delete species | new number | action rules | breed rules
if(isset($_GET['species_index'])){
	$val = mysql_real_escape_string($_GET['value']);
	$s = mysql_real_escape_string($_GET['species_index']);
	$myspecies = $json['eco']['species'][$s];
	$chan = $myspecies['species_number'];
	$species_index = $myspecies['species_index'];
	if(isset($_GET['breed_rule_index'])){
		$rules = $myspecies['breed_rules'][$_GET['breed_rule_index']];
		$Configuration_Name = $rules['Configuration_Name'];
		$Configuration_ID = $rules['Configuration_ID'];
		if($val=="reset"){
			mysql_query("DELETE FROM breed_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			mysql_query("INSERT INTO breed_rules (Configuration_ID,species_index,Configuration_Name) VALUES ('$Configuration_ID','$species_index','$Configuration_Name')",$link);
			print count($json['eco']['species'][$s]['breed_rules'])-1;
		}
		elseif($val=="delete"){mysql_query("DELETE FROM breed_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);}
		else{
			$values = explode('$;',$val);		
			mysql_query("UPDATE breed_rules SET ".dump_strided().",last_update='".time()."' WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			if(mysql_affected_rows()==0){
				mysql_query("INSERT INTO breed_rules (".get_strided(0).",Configuration_ID,species_index,last_update) VALUES (".get_strided(1).",'".createID()."','$species_index','".time()."')",$link);
				print count($json['eco']['species'][$s]['breed_rules']);
			}
			else{
				print $_GET['breed_rule_index'];
			}
		}
	}
	elseif(isset($_GET['action_rule_index'])){
		$rules = $myspecies['action_rules'][$_GET['action_rule_index']];
		$Configuration_Name = $rules['Configuration_Name'];
		$Configuration_ID = $rules['Configuration_ID'];
		if($val=="reset"){
			mysql_query("DELETE FROM action_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			mysql_query("INSERT INTO action_rules (Configuration_ID,species_index,Configuration_Name) VALUES ('$Configuration_ID','$species_index','$Configuration_Name')",$link);
			print count($json['eco']['species'][$s]['action_rules'])-1;
		}
		elseif($val=="delete"){mysql_query("DELETE FROM action_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);}
		else{
			$values = explode('$;',$val);		
			mysql_query("UPDATE action_rules SET ".dump_strided().",last_update='".time()."' WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			if(mysql_affected_rows($link)==0){
				mysql_query("INSERT INTO action_rules (".get_strided(0).",Configuration_ID,species_index,last_update) VALUES (".get_strided(1).",'".createID()."','$species_index','".time()."')",$link);
				print count($myspecies['action_rules']);
			}
			else{
				print $_GET['action_rule_index'];
			}
		}
	}
	elseif($val=='DELETE'){
		mysql_query("DELETE FROM species WHERE species_chan='$chan' AND species_creator='$username'",$link);
		//mysql_query("DELETE FROM anims WHERE anim_species NOT IN (SELECT id FROM species)",$link);
		mysql_query("DELETE FROM anims WHERE anim_species='$species_index'",$link);
		mysql_query("DELETE FROM skins WHERE skin_species='$species_index'",$link);
		mysql_query("DELETE FROM breed_rules WHERE species_index='$species_index'",$link);
		mysql_query("DELETE FROM action_rules WHERE species_index='$species_index'",$link);
	}	
	elseif($val=='NUMBER'){
		$species_chan=createID();
		mysql_query("UPDATE species SET species_chan='$species_chan' WHERE species_chan='$chan' AND species_creator='$username'",$link);
		print $species_chan;
	}
}

////BREED RECORDS

//delete all-breed
if(isset($_GET['delete'])&&isset($_GET['all_breed_index'])){
	$a = $_GET['all_breed_index'];
	$a=mysql_real_escape_string($a);
	$id = $json['eco']['breeds'][$a]['breed_id'];
	$owner = $json['eco']['breeds'][$a]['breed_owner'];
	$creator = $json['eco']['breeds'][$a]['breed_creator'];
	if($_GET['delete']=='TRUE'){mysql_query("DELETE FROM breed WHERE breed_id='$id'",$link);}
}

//rebuild all-breed
if(isset($_GET['rebuild'])&&isset($_GET['all_breed_index'])){
	$a = $_GET['all_breed_index'];
	$breed = $json['eco']['breeds'][$a]['breed_id'];
	$channel=$json['eco']['breeds'][$a]['breed_chan'];
	$owner=$json['eco']['breeds'][$a]['breed_owner'];
	mysql_query("INSERT INTO rebuild (breed_id,breed_chan,owner_name) VALUES ('$breed','$channel','$owner')", $link);
}

//set breed all-name
if(isset($_GET['all_breed_name'])&&isset($_GET['all_breed_index'])){
	$name=mysql_real_escape_string($_GET['all_breed_name']);
	$id = $json['eco']['breeds'][$_GET['all_breed_index']]['breed_id'];
	mysql_query("UPDATE breed SET breed_name='$name', web_update='1' WHERE breed_id='$id'", $link);
}

//bulk delete
if(isset($_GET['delete_indexes'])){
	$indexes = explode("_",$_GET['delete_indexes']);
	$statement=array();
	for($i=0;$i<count($indexes);$i++){
		$id = $json['eco']['breeds'][(int)$indexes[$i]]['breed_id'];
		if(strlen($id)){$statement=array_merge($statement,array(" breed_id='$id' "));}
	}
	if(count($statement)){mysql_query("DELETE FROM breed WHERE ".implode(" OR ",$statement),$link);}
}

////SETTINGS

//set inactive cron settings
if(isset($_GET['inactive_type'])&&isset($_GET['inactive_time'])){
	$time = (int)$_GET['inactive_time'];
	$type = $_GET['inactive_type'];
	if($type=="months"){$time=$time*60*60*24*30;}
	elseif($type=="days"){$time=$time*60*60*24;}
	elseif($type=="hours"){$time=$time*60*60;}
	elseif($type=="minutes"){$time=$time*60;}
	else{$time=0;}
	$result = mysql_query("select * from cleanup WHERE name='$username'", $link);
	if(mysql_num_rows($result)){mysql_query("UPDATE cleanup SET inactive_remove='$time' WHERE name='$username'", $link);}
	else{mysql_query("INSERT INTO cleanup (inactive_remove, name) VALUES ('$time', '$username')",$link);}
}

//set dead cron settings
if(isset($_GET['dead_type'])&&isset($_GET['dead_time'])){
	$time = (int)$_GET['dead_time'];
	$type = $_GET['dead_type'];
	if($type=="months"){$time=$time*60*60*24*30;}
	elseif($type=="days"){$time=$time*60*60*24;}
	elseif($type=="hours"){$time=$time*60*60;}
	elseif($type=="minutes"){$time=$time*60;}
	else{$time=0;}
	$result = mysql_query("select * from cleanup WHERE name='$username'", $link);
	if(mysql_num_rows($result)){mysql_query("UPDATE cleanup SET dead_remove='$time' WHERE name='$username'", $link);}
	else{mysql_query("INSERT INTO cleanup (dead_remove, name) VALUES ('$time', '$username')",$link);}
}



//ignore
////save chamber settings
//if(isset($_GET['chamber_index'])){
//$index = mysql_real_escape_string($_GET['chamber_index']);
//$result = mysql_real_escape_string($_GET['result']);
//mysql_query("UPDATE species SET species_chamber='$result' WHERE id='$index' AND species_creator='$username'", $link);
//}

////reset chamber settings
//if(isset($_GET['chamber_reset'])){
//mysql_query("UPDATE species SET species_chamber='$Default_Chamber' WHERE id='".mysql_real_escape_string($_GET['chamber_reset'])."' AND species_creator='$username'", $link);
//}

?>