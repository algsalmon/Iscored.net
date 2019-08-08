<?
ob_start();

include("lib/openCon.php");
include("lib/functions.php");
// This version of PayPal's sample IPN code for PHP has been
// modified to use the libcurl (CURL) library instead of fsockopen(),
// which is disabled on shared hosting from CheapCheap.biz and
// other hosting.

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST https://www.paypal.com/cgi-bin/webscr HTTP/1.0\r\n";
//$header .= "POST https://www.sandbox.paypal.com/cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
//$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);

$txn_id = "";
$payment_status = $_POST['payment_status'];
$txn_id = $_POST['txn_id'];
$mt_id = $_POST['invoice'];
$mem_id = $_POST['custom'];

if (!$fp) {
// HTTP ERROR
} else {
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			if($payment_status == "Completed"){
				$status = 1;
			}
			if($payment_status == "Pending"){
				$status = 0;
			}
			if($payment_status == "Failed"){
				$status = 3;
			}
			if($payment_status == "Denied"){
				$status = 4;
			}
			mysql_query("UPDATE orders SET pstatus_id=".$status.", ord_trans_id='".$txn_id."' WHERE ord_id=".$mt_id);
		}
		else if (strcmp ($res, "INVALID") == 0) {
			mysql_query("UPDATE orders SET pstatus_id=5, ord_trans_id='".$txn_id."' WHERE ord_id=".$mt_id);
		}
	}
fclose ($fp);
}

include("lib/closeCon.php");
ob_end_flush();
?>
