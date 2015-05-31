<?php

	//get info
	$id = mysql_real_escape_string($_GET['params_key']);
	$result=mysql_query("select * from cached_results where identifier='$id'", $link);
	if(mysql_num_rows($result)==0){die("!@#{D}");}
	$row=mysql_fetch_array($result);
	$params=$row['params'];
	$results="";
	
	//parse and display info
	if(strlen($params)>1000){
			$id  = cache_results(substr($params,1000),$id);
			$params = substr($params,0,1000);
			$results=$id."!@#".$params;
		}
	else{
			$results=$id."!@#".$params."{D}";
			mysql_query("DELETE FROM cached_results WHERE identifier='$id'",$link);
		}
	echo(str_replace("\\n","\n",$results));
	
	//display errors
//	if(!count(error_get_last()) && !strlen(mysql_error())){}
//	else{
//		if(strlen(mysql_error())){
//			echo("<b>Warning</b> ".mysql_error());
//		}
//		else{
//			$error = error_get_last();
//			echo("<b>Warning</b> ".$error['message']." line ".$error['line']." of ".$error['file']);
//		}
//	}
	

?>