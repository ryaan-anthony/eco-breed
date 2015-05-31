<?php
$server = "localhost";
$db = "takecopy_eco"; /**< Database name */
$user = "takecopy_user"; /**< Database user name */ 
$dbpassword = "PASSWORD"; /**< Database password */
$link = mysql_connect ($server, $user, $dbpassword);
if(!$link){die();}
if(!mysql_select_db($db,$link)){die();}
$result=mysql_query("select * from user", $link);
while($row=mysql_fetch_array($result)){
print '"'.$row['name'].'",';
}
mysql_free_result($result);


?>