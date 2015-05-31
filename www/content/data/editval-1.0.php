<?php
include('common.php');

function name_exists($name){
	global $link;
	$result = mysql_query("SELECT * FROM species WHERE species_name='$name'",$link);
	if(!$result || mysql_num_rows($result)==0){return FALSE;}
	return TRUE;
}
function get_strided($index){
	global $values;
	$result=array();
	for($i=0;$i<count($values);$i++){
		$data = explode("$:",$values[$i]);
		if($index){
			$result = array_merge($result, array("'".safe($data[$index])."'"));
		}
		else{
			$result = array_merge($result, array(safe($data[$index])));
		}
	}
	return implode(",",$result);
}
function dump_strided(){
	global $values;
	$result=array();
	for($i=0;$i<count($values);$i++){
		$data = explode("$:",$values[$i]);
		$result = array_merge($result,array(safe($data[0])."='".safe($data[1])."'"));
	}
	return implode(",",$result);
}
function safe($str){
	return mysql_real_escape_string(addslashes($str));
}

////SPECIES RECORDS

//set species name
if(isset($_POST['species_name'])){
	$species_name = safe(stripslashes(urldecode($_POST['species_name'])));
	if($species_name==""){die("error: Invalid name!");}
	if(name_exists($species_name)){die("error: Name already exists!");}
	$species_index = (int)$_POST['species_index'];	
	//new
	if(!$species_index){
		get_json(array("user_only" => "true"));
		$my_stats = $json['eco']['user'][0];
		$host_plan = $my_stats['host_plan'];
		$total=(int)$my_stats['species_count'];
		$limit = $Limitations[$host_plan]['species'];
		if($total>=$limit && $limit!=-1){
			die("error: Species limit reached. Upgrade your hosting to create new species.");
		}
		$species_chan = createID();
		mysql_query("INSERT INTO species (species_chan,species_creator,species_name) VALUES ('$species_chan','$username','$species_name')", $link);
		print mysql_insert_id();
		die();
	}
	//existing
	else{
		get_json(array("species" => $species_index));
		$my_species = $json['eco']['species'][0];
		$species_chan = $my_species['species_number'];
		$species_creator = $my_species['species_creator'];
		mysql_query("UPDATE species SET species_name='$species_name' WHERE species_chan='$species_chan' AND species_creator='$species_creator'", $link);
		mysql_query("UPDATE breed SET breed_species='$species_name' WHERE breed_chan='$species_chan' AND breed_creator='$species_creator'", $link);
	}
	die($species_index);
}

