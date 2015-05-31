<?php
	
	$send_globals="";
	$debug_this="";
	$object_key = 	explode("-",urldecode($_GET['config']));
	$species_id = 	trim($object_key[0]);
	$config = 		trim($object_key[1]);		
	list(
	$species_chan,
	$breed_creator,
	$breed_uuid,
	$last_update,
	$curr_pos,
	$curr_region,
	$MyGeneration,
	$breed_skins,
	$MyParents,
	$MyGender,
	$breed_id,
	$breed_name,
	$owner_id,
	$notDead,
	$Timer_Age,
	$Timer_Breed,
	$Timer_Grow,
	$Timer_Hunger,
	$MyAge,
	$MyLitters,
	$MyHunger,
	$breed_owner,
	$saved_anims,
	$total_growth,
	$Growth_Stages,
	$prim_status,
	$version,
	$timeofBirth,
	$timeofDeath,
	$null,
	$MyPartner,
	$UpdateKey,
	$globals
	) = explode(":#%",trim(str_replace(array("'",'"','\\','  '),array('','','',' '),mysql_real_escape_string($_GET['values']))));
	function getLineage($find, $index, $who){
		global $link;
		$index-=1;
		$parent = explode("|",$who[$index]);
		$result=mysql_query("select * from breed where breed_id='".$parent[0]."'", $link);
		if(!$result){return "";}
		if(mysql_num_rows($result)==0){return "";}
		$row=mysql_fetch_array($result);
		$globals = explode(";",$row['breed_globals']);
		if(count($globals)==0){return "";}
		$return_globals = array();
		for($i=0;$i<count($globals);$i+=2){
			if(array_search($globals[$i],$find)!==false && isset($globals[$i],$globals[$i+1])){
				$return_globals=array_merge($return_globals,array($globals[$i],$globals[$i+1]));
			}
		}
		return implode(",",$return_globals);
	}

	//unknown error x
	if($species_id!=$species_chan){
		die("die");
	}
	$result = mysql_query("select species_name from species where species_chan='".mysql_real_escape_string($species_chan)."'",$link);
	if(!$result){
		die("die");
	}
	$row=mysql_fetch_array($result);
	$species_name = $row['species_name'];
	
	//get subscription
	$host_plan = "Basic";
	$result = mysql_query("select * from subscriptions where name='$breed_creator'",$link);
	if($result && mysql_num_rows($result)){
		$row=mysql_fetch_array($result);
		if($row['sub_type']=="1"){$host_plan="Premium";}
		elseif($row['sub_type']=="2"){$host_plan="Unlimited";}
	}
	
	//UPDATE existing breed w/ placeholder for globals injection
	$result = mysql_query("select breed_name,breed_skins,debug_this,web_update,breed_key from breed where breed_id='$breed_id'",$link);
	if($result && mysql_num_rows($result)){
		$row = mysql_fetch_array($result);
		//queue deletion if uuids dont match x
		if($row['breed_key']!=$breed_uuid && $UpdateKey!="1"){die("die");}//duplicate
		$breed_skins = $row['breed_skins'];
		$debug_this = $row['debug_this'];
		//update breed name
		if((int)$row['web_update']){
			mysql_query("UPDATE breed SET web_update='0' WHERE breed_id='$breed_id'", $link);
			$breed_name = $row['breed_name'];	
		}
		else{
			if($breed_name==""){$breed_name="None";}
			$breed_name = $breed_name;
		}
		mysql_query("UPDATE breed SET
	breed_key='$breed_uuid',
	breed_name='$breed_name',
	breed_update='$last_update', 
	breed_pos='$curr_pos', 
	breed_region='$curr_region', 
	breed_notdead='$notDead', 
	timer_age='$Timer_Age', 
	timer_breed='$Timer_Breed', 
	timer_grow='$Timer_Grow', 
	timer_hunger='$Timer_Hunger', 
	breed_age='$MyAge', 
	breed_litters='$MyLitters', 
	breed_hunger='$MyHunger', 
	owner_name='$breed_owner', 
	owner_id='$owner_id', 
	breed_anims='$saved_anims', 
	breed_growth_total='$total_growth', 
	growth_stages='$Growth_Stages', 
	breed_physics='$prim_status', 
	breed_version='$version', 
	breed_dead='$timeofDeath',
	breed_globals='$globals',
	breed_partner='$MyPartner'
	WHERE breed_id='$breed_id'", $link);
		$send_globals="";	
	}
	
	//INSERT new breed
	else{
		//max limit
		$max_allowed = $Limitations[$host_plan]['breeds'];
		$result = mysql_query("select count(*) as breed_count from breed where breed_creator='$breed_creator'",$link);
		if($result && mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			if((int)$row['breed_count']>=$max_allowed&&$max_allowed!=-1){
				$result = mysql_query("select * from accounts where name='$breed_creator'",$link);
				$row=mysql_fetch_array($result);
				die("!@#".$row['uuid'].":%:error: User $breed_creator has exceeded their storage limits. Breed values will not be saved for ".$breed_name.".{D}");	
			}
		}
		
		//lineage globals
		$result = mysql_query("select * from breed_rules where Configuration_ID='$config'",$link);
		$rules=mysql_fetch_array($result);
		$Lineage_Selection = (int)$rules['Lineage_Selection'];
		if($Lineage_Selection==3){
			if($MyGender==$rules['Gender_Male']){$Lineage_Selection=2;}
			else{$Lineage_Selection=1;}
		}
		if($Lineage_Selection==0){
			$Lineage_Selection=rand(1,2);
		}
		if($MyParents=="None"){
			$Lineage_Selection=-1;
		}
		$Lineage_Globals = explode(",",$rules['Lineage_Globals']);
		
		//insert 
		mysql_query("INSERT INTO breed (
	owner_name,
	owner_id,
	breed_id,
	breed_name,
	breed_gender,
	breed_born,
	breed_dead,
	breed_age,
	breed_species,
	breed_skins,
	breed_hunger,
	breed_parents,
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
	'$owner_id',
	'$breed_id',
	'$breed_name',
	'$MyGender',
	'$timeofBirth',
	'$timeofDeath',
	'$MyAge',
	'$species_name',
	'$breed_skins',
	'$MyHunger',
	'$MyParents',
	'$MyGeneration',
	'$Timer_Breed',
	'$Timer_Age',
	'$Timer_Grow',
	'$Timer_Hunger',
	'$breed_uuid',
	'$last_update',
	'$species_id',
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
		if($Lineage_Selection!=-1){
			$send_globals=getLineage($Lineage_Globals,$Lineage_Selection,explode("&&",$MyParents));
		}	
	}
	
	$send_methods="";//placeholder for methodstring injection
	
	return_results(
		implode(':%:',
			array(
				$breed_name,
				$species_name,
				$breed_skins,
				$Limitations[$host_plan]['timeout'],
				$send_globals,
				$send_methods,
				$debug_this,
				""	//placeholder for injecting obj_desc master commands
			)
		)
	);
	
	
?>