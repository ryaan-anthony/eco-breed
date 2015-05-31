<?php

$user = stripslashes(urldecode($_POST['user']));
$text = stripslashes(urldecode($_POST['text']));

mail('USER@gmail.com',$user,$text);
?>