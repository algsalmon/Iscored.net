<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}

if(isset($_REQUEST['status'])){
	$_SESSION['status'] = $_REQUEST['status'];
}
else{
	if(!isset($_SESSION['status'])){
		$_SESSION['status'] = 0;
	}
}

$strMSG = "";

if(isset($_REQUEST['btnPending'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE vid_comments SET vstatus_id = 0 WHERE vcom_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnApproved'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE vid_comments SET vstatus_id = 1 WHERE vcom_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnDenied'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE vid_comments SET vstatus_id = 2 WHERE vcom_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnBlock'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE members SET vstatus_id = 3 WHERE vcom_id = ".$_REQUEST['chkstatus'][$i]);
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
	<tr><td colspan="2" width="100%" class="Header"><?php include("header.php");?></td></tr>
    <tr>
    	<td valign="top" align="center" class="Menu" width="180"><?php include("left.php");?></td>
		<td width="100%" valign="top" class="mainBody">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
            <form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
				<tr><td class="adminMainHead" colspan="2">Team Members Management</td></tr>
				<tr><td align="center" class="msg" colspan="2"><?php print($strMSG); ?></td></tr>
				<tr>
					<td align="left" height="20">
                        </td>
                        <td align="right"></td>
				</tr>
				<tr>
					<td align="center" valign="top" colspan="2">
					  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
						  <tr>
							  <td class="TableHeads" align="center"><input type="checkbox" name="chkAll" onClick="setAll();"></td>
							  <td align="center" class="TableHeads">Member Name</td>
							  <td align="center" class="TableHeads">Email</td>
							  <td align="center" class="TableHeads">Status</td>
						</tr>
					<?php
                    $counter=0;
		
					$strQry = "SELECT * from team_mem WHERE cast_id=".$_REQUEST['cast_id'];
					$nResult = mysql_query($strQry) or die(mysql_error());
					if(mysql_num_rows($nResult)>=1){
						while ($row=mysql_fetch_object($nResult)){
							$counter++;
							
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
							<td align="left"><?php print($row->mem_name_f);?> <?php print($row->mem_name_l);?></td>
							<td align="left"><?php print($row->mem_email);?></td>
							<td align="left"><?php echo $row->verified? 'Verified':'Not Verified';?></td>
				        </tr>
			<?php
						}
					}
					else{
			?>
						  <tr><td colspan="5" class="ListRow1" align="center"><b>No Record Found</b></td></tr>
			<?php
					}
			?>
					  
					  </table>
				  </td>
				</tr>
				<tr>
					<td height="30" align="center" colspan="2">
					</td>
				</tr>
			</form>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>