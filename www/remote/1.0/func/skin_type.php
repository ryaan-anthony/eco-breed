<?php			
	$skin_throttle = 500;
	$saved_categories=array();
	$saved_skins=array();
	$check_categories=array();
	$global_skins=array();
	
	function findVal($class,$category,$index){
		global $global_skins;
		for($i=0;$i<count($global_skins);$i++){
			$data=explode(":#:",$global_skins[$i]);
			if(trim($data[0])==trim($class) && trim($data[1])==trim($category)){return trim($data[$index]);}
		}
		if($index==4){return "";}
		return 0;
	}
	function getParams(){
		global $skins;
		$params="";
		$Skins_Used=explode("|",$skins);
		for($i=0;$i<count($Skins_Used);$i++){
			$data=explode("~",$Skins_Used[$i]);
			if(isset($data[2])&&$data[2]=="2"){$params.=findVal($data[0],$data[1],4);}
		}
		return $params;
	}
	function isAvailable($mygen,$gen,$odds,$used,$allow){
		if(($odds==-1&&!$allow) && $gen==1){return 0;}//skip : depreciated skin for parent breeds
		if(rand(0,(float)$odds)){return 0;}//skip : rare
		if(($mygen==$gen*-1 && $gen<0)&&$used===false){return 2;}//apply : available only this generation
		if(($gen>0 && $mygen>=$gen)&&$used===false){return 2;}//apply : available
		return 1;//save : ignore later if all_categories not filled
	}
	function pickSkin($select_from,$parse,$generation,$preferences){
		global $saved_categories, $saved_skins, $check_categories, $global_skins,$skin_throttle;
		$saved=false;
		$attempts=$skin_throttle;
		if(!count($select_from)){return;}
		do{
			$try=array();
			$preferred_skin = FALSE;
			if(count($preferences)){//pick preferred skin
				$preferred_skin = TRUE;
				$try=explode(":#:",$preferences[0]);
				$preferences=array_slice($preferences,1);
			}
			else{
				$n = rand(0,count($select_from)-1);
				if(isset($select_from[$n])){
					$try=explode($parse,trim($select_from[$n]));//pick random skin
				}
			}
			if(count($try)>1){
				$skin = $try[0];
				$category = $try[1];
				$category_used = array_search($category,$saved_categories);//this category is already used
				$skin_used = strstr(implode("|",$saved_skins), $skin."~".$category);//this skinset is already used
				if($skin_used===false){  
					if(isset($try[2])){$gen = $try[2];}//parent : gen
					if(isset($try[3])){$odds = $try[3];}//parent : odds
					if(isset($try[5])){$limit = $try[5];}//parent : limit
					else{$limit=-1;}
					if($parse=="~"){
						$gen = findVal($skin,$category,2);//child : gen
						$odds = findVal($skin,$category,3);//child : odds
						$limit = findVal($skin,$category,5);//child : limit
					}		
					if($limit==-1 || $limit>numFound($skin."~".$category)){
						$apply=isAvailable($generation,$gen,$odds,$category_used,$preferred_skin);//skip | apply | save
					}
					else{
						$apply=0;
					}
					$found = array_search($category,$check_categories);//needs this category
					if($found!==false){//needs this category : apply | save
						if($apply==2){
							unset($check_categories[$found]);
						}
						else{
							$apply=0;
						}
					}
					elseif(count($check_categories)>0){$apply=0;}//not finished applying categories : skip
					if($apply>0){// apply | save
						$saved_categories=array_merge($saved_categories,array($category));
						$saved_skins=array_merge($saved_skins,array($skin."~".$category."~".$apply));
						$saved=TRUE;			
					}	
				}
			}
			$attempts--;
			if($attempts==0){$saved=TRUE;}
		}
		while($saved==FALSE);
	}
	function randomSkins($num,$generation,$breedstring,$preferences){
		global $saved_skins,$check_categories,$global_skins,$link;
		$parse="";
		$available_skins=array();
		if(strlen($breedstring)){//child
			$parse="~";
			$result = mysql_query("
				SELECT breed_skins
				FROM breed
				WHERE INSTR('$breedstring', breed_id)
			",$link);
			if($result && mysql_num_rows($result)){
				while($row=mysql_fetch_array($result)){
					$available_skins=array_merge(
						$available_skins, 						
						explode("|",$row['breed_skins'])
					);
				}
				$available_skins=array_filter($available_skins);
			}		
		}
		else{//parent
			$parse=":#:";
			$available_skins=$global_skins;
		}
		$check_categories=numCategories($available_skins,$parse,$generation,$num);
		for($i=0;$i<$num;$i++){pickSkin($available_skins,$parse,$generation,$preferences);}
		return implode("|",$saved_skins);
	}
	function numCategories($select_from,$parse,$generation,$num){
		$list=array();
		if(!count($select_from)){return array();}
		for($i=0;$i<count($select_from);$i++){
			if(isset($select_from[$i])){
				$data=explode($parse,$select_from[$i]);
				if(isset($data[0],$data[1])){
					$category = $data[1];
					$gen = "1";
					$odds = "0";
					if(isset($data[2],$data[3])){
						$gen = $data[2];
						$odds = $data[3];
					}
					if($parse=="~"){
						$gen = findVal($data[0],$data[1],2);
						$odds = findVal($data[0],$data[1],3);
					}
					//category not already on the list
					if(array_search($category,$list)===false){
						$accepted_generation = ($generation>=(int)$gen && $gen>0) || $generation==(int)$gen*-1;
						$common_odds = (int)$odds == 0 || ($parse=="~"&&(int)$odds==-1);
						if($accepted_generation && $common_odds && count($list)<$num){
							$list=array_merge($list,array($category));
						}
					}
				}
			}
		}
		return $list;
	}
	function verify_Pref($preferences){
		$return = array();
		for($i=0;$i<count($preferences);$i++){
			$data = explode(";",$preferences[$i]);
			$skin = $data[0];
			if(isset($data[1])){$category = $data[1];}
			else{$category="None";}//assign category
			$result = skinset_Available($skin,$category);//check if exists | available
			if($result!=""){
				$return=array_merge($return,array($result));//create skin-string
			}
		}
		return $return;
	}
	function skinset_Available($skin,$category){
		global $global_skins;
		for($i=0;$i<count($global_skins);$i++){
			$data=explode(":#:",$global_skins[$i]);
			$gSkin=$data[0];
			$gCategory=$data[1];
			$gLimit=(int)$data[5];
			if($data[5]==""){$gLimit=-1;}
			if($skin==$gSkin && $category==$gCategory){
				if($gLimit==-1 || $gLimit>numFound($skin."~".$category)){
					return $global_skins[$i];
				}
			}
		}
		return "";
	}
	
	//unrefined : contains SQL
	function numFound($str){
		global $link;
		$result=mysql_query("SELECT * FROM breed WHERE breed_skins LIKE '%".$str."%'", $link);
		if(!$result){return 0;}
		return mysql_num_rows($result);
	}	
		
	//get input
	$value = $_GET['skin_string'];
	$number = $_GET['skin_num'];
	$generation = $_GET['skin_gen'];
	$skins="None";
	$params="";
	$species_chan = mysql_real_escape_string($_GET['skin_channel']);
		
	//get params
	$result = mysql_query("
	SELECT * 
	FROM skins as t1 
	WHERE t1.skin_species 
	IN (select id from species where species_chan='$species_chan')
	",$link);
	if(!$result || !mysql_num_rows($result)){
		die(return_results(":#%"));//no skins - ignore
	}
	
	//format params
	$global_skins=array();
	while($row = mysql_fetch_array($result)){
			$global_skins=array_merge(
				$global_skins,
				array(
					implode(":#:",
						array(
							$row['skin_name'],
							$row['skin_category'],
							$row['skin_gen'],
							$row['skin_odds'],
							$row['skin_params'],
							$row['skin_limit']
						)
					)
				)
			);
	}
	$row=array();
	
	//create skin
	if($_GET['skin_type']=="child"){
		$skins=randomSkins($number,$generation,$value,array());
		$params=getParams();
	}//genetic string
	elseif($_GET['skin_type']=="parent"){
		$preferences = verify_Pref(explode(",",$_GET['skin_pref']));
		$skins=randomSkins($number,$generation,'',$preferences);
		$params=getParams();
	}//random string (skin_string=total_num skins)
	elseif($_GET['skin_type']=="rebuild"){
		$skins=$value;
		$params=getParams();
	}//literal string
	return_results($skins.":#%".compact_methods($params));
	
?>