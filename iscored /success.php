<?php
//	move_uploaded_file($_FILES["vFile"]["tmp_name"], "videos/main/" . $_FILES["vFile"]["name"]);
session_start();
$_SESSION["uniqueFileName"] = $_POST["uniqueFileName"];
$uploaddir = 'temporary/'; 
$file = $uploaddir . $_SESSION["uniqueFileName"]; 
move_uploaded_file($_FILES["vFile"]["tmp_name"], $file);
?>