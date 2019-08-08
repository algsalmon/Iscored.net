<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
if(isset($_REQUEST['btnSubmit'])){
	$strQry="UPDATE user SET user_password = '".$_REQUEST['txt_password']."' WHERE user_id = ".$_SESSION['UID'];
	mysql_query($strQry) or die(mysql_error());
	$strMSG="Password Changed Successfully";
}
ob_end_flush();
?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<script language="javascript" src="../lib/functions.js" type="text/javascript"></script>
<script language="javascript">
function checkRequired(TheForm) {
	if (document.form1.txt_password.value=="" || IsBlank("form1","txt_password")==false) {
		alert("Password Required!");
		document.form1.txt_password.focus();
		return (false);
	}
	return (true);
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
                	<td class="adminMainHead">Manage Admin Password</td>
                </tr>
                <tr>
                	<td align="center">
                    	<div align="center" style="height:18px; color:#FF0000;"><?php @print($strMSG);?></div>
						<table width="450" border="0" align="center" cellpadding="2" cellspacing="0" class="FormTables">
						<form name="form1" method="post" action="<?php print($_SERVER['PHP_SELF']);?>" onSubmit="return checkRequired(this);">
							<tr><td colspan="2" align="center" class="TableHeads">Reset Admin Password</td></tr>
							<tr><td colspan="2" height="12"></td></tr>
							<tr>
								<td align="right" width="150"><b>Enter password:</b></td>
								<td align="left" width="300"><input type="password" name="txt_password" style="width:250px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
							</tr>
							<tr><td colspan="2" height="6"></td></tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input name="btnSubmit" type="submit" class="inputButton" value="Save">
								</td>
							</tr>
							<tr><td colspan="2" height="10"></td></tr>
						</form>
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
