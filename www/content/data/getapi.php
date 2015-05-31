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
function decrypt($str){
global $encryption_key;
  $str = base64_decode($str);
  $result = '';
  for($i=0; $i<strlen($str); $i++) {
    $char = substr($str, $i, 1);
    $keychar = substr($encryption_key, ($i % strlen($encryption_key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
return $result;
}
$params = unserialize(decrypt($_COOKIE[$cookie_location]));
$username=$params['name'];

function createAPI(){
return mixcase(md5(uniqid(mt_rand(), true)));
}
function Random(){
return (int)rand(0,1);	
}
function mixcase($str){
$temp="";
for($i; $i<strlen($str); $i++){
if(Random()==1){$temp.=strtoupper($str[$i]);}	  
else{$temp.=strtolower($str[$i]);}
}
return $temp;
}

//open link
$link = mysql_connect("localhost","takecopy", "devTR1420");
if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}


//check if already exists
$result=mysql_query("select * from api_dev where name='$username'", $link);
if($result && mysql_num_rows($result)){
	$row=mysql_fetch_array($result);
	die("<p><strong>Your API key:</strong><input readonly class='disabled-input wide-input' value='".$row['api_key']."'/></p>");
}

//create key
$api_key=createAPI();
if(!mysql_query("INSERT INTO api_dev (api_key, name) VALUES ('$api_key','$username')", $link)){die(mysql_error());}
print "<p><strong>Your API key:</strong><input readonly class='disabled-inputwide-input' value='$api_key'/></p>";
?>