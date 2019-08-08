<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG="";
if(isset($_REQUEST['udt'])){
	if(isset($_REQUEST['btnEdit'])){
		//$ans = htmlspecialchars(stripslashes($txtAnswer));
		$strQRY="UPDATE faqs SET faq_question='".$_REQUEST['txtQuestion']."', faq_answer='".$_REQUEST['txtAnswer']."' WHERE faq_id = ".$_REQUEST['id'];
		$nRst=mysql_query($strQRY) or die("Unable 2 Edit Package Type");
		header("Location: manage_faqs.php?op=2");
	}
	else{
		if($udt == 1){
			$strQry = "SELECT * FROM faqs WHERE faq_id = ".$_REQUEST['id'];
			$nResult = mysql_query($strQry);
			$rs = mysql_fetch_object($nResult);
			$Question = $rs->faq_question;
			$Answer = $rs->faq_answer;
		}
	}
}
elseif(isset($_REQUEST['del'])){
	if($_SESSION["UType"]>=3){
		$strMSG = "Permission Denied!";
	}
	else{
		$DelQry="DELETE FROM faqs WHERE faq_id = ".$_REQUEST['id'];
		$nResult=mysql_query($DelQry) or die("Unable to Delete Record");
		header("Location: manage_faqs.php?op=3");
	}
}
elseif(isset($btnAdd)){
	$chk = IsExist("faq_id", "faqs", "faq_question", $_REQUEST['txtQuestion']);
	if ($chk == 1){
		$strMSG="Already exist";
	}
	else{
		$MaxID = getMaximum("faqs","faq_id");
		$strQRY="INSERT INTO faqs(faq_id, faq_question, faq_answer) VALUES($MaxID, '".$_REQUEST['txtQuestion']."', '".$_REQUEST['txtAnswer']."')";
		$nRst=mysql_query($strQRY) or die("Unable 2 Add New Record");
		header("Location: manage_faqs.php?op=1");
	}
}
else{
	$Question = "";
	$Answer = "";
	$lid = "";
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
	if (frm.txtQuestion.value=="" || IsBlank("frm","txtQuestion")==false){
		alert("Question Required!");
		frm.txtQuestion.focus();
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
            	<tr><td class="adminMainHead">FAQs Management</td></tr>
                <tr><td height="7"></td></tr>
                <tr><td align="center" class="error"><?php print($strMSG);?></td></tr>
                <tr><td height="7"></td></tr>
                <tr>
                    <td align="center" valign="top">
                        <table width="550" border="0" cellpadding="2" cellspacing="0" class="FormTables">
                        <form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onSubmit="return checkRequired();">
                            <tr>
                                <th colspan="2" class="TableHeads">
                                <?php
                                    if(isset($_REQUEST['udt'])){
                                        print("Edit FAQ");
                                    }
                                    else{
                                        print("Add FAQ");
                                    }
                                ?>
                                </th>
                            </tr>
                            <tr><td align="center" colspan="2" height="10" class="error"><?php //print($strMSG);?></td></tr>
                            <tr>
                                <td width="80" align="right">Question:</td>
                                <td width="470">
                                    <input type="text" name="txtQuestion" class="inputsmallBorder" value="<?php @print($Question);?>" style="width: 420px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
                                    <input type="hidden" name="lid" value="<?php print($lid);?>">
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Answer:</td>
								<td><textarea name="txtAnswer" style="width:420px; height:100px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"><?php @print($Answer);?></textarea></td>
                            </tr>
                            <tr>
                                <td></td>
								<td align="left">
                                <?php
                                    if(isset($_REQUEST['udt'])){
                                ?>
                                        <input type="submit" name="btnEdit" value="SUBMIT" class="inputButton"> <input type="button" name="btnCancel" value="CANCEL" class="inputButton" onClick="javascript: window.location= 'manage_faqs.php?';">
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
                        <table width="96%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
                            <tr>
                                <td class="TableHeads" width="40" align="center">#</td>
                                <td class="TableHeads" align="center">Question</td>
                                <td class="TableHeads" width="100" align="center">Edit</td>
                                <td class="TableHeads" width="100" align="center">Delete</td>
                            </tr>
            <?php
                    $counter=0;
                    $strQry="SELECT faq_id, faq_question, faq_answer FROM faqs";
                    $nResult = mysql_query($strQry);
                    if (mysql_num_rows($nResult)>=1){
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
                                <td><?php print($row->faq_question);?></td>
                                <td align="center"><a href="manage_faqs.php?id=<?php print($row->faq_id);?>&udt=1" title="Edit">Edit</a></td>
                                <td align="center"><a href="manage_faqs.php?id=<?php print($row->faq_id);?>&del=1" title="Delete" onClick=" javascript: return confirm('Are you sure you want to delete this record');">Delete</a></td>
                            </tr>
            <?php
                        }
                    }
                    else{
            ?>
                            <tr><td colspan="4" class="ListRow1" align="center">No Record Found</td></tr>
            <?php
                    }
            ?>
                        </table>
                    </td>
                </tr>
                <tr><td height="20"></td></tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
