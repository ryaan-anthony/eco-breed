<?php
		
		$userid = urldecode($_GET['setauthID']);
		$version = urldecode($_GET['ver']);
//update version
		$result = mysql_query("select * from eco_creators where name='$username'",$link);
		if($result && mysql_num_rows($result)){
			mysql_query("update eco_creators set version='$version' where name='$username'",$link);
		}
//insert new creator		
		else{
			echo( "Thank you for your purchase!\n");
			mysql_query("INSERT INTO eco_creators (version,name) VALUES ('$version','$username')", $link);
//insert new account
			$result = mysql_query("select * from accounts where name='$username'", $link);
			if(!mysql_num_rows($result)){
				$unique = uniqueID();
				mysql_query("INSERT INTO accounts (name,uuid,pw) VALUES ('$username','$userid','".encrypt($unique)."')",$link);
				echo( $new_user.$unique."\n");
			}
		}
		echo( "Learn more at http://eco.takecopy.com");
		return;
	

?>