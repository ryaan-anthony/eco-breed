<?php
$creator='amynevilly resident';

$link = mysql_connect("localhost","takecopy", "devTR1420");
if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}
$species_result=mysql_query("select * from species where species_creator='".$creator."'", $link);
$breeds_result=mysql_query("select * from breed where breed_creator='".$creator."'", $link);



$start_memory = memory_get_usage();
if(mysql_num_rows($species_result)>0){$species=mysql_fetch_array($species_result);}
if(mysql_num_rows($breeds_result)>0){$breed=mysql_fetch_array($breeds_result);}
echo "Memory used: ".(memory_get_usage() - $start_memory)." bytes";
print "<br>";
print "Species: ".mysql_num_rows($species_result);
print "<br>";
print "Breeds: ".mysql_num_rows($breeds_result);
?>