<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG = "";

$strHead = "Menu Management";
if(isset($_REQUEST['pid'])){
	$pid = $_REQUEST['pid']; 
	if($pid > 0){
		$mainMenu = returnName("menu_title", "menu", "menu_id", $pid);
		$strHead = "Menu Management - ".$mainMenu;
	}
}
else{
	$pid = 0;
}

if(isset($_REQUEST['udt'])){
	if(isset($_REQUEST['btnEdit'])){
		$strQRY="UPDATE menu SET menu_title='".$_REQUEST['txtmenu']."', mtype_id=".$_REQUEST['hdntype']." WHERE menu_id = ".$_REQUEST['id'];
		$nRst=mysql_query($strQRY) or die("Unable 2 Edit");
		header("Location: manage_menu.php?op=2");
	}
	else{
		if($_REQUEST['udt'] == 1){
			$strQry = "SELECT * FROM menu WHERE menu_id = ".$_REQUEST['id'];
			$nResult = mysql_query($strQry);
			$rs = mysql_fetch_object($nResult);
			$txtmenu = $rs->menu_title;
			$hdntype = $rs->mtype_id;
			$pid = $rs->menu_parent_id;
		}
	}
}
elseif(isset($_REQUEST['del'])){
	if($_SESSION["UType"]>=3){
		$strMSG = "Permission Denied!";
	}
	else{
		$DelQry="DELETE FROM menu WHERE menu_id = ".$_REQUEST['id'];
		//$nResult=mysql_query($DelQry) or die("Unable to Delete Record");
		header("Location: manage_menu.php?op=3");
	}
}
elseif(isset($_REQUEST['btnAdd'])){
	//$chk = IsExist("menu_id", "menu", "menu_title", $txtmenu);
	//if ($chk == 1){
	//	$strMSG="Already exist";
	//}
	//else{
		$MaxID = getMaximum("menu","menu_id");
		$maxRank = getMaximum("menu","menu_rank");
		$strQRY="INSERT INTO menu(menu_id, menu_title, mtype_id, menu_parent_id, status_id, menu_rank) VALUES(".$MaxID.", '".$_REQUEST['txtmenu']."', ".$_REQUEST['hdntype'].", ".$pid.", 1, ".$maxRank.")";
		$nRst=mysql_query($strQRY) or die("Unable 2 Add New Record");
		header("Location: manage_menu.php?op=1&pid=".$pid);
	//}
}
else{
	$txtmenu = "";
	$hdntype = 1;
}

