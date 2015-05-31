<?php session_start();
if(isset($_GET['id'])){$_SESSION['walkthrough_id']=$_GET['id'];}
if(isset($_GET['num'])){$_SESSION['walkthrough_num']=$_GET['num'];}
?>