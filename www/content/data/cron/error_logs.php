<?php

function log_this($ver){
$handle = fopen("../../../remote/$ver/error_log","r");
$text = fread($handle,999999);
fclose($handle);
$handle = fopen("../../../remote/$ver/error_log","w+");
fclose($handle);
if($text!=""){mail('EMAIL@gmail.com',"ERROR(".substr_count($text,"[").") $ver",stripslashes($text));}
}

log_this("1.0");
log_this("0.221");
?>