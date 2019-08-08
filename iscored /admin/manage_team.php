<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG = "";
if(isset($_REQUEST['udt'])){
	if(isset($_REQUEST['btnEdit'])){
		$strQRY="UPDATE team_played SET team_name='".$_REQUEST['txtcat']."' WHERE team_id = ".$_REQUEST['id'];
		$nRst=mysql_query($strQRY) or die(mysql_error());
		header("Location: manage_team.php?op=2");
	}
	else{
		if($_REQUEST['udt'] == 1){
			$strQry = "SELECT * FROM team_played WHERE team_id = ".$_REQUEST['id'];
			$nResult = mysql_query($strQry);
			$rs = mysql_fetch_object($nResult);
			$txtcat = $rs->team_name;
		}
	}
}
elseif(isset($_REQUEST['del'])){
	if($_SESSION["UType"]>=3){
		$strMSG = "Permission Denied!";
	}
	else{
		$DelQry="DELETE FROM team_played WHERE team_id = ".$_REQUEST['id'];
		$nResult=mysql_query($DelQry) or die("Unable to Delete Record");
		header("Location: manage_team.php?op=3");
	}
}
elseif(isset($_REQUEST['btnAdd'])){
	if(!IsExist("team_name", "team_played", "team_name", $_REQUEST['txtcat'])){
		$MaxID = getMaximum("team_played","team_id");
		$strQRY="INSERT INTO team_played(team_id, team_name) VALUES($MaxID, '".$_REQUEST['txtcat']."')";
		$nRst=mysql_query($strQRY) or die(mysql_error());
		header("Location: manage_team.php?op=1");
	}
	else{
		header("Location: manage_team.php?op=4");
	}
}
else{
	$txtcat = "";
}
if(isset($op)){
	switch ($op) {
		case 1:
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$strMSG = "Record Updated Successfully";
			break;
		case 3:
			$strMSG = "Record Deleted Successfully";
			break;
		case 4:
			$strMSG = "Category already exist";
			break;
	}
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
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr><td class="adminMainHead">Teams Management</td></tr>
                <tr><td height="7"></td></tr>
				<tr><td align="center" class="msg"><?php print($strMSG);?></td></tr>
				<tr><td height="7"></td></tr>
				<tr>
					<td align="center" valign="top">
						<table width="550" border="0" cellpadding="2" cellspacing="0" class="FormTables">
						<form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
							<tr>
								<th colspan="2" class="TableHeads">
								<?php
									if(isset($_REQUEST['udt'])){
										print("Edit Team Record");
									}
									else{
										print("Add Team Record");
									}
								?>
								</th>
							</tr>
							<tr><td align="center" colspan="2" height="10" class="error"><?php //print($strMSG);?></td></tr>
							<tr>
								<td width="130" align="right">Teams:</td>
								<td width="400" align="left">
									<input type="text" name="txtcat" class="inputsmallBorder" value="<?php @print($txtcat);?>" style="width: 300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
								</td>
							</tr>
							<tr>
                            	<td></td>
								<td align="left">
								<?php
									if(isset($_REQUEST['udt'])){
								?>
										<input type="submit" name="btnEdit" value="EDIT" class="inputButton"> <input type="button" name="btnCancel" value="CANCEL" class="inputButton" onClick="javascript: window.location='<?php print($_SERVER['PHP_SELF']);?>?';">
								<?php
									}
									else{
								?>
										<input type="submit" name="btnAdd" value="SUBMIT" class="inputButton">
								<?php
									}
								?>
								</td>
							</tr>
							<tr><td colspan="2" height="10"></td></tr>
						</form>
						</table>
					</td>
				</tr>
				<tr><td height="20"></td></tr>
				<tr>
					<td align="center" valign="top">
						<table width="98%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
							<tr>
								<td class="TableHeads" align="center" width="50">#</td>
								<td class="TableHeads" align="center">Team</td>
								<td class="TableHeads" align="center">Edit</td>
								<td class="TableHeads" align="center">Delete</td>
							</tr>
			<?php
					$counter=0;
					$strQry="SELECT * FROM team_played ORDER BY team_id";
					$nResult = mysql_query($strQry) or die(mysql_error());
					if(mysql_num_rows($nResult)>=1){
						while ($row=mysql_fetch_object($nResult)){
							$counter++;
							if ($counter%2 == 0){
								print("<tr class=\"ListRow2\">");
							}
							else{
								print("<tr class=\"ListRow1\">");
							}
			?>
								<td align="right"><?php print($counter);?></td>
								<td align="left"><?php print($row->team_name);?></td>
								<td align="center"><a href="<?php print($_SERVER['PHP_SELF']);?>?id=<?php print($row->team_id);?>&udt=1" title="Edit">Edit</a></td>
								<td align="center"><a href="<?php print($_SERVER['PHP_SELF']);?>?id=<?php print($row->team_id);?>&del=1" title="Delete" onClick=" javascript: return confirm('Are you sure you want to delete this record');">Delete</a></td>
							</tr>
			<?php
						}
					}
					else{
			?>
							<tr><td colspan="4" class="ListRow1" align="center"><b>No Record Found</b></td></tr>
			<?php
					}
			?>
						</table>
					</td>
				</tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
