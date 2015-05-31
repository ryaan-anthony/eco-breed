<?php

$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
if(!mysql_select_db("takecopy_vendors",$link)){die(mysql_error());}

function Send_Inworld_IM($id, $str){
global $link;
$str=addslashes($str);
if(!empty($str)&&!empty($id)){
	if(!mysql_query("INSERT INTO inworld_im (uuid, message) VALUES ('$id', '$str')", $link)){die(mysql_error());} 
	$user_id = mysql_insert_id($link);
}
}

function Username2SFid($name){
global $link;
$result=mysql_query("select * from user where name='$name'", $link);
$row=mysql_fetch_array($result);
mysql_free_result($result);
return $row['sfid'];
}

function Create_New_Account($name,$uuid){
global $link;
if($name==""){return;}
if(User_Exists($name)){return Username2SFid($name);}
$name = addslashes($name);
$uuid = addslashes($uuid);
$date = addslashes(time());
$sfid = SFid();
$query = "INSERT INTO user (name, uuid, dateadded, sfid) 
 VALUES ('$name', '$uuid', '$date', '$sfid')";
if(!mysql_query($query, $link)){die(mysql_error());} 
$user_id = mysql_insert_id($link);
return $sfid;
} 

function Set_Account($name,$uuid){
Send_Inworld_IM($uuid,"An account has been created for you at http://takecopy.com/?validate=".Create_New_Account($name,$uuid)."\nClick the link to create a password and activate your account!");
}

function mix_case($str){
$temp="";
for($i; $i<strlen($str); $i++){
if((int)rand(0,1)==1){$temp.=strtoupper($str[$i]);}	  
else{$temp.=strtolower($str[$i]);}
}
return $temp;
}

function SFid(){
return mix_case(md5(uniqid(mt_rand(), true)));
}

function User_Exists($curr_user){
global $link;
$result = mysql_fetch_array(mysql_query("SELECT name FROM user WHERE name='$curr_user'",$link));
if($result){return true;}
return false;
}

?>