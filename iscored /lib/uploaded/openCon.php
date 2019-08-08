<?php
//error_reporting(15);
	$dbDatabase = "iscored_db";
	$dbServer = "localhost";
	$dbUserName = "iscored_admin";
	$dbPassword = "P@ssw0rd1";
	//$dbPort = "3306";
	$conn = mysql_connect("$dbServer","$dbUserName","$dbPassword") or die("Unable 2 Connect 2 Database Server"); 
	$db = mysql_select_db("$dbDatabase")  or die("Unable 2 Connect 2 Database"); 
?>
