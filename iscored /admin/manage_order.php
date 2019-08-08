<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
/* Instantiate class */
require_once("../lib/class.pager1.php"); 
$p = new Pager1;
$strMSG = "";

if(isset($_REQUEST['pStatus'])){
	$_SESSION['pStatus'] = $_REQUEST['pStatus'];
}
else{
	if(!isset($_SESSION['pStatus'])){
		$_SESSION['pStatus'] = 0;
	}
}

if(isset($_REQUEST['btnEdit'])){
	mysql_query("UPDATE orders SET pstatus_id=".$_REQUEST['txtpstatus'].", ord_trans_id='".$_REQUEST['txttransid']."' WHERE ord_id=".$_REQUEST['ord_id']);
	header("Location: manage_order.php?op=2");
}
elseif(isset($_REQUEST['action'])){
	if($_REQUEST['action'] == 2){
		$FormHead = "Edit Order's Information";
		$brs = mysql_query("SELECT * FROM orders WHERE ord_id = ".$_REQUEST['ord_id']);
		if(mysql_num_rows($brs) > 0){
			$brow = mysql_fetch_object($brs);
			$txtpstatus = $brow->pstatus_id;
			$txttransid = $brow->ord_trans_id;
		}
	}
}

if(isset($op)){
	switch ($op) {
		case 1:
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$strMSG = "Record Updated Successfully";
			break;
	}
}
/*if(isset($_SESSION["OType"])){
	switch ($_SESSION["OType"]) {
		case 1:
			$strWHERE = "WHERE ord_id <> 1";
			$strWHEREList = "o.ord_id <> 1";
			break;
		case 2:
			$strWHERE = "WHERE ord_id <> 1 AND ord_id <> 2";
			$strWHEREList = "o.ord_id<> 1 AND u.ord_id <> 2";
			break;
	}
}*/

