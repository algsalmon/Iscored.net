<?php
ini_set("register_glocals", "On");
//error_reporting(15);
	$dbDatabase = "iscored";
	$dbServer = "localhost";
	$dbUserName = "root";
	$dbPassword = "";
	//$dbPort = "3306";
	$conn = mysql_connect("$dbServer","$dbUserName","$dbPassword") or die("Unable 2 Connect 2 Database Server"); 
	$db = mysql_select_db("$dbDatabase")  or die("Unable 2 Connect 2 Database"); 
?>