<?php
	
		//set values
		$breed_id = mysql_real_escape_string($_GET['anim_request']);
		$species_chan = mysql_real_escape_string($_GET['anim_channel']);
		$get_anims = mysql_real_escape_string($_GET['anim_string']);
		$cached = explode('||',$get_anims);
		if(!count($cached)){
			die("ignore empty");
		}
		
		//ignore previously cached : unless rebuilt
		if(!(int)$_GET['anim_rebuilt']){
			$result = mysql_query("select * from breed where breed_cached='$get_anims' AND breed_id='$breed_id'",$link);
			if($result && mysql_num_rows($result)){die("ignore not rebuilt");}
		}
		
		//get params
		$result = mysql_query("
		SELECT * 
		FROM anims as t1 
		WHERE FIND_IN_SET(anim_name,'".implode(',',$cached)."') 
		AND t1.anim_species 
		IN (select id from species where species_chan='$species_chan')
		",$link);
		if(!$result || !mysql_num_rows($result)){
			die("ignore ");
		}
		
		//format params
		$params=array();
		while($row = mysql_fetch_array($result)){
				$params=array_merge(
					$params,
					array(
						$row['anim_name']."#".
						"stages(".$row['anim_frames'].")".
						"repeat(".$row['anim_repeat'].")".
						"delay(".$row['anim_delay'].")".
						$row['anim_params']
					)
				);
		}
		$row=array();
		
		//filter empty params
		if(!count($params)){die("ignore params");}
		
		//update breed cache
		$result = mysql_query("UPDATE breed SET breed_cached='$get_anims' WHERE breed_id='$breed_id'", $link);	
		
		//filter unknown error		
		if(!$result){die("ignore result");}
		
		//return results
		return_results(compact_methods(implode("#",array_filter($params))));
		
?>