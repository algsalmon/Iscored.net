<?php 
include("include/php_includes_top.php"); 

$strMessage = "";

if(isset($_REQUEST['btnForgot'])){
	$txtlogin = $_REQUEST['txtlogin'];
	$retRes = 0;
	$strQry = "SELECT * FROM members WHERE mem_login='".$_REQUEST['txtlogin']."'";
	$nResult = mysql_query($strQry);
	if(mysql_num_rows($nResult)>=1){
		$mrow = mysql_fetch_object($nResult);
		SendLoginDetails($_REQUEST['txtlogin'], $mrow->mem_password);
		$strMSG = "An email has been sent with login info. Please heck your email. Thanks";
	}
	else{
		$strMSG = "Your email address is not available in our database. Please enter email valid email address.<br><br><a href=\"forgot_pass.php\" title=\"Forgot Password\">Click Here</a> to try again.";
	}
}
else{
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
		alert("Email Address Required!");
		document.form1.txtlogin.focus();
		return (false);
	}
	var ChkLoginEmail = ValidEmail("form1","txtlogin");
	if (ChkLoginEmail==false) {
		alert("Please enter valid email address");
		document.form1.txtlogin.focus();
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
                    	<h3>Forgot Password</h3>
						<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
					<?php if(isset($_REQUEST['btnForgot'])){ ?>
							<p><?php print($strMSG);?></p>
					<?php } else{ ?>
							<p>Please type your email address below  and you will get your details in your email.</p>
							<table border="0" cellpadding="2" cellspacing="0">
							<form name="form1" method="post" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onsubmit="return checkRequired();">
								<tr><td colspan="2" align="center" class="clsred"><?php print($strMSG);?></td></tr>
								<tr>
									<td align="right" width="180">Email Address: </td>
									<td><input type="text" name="txtlogin" value="<?php print($txtlogin);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
								</tr>
								<tr>
									<td align="right"></td>
									<td height="40"><input type="submit" name="btnForgot" value="Submit >> >>" /></td>
								</tr>
							</form>
							</table>
					<?php } ?>
					<div class="banner_area_left"><?php showBanner1(2, "BottomLeft"); ?></div>
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
