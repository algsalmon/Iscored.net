<?php
include("include/php_includes_top.php");

$strMSG = "";
$strHead = "Payment Successful";
$strMSG = "Thank you for your payment!  Your transaction has been completed. A receipt for your purchase has been emailed to you. <br><br>";
$strMSG .= "If your Purchased Video is not available, then please our support. Thanks";
include("message.php");
die();

include("include/php_includes_bottom.php");
?>
