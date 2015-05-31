<?php

$filter="";
if(isset($_GET['user'])){$filter="WHERE name='".strtolower($_GET['user'])."'";}
$link = mysql_connect("localhost","takecopy_user", "PASSWORD");
if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}
$result=mysql_query("select * from user ".$filter, $link);
if(!$result){die("not found");}
if(!mysql_num_rows($result)){die("not found");}
if(isset($_GET['user'])){die("found!");}
while($row=mysql_fetch_array($result)){
if($row['uuid']!=""&&$row['uuid']!="null"){print '"'.$row['name'].'","'.$row['uuid'].'",';}
}
print "<BR>";
$result=mysql_query("select * from user ".$filter, $link);
while($row=mysql_fetch_array($result)){
if($row['uuid']==""||$row['uuid']=="null"){print "//".$row['name'].'<BR>';}
}



?>