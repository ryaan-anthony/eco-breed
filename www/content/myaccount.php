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
unset($_COOKIE[$cookie_location]);
setcookie($cookie_location, NULL,-1);
setcookie($cookie_location, "end",-1,'/');
print "Redirecting.. <script>function reload(){window.location.href='http://eco.takecopy.com/?e=user';} setTimeout('reload()',2500);</script>";
	
	
	
	
	
//if(!isset($_COOKIE[$cookie_location])||$_COOKIE[$cookie_location]=="end"){
//print "<div align='center'><img src='img/eco-pack.png' style='height:130px;margin-right:10px;'/><img id='eco-breed-object' src='img/eco-big0.png' style='margin-left:10px;height:130px;'/></div>";
//print "<div style='width:380px;margin-left:auto;margin-right:auto; margin-top:10px;'>";
//print "<p>You must login with your <a href='http://takecopy.com' target='_blank' style='font-size:1.0em;'>Takecopy Account</a> to continue.</p>";
//print "<p><input placeholder='Second Life Name' style='padding:3px;width:360px;font-size:1.2em;' id='eco_name'/></p>";
//print "<p><input placeholder='Takecopy Password' style='padding:3px;width:360px;font-size:1.2em;' id='eco_pw' type='password'/></p>";
//print "<p><button style='padding:3px 10px;float:right;font-size:1.2em;margin-right:10px' id='eco_login'>Login</button></p>";
//print "<div id='eco_error' style='color:orangered;'></div>";
//print "</div>";
//}
?>