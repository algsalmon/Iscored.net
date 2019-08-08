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

if(isset($btnSubmit)){
	$imgid = getMaximum("images","image_id");
	$dirName = "../page_images/";
	$thDirName = "../page_images/th/";
	$ifileName = "";
	if (!empty($_FILES["iFile"]["name"])){
		$ifileName = $imgid . "_" . $_FILES["iFile"]["name"];
		$filePath = $dirName.$ifileName;
		@move_uploaded_file($_FILES['iFile']['tmp_name'], $filePath);
		createThumbnail($dirName, $_FILES["iFile"]["name"], $thDirName, $ifileName);
	}
	mysql_query("INSERT INTO images(image_id, menu_id, image_title, image_file) VALUES(".$imgid.", ".$_REQUEST['mid'].", '".$_REQUEST['txttitle']."',  '".$ifileName."')") or die(mysql_error());
	header("Location: manage_images.php?op=1&mid=".$_REQUEST['mid']."&pid=".$_REQUEST['pid']);
}
else{
	$cfileDir = 0;
}

if(isset($btnDelete)){
	if($_SESSION["UType"]>=3){
		$strMSG = "Permission Denied!";
	}
	else{
		DeleteFileWithThumb("image_file", "images", "image_id", $imgid, "../page_images/", "../page_images/th/");
		mysql_query("DELETE FROM images WHERE image_id = ".$imgid);
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
                <tr><td class="adminMainHead">Images Management</td></tr>
                <tr>
                    <td align="center">
						<table align="center" width="96%" border="0" cellpadding="2" cellspacing="0">
							<tr><td align="center" class="msg" height="20"><?php print($strMSG);?></td></tr>
							<tr>
								<td>
									<table border="0" align="center" cellpadding="1" cellspacing="1" class="FormTables">
									<form name="form1" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" method="post" enctype="multipart/form-data">
										<tr><td colspan="2" align="left" class="TableHeads">Add New Card File</td></tr>
										<tr><td colspan="2" height="10"></td></tr>
										<tr>
											<td width="150" align="right">Title:</td>
											<td width="400" align="left"><input type="text" name="txttitle" class="inputsmallBorder" style="width:300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr>
											<td align="right">Image:</td>
											<td align="left"><input type="file" name="iFile" class="inputsmallBorder" style="width:300px;" onFocus="this.className='inputsmallBorder2';" onBlur="this.className='inputsmallBorder';"></td>
										</tr>
										<tr><td colspan="2" height="6"></td></tr>
										<tr> 
											<td></td>
											<td align="left"><input name="btnSubmit" type="submit" class="inputButton" value="SUBMIT"></td>
										</tr>
										<tr><td colspan="3" height="10"></td></tr>
									</form>
									</table>
								</td>
							</tr>
							<tr><td height="16"></td></tr>
							<tr><td align="right" class="msg" height="20"><a href="<?php print("manage_menu.php?".$_SERVER['QUERY_STRING']);?>" title="Back">Back To Main Menu >></a></td></tr>
                            <tr>
								<td align="center">
									<div style="width:100%;" class="TableHeads">Images</div>
									<div>
							<?php
								$Query = "SELECT * FROM images WHERE menu_id=".$_REQUEST['mid']." ORDER BY image_id";
								$rs = mysql_query($Query);
								if(mysql_num_rows($rs)>0){
									while($row=mysql_fetch_object($rs)){
							?>
										<div align="center" style="width:245px; border:1px solid #CCCCCC; position:relative; float:left; margin-left:5px; margin-right:5px;">
											<img src="../page_images/th/<?php print($row->image_file);?>"><br><?php print($row->image_title);?><br><a href="#" title="Delete">Delete</a>
										</div>
							<?php 
									}
								}
							?>
									</div>
								</td>
							</tr>
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
