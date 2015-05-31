<?php
$find =  stripslashes(urldecode($_GET['q']));
$results = array();


function cmp($a, $b){
if($a['count'] == $b['count']) {return 0;}
return ($a['count'] > $b['count']) ? -1 : 1;
}


function compile($data,$source,$pagename){
global $results,$find;
$search = explode(" ",$find);
$data = strip_tags($data);
$desc = substr($data, 0, 250);
$desc = substr($desc, 0, strrpos($desc,'.')).".";
$data = strtolower($data);
$count = 0;
$index = 0;
for($i=0;$i<count($search);$i++){
	if(!empty($search[$i])){
		$count += substr_count($data,strtolower($search[$i]));
		$count += substr_count(strtolower($pagename),strtolower($search[$i]));
	}
}
if(count($results)!=0){$index=count($results);}
if($count>0){$results[$index] = array("count" => $count, "source" => $source, "description" => $desc);}
}

print "<p class='description'>You searched for <a>$find</a></p>";

//$sources = array('attr','classes','core','events','expressions','methods','settings','extend');
//$sourcenames = array('Attributes','Classes','eco Core','Events & Callbacks','Expressions','Methods','Settings & Features', 'Using the API & Extensions');
$sources = array('events','expressions','methods','settings','api');
$sourcenames = array('Events','Expressions','Methods','Settings & Features', 'eco API');

for($i=0;$i<count($sources);$i++){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://eco.takecopy.com/content/".$sources[$i].".php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
compile($data,$sources[$i],$sourcenames[$i]);
curl_close($ch);
}


if(!count($results)){print '<p>There are 0 results for "'.$find.'".</p>';}
else{
usort($results, "cmp");
for($i=0;$i<count($results);$i++){

$page = $results[$i]['source'];
$pagename = $sourcenames[array_search($page,$sources)];

print "
<div class='entry'>
<p class='tags'>".$results[$i]['count']." results</p><p class='title'><a show='".$page."'>".$pagename."</a></p>
<p class='description'>".$results[$i]['description']."</p>
</div>
";
}
}


?>