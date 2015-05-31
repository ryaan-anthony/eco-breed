<?php
function videolink($title,$video){
	return "<p class='expand' style='margin-bottom:0;'><strong>$title:</strong> <a class='title sub-in'> Watch Video </a><span style='margin-left:-10px;' class='video' video='$video'></span></p>";
}
function method_profile($method, $values, $definitions, $example='', $description='', $example2='', $description2='', $example3='', $description3='', $example4='', $description4=''){
	$result= "<div class='sub-pad entry'>";
	$result.= "<p class='method-title' style='margin-bottom: 0;'>$method(<a class='method-tags'>".str_replace(array(" ","[","]"),array("","<tag style='color:gray;'>","</tag>"),$values)."</a>)</p>";
	if(count($definitions)==2){$result.= "<div>";}
	else{$result.= "<div style='padding:10px;'>";}
	for($i=0;$i<count($definitions);$i+=2){
		if($definitions[$i]!=''){$sep = " : ";}
		$result.= "<p class='sub-in hang sit'><strong>".$definitions[$i]." $sep </strong>".$definitions[$i+1]."</p>";
	}
	$result.= "</div>";
	$result.=$example;
	if($description!=""){$result.="<p class='description'>$description</p>";}
	$result.=$example2;
	if($description2!=""){$result.="<p class='description'>$description2</p>";}
	$result.=$example3;
	if($description3!=""){$result.="<p class='description'>$description3</p>";}
	$result.=$example4;
	if($description4!=""){$result.="<p class='description'>$description4</p>";}
	$result.= "</div>";
	return $result;
}
function pageButton($index, $label){
	return "<button page='$index' class='tabs sub-next'>$label</button>";//<button page='$index' class='tabs sub-next-top'>$label</button>
}
function subButton($index, $label){
	return "<a show='howto.$index' style='text-decoration:none;'><button class='sub-tab sub-next'>$label</button></a>";//<button num='$index' class='sub-tab sub-next-top'>$label</button>
}
function backButton($label,$next=0){
	if($next==0){return "<button class='sub-back sub-next'>$label</button>";}//<button num='$index' class='sub-tab sub-next-top'>$label</button>
	return "<button class='sub-back sub-next sub-next-alt'>$label</button><div><div><button num='$next' class='sub-in-btn sub-next'>Next Lesson</button></div></div>";
}
function actions_comment($pre,$mid,$suf){
	if($mid==""){return "<p class='sub-in'><a class='inline sub-up'></a>$pre <strong>$suf</strong></p>";}
	return "<p class='sub-in'><a class='inline sub-up'></a>$pre <a class='title inline sub-up'>$mid</a> $suf</p>";
}
function dep_actions_code($str,$settings=''){
	if($settings!=''){return big_code($settings.'
Actions = [
'.$str.'
];','action');}
	return big_code('Actions = [
'.$str.'
];','action');
}
function actions_code($str){
	$data = explode('",',$str);
	$str="";
	for($i=0;$i<count($data);$i+=2){
		$event=trim(str_replace('"','',$data[$i]));
		$methods=trim(str_replace('"','',$data[$i+1]));
		$str.= "<input style='border:1px dashed #CCC;' readonly class='wide-input' value ='$event' />";
		$str.= "<div class='wide-input textarea-input' readonly >$methods</div>";
	}
	return $str;
}
function normal_code($str, $type=''){
	if($type>0){return "<div class='codeblock' style='height:".$type."px;overflow:auto;font-size:0.9em;'><pre id='".uniqid()."'>$str</pre></div>";}
	if($type=='breed'){return "<div class='codeblock' style='overflow:auto;font-size:0.9em;background: #FFE;'><pre id='".uniqid()."'>$str</pre></div>";}
	if($type=='action'){return "<div class='codeblock' style='overflow:auto;font-size:0.9em;background: #f8fffa;'><pre id='".uniqid()."'>$str</pre></div>";}
	return "<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre id='".uniqid()."'>$str</pre></div>";
}
function big_tag($type){
	return '<tag style="
	position: absolute;
	bottom: 0px;
	right: 5px;
	font-size: 1.3em;
	font-weight: bold;
	color: #DDC;
	font-family: monospace;
	text-transform: uppercase;
	">'.$type.'</tag>';
}
function big_code($str, $type=''){
	if($type=='action'){return "<div class='codeblock' style='overflow:auto;font-size:0.9em;background: #f8fffa;'>".big_tag($type)."<pre id='".uniqid()."'>$str</pre></div>";}
	if($type=='breed'){return "<div class='codeblock' style='overflow:auto;font-size:0.9em;background: #FFE;'>".big_tag($type)."<pre id='".uniqid()."'>$str</pre></div>";}
	return "<div class='codeblock' style='overflow:auto;font-size:0.9em;'><pre id='".uniqid()."'>$str</pre></div>";
}
function normalSetting($name,$default,$desc,$code='',$info='',$altcode='',$altinfo=''){
	$return = "<div class='entry'>";
	if($default!=""){$return .= "<p class='tags'><tag class='sub-up'>$default</tag></p>";}
	if($name!=""){$return .= "<p class='title'>$name</p>";}
	$return .= "<div style='padding:0 10px;'>";
	if($desc!=""){
		if($code!=""){$return .= "<p class='sub-in sit'>&nbsp; $desc</p>";}
		else{$return .= "<p class='sub-in'>&nbsp; $desc</p>";}
	}
	if($code!=""){$return .= big_code($code);}
	if($info!=""){$return .= "<p class='sub-in hang' style='color:#888;'>&nbsp; $info</p>";}
	if($altcode!=""){$return .= big_code($altcode);}
	if($altinfo!=""){$return .= "<p class='sub-in hang' style='color:#888;'>&nbsp; $altinfo</p>";}
	$return .= "</div>";
	$return .= "</div>";
	return $return;
}
function breedSetting($name,$default,$desc,$code='',$info='',$altcode='',$altinfo=''){
	$return = "<div class='entry'>";
	if($default!=""){$return .= "<p class='tags'><tag class='sub-up'>$default</tag></p>";}
	if($name!=""){$return .= "<p class='title'>$name</p>";}
	$return .= "<div style='padding:0 10px;'>";
	if($desc!=""){
		if($code!=""){$return .= "<p class='sub-in sit'>&nbsp; $desc</p>";}
		else{$return .= "<p class='sub-in'>&nbsp; $desc</p>";}
	}
	if($code!=""){$return .= big_code($code,'breed');}
	if($info!=""){$return .= "<p class='sub-in hang' style='color:#888;'>&nbsp; $info</p>";}
	if($altcode!=""){$return .= big_code($altcode,'breed');}
	if($altinfo!=""){$return .= "<p class='sub-in hang' style='color:#888;'>&nbsp; $altinfo</p>";}
	$return .= "</div>";
	$return .= "</div>";
	return $return;
}
function actionSetting($name,$default,$desc='',$code='',$info='',$altcode='',$altinfo=''){
	$return = "<div class='entry'>";
	if($default!=""){$return .= "<p class='tags'><tag class='sub-up'>$default</tag></p>";}
	if($name!=""){$return .= "<p class='title'>$name</p>";}
	$return .= "<div style='padding:0 10px;'>";
	if($desc!=""){
		if($code!=""){$return .= "<p class='sub-in sit'>&nbsp; $desc</p>";}
		else{$return .= "<p class='sub-in'>&nbsp; $desc</p>";}
	}
	if($code!=""){$return .= big_code($code,'action');}
	if($info!=""){$return .= "<p class='sub-in hang' style='color:#888;'>&nbsp; $info</p>";}
	if($altcode!=""){$return .= big_code($altcode,'action');}
	if($altinfo!=""){$return .= "<p class='sub-in hang' style='color:#888;'>&nbsp; $altinfo</p>";}
	$return .= "</div>";
	$return .= "</div>";
	return $return;
}
function wttabline($head,$body,$big=FALSE){
	$size = '1.0em';
	if($big){$size = '1.4em';}
    return "<h1 style='font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;font-size: 2.3em;margin: 0.1em 0;text-transform: capitalize;' align='center'>$head</h1><p class='hang' align='center' style='font-size: $size;font-family: Consolas, Menlo, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace, serif;'>$body</p>";
}
function howToIMG($title,$img,$height=200){
	return "<p class='howto-img-txt' style='height:".$height."px;'>&bull; $title <a title='Click to Enlarge' href='http://eco.takecopy.com/img/howto/$img.png' target='_blank'><img src='img/howto/$img.png' class='howto-img'/></a></p>";
}
function wtheadline($head,$body){
	return "<div style=''><h3 style='display: inline;margin-left: 10px;'>$head</h3><p style='display: inline;color: #666;font-size: 0.9em;'> $body</p></div>";
}
function insertlogo(){
	return '<div align="center"><img class="eco-breed-object" src="img/eco-big0.png" style="height: 100px;"></div>';
}
function premium_stamp(){
	return "<span style='margin-right:10px;font-weight:bold;font-size:0.7em;color:#e9b911;cursor:default;' title='Premium Eco Extension'>PREMIUM</span>";
}
function listItem($title,$desc=''){
	return "<p style='font-size:1.0em;margin-bottom:0;'><tag style='font-size:25px;vertical-align:middle;'>&bull;</tag> $title</p><p style='font-size:0.9em;margin:0;'>  $desc</p>";
}
function toggle_example($label, $example, $type){
	return "<p class='sub-in sit wthide'>$label: <a>show $type</a> <div class='wtshow' style='display:none;'>$example</div></p>";
}
?>