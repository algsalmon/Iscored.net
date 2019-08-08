<?php
ob_start();
include("../lib/openCon.php");
include("../lib/functions.php");
session_start();
if(!isset($_SESSION['UID'])){
	header("location: login.php");
}
$strMSG = "";
if(isset($_REQUEST['vid'])){
	$rs1 = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST['vid']);
	if(mysql_num_rows($rs1)>0){
		$rVid=mysql_fetch_object($rs1);
		$vidName = $rVid->vid_name;
		$clipPath = "../videos/clips/".$rVid->vid_clip_path;
		$mediaPath = "../videos/main/".$rVid->vid_file_path;
		//$mediaPath = "vod/iscored.algie/videos/main/".$rowLatestVid->vid_file_path;
	}
}

if(isset($_REQUEST['btnPending'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE videos SET vstatus_id = 0 WHERE vid_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnApproved'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE videos SET vstatus_id = 1 WHERE vid_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnFeatured'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE videos SET vid_featured = 1 WHERE vid_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnUnFeatured'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE videos SET vid_featured = 0 WHERE vid_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnDenied'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE videos SET vstatus_id = 2 WHERE vid_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['btnBlocked'])){
	for($i=0; $i<count($_REQUEST['chkstatus']); $i++){
		mysql_query("UPDATE videos SET vstatus_id = 3 WHERE vid_id = ".$_REQUEST['chkstatus'][$i]);
	}
	$strMSG = "Record(s) updated successfully";
}
if(isset($_REQUEST['showHome'])){
	mysql_query("UPDATE videos SET vid_home = 0");
	mysql_query("UPDATE videos SET vid_home = 1 WHERE vid_id = ".$_REQUEST['vid']);
	$strMSG = "Record updated successfully";
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
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<form name="frm" method="post" action="<?php @print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data">
            	<tr><td class="adminMainHead">Member Videos</td></tr>
				<tr><td align="center" class="msg"><?php print($strMSG); ?></td></tr>
      <?php if(isset($_REQUEST['show'])){ ?>
      			<tr><td height="25"><b><?php print($vidName);?></b></td></tr>
                <tr>
                	<td align="center">
                    	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="600" height="400">
                            <param name="movie" value="VideoPlayer.swf?path=<?php print($mediaPath);?>&autoplay=true" />
                            <param name="quality" value="high" />
                            <embed src="VideoPlayer.swf?path=<?php print($mediaPath);?>&autoplay=true" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="600" height="400"></embed>
                        </object>
                    </td>
                </tr>
                <tr><td height="20"></td></tr>
       <?php } ?>
                <tr>
					<td>
						<table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
							<tr>
								<td align="center" class="TableHeads" height="28" width="30"><input type="checkbox" name="chkAll" onClick="setAll();"></td>
								<td align="center" class="TableHeads" height="28">Name</td>
								<td align="center" class="TableHeads" height="28" width="110">Category</td>
								<td align="center" class="TableHeads" height="28" width="80">Featured</td>
                                <td align="center" class="TableHeads" height="28" width="80">Comments</td>
								<td align="center" class="TableHeads" height="28" width="80">Views</td>
								<td align="center" class="TableHeads" height="28" width="80">Price</td>
								<td align="center" class="TableHeads" height="28" width="90">Date</td>                    
								<td align="center" class="TableHeads" height="28" width="60">Status</td>
								<td align="center" class="TableHeads" height="28" width="60">Download</td>
								<td align="center" class="TableHeads" height="28" width="60">Home</td>
							</tr>
			<?php
				$count=0;
				$strClass = "ListRow1";
				$strQry = "SELECT v.*, vs.vstatus_name, c.cat_name ,(SELECT COUNT(vcom_id) FROM vid_comments WHERE vstatus_id=1 AND vid_id=v.vid_id) AS totalComments FROM videos AS v, vstatus AS vs, categories AS c WHERE c.cat_id=v.cat_id AND vs.vstatus_id=v.vstatus_id AND v.mem_id=".$_REQUEST['memid']." ORDER BY v.vid_id DESC";

// SELECT v.*, s.vstatus_name , (SELECT COUNT(vcom_id) FROM vid_comments WHERE vstatus_id=1 AND vid_id=v.vid_id) AS totalComments FROM videos AS v, vstatus AS s WHERE s.vstatus_id=v.vstatus_id AND mem_id=".$_SESSION['UserID']." ORDER BY vid_id DESC

				$rs = mysql_query($strQry);
				if(mysql_num_rows($rs)>0){
					while($row=mysql_fetch_object($rs)){
						$count++;
						$showDate = "";
						if($row->vid_dateadded!=""){
							$vidDate = explode("-", $row->vid_dateadded);
							$showDate = @date("M j, Y", mktime (0, 0, 0, $vidDate[1],$vidDate[2],$vidDate[0]));
						}
						if($count%2==0){
							$strClass = "ListRow1";
						}
						else{
							$strClass = "ListRow1";
						}
						$isFeatured = "No";
						if($row->vid_featured == 1){
							$isFeatured = "Yes";
						}
				?>
					<tr>
						<td class="<?php print($strClass);?>" align="center"><input type="checkbox" name="chkstatus[]" value="<?php print($row->vid_id);?>"></td>
						<td class="<?php print($strClass);?>" align="left"><a href="<?php print($_SERVER['PHP_SELF']."?show=1&vid=".$row->vid_id."&memid=".$_REQUEST['memid']);?>" title="<?php print($row->vid_name);?>"><?php print($row->vid_name);?></a></td>
						<td class="<?php print($strClass);?>" align="left"><?php print($row->cat_name);?></td>
						<td class="<?php print($strClass);?>" align="center"><?php print($isFeatured);?></td>
					    <td class="<?php print($strClass);?>" align="center"><a href="manage_comments.php?vid=<?php print($row->vid_id);?>&memid=<?php print($row->mem_id);?>" title="View Comments"><?php print($row->totalComments);?></a></td>
						<td class="<?php print($strClass);?>" align="right"><?php print($row->vid_views);?></td>
						<td class="<?php print($strClass);?>" align="right"><?php print($row->vid_price);?></td>
						<td class="<?php print($strClass);?>" align="left"><?php print($showDate);?></td>
						<td class="<?php print($strClass);?>" align="center"><?php print($row->vstatus_name);?></td>
                        <td class="<?php print($strClass);?>" align="center"><a href="download.php?vid_id=<?php echo $row->vid_id;?>">Download Video</a></td>
						<td class="<?php print($strClass);?>" align="center">
				<?php	if($row->vid_home==1){ ?>
							<b>Shown</b>
				<?php 	} else{ ?>
							<a href="<?php print($_SERVER['PHP_SELF']."?showHome=1&vid=".$row->vid_id."&memid=".$row->mem_id);?>" title="Show on Homepage">Show</a>
				<?php 	} ?>
						</td>
					</tr>
			<?php
					}
				}
				else{
			?>
							<tr><td colspan="9" class="ListRow1" align="center"><b>No Record Found</b></td></tr>
			<?php
				}
			?>	
						</table>
					</td>
				</tr>
				<tr>
					<td height="30" align="center">
						<input type="submit" name="btnPending" value="Pending" class="inputButton">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnApproved" value="Approved" class="inputButton">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnFeatured" value="Featured" class="inputButton">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnUnFeatured" value="Not Featured" class="inputButton">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnDenied" value="Denied" class="inputButton">&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnBlocked" value="Blocked" class="inputButton">
					</td>
				</tr>
			</form>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
<?php include("../lib/closeCon.php"); ?>
