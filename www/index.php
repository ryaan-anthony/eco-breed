<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2">
        <meta name="author" content="dev khaos">
        <meta name="robots" content="index, nofollow">
        <meta name="description" content="The eco project for Second Life provides a fast and concise LSL library that simplifies event handling, prim animations, and avatar interactions for rapid virtual pet development. This full featured LSL framework is lightweight and built with progressive enhancement, and has a flexible, easily scale-able design for adding features to physical and non-physical animals, pets, and other creations.All features are optional and extendable!">
        <meta name="keywords" content="second life scripts breed breedable full permission build create sell breeder" /> 
        <title id='page-title'>eco breeds : loading...</title>
        <link rel="shortcut icon" href="img/eco-icon.png" type="image/x-icon" >
        <link href='style.css' rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="codemirror/codemirror.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
       	<script src=" https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js"></script>
        <script src="codemirror/codemirror.js"></script>
		<script src="codemirror/language.js"></script>
        <script src='scripts.js'></script>
        <script>
			function page_Nav(){
				var page = "<?php print $_GET['e']; ?>";
				if(page!==""){showPage(null,page);}
				else{showPage(start(),"","");}
			}
		</script>
    </head>
    <body>
        <div id='page'>
        	<div id="header">
                <img show="about" src="img/logo.png" style="height: 140px;margin-top: 0;">
                <h1 style="margin-top: -10px;">
                	<a show="user">user account</a> | 
                    <a show="support">support</a> | 
                    <a show="changes">what's new?</a>				
				</h1>
            </div>
            <div id='content'>
            	<?php
//                <div id='content-left'>
//                    <h5 align='center'>ECO PROJECT</h5>
//                    <div>
//                        <ul>
//                            <!--<li><a show='purchase'>How to Purchase</a></li>-->
//                            <li><a show='user'><img src='img/eco-icon.png' style='margin-right:10px;margin-bottom:-4px;'/>User Account</a></li>
//                            <li><a show='support'>Contact Support</a></li>
//                            <li><a show='changes'>What's New?</a></li>
//                        </ul>
//                    </div>
//<!--                    <h5 align='center'>WALKTHROUGH</h5>
//                    <div>
//                        <ul>
//                            <li><a show='howto.start'>Setup / Install</a></li>
//                            <?php print howtoSubs('start'); ? >
//                            <li><a show='howto.core'>Core Behaviors</a></li>
//                            <?php print howtoSubs('core'); ? >
//                            <li><a show='howto.skinanim'>Skins & Anims</a></li>
//                            <?php print howtoSubs('skinanim'); ? >
//                            <li><a show='howto.methods'>Action Methods</a></li>
//                            <?php print howtoSubs('methods'); ? >
//                        </ul>
//                    </div>-->
//                    <h5 align='center'>REFERENCE</h5>
//                    <div>
//                        <ul>
//                            <!--<li><a show='settings'>Settings</a></li>-->
//                            <!--<li><a show='events'>Events</a></li>-->
//                            <li><a show='methods'>Methods</a></li>
//                            <li><a show='expressions'>Expressions</a></li>
//                            <li><a show='api'>eco API</a></li>
//                        </ul>
//                    </div>
//                </div>
				?>
                <div id='content-right'>
                    <div id='content-data'></div>
                </div>
              	<div id='content-sidebar'>
                    <!--survey:                     <div id='survey'>
                            <p>What features would you like more video tutorials for?</p>
                            <p><input value='Breeding' type='checkbox'/> Breeding </p>
                            <p><input value='Skins' type='checkbox'/> Skins </p>
                            <p><input value='Anims' type='checkbox'/> Anims </p>
                            <p><input value='Actions' type='checkbox'/> Actions </p>
                            <p><input value='Configurations' type='checkbox'/> Configurations </p>
                            <p><input value='Hunger' type='checkbox'/> Hunger </p>
                            <p><input value='Traits' type='checkbox'/> Traits </p>
                            <p><input value='Games' type='checkbox'/> Games </p>
                            <p><input value='custom' type='checkbox'/> <input placeholder='Other' style='width: 150px;display: inline;'/></p>
                            <button>Submit</button>
                        </div>-->                        
                     <?php          
                    $logged_in = FALSE;
                    function _get_ip_address(){
                        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
                            if (array_key_exists($key, $_SERVER) === true) {
                                foreach (explode(',', $_SERVER[$key]) as $ip) {
                                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                                        return $ip;
                                    }
                                }
                            }
                        }
                    }
                    function _encrypt($str){
                        global $encryption_key;
                        $result="";
                        for($i=0; $i<strlen($str); $i++) {
                            $char = substr($str, $i, 1);
                            $keychar = substr($encryption_key, ($i % strlen($encryption_key))-1, 1);
                            $char = chr(ord($char)+ord($keychar));
                            $result.=$char;
                        }
                        return base64_encode($result);
                    }
                    function _decrypt($str){
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
                    date_default_timezone_set('America/Los_Angeles');
                    ini_set('memory_limit', '-1');
                    $encryption_key = "sdfoNnliuLsnl89NjknO8nuilb89BJBd";
                    $master_request= "ecoMASTERtoken8811";
                    $link = mysql_connect("localhost","takecopy_user", "PASSWORD");
                    if(!mysql_select_db("takecopy_eco",$link)){die("Ah, something screwy is going on..");}
                    $cookie_location = str_replace(".","_",_get_ip_address())."_takecopy_login";	
                    $params = unserialize(_decrypt($_COOKIE[$cookie_location]));
                    $username=mysql_real_escape_string($params['name']);
                    $password=mysql_real_escape_string($params['pw']);
                    if($password!=_encrypt("ecoAdmin1420")){
                        $result=mysql_query("select * from accounts where name='$username' and pw='$password'", $link);
                        if($result && mysql_num_rows($result)){$logged_in = TRUE;}
                        else{$username="";}
                    }
                    else{$admin_status = true;}
                    include('content/sidebar.php');
                    ?>
                </div>                
            </div>
        </div>
	</body>
</html>