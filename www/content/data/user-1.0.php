<?php
include('../preload.php');
include('common.php');

//functions
function splitSkins($skins){
$skinsets=explode("|",$skins);
$active=array();
$dormant=array();
for($i=0;$i<count($skinsets);$i++){
	$current=explode("~",$skinsets[$i]);
	$save = "<strong>".$current[1].":</strong> ".$current[0];
	if($current[0]!=""){
		if($current[2]=="2"){
			if(count($active)){array_push($active,$save);}
			else{$active=array($save);}
		}
		else if($current[2]=="1"){
			if(count($dormant)){array_push($dormant,$save);}
			else{$dormant=array($save);}
		}
	}
}
return array(implode("<br />",$active),implode("<br />",$dormant));
}	
function Gen($gen){
$num=substr($gen, -1);
if($num=="1"){return $gen."st";}
if($num=="2"){return $gen."nd";}
if($num=="3"){return $gen."rd";}
return $gen."th";
}	
function pullNames($parents){
$list = explode("&&",$parents);
$mom_data = explode("|",$list[0]);
$mom = $mom_data[1];
$dad_data = explode("|",$list[1]);
$dad = $dad_data[1];
$found = findBreedIndex($mom_data[0]);
if($found!=-1){$mom = "<a b='$found'>".$mom."</a>";}
$found = findBreedIndex($dad_data[0]);
if($found!=-1){$dad = "<a b='$found'>".$dad."</a>";}
if($mom==""&&$dad==""){return "None";}
if($dad==""){return $mom;}
return  $mom." and ".$dad;
}	
function findName($partner){
global $link;
$partner=mysql_real_escape_string($partner);
$result=mysql_query("select * from breed where breed_id='$partner'", $link);
if(!$result){return "None";}
$row=mysql_fetch_array($result);
$found = findBreedIndex($partner);
if($found!=-1){return "<a a='$found'>".$row['breed_name']."</a>";}
return $row['breed_name'];
}	
function findBreedIndex($id){
global $json, $all_breeds;
//$my_breeds = $json['eco']['all_breeds'];
for($i=0;$i<count($all_breeds);$i++){
	if($all_breeds[$i]['breed_id']==$id){return $i;}
}
return -1;
}	
function dropdown_type($list,$type,$class){
	$data = array();
	$options="";
	for($i=0;$i<count($list);$i++){
		$val = $list[$i][$type];
		if(array_search($val,$data)===FALSE){
			$data[$i]=$val;
			if((int)$list[$i]["species_count"]>0){$options.= "<option class='filter-".$class."-".implode("_",explode(" ",$val))."'>".$val."</option>";}
		}
	}
	return $options;
}	
function Time_Array($number){
if($number==0){return array("","never");}
$monthsDiff = floor($number/60/60/24/30);
if($monthsDiff>0){return array($monthsDiff,"months");}
$daysDiff = floor($number/60/60/24);
if($daysDiff>0){return array($daysDiff,"days");}
$hrsDiff = floor($number/60/60);
if($hrsDiff>0){return array($hrsDiff,"hours");}
$minsDiff = floor($number/60);
if($minsDiff>0){return array($minsDiff,"minutes");}
return array($number,"seconds");
}	
function getskins(){
	global $rules, $val, $my_species;
	$skins_array = $my_species[$val]['species_skins'];
	$options = array();
	for($i=0;$i<count($skins_array);$i++){
		$options=array_merge($options,array($skins_array[$i]["skin_name"],$skins_array[$i]["skin_category"]));
	}
	return $options;
}
function fetch_array($array, $key, $unique=false, $notnull=false){
	$results = array();
	for($i=0;$i<count($array);$i++){
		$value = $array[$i][$key];
		if((($unique && array_search($value,$results)===false) || !$unique) && (!empty($value) || !$notnull)){
			$results = array_merge($results,array($value));
		}
	}
	return $results;
}
function checked($needle, $haystack){
	if(array_search($needle,$haystack)!==false){return "checked";}
	return "";
}
function nl_format($str){
	return implode("\n",explode("\\n",$str));
}
function input($type,$id,$label=array(),$class='',$options=array()){
	global $rules, $default_library, $actionTypes, $input_class,$native_events,$channel, $username;
	if($type=="text"){
		$value = $rules[$id];
		if($id=="Rebuild_Object" || $id=="Breed_Object"){$placeholder="placeholder='Auto-Detect'";}
		$input = "<input id='$id' $placeholder class='wide-input $input_class' value='$value' style='width:150px;font-family: monospace;'/>";
	}
	elseif($type=="textarea"){
		$value = str_replace("&","&amp;",$rules[$id]);
		$style="min-height:100px;";
		$input = "<textarea id='$id' class='textarea-input wide-input $input_class' style='width: 220px;font-family: monospace;min-height: 100px;'>".nl_format($value)."</textarea>";
	}
	elseif($type=='text-string'){
		$value = str_replace("&","&amp;",$rules[$id]);
		$insert = "<textarea id='$id' class='textarea-input $input_class' style='display: block;width: 96%;min-height: 100px;font-family: monospace;'>".nl_format($value)."</textarea>";
	}
	elseif($type=='actions'){
		$label[0] = "Actions Console: <a style='display:none;' class='actions-toggle'>show</a> <a class='actions-toggle'>hide</a>";
		$options = explode("/;",str_replace("&","&amp;",$rules[$id]));
		$events = array();
		for($i=0;$i<count($options);$i++){
			$data = explode("/:",$options[$i]);
			$event = $data[0];
			
			$readonly = "";
			if(array_search($event,$native_events)!==false){
				$events = array_merge($events,array($event));
				$readonly = "readonly";
			}
			$rand = (rand(999,999999)+2);
			//$rand2 = (rand(999,999999)+2);id='$rand2' 
		
			$append .= "
<div id='$rand' class='handle'>
	<input placeholder='Event' class='Actions wide-input' value='".$event."' $readonly/>
	<a class='actions-del'>delete</a> | <a class='actions-chk'>check</a>
	<textarea placeholder='Methods..' class='Actions wide-input eco-codemirror'>".nl_format($data[1])."</textarea>
	<div class='temp'></div>
</div>";
		}
		$append .= "<button id='actions-new-custom'>Add event</button>";
		$wrap="<div class='sub-box' style='margin-left: 10px;min-height: 30px;'>";
		$append = "<div id='$id' class='$input_class actions-toggle sub-block draggable'>$append</div></div>";
		//$input = "<button id='actions-new' style='padding: 3px 5px;'>Add</button>";
		$input.="<select id='actions-new' style='width:158px;font-family: monospace;' class='wide-input'>";
		$input.="<option selected>-Add Event-</option>";
		for($i=0;$i<count($native_events);$i++){
			if(array_search($native_events[$i],$events)===false){
				$input.="<option>".$native_events[$i]."</option>";
			}
		}
		$input.="<option>Custom</option>";
		$input.="</select>";
	}
	elseif($type=='library'){
		$values = explode(',',$rules[$id]);
		$input = "<p><strong>$id :</strong> <a class='add-library'>add entry</a></p>";
		if(!count($values) || trim($rules[$id])==""){$values = explode(',',$default_library[$id]);}
		for($i=0;$i<count($values);$i++){
			$input .="<div style='margin-right:10px;width:35px;position:relative;display:inline-block;'><input class='library' for='$id' style='height: 9px;width:35px;font-size: 0.9em;font-family: monospace;' value='".$values[$i]."'/><a title='remove' style='color: black;font-weight: bold;font-family: sans-serif;font-size: 0.6em;'class='remove-library'>&#x58;</a></div>";
		}
		return "<div id='$id' class='$input_class' value='".$rules[$id]."'>$input</div>";
	}
	elseif($type=="ratio"){
		$value = $rules[$id];
		$odds_array=array(
		0=>"Always Female",
		-1=>"Always Male",
		1=>"Even",
		2=>"Male: Common",
		-5=>"Male: Seldom",
		-10=>"Male: Rare",
		-25=>"Male: Very Rare",
		-2=>"Female: Common",
		5=>"Female: Seldom",
		10=>"Female: Rare",
		25=>"Female: Very Rare");
		$input = "<select id='$id' class='wide-input $input_class ratio-input' style='width:158px;font-family: monospace;'>";
		$input .= "<option selected>".$odds_array[$value]."</option>";		
		foreach ($odds_array as $val) {
			if($val!=$odds_array[$value]){$input .= "<option>".$val."</option>";}
		}
		$input .= "</select>";
	}
	elseif($type=="percent"){
		if(!count($options)){$options[0]=1;}
		$value = $rules[$id];
		$input = "<input id='$id' class='$input_class wide-input number-input percent' value='$value%' style='width:90px;font-family: monospace;'/>
		<button class='number-child' dir='-".$options[0]."'>&#x25be;</button>
		<button class='number-child' dir='".$options[0]."'>&#x25b4;</button>";
	}
	elseif($type=="number"){
		if(!count($options)){$options[0]=1;}
		$value = $rules[$id];
		$input = "<input id='$id' class='$input_class wide-input number-input' value='$value' style='width:90px;font-family: monospace;'/>
		<button class='number-child' dir='-".$options[0]."'>&#x25be;</button>
		<button class='number-child' dir='".$options[0]."'>&#x25b4;</button>";
	}
	elseif($type=="minmax"){
		$input = "min:<input id='".$id[0]."' type='number' class='$input_class wide-input' value='".$rules[$id[0]]."' style='width:40px;font-family: monospace;'/> max:<input id='".$id[1]."' type='number' class='$input_class wide-input' value='".$rules[$id[1]]."' style='width:40px;font-family: monospace;'/>";
	}
	elseif($type=="readonly"){
		$value = $rules[$id];
		if($value!='Not Set'){$in=$channel.'-';}
		$input = "<input readonly id='$id' class='disabled-input wide-input' value='".$in.$value."' style='width:150px;font-family: monospace;'/>";
	}
	elseif($type=="odds"){
		$value = $rules[$id];
		$odds_array=array(-1=>"Never",0=>"Always",1=>"Common",3=>"Seldom",5=>"Rare",10=>"Very Rare",20=>"Almost Never");
		//$value =(int)$value + (int)$options[0];
		//if(!count($options)){$odds_array=array("Always","Common","Seldom","Rare","Very Rare","Almost Never");}
		$input = "<select id='$id' class='$input_class key-value wide-input odds-input' style='width:158px;font-family: monospace;'>";
		$input .= "<option selected>".$odds_array[$value]."</option>";
		foreach ($odds_array as $val) {
			if($val!=$odds_array[$value]){$input .= "<option>$val</option>";}
		}
		$input .= "</select>";
	}
	elseif($type=="globals"){
		$Globals = explode(";",trim($rules["Globals"]));
		if(trim($rules["Globals"])==""){$Globals=array();}
		$Lineage_Globals = explode(";",$rules["Lineage_Globals"]);
		$Lineage_Selection = $rules["Lineage_Selection"];
		$input .= "<input class='wide-input' style='width: 107px;' id='new-global-value'><button id='new-global' style='padding: 3px 5px;margin-right: 0px;margin-left: 5px;'>Add</button>";
		$show="";
		if(!count($Globals)){$show = "display:none;";}
		$saved_values.="<div id='Globals-Header' style='font-weight: bold;color: black;background: #F4F4F4;width: 500px;padding: 5px 10px;$show'>
		<div style='display: inline-block;width: 75px;'>Genetic?</div> 
		<div style='display: inline-block;width: 150px;'>Key</div>
		<div style='display: inline-block;width: 80px;'>Value</div>
		</div>";
		for($i=0;$i<count($Globals);$i+=2){
			$saved_values.="<p>
			<input style='margin: 0 35px;' id='line-".implode("-",explode(" ",$Globals[$i]))."'type='checkbox' ".checked($Globals[$i],$Lineage_Globals)."/>
			<input class='Globals-keyval' value='".$Globals[$i]."' readonly />
			<input id='prop-".implode("-",explode(" ",$Globals[$i]))."' value='".$Globals[$i+1]."' />
			<a style='color:orangered;margin-left:20px;' class='remove-global'>remove</a>
			</p>";
		}
		$insert .="<div id='Globals' value='".$rules['Globals']."' class='$input_class' style='padding-top:10px;'>$saved_values</div>";
		$append .= input("select",array("Lineage_Selection",$show),array("Pass on genetics values:","If values are passed on via genetics, set how the values are selected from parents to offspring."),'',array(
		0=>"Random",
		1=>"From Mom",
		2=>"From Dad",
		3=>"Gender Based"));
	}
	elseif($type=="sync-select"){
		$value = $rules[$id];
		$input = "<select id='$id' class='$input_class wide-input' style='width:158px;font-family: monospace;'>";
		$input .= "<option selected>-select-</option>";
		for($i=0;$i<count($options);$i++){
			if(array_search($options[$i],explode(",",$value))===FALSE){$input .= "<option>".$options[$i]."</option>";}
			else{$saved_values.="<p><label><input class='sync-val wide-input' style='width:150px;font-family: monospace;' value='".$options[$i]."'/></label> </p>";}//matches saved values
		}
		$input .= "</select>";
		$insert .="<div class='sub-block-temp $input_class local-values' style='padding-top:10px;'>$saved_values</div>";
	}
	elseif($type=="skin-select"){
		$value = $rules[$id];
		$Preferred_Skins = explode(";",$value);
		for($i=0;$i<count($Preferred_Skins);$i+=2){
			
		}
		$input = "<select id='$id' class='$input_class wide-input' style='width:158px;font-family: monospace;'>";
		$input .= "<option selected>-select-</option>";
		for($i=0;$i<count($options);$i+=2){
			if(array_search($options[$i],$Preferred_Skins)===FALSE){
				$input .= "<option>".$options[$i]." (".$options[$i+1].")</option>";
			}
			else{
				$saved_values.="<p><label><input key='".$options[$i].";".$options[$i+1]."' type='checkbox' class='skin-val' checked/>".$options[$i]." (".$options[$i+1].")</label></p>";
			}
		}
		$input .= "</select>";
		$insert .="<div class='sub-block-temp $input_class local-values' style='padding-top:10px;'>$saved_values</div>";
	}
	elseif($type=="select"){
		$value = $rules[$id[0]];
		$style.=$id[1];
		$selected = $options[$value];
		if($id[0]=="Activation_Param"){
			if($selected == ""){
				$selected="Custom";
				$append .= '<div class="sub-block">\'Parent\' with secure rez start_param: <div style="position: absolute;top: 0;right: 20px;"><input id="Activation_Param_Custom" class="wide-input number-input" value="'.$value.'" style="width:90px;font-family: monospace;"><button class="number-child" dir="-1" style="margin-left: 7px;">&#x25be;</button><button class="number-child" dir="1" style="margin-left: 7px;">&#x25b4;</button></div></div>';
			}
			else{
				$options = array_merge($options,array("Custom"));
			}
		}
		$input = "<select id='".$id[0]."' class='$input_class wide-input' style='width:158px;font-family: monospace;'>";
		$input .= "<option selected>$selected</option>";
		for($i=0;$i<count($options);$i++){
			if($options[$i]!=$options[$value]){$input .= "<option>".$options[$i]."</option>";}
		}
		$input .= "</select>";		
	}
	elseif($type=="hide-false"){
		$value = $rules[$id];
		if($id=="Allow_Throttling" && !count($actionTypes)){
			$input = '<p title="Requires &quot;Action_Type&quot; to be defined in your action configurations." style="color:red;margin-top: 5px;">No action types found.</p>';
		}
		else{
			if($id=="Allow_Breeding" || $id=="Allow_Rebuild" || $id=="Show_Text"){
				$data = array(0=>"NO",1=>"YES",2=>"RESERVE");
				$value = $data[(int)$value];
				unset($data[(int)$rules[$id]]);
				$data=array_merge(array(),$data);
				$alt = $data[0]."</option><option>".$data[1];
			}
			else{
				if($value=="0"){$value="NO";$alt="YES";}
				else{$value="YES";$alt="NO";}
			}
			$input .= "<select id='$id' class='$input_class bool-type $type wide-input' style='width:158px;font-family: monospace;'>";
			$input .= "<option selected>".$value."</option>";
			$input .= "<option>".$alt."</option>";
			$input .= "</select>";
		}
		for($i=0;$i<count($options);$i++){$append .= $options[$i];}
	}
	elseif($type=="hide-show"){
		$value = $rules[$id];
		$input = "<select id='$id' class='$type wide-input' style='width:158px;font-family: monospace;'>";
		$input .= "<option selected>HIDE</option>";
		$input .= "<option>SHOW</option>";
		$input .= "</select>";
		for($i=0;$i<count($options);$i++){$append .= $options[$i];}
	}
	elseif($type=="hide-zero"){
		$value = $rules[$id];
		$input = "<input id='$id' class='$input_class hide-zero wide-input number-input' value='$value' style='width:90px;font-family: monospace;'/>
		<button class='number-child' dir='-1'>&#x25be;</button>
		<button class='number-child' dir='1'>&#x25b4;</button>";
		for($i=0;$i<count($options);$i++){$append .= $options[$i];}
	}
	if($label[1]!=""){
		$style.="cursor:help;";
	}
	if($class!=""){
		if($rules[$class]=="0" || $rules[$class]==""){
			$style.="display:none;padding-left: 30px;";
		}
		$class="child-".$class;
	}
	return $wrap."<div class='sub-block $class' title='".$label[1]."' style='$style'>".
		$label[0]." <div style='position: absolute;top: 0;right: 20px;'>$input</div>".
		$insert."</div>".$append;
}

