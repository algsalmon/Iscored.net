<?php 
include("include/php_includes_top.php");

if(isset($_REQUEST['btnRegister'])){
	$txtlogin=str_replace("'", "''", $_REQUEST['txtlogin']);
	$txtname=str_replace("'", "''", $_REQUEST['txtname']);
	$txtdob=str_replace("'", "''", $_REQUEST['txtdob_yy'])."-".str_replace("'", "''", $_REQUEST['txtdob_mm'])."-".str_replace("'", "''", $_REQUEST['txtdob_dd']);
	$txtadress=str_replace("'", "''", $_REQUEST['txtadress']);
	$txtphoneno=str_replace("'", "''", $_REQUEST['txtphoneno']);
	$txtcity=str_replace("'", "''", $_REQUEST['txtcity']);
	$cbocountry=$_REQUEST['cbocountry'];
	$txtacctitle=str_replace("'", "''", $_REQUEST['txtacctitle']);
	$txtaccno = str_replace("'", "''", $_REQUEST['txtaccno']);
	$txtbank=str_replace("'", "''", $_REQUEST['txtbank']);
	$txtsfcode=str_replace("'", "''", $_REQUEST['txtsfcode']);
	$txtbankadress = str_replace("'", "''", $_REQUEST['txtbankadress']);
	$radgender=$_REQUEST['radgender'];
	if(IsExist("mem_id", "members", "mem_login", $_REQUEST['txtlogin'])){
		$strMSG = "Email / Username already exist";
	}
	else{
		$memid = getMaximum("members","mem_id");
		mysql_query("INSERT INTO members(mem_id, mem_login, mem_password, mem_name, mem_dob, gen_id, countries_id, mem_address, mem_phone, mem_city, mem_datecreated, mem_ac_title, mem_ac_number, mem_bank_name, mem_swift_code, mem_bank_address) VALUES(".$memid.", '".$txtlogin."', '".$_REQUEST['txtpass']."', '".$txtname."', '".$txtdob."', ".$radgender.", ".$cbocountry.", '".$txtadress."', '".$txtphoneno."', '".$txtcity."', '".@date("Y-m-d")."', '".$txtacctitle."', '".$txtaccno."', '".$txtbank."', '".$txtsfcode."', '".$txtbankadress."')");
		SendConfirmation($txtname, $txtlogin, $memid);
		$strHead = "Registered Successfully";
		$strMSG = "Please check your email account for account activation.";
		include("message.php");
		die();
	}
}
elseif(isset($_REQUEST['udt'])){
	if(!isset($_SESSION['UserID'])){
		header("location: login.php");
	}
	if(isset($_REQUEST['btnUpdate'])){
		//$txtlogin = str_replace("'", "''", $_REQUEST['txtlogin']);
		$txtname = str_replace("'", "''", $_REQUEST['txtname']);
		$txtdob = str_replace("'", "''", $_REQUEST['txtdob_yy'])."-".str_replace("'", "''", $_REQUEST['txtdob_mm'])."-".str_replace("'", "''", $_REQUEST['txtdob_dd']);
		$txtadress=str_replace("'", "''", $_REQUEST['txtadress']);
		$txtphoneno=str_replace("'", "''", $_REQUEST['txtphoneno']);
		$txtcity = str_replace("'", "''", $_REQUEST['txtcity']);
		$cbocountry = $_REQUEST['cbocountry'];
		$txtacctitle = str_replace("'", "''", $_REQUEST['txtacctitle']);
		$txtaccno = str_replace("'", "''", $_REQUEST['txtaccno']);
		$txtbank = str_replace("'", "''", $_REQUEST['txtbank']);
		$txtsfcode = str_replace("'", "''", $_REQUEST['txtsfcode']);
		$txtbankadress =str_replace("'", "''",  $_REQUEST['txtbankadress']);
		$radgender = $_REQUEST['radgender'];
		mysql_query("UPDATE members SET mem_name='".$txtname."', mem_dob='".$txtdob."', gen_id='".$radgender."', countries_id='".$cbocountry."', mem_address='".$txtadress."', mem_phone='".$txtphoneno."', mem_city='".$txtcity."', mem_lastupdated = '".@date("Y-m-d")."', mem_ac_title='".$txtacctitle."', mem_ac_number='".$txtaccno."', mem_bank_name='".$txtbank."', mem_swift_code='".$txtsfcode."', mem_bank_address='".$txtbankadress."' WHERE mem_id = ".$_SESSION["UserID"]);
		$strHead = "Profile Updated";
		$strMSG = "Your profile has been updated successfully.";
		include("message.php");
		die();
	}
	else{
		$nResult = mysql_query("SELECT * FROM members WHERE mem_id=".$_SESSION["UserID"]);
		if(mysql_num_rows($nResult)>=1){
			$mrow = mysql_fetch_object($nResult);
			$txtlogin = $mrow->mem_login;
			$txtname = $mrow->mem_name;
			if($mrow->mem_dob != ""){
				$txtdob = explode("-", $mrow->mem_dob);
				$txtdob_mm = $txtdob[1];
				$txtdob_dd = $txtdob[2];
				$txtdob_yy = $txtdob[0];
			}
			else{
				$txtdob_mm="";
				$txtdob_dd="";
				$txtdob_yy="";
			}
			$txtadress = $mrow->mem_address;
			$txtphoneno = $mrow->mem_phone;
			$txtcity = $mrow->mem_city;
			$cbocountry = $mrow->countries_id;
			$txtacctitle = $mrow->mem_ac_title;
			$txtaccno = $mrow->mem_ac_number;
			$txtbank = $mrow->mem_bank_name;
			$txtsfcode = $mrow->mem_swift_code;
			$txtbankadress = $mrow->mem_bank_address;
			$radgender = $mrow->gen_id 	;
		}
	}
}
else{
	$txtlogin="";
	$txtname="";
	$txtdob_mm="";
	$txtdob_dd="";
	$txtdob_yy="";
	$txtadress="";
	$txtphoneno="";
	$txtcity="";
	$cbocountry=0;
	$txtacctitle="";
	$txtaccno="";
	$txtbank="";
	$txtsfcode="";
	$txtbankadress="";
	$radgender=1;
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
		alert("Username Required!");
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
	if (document.form1.txtname.value=="" || IsBlank("form1","txtname")==false){
		alert("Full Name Required!");
		document.form1.txtname.focus();
		return (false);
	}
	if (document.form1.txtdob_mm.value=="" || IsBlank("form1","txtdob_mm")==false){
		alert("Birth Month Required!");
		document.form1.txtdob_mm.focus();
		return (false);
	}
	if (document.form1.txtdob_dd.value=="" || IsBlank("form1","txtdob_dd")==false){
		alert("Birth Day Required!");
		document.form1.txtdob_dd.focus();
		return (false);
	}
	if (document.form1.txtdob_yy.value=="" || IsBlank("form1","txtdob_yy")==false){
		alert("Birth Year Required!");
		document.form1.txtdob_yy.focus();
		return (false);
	}
	if (document.form1.txtadress.value=="" || IsBlank("form1","txtadress")==false){
		alert("Adress Required!");
		document.form1.txtadress.focus();
		return (false);
	}
	if (document.form1.txtphoneno.value=="" || IsBlank("form1","txtphoneno")==false){
		alert("Phone Number Required!");
		document.form1.txtphoneno.focus();
		return (false);
	}
	if (document.form1.txtcity.value=="" || IsBlank("form1","txtcity")==false){
		alert("City Required!");
		document.form1.txtcity.focus();
		return (false);
	}
	/*if (document.form1.txtaccno.value=="" || IsBlank("form1","txtaccno")==false){
		alert("Account Number Required!");
		document.form1.txtaccno.focus();
		return (false);
	}
	if (document.form1.txtacctitle.value=="" || IsBlank("form1","txtacctitle")==false){
		alert("Account Title Required!");
		document.form1.txtacctitle.focus();
		return (false);
	}
	if (document.form1.txtbank.value=="" || IsBlank("form1","txtbank")==false){
		alert("Bank Name Required!");
		document.form1.txtbank.focus();
		return (false);
	}
	if (document.form1.txtsfcode.value=="" || IsBlank("form1","txtsfcode")==false){
		alert("Swift Code Required!");
		document.form1.txtsfcode.focus();
		return (false);
	}
	if (document.form1.txtbankadress.value=="" || IsBlank("form1","txtbankadress")==false){
		alert("Bank Adress Required!");
		document.form1.txtbankadress.focus();
		return (false);
	}*/
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
          <h3> REGISTRATION FORM </h3>
		  <div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
          <p>Please fill the form below to Register</p>
          <br />
		  <table width="100%" border="0" cellpadding="2" cellspacing="0">
			<form name="form1" method="post" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onsubmit="return checkRequired();">
				<tr><td colspan="2" align="center" class="clsred"><?php print($strMSG);?></td></tr>
		<?php if(!isset($_REQUEST['udt'])){?>
				<tr>
					<td align="right" width="180">Email Address: </td>
					<td><input type="text" name="txtlogin" value="<?php print($txtlogin);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
				</tr>
				<tr>
					<td align="right">Password: </td>
					<td><input type="password" name="txtpass" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
				</tr>
		<?php } else{  ?>
				<tr>
					<td align="right" width="180">Email Address: </td>
					<td><b><?php print($txtlogin);?></b></td>
				</tr>
		<?php } ?>
				<tr>
					<td align="right">Name: </td>
					<td><input type="text" name="txtname" value="<?php print($txtname);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
				</tr>
				<tr>
					<td align="right">Date of Birth: </td>
					<td>
						<input type="text" name="txtdob_mm" value="<?php print($txtdob_mm);?>" size="2" maxlength="2" class="input" /> /
						<input type="text" name="txtdob_dd" value="<?php print($txtdob_dd);?>" size="2" maxlength="2" class="input" /> /
						<input type="text" name="txtdob_yy" value="<?php print($txtdob_yy);?>" size="4" maxlength="4" class="input" /> 
						&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /> (MM/DD/YYYY - 05/14/1987)
					</td>
				</tr>
				<tr>
					<td align="right">Gender: </td>
					<td>
						<input type="radio" name="radgender" value="1" <?php print(($radgender==1)? 'checked="checked"': '');?> /> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="radgender" value="2" <?php print(($radgender==2)? 'checked="checked"': '');?> /> Female
						&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" />
					</td>
				</tr>
				<tr>
					<td align="right">Phone: </td>
					<td><input type="txtphoneno" name="txtphoneno" value="<?php print($txtphoneno);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
				</tr>
				<tr>
					<td align="right">Address: </td>
					<td><input type="text" name="txtadress" value="<?php print($txtadress);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
				</tr>
                 <tr>
					<td align="right">City: </td>
					<td><input type="txtcity" name="txtcity" value="<?php print($txtcity);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
				</tr>
                <tr>
					<td align="right">Country: </td>
					<td>
						<select id="cbocountry" name="cbocountry" class="select">
							<?php FillSelected("countries", "countries_id", "countries_name", $cbocountry); ?>
						</select>
						&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" />
					</td>
				</tr>
				<tr><td colspan="2" height="10"></td></tr>
				<tr>
					<td align="left" colspan="2"><b>Bank Account Information</b></td>
				</tr>
                <tr>
					<td align="right">Account Title: </td>
					<td><input type="txtacctitle" name="txtacctitle" value="<?php print($txtacctitle);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;</td>
				</tr>
                 <tr>
					<td align="right">Account Number: </td>
					<td><input type="txtaccno" name="txtaccno" value="<?php print($txtaccno);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;</td>
				</tr>
                <tr>
					<td align="right">Bank Name: </td>
					<td><input type="txtbank" name="txtbank" value="<?php print($txtbank);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;</td>
				</tr>
                <tr>
					<td align="right">Swift code: </td>
					<td><input type="txtsfcode" name="txtsfcode" value="<?php print($txtsfcode);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;</td>
				</tr>
                 <tr>
					<td align="right">Bank Address: </td>
					<td><input type="txtbankadress" name="txtbankadress" value="<?php print($txtbankadress);?>" class="input" style="width:280px;"  />&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td align="right"></td>
					<td height="40">
					<?php if(isset($_REQUEST['udt'])){?>
						<input type="submit" name="btnUpdate" value="Submit >> >>" />
					<?php } else{ ?>
						<input type="submit" name="btnRegister" value="Submit >> >>" />
					<?php } ?>
					</td>
				</tr>
			</form>
			</table>
        </div>
        <!--content_left_side end here-->
        <div id="content_right_side">
          <?php include("include/right.php"); ?>
        </div>
      </div>
    </div>
    <!--content end here-->
    <?php include("include/footer.php"); ?>
  </div>
</div>
</body>
</html>
<?php include("include/php_includes_bottom.php"); ?>
