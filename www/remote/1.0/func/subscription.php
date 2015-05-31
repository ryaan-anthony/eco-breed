<?php

	get_json(array("user_only" => "true"));
	$my_stats = $json['eco']['user'][0];
	$subscription = (int)mysql_real_escape_string(urldecode($_GET['subscription']));
	$type = mysql_real_escape_string(urldecode($_GET['type']));
	$time_remaining=0;
	if($my_stats['host_plan']!="Basic"){
		$time_remaining = $my_stats['host_expire']-time();
		if($time_remaining<0){$time_remaining=0;}
		elseif($my_stats['host_plan']=="Premium" && $my_stats['host_plan']!=$type){$time_remaining=(int)($time_remaining*0.5);}
		elseif($my_stats['host_plan']=="Unlimited" && $my_stats['host_plan']!=$type){$time_remaining=(int)($time_remaining*2);}
	}
	$Type = "UNLIMITED";
	if($type=="Premium"){$type="1";$Type = "PREMIUM";}
	else{$type="2";}
	$time_remaining+=(2628000*$subscription);
	
	echo("Your ".$Type." plan will expire on ".date("l F d, Y",$time_remaining+time()));
	$result = mysql_query("UPDATE subscriptions SET sub_time='".($time_remaining+time())."', sub_type='$type' WHERE name='$username' ", $link);
	if(mysql_affected_rows()==0){		
		mysql_query("INSERT INTO subscriptions (sub_time,sub_type,name) VALUES ('".($time_remaining+time())."','$type','$username')", $link);
	}
	echo("(&)set");

?>