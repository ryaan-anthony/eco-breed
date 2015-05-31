<script>
account_redirect = "user-1.0.php";
account_modify_redirect = "editval-1.0.php";
account_breed_div = "-breed";
account_species_div = "-species";
</script>
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
if(!isset($_COOKIE[$cookie_location])||$_COOKIE[$cookie_location]=="end"){
	print "<div id='login-form' style='width:500px;margin-left:auto;margin-right:auto; margin-top:50px;'>
	<div align='center'>
		<h1 style='font-family: monospace;cursor:default;font-size: 1.7em;'><strong style='font-size: 1.5em;'>eco project</strong> | dev khaos</h1>
	</div>
	<p align='center' style='font-family: monospace;font-weight: bold;color: #666;'>Enter your avatar name to <span class='sub-up' style='color: orangeRed;'>login</span> or <span class='sub-up' style='color: orangeRed;'>sign up</span>.</p>
	<div align='center'><input placeholder='Second Life Name' class='wide-input login-input' id='eco-name'/></div>
	<div style='width:450px;'><button style='font-family: monospace;padding:3px 10px;float:right;font-size:1.2em;margin-top:10px' id='eco-enter'>Enter</button></div>
	<div id='eco-error' style='color:orangered;font-size:0.9em;margin-left: 60px;'></div>
</div>";
}
?>