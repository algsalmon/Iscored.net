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
				<tr><td class="adminMainHead" colspan="2">Comments Management</td></tr>
				<tr><td align="center" class="msg" colspan="2"><?php print($strMSG); ?></td></tr>
				<tr>
					<td align="left" height="20">
				<?php
				
				if(isset($_REQUEST['vid'])){
$strQry = "SELECT c.*, v.vid_name, s.vstatus_name FROM vid_comments as c, videos as v, vstatus as s WHERE s.vstatus_id=c.vstatus_id AND v.vid_id=c.vid_id AND c.vstatus_id=".$_SESSION['status']." AND c.vid_id=".$_REQUEST['vid']." ORDER BY vcom_id DESC";
			$qryString = "&vid=".$_REQUEST['vid']."&memid=".$_REQUEST['memid'];	
			$strBackLink = '<a href="user_videos.php?memid='.$_REQUEST['memid'].'" title="Back">Back</a>';
		}
		else{
$strQry = "SELECT c.*, v.vid_name, s.vstatus_name FROM vid_comments as c, videos as v, vstatus as s WHERE s.vstatus_id=c.vstatus_id AND v.vid_id=c.vid_id AND c.vstatus_id=".$_SESSION['status']." ORDER BY vcom_id DESC";
$qryString = "";
$strBackLink = "";
}
				
				 
                switch ($_SESSION['status']) {
                case 0:
                ?>
                <b>Pending</b> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=1".$qryString);?>" title="View Approved">Approved</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=2".$qryString);?>" title="View Denied">Denied</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=3".$qryString);?>" title="View Blocked">Blocked</a>
                <?php
                $strButton = '<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlock" value="Block" class="inputButton">';
                break;
                case 1:
                ?>
                <a href="<?php print($_SERVER['PHP_SELF']."?status=0".$qryString);?>" title="View Pending">Pending</a> | 
                <b>Approved</b> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=2".$qryString);?>" title="View Denied">Denied</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=3".$qryString);?>" title="View Blocked">Blocked</a>
                <?php
                $strButton = '<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlock" value="Block" class="inputButton">';
                break;
                case 2:
                ?>
                <a href="<?php print($_SERVER['PHP_SELF']."?status=0".$qryString);?>" title="View Pending">Pending</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=1".$qryString);?>" title="View Approved">Approved</a> | 
                <b>Denied</b> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=3".$qryString);?>" title="View Blocked">Blocked</a>
                <?php
                $strButton = '<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlock" value="Block" class="inputButton">';
                break;
                case 3:
                ?>
                <a href="<?php print($_SERVER['PHP_SELF']."?status=0".$qryString);?>" title="View Pending">Pending</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=1".$qryString);?>" title="View Approved">Approved</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=2".$qryString);?>" title="View Denied">Denied</a> |
                <b>Blocked</b>
                <?php
                $strButton = '<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">';
                break;
				}
                ?>
                        </td>
                        <td align="right"><?php print($strBackLink);?></td>
				</tr>
				<tr>
					<td align="center" valign="top" colspan="2">
					  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
						  <tr>
							  <td class="TableHeads" align="center" width="30"><input type="checkbox" name="chkAll" onClick="setAll();"></td>
							  <td align="center" class="TableHeads" width="180">Video Name</td>
							  <td align="center" class="TableHeads">Comments</td>
							  <td align="center" class="TableHeads" width="80">Status</td>
						</tr>
	<?php
		$counter=0;
		
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
							<td align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->vcom_id);?>"></td>
							<td align="left"><?php print($row->vid_name);?></td>
							<td align="left"><?php print($row->vcom_comment);?></td>
							<td><?php print($row->vstatus_name);?></td>			
							
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
						<?php print($strButton);?>
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