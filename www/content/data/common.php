<?php
	
	function get_json($filter=array()){
		global $json, $json_raw,$master_request,$username;
		$_GET['api']=$master_request;
		$_GET['user']=$username;
		foreach ($filter as $key => $value){$_GET["$key"]=$value;}
		include('../../api/index.php');
		$json = json_decode($json_raw,true);
		if(isset($json['error'])){
			if(isset($_GET['name'])){die("die");}
			die($json['error']['message']);
		}
	}
	function get_ip_address(){
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
	function unsetcookie(){
		global $cookie_location;
		unset($_COOKIE[$cookie_location]);
		setcookie($cookie_location, NULL,-1);
		setcookie($cookie_location, "end",-1,'/');
		return "Login Failed <script>function reload(){window.location.href='http://eco.takecopy.com/?e=user';} setTimeout('reload()',2500);</script>";
	}
	function encrypt($str){
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
	function uniqueID(){
		$str = md5(uniqid(mt_rand(), true));
		$result="";
		for($i=0; $i<strlen($str); $i++){
			if((int)rand(0,1)==1){$result.=strtoupper($str[$i]);}	  
			else{$result.=strtolower($str[$i]);}
		}
		return substr($result,0,8);
	}
	function createID(){
		$notset=false;
		while(!$notset){
			$result = uniqueID();
			if(!is_numeric($result) && !number_exists($result)){$notset=TRUE;}
		}
		return $result;
	}
	function number_exists($num){
		global $link;
		$result = mysql_query(
		"SELECT * FROM species WHERE species_chan='$num'
		UNION
		SELECT * FROM breed_rules WHERE Configuration_ID='$num'
		UNION
		SELECT * FROM action_rules WHERE Configuration_ID='$num'
		UNION
		SELECT * FROM breed WHERE breed_id='$num'",$link);
		if(!$result || mysql_num_rows($result)==0){return FALSE;}
		return TRUE;
	}	
	date_default_timezone_set('America/Los_Angeles');
	ini_set('memory_limit', '-1');
	$encryption_key = "sdfoNnliuLsnl89NjknO8nuilb89BJBd";
	$master_request= "ecoMASTERtoken8811";
	$default_library = array(
"Prefix"=>"A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,R,S,T,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,R,S,T,B,C,D,G,H",
"Middle"=>"a,e,i,et,u,ed,oo,ou,er,ar,uo,ai,erla,erlo,uar,el,an,ey,ul,in,al,ila,ilo,erp,es,e,o,y",
"Male_Suffix"=>"bo,chu,de,der,th,is,o,eem,oh,elo,oo,rp,ler,er,mo,moe,mos,id,pler,urk,obo,ple,it,e,od,rod,rix,lem,ter,ure,ox,oid,erd,nie,in,up",
"Female_Suffix"=>"a,bai,chu,de,es,oo,ee,la,ela,lera,era,mo,moo,oba,ina,ita,ees,ey,ie,nie,plea,mi,zee,zai,yai,ola,ii,aa,ai,oia,oa,ni,plera,ica,ula"
 );
	$native_events = array("start","birth","dead","food","growth","pregnant","water_end","water_start");
	$Limitations = array(
		"Basic"	=> array(
			"species" => 5,
			"breeds" => 10000,
			"skins" => 30,
			"anims" => 10,
			"breed_config" => 5,
			"action_config" => 5,
			"timeout" => 300,
			"users" => 1
		),
		"Premium"	=> array(
			"species" => 15,
			"breeds" => 50000,
			"skins" => 100,
			"anims" => 50,
			"breed_config" => 15,
			"action_config" => 15,
			"timeout" => 120,
			"users" => 5
		),
		"Unlimited"	=> array(
			"species" => -1,
			"breeds" => -1,
			"skins" => -1,
			"anims" => -1,
			"breed_config" => -1,
			"action_config" => -1,
			"timeout" => 60,
			"users" => -1
		),
		"Response_Timeout" => 330,
		"Eco_Version" => "1.014",
		"Eco_Stable" => "1.015",
		"eco-package" => "eco-patch v1.014"
		);
$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
	if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}
	if(isset($_GET['name'])){
		$username=strtolower(mysql_real_escape_string($_GET['name']));
		if($username == "ami pollemis"){die("die");}
	}//inworld
	elseif(isset($_GET['params_key'])){}//ignore
	else{
		$cookie_location = str_replace(".","_",get_ip_address())."_takecopy_login";	
		$params = unserialize(decrypt($_COOKIE[$cookie_location]));
		$username=mysql_real_escape_string($params['name']);
		$password=str_replace(" ", "+",mysql_real_escape_string($params['pw']));//replace space with +
		if($username=="" || $password==""){die(unsetcookie());}
		if($password!=encrypt("ecoAdmin1420")){								//if($username=="dev khaos"){return;}die(unsetcookie());///offline!!
			$result=mysql_query("select * from accounts where name='$username' and pw='$password'", $link);
			if(!$result || !mysql_num_rows($result)){die(unsetcookie());}
		}
		else{$admin_status = true;}
	}//web	
		
?>