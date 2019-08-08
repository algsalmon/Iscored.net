<?php

/*if(isset($btnAdd)){
	$vidid = getMaximum("cards","card_id");
	$dirName = "videos/main";
	$thumbfileName = "";
	$mfileName = "";
	if (!empty($_FILES["mFile"]["name"])){
		$mfileName = $vidid."_".$_FILES["mFile"]["name"];
		@move_uploaded_file($_FILES['mFile']['tmp_name'], $dirName."/".$mfileName);
	}
	mysql_query("INSERT INTO cards(card_id, card_name, card_price, card_thumb, card_swf, card_width, card_height, card_views, card_keywords, card_dateadded, card_addedby, status_id) VALUES(".$cardid.", '".$txtname."', '".$txtprice."', '".$thumbfileName."', '".$mfileName."', ".$txtwidth.", ".$txtheight.", ".$txtviews.", '".$txtkeywords."', '".@date("Y-m-d")."', ".$_SESSION['UID'].", 0)") or die(mysql_error());
	header("Location: manage_cards.php?op=1");
}*/

print("instId: ".$_REQUEST['instId']."<br>");
print("cartId: ".$_REQUEST['cartId']."<br>");
print("currency: ".$_REQUEST['currency']."<br>");
print("amount: ".$_REQUEST['amount']."<br>");
print("desc: ".$_REQUEST['desc']."<br>");
print("testMode: ".$_REQUEST['testMode']."<br>");
print("MC_callback: ".$_REQUEST['MC_callback']."<br>");
print("MC_orderID: ".$_REQUEST['MC_orderID']."<br>");

?>