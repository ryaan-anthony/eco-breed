<?php // API
	$master_request="ecoMASTERtoken8811";
	$Limitations = array(
		"Basic"	=> array(
			"species" => 5,
			"breeds" => 10000,
			"skins" => 30,
			"anims" => 10,
			"breed_config" => 5,
			"action_config" => 5,
			"timeout" => 300,
			"users" => 1
		),
		"Premium"	=> array(
			"species" => 15,
			"breeds" => 50000,
			"skins" => 100,
			"anims" => 50,
			"breed_config" => 15,
			"action_config" => 15,
			"timeout" => 120,
			"users" => 5
		),
		"Unlimited"	=> array(
			"species" => -1,
			"breeds" => -1,
			"skins" => -1,
			"anims" => -1,
			"breed_config" => -1,
			"action_config" => -1,
			"timeout" => 60,
			"users" => -1
		),
		"Response_Timeout" => 330,
		"Eco_Version" => "0.222"
		);
	// open $link
	$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
	if(!mysql_select_db("takecopy_eco",$link)){
		die(json_error('mysql_error',mysql_error()));
	}

	// sort input
	$Commands = array(
		"api" => NULL,
		"species" => NULL,
		"breeds" => NULL,
		"breed_rules" => NULL,
		"action_rules" => NULL,
		"skins" => NULL,
		"anims" => NULL,
		"authorized" => NULL,
		"user_only" => NULL,
		"filter_status" => NULL,
		"filter_species" => NULL
	);	
	if(!isset($_GET['api'])){
		foreach ($_POST as $key => $value){
			if(isset($_POST[$key])){
				$Commands[$key] = clean($value);
			}
		}
	}
	else{
		foreach ($_GET as $key => $value){
			if(isset($_GET[$key])){
				$Commands[$key] = clean($value);
			}
		}
	}
	
	// api token not given
	if(empty($Commands['api'])){
		die(json_error('not_set','api key not set'));
	}
	
	// master request
	if($Commands['api']==$master_request){
		$username=clean($_GET['user']);
	}	
	
	// 3rd party request
	else{
		$result = mysql_query("select * from api_dev where api_key='".$Commands['api']."'", $link);
		if(!$result || !mysql_num_rows($result)){
			die(json_error('invalid','invalid api key'));
		}
		$row = mysql_fetch_array($result);
		
		// reset counters 
		if((int)$row['recent_time']==0||time()-(int)$row['recent_time']>60){
			mysql_query("UPDATE api_dev SET recent_time='".time()."', recent_count='0' WHERE api_key='".$Commands['api']."'", $link);
		}
		
		// throttle max results
		elseif((int)$row['recent_count']>60){
			mysql_query("UPDATE api_dev SET throttle_count='".((int)$row['throttle_count']+1)."' WHERE api_key='".$Commands['api']."'", $link);
			die(json_error('request_throttled','max 60 requests per minute'));
		}
		
		// set name
		$username = $row['name'];
	}
	
	// user not set
	if(empty($username)){
		die(json_error('not_set','user not set'));
	}

	// create results
	$filter = array_filter(
		array(
			"species" => $Commands['species'],
			"breeds" => $Commands['breeds'],
			"breed_rules" => $Commands['breed_rules'],
			"action_rules" => $Commands['action_rules'],
			"skins" => $Commands['skins'],
			"anims" => $Commands['anims'],
			"authorized" => $Commands['authorized'],
			"user_only" => $Commands['user_only'],
			"filter_status" => $Commands['filter_status'],
			"filter_species" => $Commands['filter_species']
		)
	);
	if(!$filter){$json_raw = create_json();}
	else{$json_raw = create_json($filter);}
	if($Commands['api']!=$master_request){echo($json_raw);}
	
	//log errors
	$error = error_get_last();
	if(count($error)){mysql_query("insert into error_log (message,user) values ('"."<b>Warning</b> ".$error['message']." line ".$error['line']." of ".$error['file']."','$username')",$link);}

	function create_json($filter = array(
	"species" => "all",
	"breeds" => "all",
	"breed_rules" => "all",
	"action_rules" => "all",
	"skins" => "all",
	"anims" => "all",
	"authorized" => "all",
	"filter_status" => "all",
	"filter_species" => "all")){
		global $link;
		$results = array("\"user\":[".user()."]");
		if(isset($filter['species'])){$results = array_merge($results,array("\"species\":[".species($filter)."]"));}
		if(isset($filter['breeds'])){$results = array_merge($results,array("\"breeds\":[".breeds($filter)."]"));}
		return "{\"eco\":{".implode(",",$results)."}}";
	}

	function user(){
		global $username,$link;	
		$result=mysql_query("
		SELECT 
			t6.sub_type, 
			t6.sub_time, 
			t2.inactive_remove, 
			t2.dead_remove,
			t3.api_key,
			t4.version,
			t5.version as old_version,
			t1.uuid,
			COALESCE(t7.species_count,0) as species_count,
			COALESCE(t8.breed_count,0) as breed_count
		FROM
			accounts as t1
			LEFT JOIN
				cleanup as t2
			 ON t2.name=t1.name
			LEFT JOIN
				api_dev as t3
			 ON t3.name=t1.name
			LEFT JOIN
				eco_creators as t4
			 ON t4.name=t1.name
			LEFT JOIN
				user as t5
			 ON t5.name=t1.name
			LEFT JOIN
				subscriptions as t6
			 ON t6.name=t1.name
			LEFT JOIN
				(select count(*) as species_count, species_creator from species group by species_creator) as t7
			 ON t7.species_creator=t1.name
			LEFT JOIN
				(select count(*) as breed_count,breed_creator from breed group by breed_creator) as t8
			 ON t8.breed_creator=t1.name
			WHERE t1.name = '$username'
		", $link);
		if($result && mysql_num_rows($result)>0){
			$uuid = "00000000-0000-0000-0000-000000000000";
			$host_plan = "Basic";
			$row=mysql_fetch_array($result);
			if($row['sub_type']=="1"){$host_plan="Premium";}
			elseif($row['sub_type']=="2"){$host_plan="Unlimited";}
			$host_time=(int)$row['sub_time'];
			$inactive_remove = (int)$row['inactive_remove'];
			$dead_remove = (int)$row['dead_remove'];
			$api_key = $row['api_key'];
			$version = $row['version'];
			$old_version = $row['old_version'];
			if($version==""){$version=$old_version;}
			if($version==""){$version="none";}
			if($row['uuid']!=""){$uuid = $row['uuid'];}	
			$species_count = (int)$row['species_count'];
			$breed_count = (int)$row['breed_count'];
		}
		else{die(mysql_error());}
		return '
	{
	  "name": "'.$username.'",
	  "uuid": "'.$uuid.'",
	  "host_plan": "'.$host_plan.'",
	  "host_expire": "'.$host_time.'",
	  "species_count": "'.$species_count.'",
	  "breed_count": "'.$breed_count.'",
	  "inactive_remove": "'.$inactive_remove.'",
	  "dead_remove": "'.$dead_remove.'",
	  "api_key": "'.$api_key.'",
	  "version": "'.$version.'"
	}';	
	}

	function species($filter = array(
		"species" => "all",
		"breeds" => "all",
		"breed_rules" => "all",
		"action_rules" => "all",
		"skins" => "all",
		"anims" => "all",
		"authorized" => "all")){
		global $username, $link;
		$where="";
		if(is_numeric($filter['species'])){$where = "AND t1.id = '".$filter['species']."'";}
		elseif(str_replace("all","",$filter['species'])!=""){$where = "AND t1.species_chan = '".$filter['species']."'";}
		$result=mysql_query("		
		SELECT
			t1.id species_index,
			t1.species_chan species_number,
			t1.species_name,
			t1.species_creator,
			count(t2.id) species_count
		FROM species t1
		LEFT JOIN breed t2
		ON t2.breed_chan = t1.species_chan
		WHERE
			(t1.species_creator='$username' 
		 OR 
			t1.id IN (select species_index from authorized_user where name='$username'))
			$where
		GROUP BY t1.species_chan
		ORDER BY 
			t1.id ASC
		", $link);
		if($result){
			$params = array();
			while($row=mysql_fetch_array($result)){
				$input = array(
				"\"species_index\": \"".$row['species_index']."\"",
				"\"species_number\": \"".$row['species_number']."\"",
				"\"species_creator\": \"".$row['species_creator']."\"",
				"\"species_name\": \"".$row['species_name']."\"",
				"\"species_count\": \"".$row['species_count']."\""
			);			
				if(isset($filter['authorized'])){
					$input = array_merge($input,array("\"authorized_users\": [".auth_users($row['species_index'])."]"));
				}	
				if(isset($filter['skins'])){
					$input = array_merge($input,array("\"species_skins\": [".skins($row['species_index'])."]"));
				}
				if(isset($filter['anims'])){
					$input = array_merge($input,array("\"species_anims\": [".anims($row['species_index'])."]"));
				}
				if(isset($filter['breed_rules'])){
					if($filter['breed_rules']=="all"){$filter['breed_rules']="";}
					$input = array_merge($input,array("\"breed_rules\": [".breed_rules($row['species_index'],$filter['breed_rules'])."]"));
				}
				if(isset($filter['action_rules'])){
					$input = array_merge($input,array("\"action_rules\": [".action_rules($row['species_index'])."]"));
				}
				$params = array_merge($params,array("{".implode(',',$input)."}"));    
			}
			return implode(',',$params);
		}
		return mysql_error();
	}
	
	function breeds($filter = array(
	"species" => "all",
	"breeds" => "all",
	"breed_rules" => "all",
	"action_rules" => "all",
	"skins" => "all",
	"anims" => "all",
	"authorized" => "all",
	"filter_status" => "all",
	"filter_species" => "all")){
		global $username, $link,$Limitations;
		$append="";
		$where="";
		if(is_numeric($filter['breeds'])){$where = " AND id = '".$filter['breeds']."' ";}
		elseif(str_replace("all","",$filter['breeds'])!=""){$where = "AND breed_id = '".$filter['breeds']."'";}
		if(isset($filter['filter_species']) && str_replace("all","",$filter['filter_species'])!=""){$append.=" AND breed_species='".$filter['filter_species']."' ";}
		if(isset($filter['filter_status'])){
			if($filter['filter_status']=="dead"){$append.=" AND breed_dead>0 ";}
			elseif($filter['filter_status']=="inactive"){$append.= " AND (".time()."- breed_update) >".$Limitations["Response_Timeout"]." ";}
			elseif($filter['filter_status']=="alive"){$append.=" AND breed_dead='0' AND (".time()."- breed_update) <".$Limitations["Response_Timeout"];}
		}
		$result=mysql_query("
		SELECT
			id as breed_index,
			breed_id,
			breed_name,
			breed_key,
			owner_name as breed_owner,
			breed_gender,
			breed_born,
			breed_dead,
			breed_age,
			breed_species,
			breed_skins,
			breed_hunger,
			breed_parents,
			breed_generation,
			breed_chan,
			breed_creator,
			breed_pos,
			breed_region,
			breed_litters,
			breed_anims,
			breed_growth_total,
			growth_stages,
			breed_version,
			breed_update,
			breed_partner,
			breed_cached,
			web_update,
			debug_this
		FROM
			breed
		WHERE
			(breed_creator='$username' OR owner_name='$username') 
			$where
			$append
		ORDER BY 
		id ASC", $link);
		if($result){
			$params = array();
			while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
				$input = array();
				foreach ($row as $key => $value) {
					$input = array_merge($input, array("\"$key\": \"$value\""));
				}
				$params = array_merge($params,array("{".implode(',',$input)."}"));
			}
			return implode(',',$params);
		}
		return mysql_error();
	}
	
function skins($id){
	global $link;
	$result=mysql_query("select * from skins where skin_species='$id' ORDER BY id ASC", $link);
	if($result){
		$params=array();
		while($row=mysql_fetch_array($result)){
			$params = array_merge($params,array('
      { 
	 "skin_name": "'.$row['skin_name'].'", 
	 "skin_category": "'.$row['skin_category'].'", 
	 "skin_gen": "'.$row['skin_gen'].'", 
	 "skin_odds": "'.$row['skin_odds'].'", 
	 "skin_params": "'.$row['skin_params'].'",
	 "skin_limit": "'.$row['skin_limit'].'",
	 "skin_species": "'.$id.'",
	 "skin_index": "'.$row['id'].'"
      }'));
		}
		if(count($params)){return implode(',',$params);}
	}
	return "
      ";
}
function clean($str){
	return mysql_real_escape_string(str_replace(array("'",'"','\\'),"",$str));
}
function json_error($code,$type){
	return '{
	"error": {
		"code": "'.$code.'",
		"message": "'.$type.'"
	  }
	}';
}
function auth_users($species_index){
	global $link;
	$result=mysql_query("select * from authorized_user where species_index='$species_index' ORDER BY id ASC", $link);
	if($result){
		$params=array();
		while($row=mysql_fetch_array($result)){
			$params = array_merge($params,array('
      { 
	 "user_name": "'.$row['name'].'"
      }'));
		}
		if(count($params)){return implode(',',$params);}
	}
	return "
      ";
}

function anims($id){
	global $link;
	$result=mysql_query("select * from anims where anim_species='$id' ORDER BY id ASC", $link);
	if($result){
		$params=array();
		while($row=mysql_fetch_array($result)){
			$params = array_merge($params,array('
      { 
	 "anim_name": "'.$row['anim_name'].'", 
	 "anim_repeat": "'.$row['anim_repeat'].'", 
	 "anim_delay": "'.$row['anim_delay'].'", 
	 "anim_params": "'.$row['anim_params'].'", 
	 "anim_frames": "'.$row['anim_frames'].'",
	 "anim_species": "'.$id.'",
	 "anim_index": "'.$row['id'].'"
      }'));
		}
		if(count($params)){return implode(',',$params);}
	}
	return "
      ";
}
function breed_rules($id, $Configuration_ID=""){
	global $link;
	if($Configuration_ID!=""){$Configuration_ID="AND Configuration_ID='$Configuration_ID'";}
	$result=mysql_query("select * from breed_rules where species_index='$id' $Configuration_ID ORDER BY id ASC", $link);
	if($result){
		$params=array();
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){			
			$compile=array();
			foreach($row as $key=>$value) { 
				$compile = array_merge($compile,array('	 "'.$key.'": "'.$value.'"'));
			}
			if(count($compile)){$params = array_merge($params,array('
      { 
'.implode(',
',$compile).'
      }'));}
		}
		if(count($params)){return implode(',',$params);}
	}
	return "
      ";
}
function action_rules($id){
	global $link;
	$result=mysql_query("select * from action_rules where species_index='$id' ORDER BY id ASC", $link);
	if($result){
		$params=array();
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){			
			$compile=array();
			foreach($row as $key=>$value) { 
				$compile = array_merge($compile,array('	 "'.$key.'": "'.$value.'"'));
			}
			if(count($compile)){$params = array_merge($params,array('
      { 
'.implode(',
',$compile).'
      }'));}
		}
		if(count($params)){return implode(',',$params);}
	}
	return "
      ";
}
	
	

?>