<?php 
include("include/php_includes_top.php"); 

if(isset($_REQUEST['transStatus'])){
	if($_REQUEST['transStatus'] == 'Y'){
		mysql_query("UPDATE orders SET pstatus_id=1, ord_trans_id='".$_REQUEST['transId']."' WHERE ord_id=".$_REQUEST['cartId']);
		$st_msg = 1;
	}
	else{
		mysql_query("UPDATE orders SET pstatus_id=2 WHERE ord_id=".$_REQUEST['cartId']);
		$st_msg = 2;
	}
}
else{
	$strMSG = "Payment response is not yet received. Please check your mail and contact our support. Thanks";
}

include("include/php_includes_bottom.php"); 
?>
<html>
<head>
	<meta http-equiv="refresh" content="0; url=http://www.i-scored.net/video_viewed.php">
</head>
<body>
Processing...
<br><br>

If page doesn't redirect automatically in 10 seconds then <a href="http://www.i-scored.net/video_viewed.php">Click Here</a>
</body>
</html>