<?php 
include("include/php_includes_top.php"); 
$strMSG='';
$class='';
if(isset($_REQUEST['btnLogin'])){
	$txtlogin = $_REQUEST['txtlogin'];
		$retRes = 0;
	$strQry = "SELECT * FROM members WHERE mem_login='".$_POST['txtlogin']."' AND mem_password='".$_POST['txtpass']."'";
	$nResult = mysql_query($strQry);
	if(mysql_num_rows($nResult)>=1){
		$mrow = mysql_fetch_object($nResult);
		$retRes=1;
		if($mrow->mem_confirm == 1){
			$retRes=1;
		}
		else{
			$retRes=2;
		}
	}
	switch ($retRes) {
		case 0:
			$strMSG = "Invalid Login / Password";
			break;
		case 1:
			// Creating Session
			$SessionID = session_id();
			$_SESSION["UserID"] = $mrow->mem_id;
			$_SESSION["UName"] = $mrow->mem_login;
			$_SESSION["TVideos"] = $mrow->mem_total_videos;
			$_SESSION["TViews"] = $mrow->mem_view_videos;
			updateTBL("members", "mem_last_login='".@date("Y-m-d")."'", "mem_id", $mrow->mem_id);
			$strRedirURL = "my_account.php";
			if(isset($_REQUEST['ref'])){
				$strRedirURL = $_REQUEST['redirURL'];
			}
			header("Location: ".$strRedirURL);
			break;
		case 2:
			$strMSG = "Email not confirmed";
			break;
	}
}
else{
	if(isset($_REQUEST['ref'])){
		$redirURL = $_SERVER['HTTP_REFERER'];
	}
	$txtlogin = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/html_head.php"); ?>
<script language="JavaScript">
function checkRequired(){
	if (document.form1.txtlogin.value=="" || IsBlank("form1","txtlogin")==false){
		alert("Username/Email Address Required!");
		document.form1.txtlogin.focus();
		return (false);
	}
		var ChkLoginEmail = ValidEmail("form1","txtlogin");
	if (ChkLoginEmail==false) {
		alert("Please enter valid email address");
		document.form1.txtlogin.focus();
		return (false);
	}
	if (document.form1.txtpass.value=="" || IsBlank("form1","txtpass")==false){
		alert("Password Required!");
		document.form1.txtpass.focus();
		return (false);
	}
	return (true);
}
</script>
</head>

<body>
	<div id="container">
    	<div id="inner">
            <?php include("include/header.php"); ?>
            <!--content start here-->
            <div id="container">
            	<div id="content_inner">
                	<!--content_left_side start here-->
                	<div id="content_left_side">
                    	<h3>CUSTOMER LOGIN</h3>
						<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
                        <p>Please fill the form below to login</p>
                        <br />
                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                        <form name="form1" method="post" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onsubmit="return checkRequired();">
                            <tr><td colspan="2" align="center" class="clsred"><div class="<?php print($class);?>"><?php print($strMSG);?></div></td></tr>
                            <tr>
                                <td align="right" width="180">Email Address: </td>
                                <td><input type="text" name="txtlogin" value="<?php print($txtlogin);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
                            </tr>
                            <tr>
                                <td align="right">Password: </td>
                                <td><input type="password" name="txtpass" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
                            </tr>
                            <tr>
                                <td align="right"></td>
                                <td height="40">
									<input type="hidden" name="redirURL" value="<?php print($redirURL); ?>" />
									<input type="submit" name="btnLogin" value="Login >> >>" />
								</td>
                            </tr>
                            <tr>
                                <td align="right"></td>
                                <td height="40"><a href="forgot_pass.php" title="Forgot Password?">Forgot Password?</a></td>
                            </tr>
                        </form>
                        </table>
                    </div>
                    <!--content_left_side end here-->
                    <div id="content_right_side"><?php include("include/right.php"); ?></div>
                </div>
            </div>
            <!--content end here-->
            <?php include("include/footer.php"); ?>
        </div>
    </div>
</body>
</html>
<?php include("include/php_includes_bottom.php"); ?>