function minmax($count,$type){
	global $subscription,$Limitations,$allow,$modify,$difference;
	$allow=true;
	$modify = true;
	if($subscription=="Unlimited"){return "<label class='inline-tag alt-span'>($count)</label>";}
	$limit = $Limitations[$subscription][$type];
	if((int)$count>(int)$limit){$modify = false;$difference=((int)$count-(int)$limit);}
	if((int)$count>=(int)$limit){$allow=false;$style="color:red;font-weight:bold;";}
	return "<label class='inline-tag alt-span' title='upgrade hosting to increase this limit' style='$style'>($count/$limit)</label>";
}

//page compile
if(isset($_POST['s'])){//SPECIES
	$val = (int)$_POST['s'];
	get_json(array(
		"species" => $val, 
		"breed_rules" => "all",
		"action_rules" => "all",
		"skins" => "all",
		"anims" => "all",
		"authorized" => "all"));
		//var_dump($json_raw);
	$my_stats = $json['eco']['user'][0];
	$my_species = $json['eco']['species'][0];
	//$all_breeds = $json['eco']['breeds'];
	$Version = $my_stats['version'];
	$subscription = $my_stats['host_plan'];
	$species_creator = $my_species['species_creator'];
	if($species_creator!=$username){
		$result = mysql_query("select * from subscriptions where name='$species_creator'");
		if($result && mysql_num_rows($result)){
			$row=mysql_fetch_array($result);
			if($row['sub_type']=="2"){$subscription = "Unlimited";}
			else{$subscription = "Premium";}
		}
		else{
			$subscription = "Basic";
		}
	}//set creator subscription (for authorized users)
	$species = $my_species['species_name'];
	$channel = $my_species['species_number'];
	$species_index = $my_species['species_index'];
	if(is_numeric($channel)){		
		print "<div class='depreciated' style='font-size: 1.1em;padding: 10px;'>";
		print "<h2>This species was created using a depreciated version.</h2>";
		print "<ul style='margin-left:30px;'>";
		print "<h3>Here are your options:</h3>";
		$max_allowed = $Limitations[$subscription]['species'];
		$result = mysql_query("select * from species where ceil(species_chan) != species_chan and species_creator='$username'",$link);
		if($result){$total_count = mysql_num_rows($result);}
//		for($i=0;$i<count($my_species);$i++){
//			$species_number = $my_species[$i]['species_number'];
//			if((string)((int)$species_number)!=$species_number){$total_count++;}//count valid species only
//		}
		if($Version=="none"){print "<p>Unknown user - please upgrade to eco breeds version ".$Limitations['Eco_Version']."</p></div>";}
		elseif($total_count>=$max_allowed && $max_allowed!=-1){print "<p>You can not convert any more species.</p>";}		
		elseif((float)$Version>=1.0){print "<li><a id='species_number_new' s='$species_index'>Convert this species now!</a></li>";}
		elseif((float)$Version!=$Limitations['Eco_Version']){print "<li>Upgrade to <a class='upgrade-now external' > version ".$Limitations["Eco_Version"]."</a></li>";}	
		else{print "<li style='color:#666;'><em>Conversion is not currently available for version $Version</em></li>";}
		print "<li>Use the <a id='legacy' title='Requires legacy login.' class='external' href='http://eco.takecopy.com/?e=legacy' target='_blank'>Legacy UI</a><em style='color:#666'>(you will be logged out)</em></li>";
		print "</ul>";
		print "</div>";
		die();
	}//depreciated species
	//NAME:

	print "<div class='ui-left'>";
		print "<p class='sub-up hang sit' style='color: #666;'>Species Name:</p>";
		if($species!="" && $username == $species_creator){
			print "
			<a id='species_delete' s='$species_index' style='color: red;float: left;'>delete</a>
			<span style='float: left;padding: 0 5px;'> | </span>
			<a id='species_number_new' s='$species_index' style='color:orangered;float: left;'>refresh id</a>
			";
		}
	print "</div>";
	print "<div class='ui-right'>";
		print "<input id='species_name' class='wide-input' value='$species' />";
		print "<button id='species_name_save' s='$species_index' disabled style='padding:5px 10px;'>Save</button>";
		if($species==""){die("<button id='species_name_cancel' style='padding:5px 10px;'>Cancel</button></div>");}
	print "</div>";
	
	print "<div class='widget-spacer'></div>";
	
	print "<div class='widget-wrapper'>";
	//SKIN PARAMS
	$SKIN = (int)$_POST['skin_index'];
	$skinsets = $my_species['species_skins'];
	$selected = $skinsets[$SKIN];
	$available = $selected['skin_limit'];
	if($available==""){$available="-1";}
	if(count($skinsets)){$show_select="";$show_input="display:none;";}
	else{$show_select="display:none;";$show_input="";}	
	print "<div class='seperator' style='height: 50px;'>";
		print "<div class='label expand' style='margin-top: 0px;width:590px;'>";
			print "<p class='sub-up hang sit' style='margin-left: 20px;color:#666;'>Skinsets: ".minmax(count($skinsets),'skins')."</p>";
			if(count($skinsets) || ($SKIN==0 && !count($skinsets))){
				if($allow){print "<a style='margin-left: 20px;color: orangered;' id='skins-add-new' next=".count($skinsets).">new skinset</a>";}
			}
			print "<span style='display:none;'>";
			print "<div class='codeblock' style='width: 100px;height: 238px;margin-top:0px;background: #FCFCFC;'>";
				print "<ul style='list-style-image: none;margin-left: 0.2em;font-weight:normal;'>";
					print "<strong>Gen:</strong>
					<li class='hover-help' title='Must be greater than this generation. Example: 3 = must be 3rd generation or higher to use this skin'>&gt;0 = Minimum Gen</li>
					<li class='hover-help' title='Only this generation. Example: -3 = only 3rd generation can use this skin.'>&lt;0 = Only This</li>
					<br />
					<strong>Odds:</strong>
					<li class='hover-help' title='Depreciated skins will still be applied to offspring of parent breeds who already have the skin. Use this for limited release skins to depreciate the skinset so it will not be applied to 1st generation breeds.'>-1 = Depreciated</li>
					<li class='hover-help' title='Common skin, will be applied if randomly selected.'>&nbsp;0 = Common</li>
					<li class='hover-help' title='The higher the number, the more rare the skin.'>&gt;0 = Rare</li>
					<br />
					<strong>Limit:</strong>
					<li class='hover-help' title='Unlimited number of breeds can apply this skin.'>-1 = Unlimited</li>
					<li class='hover-help' title='Depreciated, no new breeds can access this skin.'>&nbsp;0 = Depreciated</li>
					<li class='hover-help' title='Only X number of breeds can have this skin. This number will dynamically decrease until it reaches zero as breeds apply this skin.'>&gt;0 = Fixed</li>";
				print "</ul>";
			print "</div>";		
			print "<div class='params_box' align='center' style='padding: 5px 0;position:absolute;top: 5px;right: 0;height: 250px;'>";
				/*SKIN SELECT*/
				print "<div class='input_box'>";
				print "<p>Skin Name: ";
				if(count($skinsets)){print "<a id='skin-name-edit' style=''>(edit)</a>";}
				print "</p>";
				print "<span id='skin-name-show'>
				<select s='$species_index' id='skin-name' style='".$show_select."width:155px;padding:3px;'>";
				print "<option skin='$SKIN'>".$selected['skin_name']."</option>";
				for($i=0;$i<count($skinsets);$i++){
					$skinset = $skinsets[$i];
					if($i!=$SKIN && $skinset['skin_category']==$selected['skin_category']){
						print "<option skin='$i'>".$skinset['skin_name']."</option>";
					}
				}
				print "</select>";
				print "<input id='skin-name-new' value='".$selected['skin_name']."' style='".$show_input."width:145px;padding:3px;'/>";
				print "</span>";
				print "</div>";
				
				/*CATEGORY SELECT*/
				$displayed_categories=array($selected['skin_category']);
				print "<div class='input_box'>";
				print "<p>Category: ";
				if(count($skinsets)){print "<a id='cat-name-edit' style=''>(edit)</a>";}
				print "</p>";
				print "<span id='cat-name-show'>
				<select c='$val' id='cat-name' style='".$show_select."width:150px;padding:3px;'>";
				print "<option cat='$SKIN'>".$selected['skin_category']."</option>";
				for($i=0;$i<count($skinsets);$i++){
					$category = $skinsets[$i]['skin_category'];
					if($i!=$SKIN && array_search($category,$displayed_categories)===false){
						$displayed_categories = array_merge($displayed_categories,array($category));
						print "<option cat='$i'>$category</option>";
					}
				}
				print "</select>";
				print "<input id='cat-name-new' value='".$selected['skin_category']."' style='".$show_input."width:140px;padding:3px;'/>";
				print "</span>";
				print "</div>";
				
				/*FILTERS & PARAMS*/
				print "<div class='input_box'><p>Gen:</p><input id='skin-gen' type='number' style='width:35px;padding:3px;' value='".$selected['skin_gen']."' /></div>";
				print "<div class='input_box'><p>Odds:</p><input id='skin-odds' type='number' style='width:35px;padding:3px;' value='".$selected['skin_odds']."' /></div>";
				print "<div class='input_box'><p>Limit:</p><input id='skin-limit' type='number' style='width:35px;padding:3px;' value='".$available."' /></div>";
				print "<p>Prim Methods: <a class='prim-methods'>(formatting help)</a></p>";
				print "<textarea placeholder='Supply Prim Methods Here...' id='skin-params' class='mod-code'>".str_replace(")",")\n",$selected['skin_params'])."</textarea>";
				if(count($skinsets)){print "<p><a id='skin_delete' s='$species_index' skin='$SKIN' style='color:orangered;'>delete this skin</a></p>";}
				if($modify){
					print "<button id='skin_save' s='$species_index' skin='$SKIN' style='float:right;padding:5px 10px;' disabled>Save Changes</button>";
				}
				else{
					print "<div style='padding: 10px 0;font-weight: bold;'>You must delete $difference skins before you can make changes.</div>";
				}
				print "<button id='skin_cancel' s='$species_index' skin='$SKIN' style='float:right;padding:5px 10px;'>Cancel</button>";
				
			print "</div>";	
			print '<div class="prim-methods" style="margin: 10px 100px;font-size: 14px;background: #f7f7f7;padding: 20px;display:none;">
<div class="entry">
	<p class="tags">prim, face, float [ , float ... ]</p><p class="title">alpha()</p>
</div>
<div class="entry">
	<p class="tags">prim, face, vector [ , vector ... ]</p><p class="title">color()</p>
</div>
<div class="entry">
	<p class="tags">prim, face, value [ , value ... ]</p><p class="title">glow()</p>
</div>
<div class="entry">
	<p class="tags">prim, vector [ , vector ... ]</p><p class="title">pos()</p>
</div>
<div class="entry">
	<p class="tags">prim, rotation [ , rotation ... ]</p><p class="title">rot()</p>
</div>
<div class="entry">
	<p class="tags">prim, flags, uuid [ , uuid ... ]</p><p class="title">sculpt()</p>
</div>
<div class="entry">
	<p class="tags">prim, face, value [ , value ... ]</p><p class="title">shine()</p>
</div>
<div class="entry">
	<p class="tags">prim, vector [ , vector ... ]</p><p class="title">size()</p>    
</div>
<div class="entry">
	<p class="tags">prim, face, uuid [ , uuid ... ]</p><p class="title">texture()</p>
</div>
<div class="entry">
	<p class="tags">prim, type, params</p><p class="title">type()</p>
</div></div>';	
		print "</span>";
			print '<div style="position: absolute;top: 0px;right: 150px;" class="alt-span">';
				print '<select id="alt-skin" style="width: 200px;padding: 5px;border: 1px solid #DCDCE9;">';
					print "<option selected>-</option>";
					for($i=0;$i<count($skinsets);$i++){
						if($skinsets[$i]['skin_name']!=""){print "<option skin='$i' s='$species_index'>".$skinsets[$i]['skin_name']."</option>";}
					}
				print '</select>';
			print '</div>';
		print '</div>';
	print "</div>";
	print "</div>";

	print "<div class='widget-wrapper'>";
	//ANIM PARAMS
	$ANIM = (int)$_POST['anim_index'];
	$animsets = $my_species['species_anims'];
	$selected = $animsets[$ANIM];
	if(count($animsets)){$show_select="";$show_input="display:none;";}
	else{$show_select="display:none;";$show_input="";}
	print "<div class='seperator' style='height: 50px;'>";
		print "<div class='label expand' style='margin-top: 0px;width:590px;'>";
			print "<p class='sub-up hang sit' style='margin-left: 20px;color:#666;'>Animations: ".minmax(count($animsets),'anims')."</p>";
			if(count($animsets) || ($ANIM==0 && !count($animsets))){
				if($allow){print "<a style='margin-left: 20px;color: orangered;' id='anims-add-new' next=".count($animsets).">new animation</a>";}
			}
			print "<span style='display:none;'>";
				print "<div class='codeblock' style='width: 100px;margin-top:5px;height: 238px;background: #FCFCFC;'>";
					print "<ul style='list-style-image: none;margin-left: 0.2em;font-weight:normal;margin-top: 10px;'>
						<strong>Frames:</strong>
						<li class='hover-help' title='Only set first frame.'>&nbsp;1 = Pose</li>
						<li class='hover-help' title='Set two or more frames in a sequence.'>&gt;1 = Animation</li>
						<br />
						<strong>Repeat:</strong>
						<li class='hover-help' title='Loops the sequence infinitely.'>-1 = Infinite</li>
						<li class='hover-help' title='Triggers the sequence once.'>&nbsp;0 = Once</li>
						<li class='hover-help' title='Repeats the sequence this number of times.'>&gt;1 = Num Repeats</li>
						<br />
						<strong>Delay:</strong>
						<li class='hover-help' title='Delays the animation for this many seconds between each frame and each sequence.'>&gt;0.0 = Seconds</li>
					</ul>";
				print "</div>";
				print "<div class='params_box' align='center' style='padding: 5px 0;position:absolute;top: 5px;right: 0;height: 250px;'>";
					print "<div class='input_box'>
						<p>Anim Name: ";
						if(count($animsets)){print "<a id='anim-name-edit' style=''>(edit)</a>";}
						print "</p>
						<span id='anim-name-show'>
							<select s='$species_index' id='anim-name' style='".$show_select."width:225px;padding:3px;'>";
						print "<option anim='$ANIM'>".$selected['anim_name']."</option>";
						for($i=0;$i<count($animsets);$i++){
							if($i!=$ANIM){
								print "<option anim='$i'>".$animsets[$i]['anim_name']."</option>";
							}
						}
						$stages = $selected['anim_frames'];
						if($stages==""){$stages="0";}
						print "</select>
							<input id='anim-name-new' value='".$selected['anim_name']."' style='".$show_input."width:215px;padding:3px;'/>
						</span>
					</div>
					<div class='input_box'>
						<p>Frames:</p>
						<input id='anim-stages' type='number' style='width:55px;padding:3px;' value='".$stages."' />
					</div>
					<div class='input_box'>
						<p>Repeat:</p>
						<input id='anim-repeat' type='number' style='width:55px;padding:3px;' value='".$selected['anim_repeat']."' />
					</div>
					<div class='input_box'>
						<p>Delay:</p>
						<input id='anim-delay' type='number' style='width:55px;padding:3px;' value='".$selected['anim_delay']."' />
					</div>
					<p>Prim Methods: <a class='prim-methods'>(formatting help)</a></p>
					<textarea placeholder='Supply Prim Methods Here...' id='anim-params' class='mod-code'>".str_replace(")",")\n",$selected['anim_params'])."</textarea>";
					if(count($animsets)){print "<p><a id='anim_delete' s='$species_index' anim='$ANIM' style='color:orangered;'>delete this anim</a></p>";}
					
					if($modify){
						print "<button id='anim_save' s='$species_index' anim='$ANIM' style='float:right;padding:5px 10px;' disabled>Save Changes</button>";
					}
					else{
						print "<div style='padding: 10px 0;font-weight: bold;'>You must delete $difference anims before you can make changes.</div>";
					}
					print "<button id='anim_cancel' s='$species_index' anim='$ANIM' style='float:right;padding:5px 10px;'>Cancel</button>";
				print "</div>";
				print '<div class="prim-methods" style="margin: 10px 100px;font-size: 14px;background: #f7f7f7;padding: 20px;display:none;">
	<div class="entry">
		<p class="tags">prim, face, float [ , float ... ]</p><p class="title">alpha()</p>
    </div>
    <div class="entry">
        <p class="tags">prim, face, vector [ , vector ... ]</p><p class="title">color()</p>
	</div>
    <div class="entry">
	    <p class="tags">prim, face, value [ , value ... ]</p><p class="title">glow()</p>
    </div>
    <div class="entry">
    	<p class="tags">prim, vector [ , vector ... ]</p><p class="title">pos()</p>
    </div>
    <div class="entry">
	    <p class="tags">prim, rotation [ , rotation ... ]</p><p class="title">rot()</p>
    </div>
    <div class="entry">
    	<p class="tags">prim, flags, uuid [ , uuid ... ]</p><p class="title">sculpt()</p>
    </div>
    <div class="entry">
	    <p class="tags">prim, face, value [ , value ... ]</p><p class="title">shine()</p>
    </div>
    <div class="entry">
        <p class="tags">prim, vector [ , vector ... ]</p><p class="title">size()</p>    
    </div>
    <div class="entry">
	    <p class="tags">prim, face, uuid [ , uuid ... ]</p><p class="title">texture()</p>
    </div>
    <div class="entry">
    	<p class="tags">prim, type, params</p><p class="title">type()</p>
    </div></div>';
			print "</span>";
			print '<div style="position: absolute;top: 0px;right: 150px;" class="alt-span">';
				print '<select id="alt-anim" style="width: 200px;padding: 5px;border: 1px solid #DCDCE9;">';
					print "<option selected>-</option>";
					for($i=0;$i<count($animsets);$i++){
						if($animsets[$i]['anim_name']!=""){print "<option anim='$i' s='$species_index'>".$animsets[$i]['anim_name']."</option>";}
					}
				print '</select>';
			print '</div>';
		print "</div>";
	print "</div>";
	print "</div>";

	print "<div class='widget-wrapper'>";
	//BREED RULES
	$input_class = 'breed-rules-input';
	$BREED_RULE = (int)$_POST['breed_rules_index'];
	$rulesets = $my_species['breed_rules'];
	$next = count($rulesets);
	if(isset($_POST['breed_rules_index'])){$show_select="";$show_input="display:none;";}
	else{$show_select="display:none;";$show_input="";}
	if($BREED_RULE==count($rulesets) || !count($rulesets)){
		$default = array();
		$result=mysql_query("DESCRIBE breed_rules", $link);
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			if($row['Field']=='Configuration_ID'){$row['Default']="Not Set";}
			if($row['Field']=='species_index'){$row['Default']=$species_index;}
			$default = array_merge($default,array($row['Field']=>$row['Default']));
		}			
		$rulesets[$BREED_RULE]=$default;
	} 
	else{
		$reset_delete = "<div class='sub-block' align='center' style='padding: 5px;'><a style='color: red; font-weight:bold;' s='$species_index' id='delete-breed-rules' this='$BREED_RULE'>delete configuration</a> | <a style='color: orangered;' s='$species_index' id='reset-breed-rules' this='$BREED_RULE'>reset to default</a></div>";//delete | reset
	}
	$rules = $rulesets[$BREED_RULE];
	$actionTypes = fetch_array($my_species['action_rules'],'Action_Type',true,true);
	print "<div class='seperator' style='height: 50px;'>";
		print "<div class='label expand' style='margin-top: 0px;width:590px;'>";
			print "<p class='sub-up hang sit' style='margin-left: 20px;color:#666;'>Breed Settings: ".minmax($next,'breed_config')."</p>";
			if(count($rulesets) || ($BREED_RULE==0 && !count($rulesets))){
				if($allow){print "<a style='margin-left: 20px;color: orangered;' id='breed-rules-add-new' s='$species_index' next='$next'>new configuration</a>";}
			}
			print '<div style="position: absolute;top: 0px;right: 150px;">';
				print '<select id="alt-breed-rules" style="width: 200px;padding: 5px;border: 1px solid #DCDCE9;">';
					print "<option selected>-</option>";
					for($i=0;$i<count($rulesets);$i++){
						if($rulesets[$i]['Configuration_Name']!=""){
							print "<option breed-rule='$i' s='$species_index'>".$rulesets[$i]['Configuration_Name']."</option>";
						}
					}
				print '</select>';
				print "<span style='$show_select position: absolute;width: 140px;right: -150px;top: 0px;'>";
					print "<button this='$BREED_RULE' id='save-breed-rules' s='$species_index' disabled style='padding: 5px 10px;'>Save</button> "; 
					print "<button id='cancel-breed-rules' style='padding: 5px 10px;'>Cancel</button>";
				print "</span>";
			print '</div>';
			if(isset($_POST['breed_rules_index'])){
			print "<span style='$show_select' id='breed-rules'>";
				print "<div class='sub-box' style='margin-left: 10px;'>";
					print $reset_delete;
					print input("text","Configuration_Name",array("Configuration Name:","Used to identify this configuration."));
					print "<hr>";
					print input("readonly","Configuration_ID",array("Configuration ID:","Used to identify this configuration."));
					print "<hr>";
					print input("select",array("Activation_Param"),array("Breed Type:","First generation or child object?"),'',array(0=>"Child",1=>"Parent"));
					print "<hr>";
					print input("hide-false","Name_Generator",array("Create random <strong>names</strong>?","Turns on/off the name generator."),'',array(
						input("hide-false","Gender_Specific",array("Create names based on gender?"),'Name_Generator'),
						input("text","Name_Object",array("Set breed name on object:","Use the %name% or %desc% expression to insert the breed's name into the string."),'Name_Generator')));
					print "<hr>";
					print input("hide-false","Lifespan",array("Does your breed <strong>age</strong>?","Turns on/off ageing."),'',array(
						input("number","Year",array("Length of a year in minutes:"),'Lifespan'),
						input("odds","Survival_Odds",array("Chances of death from old age:"),'Lifespan'),
						input("minmax",array("Age_Min","Age_Max"),array("Define old age:","Set max to -1 for unlimited ageing."),'Lifespan')
						));
					print "<hr>";
					print input("hide-zero","Growth_Stages",array("Number of <strong>growth</strong> stages:","Growth is the re-sizing and re-positioning of all prims in a linkset. The difference is applied to animations, rebuilt breeds, as well as sit and camera positions. Once growth has completed it's last stage, the growth timer deactivates and the object remains a static size unless re-enabled."),'',array(
						input("number","Growth_Timescale",array("Length of a growth cycle in minutes:"),'Growth_Stages'),
						input("number","Growth_Scale",array("Growth scale:"),'Growth_Stages',array(0.01)),
						input("number","Growth_Offset",array("Growth offset:"),'Growth_Stages',array(0.01)),
						input("odds","Growth_Odds",array("Odds of growing each cycle:"),'Growth_Stages')
						));
					print "<hr>";						
					print input("hide-zero","Hunger_Timescale",array("How often to look for <strong>food</strong>, in minutes:","The hunger level is part of the built-in point system. Food consumption is precise and secure with built in logic to handle multiple food sources."),'',array(
						input("percent","Hunger_Start",array("Starting hunger level:"),'Hunger_Timescale'),
						input("odds","Hunger_Odds",array("Odds of eating each cycle:"),'Hunger_Timescale'),
						input("minmax",array("Hunger_Min","Hunger_Max"),array("Food units eaten each cycle:"),'Hunger_Timescale'),
						input("percent","Hunger_Lost",array("Hunger points lost each cycle:"),'Hunger_Timescale'),
						input("odds","Starvation_Odds",array("Should breed die from hunger?"),'Hunger_Timescale',array(1)),
						input("percent","Starvation_Threshold",array("Death occurs below this level:"),'Hunger_Timescale')
						));
					print "<hr>";
					print input("hide-false","Genders",array("Does your breed have <strong>genders</strong>?"),'',array(
						input("ratio","Gender_Ratio",array("Gender ratio:","Ratio of gender selection upon creation."),'Genders')
						));
					print "<hr>";
					print input("hide-zero","Breed_Time",array("How often does your breed <strong>reproduce</strong>, in minutes?","Breeding is the act of mating and/or producing offspring where parents pass on unique information such as skin preferences or other traits to their offspring, thus creating a unique lineage."),'',array(
						input("number","Pregnancy_Timeout",array("Length of pregnancy in minutes:","Time in minutes between breeding and birth : 0 = Instant Birth"),'Breed_Time'),
						input("odds","Breed_Failed_Odds",array("Birth success rate:"),'Breed_Time'),
						input("minmax",array("Litter_Min","Litter_Max"),array("Number of breeds in each litter:"),'Breed_Time'),
						input("hide-false","Litter_Rare",array("Large litters more rare?"),'Breed_Time'),
						input("number","Litters",array("Maximum number of litters a breed can have:","-1 = Unlimited"),'Breed_Time'),
						input("minmax",array("Breed_Age_Min","Breed_Age_Max"),array("Age bracket where breeding occurs:","Set max to -1 for no maximum age."),'Breed_Time'),
						input("hide-false","Require_Partners",array("Require partners to breed?"),'Breed_Time'),
						input("hide-false","Unique_Partner",array("Disallow breeding among siblings and parents?"),'Breed_Time'),
						input("hide-false","Keep_Partners",array("Keep the same partners each breeding cycle?"),'Breed_Time'),
						input("number","Partner_Timeout",array("Look for new partner after how many cycles?"),'Breed_Time')
						));
					print "<hr>";
					print input("hide-false","Skins",array("Do you want to apply <strong>skins</strong> to your breed?","Skins can be applied in a variety of ways to suit your needs. Such as mixed coat, pure breed, rare, unlockable, limited edition, with or without genetic or built-in preferences. A skinset can alter the entire primset or just individual surfaces. The skin a breed has can also be used to define functionality such as behavior, traits, titles, etc."),'',array(
						input("minmax",array("Skins_Min","Skins_Max"),array("Number of skinsets to save:","This sets the number of skins per breed; skins that are saved and not applied can be passed on to offspring."),'Skins'),
						input("hide-false","Preserve_Lineage",array("Offspring gets their skins from parents?","If NO, skins are randomly selected from the webserver."),'Skins'),
						input("skin-select","Preferred_Skins",array("Apply only these skins if available:"),'Skins',getskins())
						));
					print "<hr>";							
					print input("globals","null",array("Create/Modify global values:","Create and define the starting value for custom properties. These values can be modified using the prop() method and used as an expression to find it's value."));
					print "<hr>";											
					print "<div class='sub-block' align='center' style='padding: 5px;'>";
						print "<a style='color: orangered; font-weight:bold;display:none;' class='advanced-breed-rules' this='$BREED_RULE'>hide advanced</a>";
						print "<a style='color: orangered; font-weight:bold;' class='advanced-breed-rules' this='$BREED_RULE'>show advanced</a>";
					print "</div>";
					print "<div id='advanced-breed-rules-toggle' style='display:none;'>";
						print input("hide-show","Defaults",array("Hide/Show default values"),'',array(
						input("number","Retry_Timeout",array("Retry the connection after this many seconds:"),'Defaults'),
						input("number","Age_Start",array("Age at birth/creation:"),'Defaults'),
						input("hide-false","Self_Destruct",array("Self-destruct if authentication fails?"),'Defaults'),
						input("hide-false","Owner_Only",array("Restrict communications to owner-only?"),'Defaults'),
						input("number","Limit_Requests",array("Limit the number of pending requests:"),'Defaults'),
						input("number","Sound_Volume",array("Default sound volume: (0.0 to 1.0)"),'Defaults',array(0.1)),
						input("text","Sit_Pos",array("Sit position:"),'Defaults vectors'),
						input("text","Sit_Rot",array("Sit rotation:"),'Defaults vectors'),
						input("hide-false","Sit_Adjust",array("Adjust sit position for growth:"),'Defaults'),
						input("text","Cam_Pos",array("Camera Position:"),'Defaults vectors'),
						input("text","Cam_Look",array("Camera Direction:"),'Defaults vectors'),
						input("hide-false","Cam_Adjust",array("Adjust camera position for growth:"),'Defaults'),
						input("number","Text_Prim",array("Prim to display hover text:"),'Defaults'),
						input("text","Text_Color",array("Hover text color:"),'Defaults vectors'),
						input("number","Text_Alpha",array("Hover text transparency: (0.0 to 1.0)"),'Defaults',array(0.1)),
						input("hide-false","Pause_Anims",array("pause() effects animations?"),'Defaults'),
						input("hide-false","Pause_Move",array("pause() effects movement?"),'Defaults'),
						input("hide-false","Pause_Core",array("pause() effects core functions?"),'Defaults'),
						input("hide-false","Pause_Action",array("pause() effects action methods?"),'Defaults'),
						input("hide-false","Select_Generation",array("Select highest parent generation:"),'Defaults')
						));	
						print "<hr>";
						print input("hide-false","Allow_Throttling",array("Sync to Action objects?"),'',array(
						input("number","Sync_Timeout",array("Timeout (in seconds) for missing action objects:","If action object is removed, set a timeout for breed to look for replacement."),'Allow_Throttling'),
						input("sync-select","Allowed_Types",array("Select action objects to sync with:"),'Allow_Throttling',$actionTypes)						
						));
						print "<hr>";						
						print input("hide-show","Name_Library",array("Name Library"),'',array(
						"<div class='sub-block child-Name_Library' style='display:none;'>".
						input('library','Prefix').
						input('library','Middle').
						input('library','Male_Suffix').
						input('library','Female_Suffix').
						"</div>"		
						));
						print "<hr>";
						print input("hide-show","Strings",array("Strings"),'',array(
						input("text","Gender_Male",array("Define the gender label for male breeds:"),'Strings'),
						input("text","Gender_Female",array("Define the gender label for female breeds:"),'Strings'),
						input("text","Gender_Unisex",array("Define the gender label for unisex breeds:"),'Strings'),
						input("text","Loading_Text",array("Custom loading message:"),'Strings'),
						input("text","Undefined_Value",array("Undefined expressions return this string:"),'Strings')						
						));			
						print "<hr>";
						print input("hide-show","Behaviors",array("Movement Behaviors"),'',array(
						input("select",array("Prim_Material"),array("Prim Material","The object's prim material is how the physics engine determines how the physical object reacts to other primsets, avatars, and terrain."),'Behaviors',array(0=>"stone", 1=>"metal", 2=>"glass", 3=>"wood", 4=>"flesh", 5=>"plastic", 6=>"rubber")),
						input("number","Slope_Offset",array("Offset for AVOID_SLOPES flag:","The AVOID_SLOPES flag detects inclines that are greater than the breed-object's geometric center plus this offset. If the incline is greater than this height, the breed will not attempt to move to that destination, instead calling the avoid callback defined within the method, otherwise silently fails."),'Behaviors',array(0.1)),
						input("number","Move_Timer",array("Frequency of move attempts in seconds:"),'Behaviors',array(0.1)),
						input("hide-false","Finish_Move",array("Finish move before accepting new move requests:"),'Behaviors'),
						input("number","Target_Dist_Min",array("Distance in meters from target destination:"),'Behaviors',array(0.1)),
						input("number","Water_Timeout",array("Time in seconds allowed out of the water:","This value is only used with the 'swim' movement behavior which acts as an occurance counter that counts the number of move attempts (defined by the frequency of the Move_Timer) while the breed is out of the water."),'Behaviors'),
						input("number","Move_Attempts",array("Max attempts to reach it's destination:"),'Behaviors'),
						input("hide-false","Allow_Drift",array("Allow breed to drift beyond it's destination:"),'Behaviors'),
						input("hide-false","Anim_Each_Move",array("Each move attempt will trigger a synced animation:"),'Behaviors'),
						input("hide-false","End_Move_Physics",array("Remain physical after physical movement:"),'Behaviors'),
						input("hide-false","Legacy_Prims",array("Use legacy prim system:"),'Behaviors')
						));
						print "<hr>";
						print input("hide-show","Speed",array("Speed & Gravity"),'',array(
						input("number","Ground_Friction",array("Ground Friction:"),'Speed',array(0.1)),
						input("number","Turning_Speed",array("Turning Speed:"),'Speed',array(0.1)),
						input("number","Turning_Time",array("Turning Time:"),'Speed',array(0.1)),
						input("number","Speed_setpos",array("Speed for move() type: setpos"),'Speed',array(0.1)),
						input("number","Speed_nonphys",array("Speed for move() type: nonphys"),'Speed',array(0.1)),
						input("number","Speed_nonphysUp",array("Speed for move() type: nonphysUp"),'Speed',array(0.1)),
						input("number","Speed_walk",array("Speed for move() type: walk"),'Speed',array(0.1)),
						input("number","Gravity_walk",array("Gravity for move() type: walk"),'Speed',array(0.1)),
						input("number","Speed_run",array("Speed for move() type: run"),'Speed',array(0.1)),
						input("number","Gravity_run",array("Gravity for move() type: run"),'Speed',array(0.1)),
						input("number","Speed_jump",array("Speed for move() type: jump"),'Speed',array(0.1)),
						input("number","Gravity_jump",array("Gravity for move() type: jump"),'Speed',array(0.1)),
						input("number","Speed_swim",array("Speed for move() type: swim"),'Speed',array(0.1)),
						input("number","Gravity_swim",array("Gravity for move() type: swim"),'Speed',array(0.1)),
						input("number","Speed_hop",array("Speed for move() type: hop"),'Speed',array(0.1)),
						input("number","Gravity_hop",array("Gravity for move() type: hop"),'Speed',array(0.1)),
						input("number","Speed_hover",array("Speed for move() type: hover"),'Speed',array(0.1)),
						input("number","Gravity_hover",array("Gravity for move() type: hover"),'Speed',array(0.1)),
						input("number","Speed_fly",array("Speed for move() type: fly"),'Speed',array(0.1)),
						input("number","Gravity_fly",array("Gravity for move() type: fly"),'Speed',array(0.1)),
						input("number","Speed_float",array("Speed for move() type: float"),'Speed',array(0.1)),
						input("number","Gravity_float",array("Gravity for move() type: float"),'Speed',array(0.1))
						));
					print "</div>";
				print "</div>";
			print "</span>";
			}
		print "</div>";
	print "</div>";
	print "</div>";

	print "<div class='widget-wrapper'>";
	//ACTION RULES
	$input_class = 'action-rules-input';
	$ACTION_RULE = (int)$_POST['action_rules_index'];
	$rulesets = $my_species['action_rules'];	
	$select_rules = '<select id="alt-action-rules" style="width: 200px;padding: 5px;border: 1px solid #DCDCE9;">';
	$select_rules .=  "<option selected>-</option>";
	for($i=0;$i<count($rulesets);$i++){
		if($rulesets[$i]['Configuration_Name']!=""){
			$select_rules .= "<option action-rule='$i' s='$species_index'>".$rulesets[$i]['Configuration_Name']."</option>";
		}
	}
	$select_rules .= '</select>';
	$next = count($rulesets);
	if(isset($_POST['action_rules_index'])){$show_select="";$show_input="display:none;";}
	else{$show_select="display:none;";$show_input="";}
	if($ACTION_RULE==count($rulesets) || !count($rulesets)){
		$default = array();
		$result=mysql_query("DESCRIBE action_rules", $link);
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			if($row['Field']=='Configuration_ID'){$row['Default']="Not Set";}
			if($row['Field']=='species_index'){$row['Default']=$species_index;}
			if($row['Field']=='Actions'){$row['Default']="start/:say(Hello, %owner_name%!)";}
			if($row['Field']=='Text_String'){$row['Default']="eco.action v%version% \n by %creator%";}
			$default = array_merge($default,array($row['Field']=>$row['Default']));
		}
		$rulesets[$ACTION_RULE]=$default;
	} 
	else{
		$reset_delete = "<div class='sub-block' align='center' style='padding: 5px;'><a style='color: red; font-weight:bold;' s='$species_index' id='delete-action-rules' this='$ACTION_RULE'>delete configuration</a> | <a style='color: orangered;' s='$species_index' id='reset-action-rules' this='$ACTION_RULE'>reset to default</a></div>";//delete | reset
	}
	$rules = $rulesets[$ACTION_RULE];
	print "<div class='seperator' style='height: 50px;'>";
		print "<div class='label expand' style='margin-top: 0px;width:590px;'>";
			print "<p class='sub-up hang sit' style='margin-left: 20px;color:#666;'>Action Settings: ".minmax($next,'action_config')."</p>";
			if($allow){print "<a style='margin-left: 20px;color: orangered;' id='action-rules-add-new' s='$species_index' next='$next'>new configuration</a>";}
			print '<div style="position: absolute;top: 0px;right: 150px;">';
				print $select_rules;
				print "<span style='$show_select position: absolute;width: 140px;right: -150px;top: 0px;'>";
					print "<button this='$ACTION_RULE' id='save-action-rules' s='$species_index' disabled style='padding: 5px 10px;'>Save</button> "; 
					print "<button id='cancel-action-rules' style='padding: 5px 10px;'>Cancel</button>";
				print "</span>";
			print '</div>';
			if(isset($_POST['action_rules_index'])){
				print "<span style='$show_select' id='action-rules'>";
					print input("actions","Actions");
					print "<div class='sub-box' style='margin-left: 10px;'>";
						print $reset_delete;
						print input("text","Configuration_Name",array("Configuration Name:","Used to identify this configuration."));
						print "<hr>";
						print input("readonly","Configuration_ID",array("Configuration ID:","Used to identify this configuration."));
						print "<hr>";	
						print input("text","Action_Type",array("Action Type: <em>(optional)</em>"));
						print "<hr>";	
						print input("hide-false","Show_Text",array("Show hover text over <strong>action</strong> object?"),'',array(
							input("text-string","Text_String",array("Hover text:"),'Show_Text'),
							input("text","Text_Color",array("Text color:"),'Show_Text')
							));
						print "<hr>";	
						print input("hide-zero","Food_Level",array("Set a food level to create a food source:","Units of food. Set to '0' to disable. Set to '-1' for unlimited food."),'',array(
							input("number","Food_Quality",array("Food Quality:"," How many points each food unit is worth."),'Food_Level'),
							input("number","Food_Threshold",array("Self destruct when food level is less than:","Set 0 to disable."),'Food_Level'),
							input("hide-false","Reserve_Food",array("Reserve for extensions only?"),'Food_Level')
							));
						print "<hr>";	
						print input("hide-false","Allow_Breeding",array("Allow this to be a breeding source?"),'',array(
							input("number","Limit_Rezzed",array("Limit the number of offspring:","-1 = Unlimited"),'Allow_Breeding'),
							input("hide-false","Breed_Maxed_Die",array("Self destruct when max offspring is created?"),'Allow_Breeding'),
							input("hide-false","Breed_One_Family",array("Reserve for one breeding pair?"),'Allow_Breeding'),
							input("text","Breed_Object",array("Offspring object name:","Leave blank to auto-detect."),'Allow_Breeding')
							));
						print "<hr>";	
						print input("hide-false","Allow_Rebuild",array("Allow breeds to be rebuilt?"),'',array(
							input("number","Rebuild_Max",array("How many breeds to provide rebuild support for:"),'Allow_Rebuild'),
							input("select",array("Status"),array("Rebuild based on status:"),'Allow_Rebuild',array( 0=>"Active", 1=> "Not Responding", 2 => "Both" )),
							input("hide-false","Dead_Breeds",array("Rebuild dead breeds?"),'Allow_Rebuild'),
							input("text","Rebuild_Object",array("Rebuild object name:","Leave blank to auto-detect."),'Allow_Rebuild')
							));
						print "<hr>";	
						print "<div class='sub-block' align='center' style='padding: 5px;'>";
							print "<a style='color: orangered; font-weight:bold;display:none;' class='advanced-action-rules' this='$ACTION_RULE'>hide advanced</a>";
							print "<a style='color: orangered; font-weight:bold;' class='advanced-action-rules' this='$ACTION_RULE'>show advanced</a>";
						print "</div>";
						print "<div id='advanced-action-rules-toggle' style='display:none;'>";
							print input("hide-show","Defaults",array("Hide/Show default settings:"),'',array(
							input("text","Version",array("Action version:","For version control."),"Defaults"),
							input("number","Activation_Param",array("Secure rez start_param:"),"Defaults"),
							input("hide-false","Self_Destruct",array("Self-destruct if authentication fails?"),"Defaults"),
							input("hide-false","Owner_Only",array("Restrict communications to owner-only?"),"Defaults"),
							input("select",array("Touch_Events"),array("Define action touch events:","Action touch events can be created and toggled based on the name or description of the prim touched or it's link number."),"Defaults",array(0=>"None",1=>"Object Name",2=>"Object Desc",3=>"Link Number")),
							input("number","Limit_Requests",array("Limit the number of pending requests:"),"Defaults"),
							input("number","Breed_Limit",array("Limit number of breeds:","-1 for unlimited"),"Defaults"),
							input("number","Breed_Timeout",array("Breed timeout:","Time in seconds for a breed to respond before allowing other breeds to interact."),"Defaults"),
							input("text","Desc_Filter",array("Match keyword: <em>(optional)</em>", "Ignore breeds that do not have a matching keyword in their object description field. Leave blank to disable this filter."),"Defaults")
							));	
							print "<hr>";
							print input("hide-show","Offsets",array("Hide/Show rez offsets:"),'',array(
							input("number","Radius",array("Radius:","Radius, in meters, to rez child/rebuilt breeds. You can not set this value higher than 10 or the rezzing will silently fail."),'Offsets',array(0.1)),
							input("number","Height",array("Height:","Height from the action's root center from which breeds are rezzed."),'Offsets',array(0.1)),
							input("text","Offset",array("Position Offset:","The position offset from which breeds are rezzed from the root prim's center. You can not set any value higher than 10 or the rezzing will silently fail."),'Offsets'),
							input("text","Rot",array("Rotational Offset:","The rotational offset from which breeds are rezzed, in euler vector format, which is later translated into radians based on the rez patten."),'Offsets'),
							input("number","Pattern",array("Circle size:","Number of rez locations around the offset. Set to 0 to auto-scale per litter."),'Offsets'),
							input("number","Arc",array("Define the arc of the circle:","'1.0' is a round circle. Greater than '1.0' creates an arc on the x axis. Less than '1.0' creates an arc on the y axis."),'Offsets',array(0.1))
							));	
							print "<hr>";
							print input("hide-show","Strings",array("Hide/Show menu strings:"),'',array(
							input("number","Touch_Length",array("Time in seconds to hold for menu:"),'Strings'),
							input("textarea","Message",array("Message in the breed selection menu:"),'Strings'),
							input("text","Button_Next",array("Define the 'NEXT' button:"),'Strings'),
							input("text","Button_Prev",array("Define the 'PREV' button:"),'Strings'),
							input("textarea","Confirm_Message",array("Message in the confirmation popup:"),'Strings'),
							input("text","Button_Confirm",array("Define the 'CONFIRM' button:"),'Strings'),
							input("text","Button_Cancel",array("Define the 'CANCEL' button:"),'Strings')
							));	
						print "</div>";
					print "</div>";
				print "</span>";
			}
		print "</div>";
	print "</div>";
	print "</div>";

	print "<div class='widget-wrapper'>";
	//AUTHORIZED USERS
	if($username == $species_creator){
		$authorized = $my_species['authorized_users'];
		print "<div class='seperator' style='height: 50px;'>";
			print "<div class='label' style='margin-top: 0px;width:590px;'>";
				print "<p class='sub-up hang sit' style='margin-left: 20px;color:#666;'>Authorized Users:  ".minmax(count($authorized),'users')."</p>";
				print "<div s='$species_index' id='add-authorized-user' style='position: absolute;top: 0px;right: 150px;' title='Give another user the permission to modify this species.'>";
					if($allow){print "<input class='wide-input'/><button disabled>Add</button><span></span>";}
				print "</div>";
				print "<div id='auth-users'>";
				for($i=0;$i<count($authorized);$i++){
					print "<div class='auth-user'><input class='wide-input' value='".$authorized[$i]['user_name']."' readonly/><a>remove</a></div>"; 
				}
				print "</div>";
			print "</div>";
		print "</div>";
	}
	print "</div>";
	
}
elseif(isset($_POST['b'])){//BREEDS table
	$results_filter = explode(";;",$_POST['b']);	 
	get_json(array("breeds" => "all", "filter_status" => str_replace("filter-breeds-", "", $results_filter[1]), "filter_species" => str_replace(array("filter-species-","_"), array(""," "), $results_filter[0])));
	$my_stats = $json['eco']['user'][0];
	$all_breeds = $json['eco']['breeds'];
	$options=array("months","days","hours","minutes","never");
	$inactive_data = Time_Array($my_stats['inactive_remove']);
	$dead_data = Time_Array($my_stats['dead_remove']);
	$inserted=0;
	if(count($all_breeds)){
		$print_table = "
		<table style='width:100%;margin-bottom:40px;' class='all-breed'>
			<tr style='height: 25px;'>
				<th id='all-breed-name' class='all-breed'>Breed Name</th>
				<th id='all-breed-gender' class='all-breed'>Gender</th>
				<th id='all-breed-age' class='all-breed'>Age</th>
				<th id='all-breed-status' class='all-breed'>Status</th>
			</tr>";
			for($i=0;$i<count($all_breeds);$i++){				
				$species = implode("_",explode(" ",$all_breeds[$i]['breed_species']));
				$dead = (int)$all_breeds[$i]['breed_dead'];
				$not_responding = ((time()-(int)$all_breeds[$i]['breed_update'])>$Limitations["Response_Timeout"]);				
				$name = $all_breeds[$i]['breed_name'];
				if($name==""){$name="None";}
				$breed_id = $all_breeds[$i]['breed_id'];
				$skins = $all_breeds[$i]['breed_skins'];
				$breed_index = $all_breeds[$i]['breed_index'];
				$age = $all_breeds[$i]['breed_age'];
				$gender = $all_breeds[$i]['breed_gender'];
				$owner = implode("_",explode(" ",$all_breeds[$i]['breed_owner']));
				$died = "LIVE";
				$breeds = "alive";
				if($dead>0){$died="Died: ".date("M d, Y",$dead);$breeds = "dead";}
				elseif($not_responding){$died="Not Responding";$breeds = "inactive";}
				$inserted++;
				$print_table .= "<tr style='height:25px;' 
				class='all-breed-sortable' 
				all-breed-name='$name'
				all-breed-gender='$gender'
				all-breed-age='$age'
				all-breed-status='$died'
				all-breed-index='$i'
				breeds='$breeds'
				species='$species'
				owner='$owner'
				>
					<td style='width:35%;'><input a='$breed_index' class='checkbox' type='checkbox' /><a a='$breed_index' breed_id='$breed_id' class='all_breed_index' style='margin-left:10px;font-weight:bold;'>".str_replace(" ","&nbsp;",$name)."</a></td>
					<td style='text-align:center;'>$gender</td>
					<td style='text-align:center;'>$age</td>
					<td style='text-align:center;'>$died</td>
				</tr>";				
			}
		$print_table .= "</table>
		<div style='height:20px;position:absolute;bottom:10px;left: 10px;'>
			<img src='img/arrow_acct.png' style='margin-left: -8px;'/>
			<a class='check-all' style='font-size:1.0em;margin-right:5px;' type='a'>Select All</a> / 
			<a class='check-none' style='font-size:1.0em;margin-left:5px;' type='a'>Select None</a> 
			<a style='margin-left:20px;color:red;font-weight:bold;' class='check-del' type='a' onmouseover=\"this.style.color='orangered';\" onmouseout=\"this.style.color='red';\" >Delete Selected</a> 
		</div>";
	}
	else{
		die("<p align='center' style='color:orangered;'>No results found!</p>");
	}//no results
	print "<div style='width: 90%;margin-left: auto;margin-right: auto;padding-top: 10px;'>";
		$species_filter = str_replace(array("filter-species-","_"),array(""," "),$results_filter[0]);
		$breeds_filter = str_replace(array("filter-breeds-","_"),array(""," "),$results_filter[1]);
		if($species_filter=="all"){$species_filter="";}
		print "<h2 style='margin: 0.2em 0;'>Displaying $breeds_filter $species_filter <span style='sub-in'>($inserted)</span></h2>";
		if($breeds_filter=="inactive" || $breeds_filter=="all"){
			print "<p style='position:relative;'>Delete <span style='font-weight:bold;font-size: 1.2em;'>inactive breeds</span> after &nbsp; ";
				print "<span style='position: absolute;right: 50px;top: -5px;'>";
					print "<input id='inactive-time' style='width:60px;' value='".$inactive_data[0]."'/> ";
					print "<select id='inactive-type'>";
						print "<option selected>".$inactive_data[1]."</option>";
						for($i=0;$i<count($options);$i++){
							if($inactive_data[1]!=$options[$i]){print "<option>".$options[$i]."</option>";}
						}
					print "</select>";
					print "<button id='inactive-set' disabled='disabled'>Set</button> ";
					print "<img src='img/help.png' title='This setting allows you to automatically delete the records of breeds that stop responding after this amount of time. If the breed reconnects to the grid after the record is destroyed, it will create a new record.' style='margin-bottom: -2px;'/>";
				print "</span>";
			print "</p>";
		}
		if($breeds_filter=="dead" || $breeds_filter=="all"){
			print "<p style='position:relative;'>Delete <span style='font-weight:bold;font-size: 1.2em;'>dead breeds</span> after &nbsp; ";
				print "<span style='position: absolute;right: 50px;top: -5px;'>";
					print "<input id='dead-time' style='width:60px;' value='".$dead_data[0]."'/> ";
					print "<select id='dead-type'>";
						print "<option selected>".$dead_data[1]."</option>";
						for($i=0;$i<count($options);$i++){
							if($dead_data[1]!=$options[$i]){print "<option>".$options[$i]."</option>";}
						}
					print "</select>";
					print "<button id='dead-set' disabled='disabled'>Set</button> ";
					print "<img src='img/help.png' title='This setting allows you to automatically delete the records of dead breeds after this amount of time. If the breed reconnects to the grid after the record is destroyed, it will create a new record.' style='margin-bottom: -2px;'/>";
				print "</span>";
			print "</p>";
		}
	print "</div>";
	if($inserted){
		die($print_table);
	}//print table
	else{
		die("<p align='center' style='color:orangered;'>No results found.</p>");
	}//no results
}
elseif(isset($_POST['a'])){//BREED profile
	$val = (int)$_POST['a'];
	get_json(array("breeds" => $val));
	$breed = $json['eco']['breeds'][0];
	$name = $breed['breed_name'];
	$breed_id = $breed['breed_id'];
	$species = $breed['breed_species'];
	$creator = $breed['breed_creator'];
	$pos = $breed['breed_pos'];
	$pos=str_replace(array("<",">"),"",$pos);
	$vec=explode(", ",$pos);
	$region = urlencode($breed['breed_region']);
	$slurl = "http://slurl.com/secondlife/".$region."/".(int)($vec[0])."/".(int)($vec[1])."/".(int)($vec[2]);
	$owner = $breed['breed_owner'];
	$family = $breed['breed_family'];
	$gender = $breed['breed_gender'];
	$generation = $breed['breed_generation'];
	$age = number_format($breed['breed_age']);
	$born = $breed['breed_born'];
	$time =date("g:i A T",$born);
	$then =date("M d, Y",$born);
	$now =date("M d, Y",time());
	$partner = $breed['breed_partner'];
	$parents = $breed['breed_parents'];
	$litters = $breed['breed_litters'];
	$hunger = $breed['breed_hunger'];
	$debug_this = explode('-',$breed['debug_this']);
	$skins = splitSkins($breed['breed_skins']);	
print "<div style='padding: 20px 40px;font-family: monospace;font-size: 1.4em;'>";
	//menu
	print "<div style='text-align:center;height:35px;'>";
		print "<a id='all_breed_rebuild' a='$val' >rebuild this breed</a>";
		print " | ";
		print "<a id='all_breed_delete' a='$val' class='$breed_id' style='color:orangered;'>delete this breed</a>";
	print "</div>";
	//name
	print "<div class='seperator'>";
		print "<div class='label'>Name:</div> ";
		print "<input id='all_breed_name' class='wide-input' style='font-size:1.3em;font-weight:bold;' value='$name' />";
		print "<button id='all_breed_name_save' a='$val' class='$breed_id' disabled >";
		print "Set Name";
		print "</button>";
	print "</div>";
	//species
	print "<div class='seperator'>";
		print "<div class='label' style='margin:0;'>Species:</div>";
		print "$species by ".ucwords($creator);
	print "</div>";
	//location
	print "<div class='seperator'>";
		print "<div class='label' style='margin:0;'>Location:</div>";
		print "<a href='$slurl' target='_blank'>$slurl</a>";
	print "</div>";
	//owner
	print "<div class='seperator'>";
		print "<div class='label' style='margin:0;'>Owner:</div>";
		print ucwords($owner);
	print "</div>";
	//gender
	print "<div class='seperator'>";
		print "<div class='label' style='margin:0;'>Gender:</div>";
		print Gen($generation)." Generation $gender";
	print "</div>";
	//age
	if($born=="0"){
		print "<div class='seperator'>";
			print "<div class='label' style='margin:0;'>Age:</div>";
			print "Unborn";
		print "</div>";
	}
	else{
		$born="on ".$then;
		if($then==$now){$born="Today";}
		print "<div class='seperator'>";
			print "<div class='label' style='margin:0;'>Age:</div>";
			print "$age years old. Born ".$born." at $time";
		print "</div>";
	}
	//partner
	if($partner!=""){
		print "<div class='seperator'>";
			print "<div class='label' style='margin:0;'>Partner:</div>";
			print findName($partner);
		print "</div>";
	}	
	//parents
	if((int)$generation>1){
		print "<div class='seperator'>";
			print "<div class='label' style='margin:0;'>Parents:</div>";
			print pullNames($parents);
		print "</div>";
	}
	//litters
	if($gender!="Male"){
	print "<div class='seperator'>";
		print "<div class='label' style='margin:0;'>Litters:</div>";
		print "$litters";
	print "</div>";
	}
	//skins-active
	if($skins[0]!=""&&$skins[0]!="None"){
		print "<div class='seperator'>";
			print "<div class='label' style='margin:0;'>Skins:</div>";
			print "<div style='display: inline-block;'>".$skins[0]."</div>";
		print "</div>";
	}
	//skins-dormant
	if($skins[1]!=""&&$skins[1]!="None"){
		print "<div class='seperator'>";
			print "<div class='label' style='margin:0;'>Dormant:</div>";
			print "<div style='display: inline-block;'>".$skins[1]."</div>";
		print "</div>";
	}
	//debug
	if((float)$breed['breed_version']>=1.0){
		print "<div id='debug_this' a='$val' class='seperator'>";
			print "<div class='label'>Diagnostics: <button disabled>Update</button></div> ";
			$types = array("func","Growth,Hunger,Rez,Animate,Attach","comm","Event Calls","event","Method Calls","process","Breeding","id","Breed Creation");
			for($i=0;$i<count($debug_this);$i++){
				$found = array_search($debug_this[$i],$types);
				if($found!==false){
					print "<p><input type='checkbox' value='".$types[$found]."' checked /> ".$types[$found+1]."</p>";		
					unset($types[$found]);	
					unset($types[$found+1]);		
					$types=array_merge(array(),$types);
				}
			}
			for($i=0;$i<count($types);$i+=2){
				print "<p><input type='checkbox' value='".$types[$i]."' /> ".$types[$i+1]."</p>";				
			}
		print "</div>";
	}
print "</div>";
}
else{//PAGE COMPILE
	get_json(array("species" => "all"));
	$my_stats = $json['eco']['user'][0];
	$my_species = $json['eco']['species'];
	$Version = $my_stats['version'];
	$subscription = $my_stats['host_plan'];
	// hosting
	if($subscription!="Basic"){
		$expires="(Expires: ".date("l F d, Y",$my_stats['host_expire']).")";
	}
	//version
	// && array_search($username,array("dev khaos", "ecobreeder resident", "badpeaches blackheart"))!==false
	if((float)$Version<(float)$Limitations["Eco_Version"]){$updateVersion = "<a class='upgrade-now external'  style='font-size: 0.9em;'>Upgrade to v".$Limitations["Eco_Version"]."</a>";}
	if((float)$Version!=(float)$Limitations["Eco_Stable"]){$updateVersion .="<p title='This message will be removed when this version is production ready.' style='color:red;font-size: 0.9em;margin-left: 160px;'>This version has been flagged as <strong>EXPERIMENTAL</strong></p>";}
	//print user profile
	print "<div class='user-profile'>";
		print "<div class='line'><div><label>$username <a id='eco-logout' style='color: #0F67A1!important;cursor:pointer!important;'>Sign out</a></label></div></div>";//name
		if((float)$Version>0){
			$Create_Species = "<option s='0'>*CREATE NEW*</option>";
			print "<p><strong style='color:#666;'>Stack Version:</strong><span class='sub-up'>eco breeds v$Version &nbsp; $updateVersion</span></p>";
			print "<p><strong style='color:#666;'>Hosting Plan:</strong><span class='sub-up'>$subscription</span> &nbsp; <span style='font-size: 0.85em;'>$expires</span></p>";
		}
		if(count($my_species)){
				print "<p><strong style='color:#666;'>Species:".minmax((int)$my_stats['species_count'],'species')."</strong>";
				print "<select id='species-selector' class='wide-input'>";
				print "<option selected>-</option>";
				$limit = $Limitations[$subscription]['species'];
				if((float)$Version>=1.0&&($limit>count($my_species) || $limit==-1)){print $Create_Species;}
				for($i=0;$i<count($my_species);$i++){
						$add="";
					if($my_species[$i]['species_creator']!=$username){
						$add=" (".$my_species[$i]['species_creator'].")";
					}
					print "<option s='".$my_species[$i]['species_index']."'>".$my_species[$i]['species_name'].$add."</option>";
				}
				print "</select>";
				print "<button id='species-cancel' disabled>Cancel</button>";
				print "</p>";	
			}
		elseif((float)$Version>=1.0){
				print "<div class='new-species content-tabs'><a s='0'>Click here to create a species.</a></div>";
			}
		else{
			print "<div align='center' class='safe-link' style='padding:50px 0;'><a show='about' style='font-family:monospace;color:orangered;'>You must be an authorized user to access this area.</a></div>";
		}
		print "<div class='content-tabs' id='content-temp-species' style='display:none;'></div>";	
		if((int)$my_stats['breed_count']>0){
				print "<p id='breed-filter'>";
					print "<strong style='color:#666;'>Breeds:".minmax((int)$my_stats['breed_count'],'breeds')."</strong>";		
					print "<select class='wide-input' style='width: 150px;'>
					<option class='ignore' selected>-display-</option>
					<option class='filter-species-all'>All Species</option>
					".dropdown_type($my_species,"species_name","species")."
				</select>	";	
					print "<select class='wide-input' style='width: 150px;'>
					<option class='ignore'>-status-</option>
					<option class='filter-breeds-all'>All</option>
					<option class='filter-breeds-alive'>Alive</option>
					<option class='filter-breeds-dead'>Dead</option>
					<option class='filter-breeds-inactive'>Inactive</option>
				</select>";
					print "<button id='breeds-display' disabled>Display</button>";
				print "</p>";
				print "<div class='content-tabs' id='content-temp-breed' style='display:none;'></div>";
			}
		if($json_raw!="" && $admin_status){
			print "<p><strong>Your results:</strong> 		<a id='toggle-json' style='text-decoration:none;'>Toggle Results</a></p>";
			print "<div id='json-container' style='height:500px;overflow:scroll;display:none;'>".big_code($json_raw)."</div>";
		}
	print "</div>";
}

?>