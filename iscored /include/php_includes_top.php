<?php
ob_start();
session_start();
include("lib/openCon.php");
include("lib/functions.php");
include("lib/functions_main.php");
include("lib/site_settings.php");
/* Instantiate class */
require_once("lib/class.pager1.php"); 
$p = new Pager1;
$strMSG="";
$curr='class="selected"';
$custom = "";

if(!isset($_REQUEST['mid'])){
	$mid=1;
}
else{
	$mid=$_REQUEST['mid'];
}

$getContent_rs = mysql_query("SELECT * FROM menu WHERE menu_id=".$mid);
if(mysql_num_rows($getContent_rs)>0){
	$getContent = mysql_fetch_object($getContent_rs);
	$cntid = $getContent->cnt_id;
}
else{
	$cntid = 0;
}
if(!isset($_SESSION['UserID'])){
	$slowMotion = 1;
}
else{
	if(isset($_REQUEST['vid'])){
		$isCheck = chkExist("ord_id", "orders", "WHERE mem_id=".$_SESSION['UserID']." AND vid_id=".$_REQUEST['vid']." AND pstatus_id=1");
		if($isCheck==0){
			$slowMotion = 1;
		}
		else{
			$slowMotion = 0;
		}
	}
	else{
		$slowMotion = 1;
	}
}

?>
