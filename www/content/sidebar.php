<?php include('preload.php'); 
	$file_tree = array(
		3 => array(
			"title" => "Quick Reference",
			"loc" => "reference/",
			"children" => array(
				"methods",
				"events",
				"expressions",
				"commands",
				
				"prop",
				"val",
				"api",
				
				"prims",
				"unicode",
				"textbreak",
				"primgen",
				"primgen2"
			)
		),
		4 => array(
			"title" => "Examples",
			"loc" => "examples/",
			"children" => array(
				"naming",
				"deadstats",
				"revive",
				"physfeat",
				"destroy",
				"farming",
				"hunger-stunted",
				"hatchegg",
				"filterchat",
				"skinanim"
			)
		),
		0 => array(
			"title" => "Announcements",
			"loc" => "announcements/",
			"children" => array(
/*				"5282012",
				"4122012"*/
//				"31920122"
			)
		),
		1 => array(
			"title" => "Statistics",
			"loc" => "stats/",
			"children" => array(
				"live"
			)
		),
		2 => array(
			"title" => "Walkthrough",
			"loc" => "howto/",
			"children" => array(
				"account",
				"orientate",
				"install",
				"setup",
							
				"names",
				"lifespan",
				"growth",
				
				"hunger",
				"food",
				
				"breeding",
				"home",
				
				"whatisaction",				
				"actions",				
				"native",				
				"actiontouch",				
				"usemethods",				
				"sync",
				"rebuild",
			
				"communication",
				"hovertext",
				"menus",
				
				"movement",
				"moving",
				"inventory",
				"sounds",
				"animate",
				"rezzing",
				"attach",
				"eventflow",
				"toggle",
				"filter",
				"enable",
				"pause",
				"properties",
				"val",
				
				"skins",
				"skinset",
				"anims"				
			)
		)
	);
	print "<div>";
		for($i=0;$i<count($file_tree);$i++){
			$children = $file_tree[$i]["children"];
			if(count($children)){
				print "<div class='widget-info'>";
					$search = "";
					$show_search = "";
					if($file_tree[$i]['title']!="Statistics" &&$file_tree[$i]['title']!="Announcements"){
						$search = "<div class='search' search='".$file_tree[$i]['title']."' ><input placeholder='start typing..'></div>";
						//$show_search = "<a>search & find</a>";
					}
					$odd=0;
					$truncated = false;
					print "<h1><span style='display:none;'>&#9664;&nbsp;Go&nbsp;Back</span>".$file_tree[$i]["title"]."$show_search</h1>".$search;
					///////////////////////////////////////////////////////KEEP!!!!/////shuffle($children);
					$children=array_merge(array(),$children);
					for($n=0;$n<count($children);$n++){
						if($n==4){
							$truncated = true;
							print "<div class='widget-hidden' style='display:none;'>";
						}
						$odd++;
						if($odd>1){$odd=0;}
						include("content/sidebar/".$file_tree[$i]["loc"].$children[$n].".php");
					}
					if($truncated){
						print "</div><div class='widget-all'>View All</div>";
					}
				print "</div>";
			}
			print "<div class='widget-spacer'>";
			print "</div>";
		}
	print "</div>";
?>