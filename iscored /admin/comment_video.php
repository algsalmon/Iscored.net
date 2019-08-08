<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
if(isset($_REQUEST['vid'])){
	$rs1 = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST['vid']);
	if(mysql_num_rows($rs1)>0){
		$rVid=mysql_fetch_object($rs1);
		$vidName = $rVid->vid_name;
	}
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

ob_end_flush();
?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr><td colspan="2" width="100%" class="Header"><?php include("header.php");?></td></tr>
    <tr>
    	<td valign="top" align="center" class="Menu" width="180"><?php include("left.php");?></td>
		<td width="100%" valign="top" class="mainBody">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="adminMainHead">Comments of <?php print($vidName);?></td>
                </tr>
            </table>
                <p align="right"><a href="user_videos.php?memid=1"><input type="button" name="back" value="Back" /></a></p>
				<table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
					<?php
	$strQry = "SELECT  v.*, m.mem_name FROM vid_comments AS v, members as m WHERE m.mem_id=v.mem_id AND v.vid_id=".$_REQUEST['vid']." AND v.vstatus_id=1 ORDER BY v.vcom_id DESC";
	$rs = mysql_query($strQry);
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_object($rs)){
?>
					<tr>
                  <input type="checkbox" name="chkAll" onClick="setAll();"><td align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->mem_id);?>"></td>
					<td align="center" class="ListRow1" align="left" valign="top"><b><?php print($row->mem_name);?></b><br />
                        	<?php print($row->vcom_date);?> </td>
					 <td align="center" class="ListRow1"align="left" valign="top"><?php print($row->vcom_comment);?></td>
                         
               	</tr>
					<?php
		}
	}
	else{
?>
					<tr><td align="center">No Comments Found</td></tr>
<?php
	}
?>
				</table>
                <?php 
                switch ($_SESSION['status']) {
                case 0:
                ?>
                <b>Pending</b> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=1");?>" title="View Approved">Approved</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=2");?>" title="View Denied">Denied</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=3");?>" title="View Blocked">Blocked</a>
                <?php
                $strButton = '<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlock" value="Block" class="inputButton">';
                break;
                case 1:
                ?>
                <a href="<?php print($_SERVER['PHP_SELF']."?status=0");?>" title="View Pending">Pending</a> | 
                <b>Approved</b> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=2");?>" title="View Denied">Denied</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=3");?>" title="View Blocked">Blocked</a>
                <?php
                $strButton = '<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlock" value="Block" class="inputButton">';
                break;
                case 2:
                ?>
                <a href="<?php print($_SERVER['PHP_SELF']."?status=0");?>" title="View Pending">Pending</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=1");?>" title="View Approved">Approved</a> | 
                <b>Denied</b> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=3");?>" title="View Blocked">Blocked</a>
                <?php
                $strButton = '<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlock" value="Block" class="inputButton">';
                break;
                case 3:
                ?>
                <a href="<?php print($_SERVER['PHP_SELF']."?status=0");?>" title="View Pending">Pending</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=1");?>" title="View Approved">Approved</a> | 
                <a href="<?php print($_SERVER['PHP_SELF']."?status=2");?>" title="View Denied">Denied</a> |
                <b>Blocked</b>
                <?php
                $strButton = '<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">';
                break;
				}
				?>
             <p><?php //print($strButton);?></p>
				<br />
        </td>
    </tr>
    <tr><td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
