<?php 
include("include/php_includes_top.php"); 

if(isset($_REQUEST['memid'])){
	$chk = IsExist("mem_id", "members", "mem_id", $_REQUEST['memid']);
	$strHead = "Email Confirmation";
	$strMSG = "No record found.";
	if ($chk == 1){
		$chkCon = returnName("mem_confirm", "members", "mem_id", $_REQUEST['memid']);
		if($chkCon == 0){
			$strQRY="UPDATE members SET mem_confirm = 1 WHERE mem_id = ".$_REQUEST['memid'];
			$nRst=mysql_query($strQRY) or die("Unable 2 Update Record");
			$strHead = "Email Confirmation";
			$strMSG = "Your email has been confirmed successfully. <a href=\"login.php\" title=\"Login\">Click Here</a> to login.";
		}
		else{
			$strHead = "Email Confirmation";
			$strMSG = "Your email address is already confirmed. <a href=\"login.php\" title=\"Login\">Click Here</a> to login.";
		}
	}
	else{
		$strHead = "Email Confirmation";
		$strMSG = "No record found.";
	}
	include("message.php");
	die();
}
?>

