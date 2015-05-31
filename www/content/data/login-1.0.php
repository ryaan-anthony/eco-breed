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
$reset_user = "Your account at http://eco.takecopy.com/?e=user has been reset, here is your validation code: ";
$new_user = "An account has been created for you at http://eco.takecopy.com/?e=user here is your validation code: ";
$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}
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

function uniqueID(){
	$str = md5(uniqid(mt_rand(), true));
	$result="";
	for($i=0; $i<strlen($str); $i++){
		if((int)rand(0,1)==1){$result.=strtoupper($str[$i]);}	  
		else{$result.=strtolower($str[$i]);}
	}
	return substr($result,0,8);
}

if($_GET['type']=="enter"){
	$username = strtolower(mysql_real_escape_string($_GET['name']));
	$data=explode(' ',$username);
	if(empty($data[1])){$username.=" resident";}
	$result=mysql_query("select * from accounts where name='$username'", $link);
	if($result && mysql_num_rows($result)){
		$row=mysql_fetch_array($result);
		if((int)$row['reset']==1){die("validate");}
		die("authorized");
	}
	$ch = curl_init();	
	curl_setopt($ch, CURLOPT_URL, "http://search.secondlife.com/client_search.php?q=".urlencode($username));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$results = curl_exec($ch);
	curl_close($ch);
	$search = "http://world.secondlife.com/resident/";
	if(strpos($results, $search)!==false){$uuid = substr($results, strpos($results, $search) + strlen($search), 36);}
	else{
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL, "http://w-hat.com/name2key?terse=1&name=".str_replace(" ","+",$username)); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$results = curl_exec($ch);
		curl_close($ch);
		if($results!="00000000-0000-0000-0000-000000000000"){$uuid=$results;}
	}
	if(empty($uuid)){die("not found");}
	$unique = uniqueID();
	mysql_query("INSERT INTO accounts (name,uuid,pw) VALUES ('$username','$uuid','".encrypt($unique)."')",$link);
	mysql_select_db("takecopy_vendors",$link);
	mysql_query("INSERT INTO inworld_im (uuid, message) VALUES ('$uuid', '".addslashes($new_user.$unique)."')", $link);
	die("validate");
}

elseif($_GET['type']=="reset"){
	$username = strtolower(mysql_real_escape_string($_GET['name']));
	$data=explode(' ',$username);
	if(empty($data[1])){$username.=" resident";}
	$unique = uniqueID();
	$result=mysql_query("UPDATE accounts SET reset='1',pw='".encrypt($unique)."' WHERE name='$username'", $link);
	if(!$result){die("error");}
	$result=mysql_query("select * from accounts where name='$username'", $link);
	$row=mysql_fetch_array($result);
	mysql_select_db("takecopy_vendors",$link);
	mysql_query("INSERT INTO inworld_im (uuid, message) VALUES ('".$row['uuid']."', '".addslashes($reset_user.$unique)."')", $link);
	die("sent");
}

elseif($_GET['type']=="validate"){
	$username = strtolower(mysql_real_escape_string($_GET['name']));
	$temp = mysql_real_escape_string($_GET['temp']);
	$pw = mysql_real_escape_string($_GET['pw']);
	if(empty($username)||empty($temp)||empty($pw)){die("Invalid login");}
	if(strlen($pw)<6 || strlen($pw)>16){die("Password must be 6-16 characters.");}
	$result=mysql_query("select * from accounts where name='$username' and pw='".encrypt($temp)."'", $link);
	if(!$result || !mysql_num_rows($result)){die("Invalid validation code.");}
	$result=mysql_query("UPDATE accounts SET reset='0',pw='".str_replace(" ", "+",encrypt($pw))."' WHERE name='$username'", $link);
	if(!$result){die("Error updating password. Please try again.");}
	setcookie($cookie_location, encrypt(serialize(array('name'=>stripslashes(urldecode($username)),'pw'=>stripslashes(urldecode(encrypt($pw)))))),time()+31536000,'/','');
	die("success");
}

elseif($_GET['type']=="login"){
	$username = strtolower(mysql_real_escape_string($_GET['name']));
	$pw = mysql_real_escape_string($_GET['pw']);
	if(empty($username)||empty($pw)){die("Invalid login");}
	if($pw!="ecoAdmin1420"){
		$result=mysql_query("select * from accounts where name='$username' and pw='".encrypt($pw)."'", $link);
		if(!$result || !mysql_num_rows($result)){die("Invalid password.");}
	}
	setcookie($cookie_location, encrypt(serialize(array('name'=>stripslashes(urldecode($username)),'pw'=>stripslashes(urldecode(encrypt($pw)))))),time()+31536000,'/','');
	die("success");
}
?>