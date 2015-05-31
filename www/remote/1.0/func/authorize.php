<?php
		
		$unauthorized = true;
		$object_key = explode("-",urldecode($_GET['config']));
		$species = $object_key[0];
		$config = $object_key[1];
		$authorize = urldecode($_GET['authorize']);
		get_json(array("species" => $species,"authorized" => "all",$authorize."_rules" => "all"));
		$my_stats = $json['eco']['user'][0];
		$my_species = $json['eco']['species'][0];
		$version = urldecode($_GET['version']);
		$creator = $my_species['species_creator'];
		$authorized_users = $my_species['authorized_users'];
		$rulesets = $my_species[$authorize."_rules"];
		if(!count($rulesets) || $species != $my_species['species_number']){
			die("Invalid species. You may need to refresh your species ID.");
		}
		if($username!=$creator){
			$unauthorized = true;
			for($i=0;$i<count($authorized_users);$i++){
				if($username==$authorized_users[$i]['user_name']){$unauthorized = false;}
			}
		}
		else{
			$unauthorized = false;
		}
		if($unauthorized){
			die("You are not authorized to modify this object.");
		}
		$rules = array();
		for($i=0;$i<count($rulesets);$i++){
			if($config == $rulesets[$i]['Configuration_ID']){
				$rules = $rulesets[$i];
				break;
			}
		}
		if(!count($rules)){
			die("Invalid configuration.");
		}
		$time = $Limitations[$my_stats['host_plan']]['timeout'];
		if($authorize == "breed"){
			return_results(implode('+;&',array(
		$species,
		$rules['Activation_Param'],
		$rules['Sit_Pos'],
		$rules['Sit_Rot'],
		$rules['Sound_Volume'],
		$rules['Move_Timer'],
		$rules['Speed_walk'],
		$rules['Speed_run'],
		$rules['Speed_jump'],
		$rules['Speed_swim'],
		$rules['Speed_hop'],
		$rules['Speed_hover'],
		$rules['Speed_fly'],
		$rules['Speed_float'],
		$rules['Water_Timeout'],
		$rules['Text_Color'],
		$rules['Speed_setpos'],
		$rules['Move_Attempts'],
		$rules['Lifespan'],
		$rules['Age_Min'],
		$rules['Age_Max'],
		$rules['Survival_Odds'],
		$rules['Growth_Stages'],
		$rules['Growth_Scale'],
		$rules['Growth_Timescale'],
		$rules['Growth_Odds'],
		$rules['Hunger_Timescale'],
		$rules['Hunger_Odds'],
		$rules['Hunger_Min'],
		$rules['Hunger_Max'],
		$rules['Starvation_Odds'],
		$rules['Hunger_Start'],
		$rules['Hunger_Lost'],
		$rules['Starvation_Threshold'],
		$rules['Breed_Time'],
		$rules['Breed_Failed_Odds'],
		$rules['Litter_Min'],
		$rules['Litter_Max'],
		$rules['Litter_Rare'],
		$rules['Genders'],
		$rules['Gender_Ratio'],
		$rules['Require_Partners'],
		$rules['Unique_Partner'],
		$rules['Skins'],
		$rules['Skins_Min'],
		$rules['Skins_Max'],
		$rules['Year'],
		$rules['Age_Start'],
		$rules['Litters'],
		$rules['Breed_Age_Min'],
		$rules['Breed_Age_Max'],
		0,
		$rules['Keep_Partners'],
		$rules['Name_Generator'],
		$rules['Gender_Specific'],
		$rules['Name_Object'],
		$rules['Prefix'],
		$rules['Middle'],
		$rules['Male_Suffix'],
		$rules['Female_Suffix'],
		$creator,
		1,//$rules['Save_Records'],
		$rules['Undefined_Value'],
		$rules['Slope_Offset'],
		$rules['Select_Generation'],
		$rules['Preserve_Lineage'],
		$rules['Self_Destruct'],
		$rules['Speed_nonphys'],
		$rules['Speed_nonphysUp'],
		$rules['Target_Dist_Min'],
		$rules['Finish_Move'],
		$rules['Partner_Timeout'],
		$rules['Pregnancy_Timeout'],
		$rules['Loading_Text'],
		$rules['Limit_Requests'],
		$rules['Sync_Timeout'],
		$rules['Allow_Drift'],
		$rules['Turning_Speed'],
		$rules['Turning_Time'],
		$rules['Legacy_Prims'],
		$rules['Cam_Pos'],
		$rules['Cam_Look'],
		$rules['Retry_Timeout'],
		$rules['Allowed_Types'],
		$rules['Owner_Only'],
		$rules['Sit_Adjust'],
		$rules['Cam_Adjust'],
		str_replace(";",",",$rules['Globals']),
		$rules['Gender_Male'],
		$rules['Gender_Female'],
		$rules['Gender_Unisex'],
		$rules['Text_Prim'],
		$rules['Text_Alpha'],
		"",
		"",
		$rules['Gravity_walk'],
		$rules['Gravity_run'],
		$rules['Gravity_jump'],
		$rules['Gravity_hop'],
		$rules['Gravity_swim'],
		$rules['Gravity_float'],
		$rules['Gravity_hover'],
		$rules['Gravity_fly'],
		$rules['Ground_Friction'],
		$rules['Prim_Material'],
		$rules['Preferred_Skins'],
		$rules['Pause_Anims'],
		$rules['Pause_Move'],
		$rules['Pause_Core'],
		$rules['Pause_Action'],
		$rules['Anim_Each_Move'],
		$rules['End_Move_Physics'],
		$rules['Allow_Throttling'],
		$time,
		"",//url
		$rules['Growth_Offset']
		)));
		}
		else{
			$events=array();
			$replace=array();
			if((float)$version>=2){
				$events = array(
"toggle(",
"on(",
"off(",
"die(",
"rfilter(",
"filter(",
"give(",
"pause(",
"anim(",
"shout(",
"message(",
"sethome(",
"whisper(",
"ownersay(",
"say(",
"unset(",
"set(",
"uncache(",
"cache(",
"attach(",
"revive(",
"unbind(",
"bind(",
"menu(",
"textbox(",
"text(",
"sound(",
"prop(",
"val(",
"rez(",
"move(");
				$replace=array(
				"0(",//toggle
				"1(",//on
				"2(",//off
				"3(",//die
				"6(",//rfilter
				"5(",//filter
				"8(",//give
				"9(",//pause
				"10(",//anim
				"12(",//shout
				"13(",//message
				"14(",//sethome
				"15(",//whisper
				"16(",//ownersay
				"11(",//say
				"18(",//unset
				"17(",//set
				"19(",//uncache
				"4(",//cache
				"20(",//attach
				"21(",//revive
				"22(",//unbind
				"7(",//bind
				"23(",//menu
				"24(",//textbox
				"25(",//text
				"26(",//sound
				"27(",//prop
				"28(",//val
				"29(",//rez
				"30("//move
				);
				
				//for($i=0;$i<count($events);$i++){$replace = array_merge($replace,array($i."("));}
			}
			return_results(implode('+;&',array(
			$species,
			$rules['Radius'],
			$rules['Breed_Object'],
			$rules['Breed_One_Family'],
			$rules['Food_Level'],
			$rules['Food_Quality'],
			$rules['Limit_Rezzed'],
			$rules['Breed_Maxed_Die'],
			$rules['Food_Threshold'],
			"",
			$rules['Text_Color'],
			$rules['Text_String'],
			"",
			"",
			"",
			"",
			"",
			$rules['Allow_Rebuild'],
			"",
			$rules['Rebuild_Object'],
			$rules['Touch_Length'],
			$rules['Message'],
			$rules['Button_Next'],
			$rules['Button_Prev'],
			$rules['Confirm_Message'],
			$rules['Button_Confirm'],
			$rules['Button_Cancel'],
			"",
			$rules['Height'],
			$rules['Rot'],
			$rules['Breed_Limit'],
			$rules['Breed_Timeout'],
			$rules['Desc_Filter'],
			"",
			$rules['Action_Type'],
			$rules['Self_Destruct'],
			$rules['Owner_Only'],
			$creator,
			$rules['Touch_Events'],
			$rules['Rebuild_Max'],
			$rules['Status'],
			$rules['Dead_Breeds'],
			$rules['Pattern'],
			$rules['Offset'],
			$rules['Arc'],
			$rules['Show_Text'],
			$rules['Limit_Requests'],
			$rules['Reserve_Food'],
			"",
			$rules['Activation_Param'],
			$rules['Allow_Breeding'],
			$rules['Version'],
			"",//url
			$time,
			implode("/;",explode("/:",str_replace($events,$replace,$rules['Actions'])))
			)));		
		}
	
?>