//set skins
if(isset($_POST['skin_index'])){
	$species_index = (int)$_POST['species_index'];
	get_json(array("species" => $species_index,"skins" => "all"));
	$my_stats = $json['eco']['user'][0];
	$my_species = $json['eco']['species'][0];
	$species_creator = $my_species['species_creator'];
	$species_number = $my_species['species_number'];
	$skinsets = $my_species['species_skins'];
	$skin = $skinsets[(int)mysql_real_escape_string($_POST['skin_index'])];
	$val = stripslashes(urldecode($_POST['value']));
	
	//user input : new skin
	$data = explode(":;:",$val);
	$skin_name = safe($data[0]);
	$skin_category = safe($data[1]);
	$skin_gen = safe($data[2]);
	$skin_odds = safe($data[3]);
	$skin_params = safe(str_replace("\\n","",$data[4]));
	$skin_limit = safe($data[5]);
	
	//json output : old skin
	$old_skin = $skin['skin_name'];
	$old_category = $skin['skin_category'];
	
	$where = "WHERE skin_species='".$skin['skin_species']."' AND id='".$skin['skin_index']."'";
	if($_POST['value']=='DELETE'){mysql_query("DELETE FROM skins ".$where, $link);}
	else{
		if(count($skin)){
			mysql_query("UPDATE skins SET skin_name='$skin_name', skin_category='$skin_category', skin_gen='$skin_gen', skin_odds='$skin_odds', skin_params='$skin_params', skin_limit='$skin_limit' ".$where, $link);
		}
		else{
			$max_allowed = $Limitations[$my_stats['host_plan']]['skins'];
			if(count($skinsets)<$max_allowed || $max_allowed==-1){
				mysql_query("insert into skins (skin_name, skin_category, skin_gen, skin_odds, skin_params, skin_limit, skin_species) values ('$skin_name','$skin_category','$skin_gen','$skin_odds','$skin_params','$skin_limit', '".$my_species['species_index']."')");
			}
		}
	}
	
	//set existing breed_skins to new values
	if($skin_name.$skin_category!=$old_skin.$old_category && $old_skin!=""){
		if($_POST['value']!='DELETE'){
			$result = mysql_query("
			UPDATE breed
			SET breed_skins = replace(breed_skins,'$old_skin~$old_category','$skin_name~$skin_category')
			WHERE breed_creator='$species_creator' AND breed_chan='$species_number'
			",$link);
		}
		else{
//			$result = mysql_query("
//			UPDATE breed
//			SET breed_skins = replace(breed_skins,'$old_skin~$old_category','~')
//			WHERE breed_creator='$species_creator' AND breed_chan='$species_number'
//			",$link);
		}//remove skin from breeds (? meh ?)
	}
	die();
}

//set anims
if(isset($_POST['anim_index'])){
	$species_index = (int)$_POST['species_index'];
	get_json(array("species" => $species_index,"anims" => "all"));
	$my_stats = $json['eco']['user'][0];
	$my_species = $json['eco']['species'][0];
	$animsets =$my_species['species_anims'];
	$anim = $animsets[mysql_real_escape_string($_POST['anim_index'])];
	
	$val = stripslashes(urldecode($_POST['value']));
	//user input : new anim
	$data = explode(":;:",$val);
	$anim_name = safe($data[0]);
	$anim_repeat = safe($data[1]);
	$anim_delay = safe($data[2]);
	$anim_params = safe(str_replace("\\n","",$data[3]));
	$anim_frames = safe($data[4]);
	
	//json output : old anim
	$old_anim = $anim['anim_name'];	
	$where = "WHERE anim_species='".$anim['anim_species']."' AND id='".$anim['anim_index']."'";
	if($_POST['value']=='DELETE'){mysql_query("DELETE FROM anims ".$where, $link);}
	else{
		if(count($anim)){mysql_query("UPDATE anims SET anim_name='$anim_name', anim_repeat='$anim_repeat', anim_delay='$anim_delay', anim_params='$anim_params', anim_frames='$anim_frames' ".$where, $link);}
		else{
			$max_allowed = $Limitations[$my_stats['host_plan']]['anims'];
			if(count($animsets)<$max_allowed || $max_allowed==-1){
				mysql_query("insert into anims (anim_name, anim_repeat, anim_delay, anim_params, anim_frames, anim_species) values ('$anim_name','$anim_repeat','$anim_delay','$anim_params','$anim_frames', '".$my_species['species_index']."')");
			}
		}
	}
	
	//update breed-cached
	if($anim_name!=$old_anim  && $old_anim!=""){
		if($_POST['value']!='DELETE'){
			$result = mysql_query("
			UPDATE breed
			SET breed_cached = replace(breed_cached,'$old_anim','')
			WHERE breed_creator='$species_creator' AND breed_chan='$species_number'
			",$link);
		}
	}
	die();
}

//delete species | new number | action rules | breed rules
if(isset($_POST['species_index'])){
	$val="";
	if(isset($_POST['value'])){$val = stripslashes(urldecode($_POST['value']));}
	$species_index=(int)$_POST['species_index'];
	get_json(array("species" => $species_index,"breed_rules" => "all","action_rules" => "all","authorized" => "all"));
	$my_stats = $json['eco']['user'][0];
	$myspecies = $json['eco']['species'][0];
	$chan = $myspecies['species_number'];
	$species_index = $myspecies['species_index'];
	if(isset($_POST['breed_rule_index'])){
		$rules = $myspecies['breed_rules'][$_POST['breed_rule_index']];
		$Configuration_Name = $rules['Configuration_Name'];
		$Configuration_ID = $rules['Configuration_ID'];
		if($val=="reset"){
			mysql_query("DELETE FROM breed_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			mysql_query("INSERT INTO breed_rules (Configuration_ID,species_index,Configuration_Name) VALUES ('$Configuration_ID','$species_index','$Configuration_Name')",$link);
			print count($myspecies['breed_rules'])-1;
		}
		elseif($val=="delete"){mysql_query("DELETE FROM breed_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);}
		else{
			$values = explode('$;',$val);		
			mysql_query("UPDATE breed_rules SET ".dump_strided().",last_update='".time()."' WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			$max_allowed = $Limitations[$my_stats['host_plan']]['breed_config'];
			if(mysql_affected_rows()==0 && (count($myspecies['breed_rules'])<$max_allowed || $max_allowed==-1)){
				mysql_query("INSERT INTO breed_rules (".get_strided(0).",Configuration_ID,species_index,last_update) VALUES (".get_strided(1).",'".createID()."','$species_index','".time()."')",$link);
				print count($myspecies['breed_rules']);
			}
			else{
				print $_POST['breed_rule_index'];
			}
		}
	}
	elseif(isset($_POST['action_rule_index'])){
		$rules = $myspecies['action_rules'][$_POST['action_rule_index']];
		$Configuration_Name = $rules['Configuration_Name'];
		$Configuration_ID = $rules['Configuration_ID'];
		if($val=="reset"){
			mysql_query("DELETE FROM action_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			mysql_query("INSERT INTO action_rules (Configuration_ID,species_index,Configuration_Name) VALUES ('$Configuration_ID','$species_index','$Configuration_Name')",$link);
			print count($myspecies['action_rules'])-1;
		}
		elseif($val=="delete"){mysql_query("DELETE FROM action_rules WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);}
		else{
			$values = explode('$;',str_replace(array("0xSl","0x43"),array("%","+"),$val));
			mysql_query("UPDATE action_rules SET ".dump_strided().",last_update='".time()."' WHERE species_index='$species_index' AND Configuration_ID='$Configuration_ID'", $link);
			$max_allowed = $Limitations[$my_stats['host_plan']]['action_config'];
			if(mysql_affected_rows($link)==0 && (count($myspecies['action_rules'])<$max_allowed || $max_allowed==-1)){
				mysql_query("INSERT INTO action_rules (".get_strided(0).",Configuration_ID,species_index,last_update) VALUES (".get_strided(1).",'".createID()."','$species_index','".time()."')",$link);
				print count($myspecies['action_rules']);
			}
			else{
				print $_POST['action_rule_index'];
			}
		}
	}
	elseif(isset($_POST['rem_authorized_user'])){
		$remove_user = mysql_real_escape_string($_POST['rem_authorized_user']);
		$result = mysql_query("delete from authorized_user where name='$remove_user' and species_index='$species_index'",$link);
		if(mysql_affected_rows()){print "success";}
		else{die("error");}
		$result = mysql_query("select * from accounts where name='$remove_user'",$link);
		if(!$result){die("error");}
		$row = mysql_fetch_array($result);
		mysql_select_db("takecopy_vendors",$link);
		mysql_query("INSERT INTO inworld_im (uuid, message) VALUES ('".$row['uuid']."', '".addslashes("Modify permissions for ".$myspecies['species_name']." has been revoked.")."')", $link);
		die();
	}
	elseif(isset($_POST['authorized_user'])){
		$name = strtolower(mysql_real_escape_string($_POST['authorized_user']));
		if($name == $myspecies['species_creator']){die("This user is already authorized.");}
		$result=mysql_query("select * from accounts where name='$name'", $link);
		if(!$result || !mysql_num_rows($result)){die("User must have an eco account.");}
		$result=mysql_query("select * from authorized_user where name='$name' and species_index='$species_index'", $link);
		if($result && mysql_num_rows($result)){die("This user is already authorized.");}
		$max_allowed = $Limitations[$my_stats['host_plan']]['users'];
		if(count($myspecies['authorized_users'])>=$max_allowed && $max_allowed!=-1){die("You cannot add any more users.");}
		if(!mysql_query("INSERT INTO authorized_user (name,species_index) VALUES ('$name','$species_index')",$link)){die("Unexpected error, please try again.");}
		print "success";
		$result = mysql_query("select * from accounts where name='$name'",$link);
		if(!$result){die("error");}
		$row = mysql_fetch_array($result);
		mysql_select_db("takecopy_vendors",$link);
		mysql_query("INSERT INTO inworld_im (uuid, message) VALUES ('".$row['uuid']."', '".addslashes($myspecies['species_creator']." has granted you modify permissions for ".$myspecies['species_name'].".")."')", $link);
		die();
	}
	elseif($val=='DELETE'){
		mysql_query("DELETE FROM species WHERE species_chan='$chan' AND species_creator='$username'",$link);
		//mysql_query("DELETE FROM anims WHERE anim_species NOT IN (SELECT id FROM species)",$link);
		mysql_query("DELETE FROM anims WHERE anim_species='$species_index'",$link);
		mysql_query("DELETE FROM skins WHERE skin_species='$species_index'",$link);
		mysql_query("DELETE FROM breed_rules WHERE species_index='$species_index'",$link);
		mysql_query("DELETE FROM action_rules WHERE species_index='$species_index'",$link);
		mysql_query("DELETE FROM authorized_user WHERE species_index='$species_index'",$link);
	}	
	elseif($val=='NUMBER'){
		$species_chan=createID();
		mysql_query("UPDATE breed SET breed_chan='$species_chan' WHERE breed_chan='$chan' AND species_creator='$username'",$link);
		mysql_query("UPDATE species SET species_chan='$species_chan' WHERE species_chan='$chan' AND species_creator='$username'",$link);
		print $species_chan;
	}
}

////BREED RECORDS

//delete | rebuild | rename all-breed
if(isset($_POST['all_breed_index'])){
	get_json(array("breeds" => (int)$_POST['all_breed_index']));
	$all_breeds = $json['eco']['breeds'][0];
	$id = $all_breeds['breed_id'];
	$owner = $all_breeds['breed_owner'];
	$creator = $all_breeds['breed_creator'];
	if(isset($_POST['debug_this'])){
		mysql_query("UPDATE breed set debug_this='".mysql_real_escape_string($_POST['debug_this'])."' WHERE breed_id='$id'",$link);
	}
	elseif(isset($_POST['all_breed_name'])){mysql_query("UPDATE breed SET breed_name='".mysql_real_escape_string($_POST['all_breed_name'])."', web_update='1' WHERE breed_id='$id'", $link);}
	elseif(isset($_POST['rebuild'])){
		mysql_query("INSERT INTO rebuild (breed_id,breed_chan,owner_name) VALUES ('$id','$channel','$owner')", $link);
 	}
	elseif(isset($_POST['delete']) && $_POST['delete']=='TRUE'){
		mysql_query("DELETE FROM breed WHERE breed_id='$id'",$link);
	}
}

//bulk delete
if(isset($_POST['delete_indexes'])){
	$indexes = explode("_",mysql_real_escape_string($_POST['delete_indexes']));
	$statement=array();
	for($i=0;$i<count($indexes);$i++){
		$id = $indexes[$i];
		if(strlen($id)){$statement=array_merge($statement,array(" id='$id' "));}
	}
	if(count($statement)){mysql_query("DELETE FROM breed WHERE (".implode(" OR ",$statement).") AND (owner_name='$username' OR breed_creator='$username')",$link);}
}

////SETTINGS

//set inactive cron settings
if(isset($_POST['inactive_type'])&&isset($_POST['inactive_time'])){
	$time = (int)$_POST['inactive_time'];
	$type = $_POST['inactive_type'];
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
if(isset($_POST['dead_type'])&&isset($_POST['dead_time'])){
	$time = (int)$_POST['dead_time'];
	$type = $_POST['dead_type'];
	if($type=="months"){$time=$time*60*60*24*30;}
	elseif($type=="days"){$time=$time*60*60*24;}
	elseif($type=="hours"){$time=$time*60*60;}
	elseif($type=="minutes"){$time=$time*60;}
	else{$time=0;}
	$result = mysql_query("select * from cleanup WHERE name='$username'", $link);
	if(mysql_num_rows($result)){mysql_query("UPDATE cleanup SET dead_remove='$time' WHERE name='$username'", $link);}
	else{mysql_query("INSERT INTO cleanup (dead_remove, name) VALUES ('$time', '$username')",$link);}
}

//request eco-package delivery
if(isset($_POST['upgrade_now'])){
	get_json(array("user_only" => "true"));
	$my_stats = $json['eco']['user'][0];
	if($my_stats['version']!="none"){
		$owner = "dev khaos";
		$buyer = $my_stats['uuid'];
		$item = $Limitations["eco-package"];
		$itemid = "5B06e68C1fa5Df557CdeF7Cd8997E92B";
		mysql_select_db("takecopy_vendors",$link);
		mysql_query("insert into delivery (owner,buyer,item,itemid) values ('$owner','$buyer','$item','$itemid')");	
		mysql_select_db("takecopy_eco",$link);
		die("Update sent! It may take up to 30 seconds to receive the inventory in world.");
	}
	else{
		die("Invalid user");
	}	
}




//ignore
////save chamber settings
//if(isset($_POST['chamber_index'])){
//$index = mysql_real_escape_string($_POST['chamber_index']);
//$result = mysql_real_escape_string($_POST['result']);
//mysql_query("UPDATE species SET species_chamber='$result' WHERE id='$index' AND species_creator='$username'", $link);
//}

////reset chamber settings
//if(isset($_POST['chamber_reset'])){
//mysql_query("UPDATE species SET species_chamber='$Default_Chamber' WHERE id='".mysql_real_escape_string($_POST['chamber_reset'])."' AND species_creator='$username'", $link);
//}

?>