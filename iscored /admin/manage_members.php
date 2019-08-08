<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}

if(isset($_REQUEST['confirm'])){
	$_SESSION['confirm'] = $_REQUEST['confirm'];
}
else{
	if(!isset($_SESSION['confirm'])){
		$_SESSION['confirm'] = 0;
	}
}

$strMSG = "";

if(isset($_REQUEST['btnActive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET status_id = 1 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnInactive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET status_id = 0 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnConfirm'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET mem_confirm = 1 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnNotConfirm'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET mem_confirm = 0 WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnDelete'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("DELETE FROM members WHERE mem_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}

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
				<form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
					<tr>
						<td class="adminMainHead">Members Management</td>
					</tr>
					<tr>
						<td align="center" class="msg"><?php print($strMSG); ?></td>
					</tr>
					<?php if(isset($_REQUEST['show'])){ ?>
					<tr>
						<td>
						<?php	
							$Query="SELECT m.*, g.gen_name, c.countries_name FROM members AS m, countries AS c, gender AS g WHERE g.gen_id=m.gen_id AND c.countries_id=m.countries_id AND m.mem_id=".$_REQUEST['memid']." ORDER BY m.mem_id DESC";
							$rs = mysql_query($Query);
							if(mysql_num_rows($rs)>0){
								//while($row=mysql_fetch_object($rs)){
								$row=mysql_fetch_object($rs);	
						?>
							<table border="0" align="center" cellpadding="4" cellspacing="0" class="FormTables">
								<tr>
									<td colspan="2" align="left" class="TableHeads">Details</td>
								</tr>
								<tr>
									<td colspan="2" height="10"></td>
								</tr>
								<tr>
									<td width="140" align="right">Name:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_name);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Gender:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->gen_name);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Date of Birth:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_dob);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Phone:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_phone);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Adress:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_address);?></td>
								</tr>
								<tr>
									<td width="140" align="right">City:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_city);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Country:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->countries_name);?></td>
								</tr>
								<tr>
									<td colspan="2" height="10"></td>
								</tr>
								<tr>
									<td colspan="2" align="left" class="TableHeads">Bank Details</td>
								</tr>
								<tr>
									<td colspan="2" height="10"></td>
								</tr>
								<tr>
									<td width="140" align="right">Account Title:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_ac_title);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Account Number:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_ac_number);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Bank Name:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_bank_name);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Swift Code:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_swift_code);?></td>
								</tr>
								<tr>
									<td width="140" align="right">Bank Adress:</td>
									<td width="300" align="left" style="padding-left:4px;padding-right:4px;"><?php print($row->mem_bank_address);?></td>
								</tr>
								<?php
								//}
							}
							else{	
						?>
								<tr>
									<td colspan="5" align="center" class="ListRow1">No Record Found</td>
								</tr>
								<?php
							}
						?>
								<tr>
									<td colspan="2" height="6"></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td align="left"><input name="btnBack" type="button" class="inputButton" value="BACK" onClick="javascript: window.location = '<?php print($_SERVER['PHP_SELF']);?>';"></td>
								</tr>
								<tr>
									<td colspan="3" height="10"></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } else{ ?>
					<tr>
						<td align="left" height="20">	
							<?php
							switch ($_SESSION['confirm']) {
								case 0:
						?>
							<a href="<?php print($_SERVER['PHP_SELF']."?confirm=1");?>" title="View Confirmed">Confirmed</a> | <b>Not Confirmed</b>
							<?php
									$strButton = "<input type=\"submit\" name=\"btnConfirm\" value=\"Confirmed\" class=\"inputButton\">";
									$strBtnDelete = "<input type=\"submit\" name=\"btnDelete\" value=\"DELETE\" class=\"inputButton\" onClick=\"return confirm('Delete record will remove all company information as well as login info. Sre you sure you want to delete this record?');\">";
									break;
								case 1:
						?>
							<b>Confirmed</b> | <a href="<?php print($_SERVER['PHP_SELF']."?confirm=0");?>" title="View Not Confirmed">Not Confirmed</a>
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
									<td align="center" class="TableHeads">Name</td>
									<td align="center" class="TableHeads">Email</td>
									<td width="80" align="center" class="TableHeads">Videos</td>
									<td width="110" align="center" class="TableHeads">Status</td>
									<td width="90" align="center" class="TableHeads">Date Added</td>
									<td width="90" align="center" class="TableHeads">Last Login</td>
								</tr>
								<?php
		$counter=0;
		$strQry="SELECT m.*, s.status_name, (SELECT COUNT(vid_id) FROM videos WHERE mem_id=m.mem_id) AS total_videos FROM members AS m, status AS s WHERE s.status_id=m.status_id AND m.mem_confirm=".$_SESSION['confirm']." ORDER BY m.mem_id";
					$nResult = mysql_query($strQry) or die(mysql_error());
					if(mysql_num_rows($nResult)>=1){
						while ($row=mysql_fetch_object($nResult)){
							$counter++;
							$showDate = "";
							if($row->mem_datecreated!=""){
								$memDate = explode("-", $row->mem_datecreated);
								$showDate = @date("M j, Y", mktime (0, 0, 0, $memDate[1],$memDate[2],$memDate[0]));
							}
							if(($row->mem_last_login == "0000-00-00") || ($row->mem_last_login == "")){
								$lastLogin = "";
							}
							else{
								$shDate = explode("-", $row->mem_last_login);
								$lastLogin = @date("M j, Y", mktime (0, 0, 0, $shDate[1],$shDate[2],$shDate[0]));
							}
							if ($counter%2 == 0){
								$strClass = "ListRow2";
							}
							else{
								$strClass = "ListRow1";
							}
							//print(($row->mem_confirm==1)? "Confirmed": "Not Confirmed");
			?>
								<tr class="<?php print($strClass);?>">
									<td align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->mem_id);?>"></td>
									<td align="left"><a href="<?php print($_SERVER['PHP_SELF']."?show=1&memid=".$row->mem_id);?>" title="<?php print($row->mem_name);?>"><?php print($row->mem_name);?></a></td>
									<td align="left"><?php print($row->mem_login);?></td>
									<td><a href="user_videos.php?memid=<?php print($row->mem_id);?>"><?php print($row->total_videos);?> Videos</a></td>
									<td align="center"><?php print($row->status_name);?></td>
									<td align="left"><?php print($showDate);?></td>
									<td align="left"><?php print($lastLogin);?></td>
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
						<td height="30" align="center"><input type="submit" name="btnActive" value="Active" class="inputButton">
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" name="btnInactive" value="Inactive" class="inputButton">
							&nbsp;&nbsp;&nbsp;&nbsp; <?php print($strButton);?>&nbsp;&nbsp;&nbsp;&nbsp; <?php print($strBtnDelete);?> </td>
					</tr>
				</form>
				<?php }?>
			</table></td>
	</tr>
	<tr>
		<td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td>
	</tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
