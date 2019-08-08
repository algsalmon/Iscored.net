<?php
ob_start();
session_start();
include("lib/openCon.php");
include("lib/functions.php");
include("lib/functions_main.php");
$strMSG="";

if(isset($_REQUEST['option'])){
	switch ($_REQUEST['option']) {
		case 1:
			$isExist = chkExist("ord_id", "orders", " WHERE vid_id=".$_REQUEST['vid']." AND mem_id=".$_SESSION['UserID']); 
			if($isExist!=0){
				print("0||&&You already purchased the same video!");
			}
			else{
				$ordID = getMaximum("orders","ord_id");
				mysql_query("INSERT INTO orders(ord_id, cat_id, mem_id, vid_id, ord_date, pstatus_id) VALUES(".$ordID.", ".$_REQUEST['cid'].", ".$_SESSION["UserID"].", ".$_REQUEST['vid'].", '".@date("Y-m-d")."', 0)");
				print("1||&&".$ordID);
			}
		break;
	}
}


include("lib/openCon.php");
ob_end_flush();
?>