if(isset($_REQUEST['btnActive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE menu SET status_id = 1 WHERE menu_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnInactive'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE menu SET status_id = 0 WHERE menu_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}

if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$strMSG = "Record Updated Successfully";
			break;
		case 3:
			$strMSG = "Record Deleted Successfully";
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
<script language="javascript" src="../lib/functions.js" type="text/javascript"></script>
<script language="JavaScript">
function checkRequired(){
	if (frm1.txtmenu.value=="" || IsBlank("frm1","txtmenu")==false){
		alert("Menu Title Required!");
		frm1.txtmenu.focus();
		return (false);
	}
	return (true);
}	

function chkRequired(TheForm)	{
	if (Checkbox("frm", 'chkstatus[]') == false){
		alert("You must check atleast one checkbox");
		return (false);
	}	
	return (true);
}

function setAll(){
	if(frm.chkAll.checked == true){
		checkAll("frm", "chkstatus[]");
	}
	else{
		clearAll("frm", "chkstatus[]");
	}
}	
</script>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr><td colspan="2" width="100%" class="Header"><?php include("header.php");?></td></tr>
    <tr>
    	<td valign="top" align="center" class="Menu" width="180"><?php include("left.php");?></td>
		<td width="100%" valign="top" class="mainBody">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            	<tr><td class="adminMainHead"><?php print($strHead);?></td></tr>
				<tr>
					<td>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr><td height="7"></td></tr>
							<tr><td align="center" class="msg"><?php print($strMSG);?></td></tr>
					<?php if(isset($_REQUEST['udt'])){ ?>
							<tr><td height="7"></td></tr>
							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="2" cellspacing="0" class="FormTables">
									<form name="frm1" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return checkRequired();">
										<tr>
											<th colspan="2" class="TableHeads">
											<?php
												if(isset($_REQUEST['udt'])){
													print("Edit Menu");
												}
												else{
													print("Add Menu");
												}
											?>
											</th>
										</tr>
										<tr><td align="center" colspan="2" height="10" class="error"><?php //print($strMSG);?></td></tr>
										<tr>
											<td width="120" align="right">Menu Title:</td>
											<td width="350" align="left"><input type="text" name="txtmenu" class="inputsmallBorder" value="<?php @print($txtmenu);?>" style="width: 300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr>
											<td></td>
											<td align="left">
												<input type="hidden" name="hdntype" value="1">
												<input type="hidden" name="pid" value="<?php print($pid); ?>">
											<?php
												if(isset($_REQUEST['udt'])){
											?>
													<input type="submit" name="btnEdit" value="EDIT" class="inputButton"> <input type="button" name="btnCancel" value="CANCEL" class="inputButton" onClick="javascript: window.location= 'manage_menu.php?pid=<?php print($pid);?>';">
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
					<?php } ?>
							<tr><td height="20"></td></tr>
							<tr>
								<td align="center" valign="top">
									<table width="96%" border="0" cellpadding="2" cellspacing="1">
									<form name="frm" method="post" action="<?php print($_SERVER['PHP_SELF']);?>" onSubmit="return chkRequired(this);">
									<?php if($pid > 0){ ?>
										<tr><td height="20" align="right"><a href="<?php print($_SERVER['PHP_SELF']);?>" title="Back">Back To Main Menu >></a></td></tr>
									<?php } ?>
										<tr>
											<td>
												<table width="100%" border="0" cellpadding="0" cellspacing="1" class="ListTables">
													<tr>
														<td align="center" class="TableHeads" width="30">#<!--<input type="checkbox" name="chkAll" onClick="setAll();">--></td>
														<td align="center" class="TableHeads">Menu Title</td>
														<td align="center" class="TableHeads" width="80">Contents</td>
														<td align="center" class="TableHeads" width="80">Status</td>
														<td align="center" class="TableHeads" width="80">Edit</td>
												<?php if($pid>0){ ?>
														<td align="center" class="TableHeads" width="80">Delete</td>
												<?php } ?>
													</tr>
									<?php
											$counter=0;
											$strQry="SELECT m.*, s.status_name FROM menu AS m, status AS s WHERE s.status_id = m.status_id AND m.menu_parent_id=".$pid." ORDER BY m.menu_rank";
											$nResult = mysql_query($strQry);
											if (mysql_num_rows($nResult)>=1){
												while ($row=mysql_fetch_object($nResult)){
													$counter++;
													$strShowLinkTotal = "";
													if ($counter%2 == 0){
														print("<tr class=\"ListRow2\">");
													}
													else{
														print("<tr class=\"ListRow1\">");
													}
									?>
														<td align="right" width="30"><?php print($counter."&nbsp;");?><!--<input type="checkbox" name="chkstatus[]" value="<?php //print($row->menu_id);?>">--></td>
                                                    	<td align="left"><?php print($row->menu_title);?></td>
														<td align="center"><a href="manage_contents.php?mid=<?php print($row->menu_id);?>&pid=<?php print($pid);?>&cntid=<?php print($row->cnt_id);?>" title="Manage Contents">Contents</a></td>
														<td align="center"><?php print($row->status_name);?></td>
														<td align="center"><a href="<?php print($_SERVER['PHP_SELF']."?id=".$row->menu_id."&pid=".$pid."&udt=1");?>" title="Edit">Edit</a></td>
												<?php if($pid>0){ ?>
														<td align="center"><a href="<?php print($_SERVER['PHP_SELF']."?id=".$row->menu_id."&pid=".$pid."&del=1");?>" title="Delete" onClick=" javascript: return confirm('Are you sure you want to delete this record');">Delete</a></td>
												<?php } ?>
													</tr>
									<?php
												}
											}
											else{
									?>
													<tr><td colspan="100%" class="ListRow1" align="center">No Record Found</td></tr>
									<?php
											}
									?>
												</table>
											</td>
										</tr>
										<tr><td height="10"></td></tr>
										<tr>
											<td align="center">
												<input type="hidden" name="pid" value="<?php print($pid);?>">
												<!--<input type="submit" name="btnActive" value="Active" class="inputButton">
												<input type="submit" name="btnInactive" value="Inactive" class="inputButton">-->
											</td>
										</tr>
										<tr><td height="10"></td></tr>
									</form>
									</table>	
								</td>
							</tr>
							<tr><td height="20"></td></tr>
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
