<?php
///VALIDATE USER
function Send_Validation($user){
global $OK_Button, $link, $Validation_Failed, $Validation_Success;
$null_key = "00000000-0000-0000-0000-000000000000";
$name_seg=explode(' ',$user);
if(empty($name_seg[1])){$user=$user." resident";}
$escapename=urlencode($user);
$uuid="";
$searchurl = "http://secondlife.com/app/search/search?q=" . str_replace(" ", "+", $user);
$ch = curl_init();	
curl_setopt($ch, CURLOPT_URL, $searchurl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$site = curl_exec($ch);
curl_close($ch);
$search = "http://world.secondlife.com/resident/";
if (substr_count($site, $search) ==1){
	$keypos = strpos($site, $search) + strlen($search);
	$uuid = substr($site, $keypos, 36);
	if($uuid!=$null_key&&!empty($uuid)){$found_key=true;}
}
if(!$found_key){
	$url="http://w-hat.com/name2key?terse=1&name=$escapename";
	$h = fopen($url, "r");
	if($h){
		$uuid = fread($h, 100);
		fclose($h);
		if($uuid!=$null_key&&!empty($uuid)){$found_key=true;}
	}
}
if($OK_Button!=""){
	if(!$found_key){Show_Popup("Validation Failed",$Validation_Failed.$OK_Button,false);}
	else{Set_Account($user,$uuid);Show_Popup("Validation Link Sent In-World",$Validation_Success.$OK_Button,false);}
}
else{
	if(!$found_key){die("error: unable to validate user");}
	else{Set_Account($user,$uuid);die("error: user not validated. validation link sent to user ($user) in-world");}
}
}
?>