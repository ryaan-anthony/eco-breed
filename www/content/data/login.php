<?php

function get_ip_address() {foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }}
$cookie_location = str_replace(".","_",get_ip_address())."_takecopy_login";
$encryption_key = "sdfoNnliuLsnl89NjknO8nuilb89BJBd";

function encrypt($str){
global $encryption_key;
  for($i=0; $i<strlen($str); $i++) {
     $char = substr($str, $i, 1);
     $keychar = substr($encryption_key, ($i % strlen($encryption_key))-1, 1);
     $char = chr(ord($char)+ord($keychar));
     $result.=$char;
  }
  return base64_encode($result);
}

//function http_post($url, $fields){
//	$ch = curl_init($url);
//	curl_setopt($ch, CURLOPT_POST, 1);
//	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//	//curl_setopt($ch, CURLOPT_HEADER, 0);
//	curl_setopt($ch, CURLOPT_COOKIEJAR, '/');
//	$res = curl_exec($ch);
//	curl_close($ch);
//	return $res;
//}

function Name2Password($name){
$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
if(!mysql_select_db("takecopy_vendors",$link)){die(mysql_error());}
	$result=mysql_query("select * from user where name='$name'", $link);
	if($result){
		$row=mysql_fetch_array($result);
		mysql_free_result($result);
		return $row['password'];
	}
	return "(Error: #2542369) NOT A VALID LOGIN IDENTIFICATION PASSWORD!!!";
}

function login($username, $password){
	if($password==Name2Password($username)){return TRUE;}
	return FALSE;
}

$username = strtolower(stripslashes(urldecode($_GET['name'])));
$name_seg=explode(' ',$username);
if(empty($name_seg[1])){$username=$username." resident";}
$password = stripslashes(urldecode($_GET['pw']));
if(login($username, $password)){
setcookie($cookie_location, encrypt(serialize(array('name'=>$username,'pw'=>$password))),time()+31536000,'/','');//
print "true";
}
?>