?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<script language="javascript" src="../lib/functions.js"></script>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr>
		<td colspan="2" width="100%" class="Header"><?php include("header.php");?></td>
	</tr>
	<tr>
		<td valign="top" align="center" class="Menu" width="180"><?php include("left.php");?></td>
		<td width="100%" valign="top" class="mainBody"><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="adminMainHead">Order Management</td>
				</tr>
				<tr>
					<td align="center" class="msg"><?php print($strMSG); ?></td>
				</tr>
				<?php if(isset($_REQUEST['action'])){ ?>
				<tr>
					<td><table border="0" align="center" cellpadding="2" cellspacing="0" class="FormTables">
							<form name="form1" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" method="post" enctype="multipart/form-data">
								<tr>
									<td colspan="2" align="left" class="TableHeads"><?php print($FormHead);?></td>
								</tr>
								<tr>
									<td colspan="2" height="10"></td>
								</tr>
								<tr>
									<td align="right" width="150">Status:</td>
									<td align="left" width="300"><select name="txtpstatus" class="inputsmallBorder" style="width: 200px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
											<?php FillSelected("pay_status", "pstatus_id", "pstatus_name", $txtpstatus); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td align="right">Transaction ID:</td>
									<td align="left"><input type="text" name="txttransid" value="<?php print($txttransid);?>" style="width:200px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
								</tr>
								<tr>
									<td colspan="2" height="6"></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td align="left">
										<input name="btnEdit" type="submit" class="inputButton" value="SUBMIT">
										&nbsp;&nbsp;
										<input name="btnCancel" type="button" class="inputButton" value="CANCEL" onClick="javascript: window.location = '<?php print($_SERVER['HTTP_REFERER']);?>';">
									</td>
								</tr>
								<tr>
									<td colspan="3" height="10"></td>
								</tr>
							</form>
						</table></td>
				</tr>
				<?php } else{ ?>
				<form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
					<tr>
						<td align="left" height="20">
							<?php
								switch ($_SESSION['pStatus']) {
									case 0:
							?>
										<b>Pending</b> | 
										<a href="<?php print($_SERVER['PHP_SELF']."?pStatus=1");?>" title="View Completed">	Completed</a> | 
										<a href="<?php print($_SERVER['PHP_SELF']."?pStatus=2");?>" title="View Cancelled">	Cancelled</a>
							<?php
										$strButton = "<input type=\"submit\" name=\"btnConfirm\" value=\"Confirmed\" class=\"inputButton\">";
										$strBtnDelete = "<input type=\"submit\" name=\"btnDelete\" value=\"DELETE\" class=\"inputButton\" onClick=\"return confirm('Delete record will remove all company information as well as login info. Sre you sure you want to delete this record?');\">";
										break;
									case 1:
							?>
										
										<a href="<?php print($_SERVER['PHP_SELF']."?pStatus=0");?>" title="View Pending"> Pending</a> | 
										<b>Completed</b> | 
										<a href="<?php print($_SERVER['PHP_SELF']."?pStatus=2");?>" title="View Cancelled">	Cancelled</a>
							<?php
										$strButton = "<input type=\"submit\" name=\"btnNotConfirm\" value=\"Not Confirmed\" class=\"inputButton\">";
										$strBtnDelete = "";
										break;
									case 2:
							?>
										
										<a href="<?php print($_SERVER['PHP_SELF']."?pStatus=0");?>" title="View Pending"> Pending</a> | 
										<a href="<?php print($_SERVER['PHP_SELF']."?pStatus=1");?>" title="View Completed">	Completed</a> | 
										<b>Cancelled</b>
							<?php
										$strButton = "<input type=\"submit\" name=\"btnNotConfirm\" value=\"Not Confirmed\" class=\"inputButton\">";
										$strBtnDelete = "";
										break;
								}
							?>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
								<tr>
									<td class="TableHeads" align="center" width="30"><input type="checkbox" name="chkAll" onClick="setAll();"></td>
									<td align="center" class="TableHeads">Member</td>
									<td align="center" class="TableHeads">Video</td>
									<td align="center" class="TableHeads">Transaction ID</td>
									<td width="110" align="center" class="TableHeads">Payment</td>
									<td width="110" align="center" class="TableHeads">Date</td>
									<td width="80" align="center" class="TableHeads">Edit</td>
								</tr>
								<?php
								//Selecting all Messages...
								$Query = "SELECT o.*, m.mem_name ,v.vid_name ,s.pstatus_name FROM orders AS o, members AS m, videos AS v, pay_status AS s WHERE s.pstatus_id=o.pstatus_id AND o.pstatus_id=".$_SESSION['pStatus']." AND v.vid_id=o.vid_id AND m.mem_id=o.mem_id ORDER BY o.ord_id DESC";
								$counter=0;
								/* Show many results per page? */ 
								$limit = 50; 
								/* Find the start depending on $_GET['page'] (declared if it's null) */ 
								$start = $p->findStart($limit); 
								/* Find the number of rows returned from a query; Note: Do NOT use a LIMIT clause in this query */ 
								$count = mysql_num_rows(mysql_query($Query)); 
								/* Find the number of pages based on $count and $limit */ 
								$pages = $p->findPages($count, $limit); 
								/* Now we use the LIMIT clause to grab a range of rows */ 
								//$nResult = mysql_query($Query." LIMIT ".$start.", ".$limit);
								$rs = mysql_query($Query." LIMIT ".$start.", ".$limit);
		
					if(mysql_num_rows($rs)>=1){
						while ($row=mysql_fetch_object($rs)){
							$counter++;
							$showDate = "";
							if($row->ord_date!=""){
								$tmpDate = explode("-", $row->ord_date);
								$showDate = @date("M j, Y", mktime (0, 0, 0, $tmpDate[1],$tmpDate[2],$tmpDate[0]));
							}
							if ($counter%2 == 0){
								$strClass = "ListRow2";
							}
							else{
								$strClass = "ListRow1";
							}
							//print(($row->mem_confirm==1)? "Confirmed": "sNot Confirmed");
			?>
								<tr class="<?php print($strClass);?>">
									<td align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->ord_id);?>"></td>
									<td align="left"><?php print($row->mem_name);?></td>
									<td align="left"><?php print($row->vid_name);?></td>
									<td align="left"><?php print($row->ord_trans_id);?></td>
									<td align="center"><?php print($row->pstatus_name);?></td>
									<td align="left"><?php print($showDate);?></td>
									<td align="center"><a href="<?php print($_SERVER['PHP_SELF']."?action=2&ord_id=".$row->ord_id);?>" title="Edit">Edit</a></td>
								</tr>
								<?php
						}
					}
					else{
			?>
								<tr>
									<td colspan="7" class="ListRow1" align="center"><b>No Record Found</b></td>
								</tr>
								<?php
					}
			?>
							</table></td>
					</tr>
					<tr>
							<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td><?php print("Page <b>".$_GET['page']."</b> of ".$pages);?></td>
										<td align="right"><?php	
												$next_prev = $p->nextPrev($_GET['page'], $pages, "");
												print($next_prev);
											?>
										</td>
									</tr>
								</table></td>
						</tr>
				</form>
				<?php } ?>
			</table></td>
	</tr>
	<tr>
		<td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td>
	</tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
