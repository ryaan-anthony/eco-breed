<?php
/*	$start_time=microtime(true);
	$start_mem = memory_get_usage();
*/	
	include('../../content/data/common.php');
	$new_user = "An account has been created for you at http://eco.takecopy.com/?e=user here is your validation code: ";
	$encryption_key = "sdfoNnliuLsnl89NjknO8nuilb89BJBd";	
	function compact_methods($str){
		$orig = array('size(','pos(','rot(','sculpt(','texture(','color(','repeat(','delay(','type(','alpha(','shine(','glow(','stages(');
		$new = array(	 '0(',  '1(',  '2(',     '3(',      '4(',    '5(',     '6(',    '7(',   '8(',    '9(',   '10(',  '11(',    '12(');	
		return str_replace($orig,$new,$str);
	}	
	function cache_results($params,$identifier){
		global $link;
		if($identifier!=""){
			mysql_query("UPDATE cached_results SET params='$params' WHERE identifier='$identifier'", $link);
			return $identifier;
		}
		else{
			$identifier = createID();
			mysql_query("INSERT INTO cached_results (identifier,params) VALUES ('$identifier','$params')", $link);
			return $identifier;
		}
	}
	function return_results($str){
	global $request_type, $username,$link;
		if(strlen($str)>1000){
			$str = cache_results(substr($str,1000),"")."!@#".substr($str,0,1000);
		}
		else{
			$str="!@#".$str."{D}";
		}
		if(!count(error_get_last()) && !strlen(mysql_error())){echo(str_replace("\\n","\n",$str));}
		else{
			if(strlen(mysql_error())){
				echo("<b>Warning</b> ".mysql_error());
				mysql_query("insert into error_log (message) values ('"."<b>Warning</b> ".mysql_error()."')",$link);
				print mysql_error();
			}
			else{
				$error = error_get_last();
				echo("<b>Warning</b> ".$error['message']." line ".$error['line']." of ".$error['file']);
				mysql_query("insert into error_log (message,type,user) values ('"."<b>Warning</b> ".$error['message']." line ".$error['line']." of ".$error['file']."','$request_type','$username')",$link);
				print mysql_error();
			}
		}
	}	
	$request_type = "unknown";
	$request = array(
		"values",//breed input
		"mybreeds",//rebuild list
		"authorize",//authorize action|breed
		"rebuild_request",//rebuild command
		"params_key",//cached results
		"anim_request",//anim
		"skin_type",//skin
		"setauth",//eco-package 1.0 proof of purchase
		"subscription"//hosting upgrade handler
	);
	for($i=0; $i<count($request); $i++){
		$request_type = $request[$i];
		if(isset($_GET["$request_type"])){include("func/$request_type.php");break;}
	}
	
	
//	//authorize action|breed
//	if(isset($_GET['authorize'])){$request_type = "authorize";include('func/authorize.php');}
//	//eco-package 1.0 proof of purchase
//	elseif(isset($_GET['setauth'])){$request_type = "setauth";include('func/setauth.php');}
//	//rebuild command
//	elseif(isset($_GET['rebuild_request'])){$request_type = "rebuild_request";include('func/rebuild_request.php');}
//	//cached results
//	elseif(isset($_GET['params_key'])){$request_type = "params_key";include('func/params_key.php');}	
//	//hosting upgrade handler
//	elseif(isset($_GET['subscription'])){$request_type = "subscription";include('func/subscription.php');}	
//	//rebuild list
//	elseif(isset($_GET['mybreeds'])){$request_type = "mybreeds";include('func/mybreeds.php');}	
//	//breed input
//	elseif(isset($_GET['values'])){$request_type = "values";include('func/values.php');}
//	//anim
//	elseif(isset($_GET['anim_request'])){$request_type = "anim_request";include('func/anim_request.php');}
//	//skin
//	elseif(isset($_GET['skin_type'])){$request_type = "skin_type";include('func/skin_type.php');}	

	/*$time = microtime(true)-$start_time;
	$peak = memory_get_peak_usage();
	$mem = memory_get_usage()-$start_mem;
	mysql_query("insert into api_execution (exec_time) values ('$peak : $time : $mem : $request_type : $username')",$link);
	*/
?>