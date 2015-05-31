<?php

	list(
		$breed_id,
		$breed_key,//update
		$owner_name,
		$breed_creator,
		$breed_version,//update
		$breed_pos,//update
		$breed_region,//update
		$breed_update,//update
		$breed_chan
	) = explode(":#%",mysql_real_escape_string($_GET['rebuild_request']));
	$result = mysql_query("
		SELECT 	
			t1.breed_name,
			t2.owner_name as partner_owner,"./* NEW */"
			t1.breed_gender,
			t1.breed_age,
			t1.breed_species,
			t1.breed_skins,
			t1.breed_hunger,
			t1.breed_parents,
			t2.breed_name as partner_name,"./* NEW */"
			t1.breed_generation,
			t1.timer_breed,
			t1.timer_age,
			t1.timer_grow,
			t1.timer_hunger,
			t1.breed_notdead,
			t1.breed_litters,
			t1.breed_anims,
			t1.breed_growth_total,
			t1.growth_stages,
			t1.breed_physics,
			t1.breed_born,
			t1.breed_dead,
			t1.breed_id,
			t1.breed_partner,
			t1.breed_globals,
			t1.breed_cached 
		FROM breed t1, breed t2
		WHERE t1.breed_id='$breed_id' 
		AND t1.owner_name='$owner_name' 
		AND t1.breed_creator='$breed_creator' 
		AND t1.breed_chan='$breed_chan'
		AND (t2.breed_id = t1.breed_partner or 1=1)
	",$link);
	if(!$result || !mysql_num_rows($result)){die();}
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	mysql_query("UPDATE breed SET
	breed_update='$breed_update', 
	breed_pos='$breed_pos', 
	breed_region='$breed_region', 		
	breed_version='$breed_version',
	breed_key='$breed_key'
	WHERE breed_id='$breed_id'", $link);
	echo( implode(":#%",$row) );

?>