<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG = "";
$FormHead = "";

if(isset($btnAdd)){
	$fid = getMaximum("card_files","cfile_id");
	$dirName = "../cards/".$cardid."/";
	if(!is_dir($dirName)){
		mkdir($dirName, 0777);
	}
	if(!is_dir($dirName."pages/")){
		mkdir($dirName."pages/", 0777);
	}
	if(!is_dir($dirName."data/")){
		mkdir($dirName."data/", 0777);
	}
	if (!empty($_FILES["cFile"]["name"])){
		$cfileName = $_FILES["cFile"]["name"];
		$upDir = $dirName.$cfileDir;
		$filePath = $upDir.$cfileName;
		@move_uploaded_file($_FILES['cFile']['tmp_name'], $filePath);
	}
	$isCustom = 0;
	if(isset($custom)){
		$isCustom = 1;
	}
	mysql_query("INSERT INTO card_files(cfile_id, card_id, cfile_path, cfile_title, cfile_iscustom, cfile_folder, ftype_id) VALUES(".$fid.", ".$cardid.", '".$filePath."',  '".$cTitle."', ".$isCustom.", '".$cfileDir."', ".$ftype.")") or die(mysql_error());
	header("Location: manage_files.php?op=1&cardid=".$cardid);
}
else{
	$cfileDir = 0;
}

if(isset($btnDelete)){
	if($_SESSION["UType"]>=3){
		$strMSG = "Permission Denied!";
	}
	else{
		for($i=0; $i<count($chkstatus); $i++){
			@unlink($hdnFile[$i]);
			mysql_query("DELETE FROM card_files WHERE cfile_id = ".$chkstatus[$i]);
		}
		$strMSG = "Record(s) deleted successfully";
	}
}

if(isset($op)){
	switch ($op) {
		case 1:
			$strMSG = "Record Added Successfully";
			break;
		case 2:
			$strMSG = "Record Updated Successfully";
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
                <tr><td class="adminMainHead">Card Files Management</td></tr>
                <tr>
                    <td align="center">
						<table align="center" width="96%" border="0" cellpadding="2" cellspacing="0">
							<tr><td align="center" class="msg" height="20"><?php print($strMSG);?></td></tr>
							<tr>
								<td>
									<table border="0" align="center" cellpadding="1" cellspacing="1" class="FormTables">
									<form name="form1" action="<?php print($_SERVER['PHP_SELF']);?>" method="post" onSubmit="return checkPassword();" enctype="multipart/form-data">
										<tr><td colspan="2" align="left" class="TableHeads">Add New Card File</td></tr>
										<tr><td colspan="2" height="10"></td></tr>
										<tr>
											<td align="right" width="150">Upload To:</td>
											<td align="left" width="400">
												<select name="cfileDir" style="width:250px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
													<option value="">Root</option>
													<option value="pages/">Pages</option>
													<option value="data/">Data</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="right">File Title:</td>
											<td align="left"><input type="text" name="cTitle" class="inputsmallBorder" style="width:300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr>
											<td align="right">Card File:</td>
											<td align="left"><input type="file" name="cFile" class="inputsmallBorder" style="width:300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr>
											<td align="right">Customizable:</td>
											<td align="left"><input type="checkbox" name="custom" value="1"></td>
										</tr>
										<tr>
											<td align="right">File Type:</td>
											<td align="left">
												<select name="ftype" style="width:250px;" class="inputsmallBorder" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';">
													<?php FillSelected("file_types", "ftype_id", "ftype_name", $ftype); ?>
												</select>
											</td>
										</tr>
										<tr><td colspan="2" height="6"></td></tr>
										<tr> 
											<td>&nbsp;<input type="hidden" name="cardid" value="<?php print($cardid);?>"></td>
											<td align="left"><input name="btnAdd" type="submit" class="inputButton" value="SUBMIT"></td>
										</tr>
										<tr><td colspan="3" height="10"></td></tr>
									</form>
									</table>
								</td>
							</tr>
							<tr><td height="16"></td></tr>
							<form name="frm" method="post" action="<?php print($_SERVER['PHP_SELF']);?>" onSubmit="return chkRequired(this);">
                            <tr>
								<td align="center">
									<table width="100%" align="center" cellpadding="0" cellspacing="1" class="ListTables">
										<tr>
											<td width="30" align="center" class="TableHeads"><input type="checkbox" name="chkAll" onClick="setAll();"></td>
											<td align="center" class="TableHeads">File Title</td>
											<td align="center" class="TableHeads">Card File</td>
											<td width="60" align="center" class="TableHeads">Type</td>
											<td width="100" align="center" class="TableHeads">Customizable</td>
											<td width="80" align="center" class="TableHeads">Delete</td>
										</tr>
						<?php
							$cnt = 0;
							$clsName = "ListRow1";
							$Query = "SELECT c.*, t.ftype_name FROM card_files AS c, file_types AS t WHERE c.card_id=".$cardid." AND t.ftype_id=c.ftype_id ORDER BY c.cfile_id";
							$rs = mysql_query($Query);
							if(mysql_num_rows($rs)>0){
								while($row=mysql_fetch_object($rs)){	
									$cnt++;
									if ($cnt%2 == 0){
										$clsName = "ListRow2";
									}
									else{
										$clsName = "ListRow1";
									}
									$isCust = "No";
									if($row->cfile_iscustom == 1){
										$isCust = "Yes";
									}
						?>
										<tr class="<?php print($clsName);?>"> 
											<td align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->cfile_id);?>"></td>
											<td align="left"><?php print($row->cfile_title);?></td>
											<td align="left">
												<?php print($row->cfile_path);?>
												<input type="hidden" name="hdnFile[]" value="<?php print($row->cfile_path);?>">
											</td>
											<td align="center"><?php print($row->ftype_name);?></td>
											<td align="center"><?php print($isCust);?></td>
											<td align="center"><a href="<?php print($row->cfile_path);?>" title="View File" target="_blank">View File</a></td>
										</tr>
						<?php
								}
							}
							else{	
						?>
										<tr><td colspan="6" align="center" class="ListRow1">No Record Found</td></tr>
						<?php
							}
						?>
									</table>
								</td>
							</tr>
							<tr>
								<td height="25" align="center">
									<input type="hidden" name="cardid" value="<?php print($cardid);?>">
									<input type="submit" name="btnDelete" value="DELETE" class="inputButton">
								</td>
							</tr>
							</form>
							<tr><td height="10"></td></tr>
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
