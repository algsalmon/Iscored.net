<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG = "";

if(isset($_REQUEST['btnSubmit'])){
	$strQRY="UPDATE contents SET cnt_heading='".$_REQUEST['txthead']."', cnt_details='".$_REQUEST['pContents']."', cnt_keywords='".$_REQUEST['txtkeywords']."' WHERE cnt_id = ".$_REQUEST['cntid'];
	$nRst=mysql_query($strQRY) or die("Unable 2 Edit");
	header("Location: manage_menu.php?op=2&mid=".$_REQUEST['mid']."&pid=".$_REQUEST['pid']);
}

if(isset($_REQUEST['cntid'])){
	$cntid = $_REQUEST['cntid'];
	if($cntid > 0){
		$strQry = "SELECT * FROM contents WHERE cnt_id = ".$cntid;
		$nResult = mysql_query($strQry);
		$rs = mysql_fetch_object($nResult);
		$txthead = $rs->cnt_heading;
		$txtkeywords = $rs->cnt_keywords;
		$pContents = $rs->cnt_details;
		$mid = $_REQUEST['mid'];
		$pid = $_REQUEST['pid'];
	}
	else{
		$cntid = getMaximum("contents","cnt_id");
		mysql_query("UPDATE menu SET cnt_id=".$cntid." WHERE menu_id=".$_REQUEST['mid']);
		$strQRY = "INSERT INTO contents(cnt_id, cnt_heading, cnt_details, cnt_keywords) VALUES(".$cntid.", '', '', '')";
		$nRst = mysql_query($strQRY) or die("Unable 2 Add New Record");
		$txthead = "";
		$txtkeywords = "";
		$pContents = "";
		$mid = $_REQUEST['mid'];
		$pid = $_REQUEST['pid'];
	}
}

include("../FCKeditor/fckeditor.php");
ob_end_flush();
?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script language="javascript" src="../lib/functions.js" type="text/javascript"></script>
<script language="JavaScript">
function checkRequired(){
	if (frm1.txtcat.value=="" || IsBlank("frm1","txtcat")==false){
		alert("Category Name Required!");
		frm1.txtcat.focus();
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
            	<tr>
                	<td class="adminMainHead">Contents Management</td>
                </tr>
				<tr>
					<td>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr><td height="7"></td></tr>
							<tr><td align="center" class="msg"><?php print($strMSG);?></td></tr>
							<tr><td height="7"></td></tr>
							<tr>
								<td align="center" valign="top">
									<table width="90%" border="0" cellpadding="2" cellspacing="0" class="FormTables">
									<form name="frm1" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return checkRequired();">
										<tr><th colspan="2" class="TableHeads">Update Contents</th></tr>
										<tr><td align="center" colspan="2" height="10" class="error"><?php //print($strMSG);?></td></tr>
										<tr>
											<td width="120" align="right">Heading:</td>
											<td align="left"><input type="text" name="txthead" class="inputsmallBorder" value="<?php @print($txthead);?>" style="width: 300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr>
											<td width="120" align="right">Keywords:</td>
											<td align="left"><input type="text" name="txtkeywords" class="inputsmallBorder" value="<?php @print($txtkeywords);?>" style="width: 300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr>
											<td></td>
											<td>
												<?php
													$sBasePath = "../FCKeditor/";
													//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
													$oFCKeditor = new FCKeditor('pContents');
													$oFCKeditor->BasePath = $sBasePath;
													$oFCKeditor->Value		= $pContents;
													$oFCKeditor->Create();
												?>
											</td>
										</tr>
										<tr>
											<td></td>
											<td align="left">
												<input type="hidden" name="mid" value="<?php print($mid);?>">
												<input type="hidden" name="pid" value="<?php print($pid);?>">
												<input type="hidden" name="cntid" value="<?php print($cntid);?>">
												<input type="submit" name="btnSubmit" value="Submit" class="inputButton">
												<input type="button" name="btnCancel" value="Cancel" class="inputButton" onClick="javascript: window.location= '<?php print("manage_menu.php?".$_SERVER['QUERY_STRING']);?>';">
											</td>
										</tr>
										<tr><td colspan="2" height="10"></td></tr>
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
