<?php	
	
	$data = explode( ":#%", mysql_real_escape_string( $_GET['mybreeds'] ) );
	$config = explode("-",$data[0]);
	$owner = $data[1];
	$limit = $data[2];
	$data = array();	
	$result =	mysql_query("
		SELECT
			t1.id,
			t1.breed_name,
			t1.breed_id,
			t3.id as rebuild,
			t3.breed_id as rebuild_id
		FROM
			breed as t1
		LEFT JOIN action_rules t2
		ON t2.Configuration_ID='".$config[1]."'
		LEFT JOIN rebuild t3
		ON t3.breed_chan=t1.breed_chan
		AND t3.owner_name=t1.owner_name
		WHERE t1.breed_chan='".$config[0]."'
		AND t1.owner_name='$owner'
		AND (
				(t2.Status='0' AND t1.breed_update>='".(time()-$Limitations["Response_Timeout"])."' )
			OR 
				(t2.Status='1' AND t1.breed_update<'".(time()-$Limitations["Response_Timeout"])."' )
			OR 
				(t2.Status>1)
			)
		AND (
				(t2.Dead_Breeds='0' AND t1.breed_notdead='1')
			OR 
				(t2.Dead_Breeds='2' AND t1.breed_notdead='0')
			OR 
				(t2.Dead_Breeds!='0' AND t2.Dead_Breeds!='2')
			)
		ORDER BY t1.id ASC
		LIMIT $limit			 
		",$link);
	if(!$result || !mysql_num_rows($result)){
		die(
			"(&)".//mysql_error().
			$Limitations['Response_Timeout'].
			"{D}"
		);
	}
	$breeds = array();
	$rebuild_queue = "";
	$inject_refresh = "";//-refresh";//placeholder for '-refresh' injection
	while($row=mysql_fetch_array($result)){
		if(isset($row['rebuild'])&&empty($rebuild_queue)){
			$rebuild_queue = "(&)".$row['rebuild_id'];
			mysql_query("DELETE FROM rebuild WHERE id='".$row['rebuild']."'",$link);
		}
		$breeds = array_merge(
			$breeds, 
			array(
				substr($row['breed_name'],0,20).
				"|".
				$row['breed_id']
			)
		);
	}	
	$row=array();
	return_results(
		implode(":#:",$breeds).
		"(&)".$Limitations['Response_Timeout'].
		"++".$inject_refresh.
		$rebuild_queue
	);
		
?>