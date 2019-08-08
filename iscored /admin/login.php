<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");

session_start();

$strMSG="";

if (isset($_REQUEST['btnLogin'])){
	$nRes=checkAdminLogin($_REQUEST['txtuname'],$_REQUEST['txtpass']);
	switch ($nRes) {
		case 0:
			$strMSG="Invalid Login / Password";
			break;
		case 1:
			// Creating Session
			$strQry="SELECT * FROM user WHERE user_name='".$_REQUEST['txtuname']."' AND user_password='".$_REQUEST['txtpass']."'";
			$nResult=mysql_query($strQry);
			if (mysql_num_rows($nResult)>=1){
				$row=mysql_fetch_object($nResult);
				if($row->status_id == 1){
					$SessionID = session_id();
					$_SESSION["UID"] = $row->user_id;
					$_SESSION["AdminUName"] = $row->user_name;
					$_SESSION["UType"] = $row->utype_id;
					if($row->utype_id == 4){
						$_SESSION["ClientID"] = $row->clt_id;
					}
					else{
						$_SESSION["ClientID"] = 0;
					}
					header("Location: index.php");
					break;
				}
				else{
					$strMSG="Account Not Activated";
					break;
				}
			}
	}
}
ob_end_flush();

?>
<html>
<head>
<title>Admin Control Panel</title>
<link rel="stylesheet" href="styles/style.css" type="text/css">
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr><td width="100%" class="Header"><?php include("header.php");?></td></tr>
    <tr>
		<td valign="top" class="mainBody" style="padding-top:20px;">
			<table align="center" width="350" border="0" cellpadding="0" cellspacing="0" class="FormTables">
                <tr><th height="20" class="TableHeads">Login Area</th></tr>
                <tr>
                    <td width="350" valign="top" align="center">
                        <table width="300" border="0" cellpadding="1" cellspacing="0">
                        <form name="frmlogin" method="post" action="<?php print($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
                            <tr><td colspan="2" height="16" align="center" class="msg"><?php print($strMSG);?></td></tr>
                            <tr>
                                <td width="100" height="18" align="right">Username: </td>
                                <td width="220"><input type="text" name="txtuname" style="width: 220px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
                            </tr>
                            <tr><td colspan="2" height="3"></td></tr>
                            <tr>
                                <td height="18" align="right">Password: </td>
                                <td><input type="password" name="txtpass" style="width: 220px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
                            </tr>
                            <tr><td colspan="2" height="3"></td></tr>
                            <tr>
                                <td></td>
                                <td align="right"><input type="submit" name="btnLogin" value="Login" class="inputButton"></td>
                            </tr>
                            <tr><td colspan="2" height="5"></td></tr>
                        </form>
                        </table>
                    </td>
                </tr>
                <tr><td width="167" height="3"></td></tr>
            </table>
        </td>
    </tr>
    <tr><td valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
