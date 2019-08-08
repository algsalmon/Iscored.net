<?php
include("include/php_includes_top.php");
ob_start();
include("lib/openCon.php");

if(isset($_REQUEST['vid'])){
	$rs1 = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST['vid']);
	if(mysql_num_rows($rs1)>0){
		$rVid=mysql_fetch_object($rs1);
		$clipPath = "videos/clips/".$rVid->vid_clip_path;
		$mediaPath = "videos/main/".$rVid->vid_file_path;
		$vidName = $rVid->vid_name;
	}
}
else{
	$strHead = "Video not found";
	$strMSG = "Video you are looking for is not available or not found";
	include("message.php");
	die();
}

if(isset($_REQUEST['btnComments'])){
	$comid = getMaximum("vid_comments","vcom_id");
	mysql_query("INSERT INTO vid_comments(vcom_id, vid_id, mem_id, vcom_comment, vcom_date, vstatus_id) VALUES(".$comid.", ".$_REQUEST['vid'].", ".$_SESSION["UserID"].", '".$_REQUEST['txtcomments']."', '".@date("Y-m-d")."', 0)");
	header("Location: view_video.php?op=1&vid=".$_REQUEST['vid']);
}

if(isset($op)){
	switch ($op) {
		case 1:
			$strMSG = "Comments Added Successfully";
			break;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/html_head.php"); ?>
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
				<h3><?php print($vidName);?></h3>
				<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
				<h4>Comments</h4>
				<table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
					<?php
	$strQry = "SELECT  v.*, m.mem_name FROM vid_comments AS v, members as m WHERE m.mem_id=v.mem_id AND v.vid_id=".$_REQUEST['vid']." AND v.vstatus_id=1 ORDER BY v.vcom_id DESC";
	$rs = mysql_query($strQry);
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_object($rs)){
?>
					<tr>
						<td width="130" class="comments_left" align="left" valign="top"><b><?php print($row->mem_name);?></b><br />
							<?php print($row->vcom_date);?> </td>
						<td class="comments_right" align="left" valign="top"><?php print($row->vcom_comment);?></td>
                         
               	</tr>
					<?php
		}
	}
	else{
?>
					<tr><td align="center">No Comments Found</td></tr>
<?php
	}
?>
				</table>
                <p align="right"><a href="my_videos.php"><input type="button" name="back" value="Back" /></a></p>
				<div class="banner_area_left"><?php showBanner1(2, "BottomLeft"); ?></div>
				<br />
			</div>
			<!--content_left_side end here-->
			<div id="content_right_side">
				<?php include("include/right.php"); ?>
			</div>
		</div>
		<!--content end here-->
		<?php include("include/footer.php"); ?>
	</div>
</div>
</body>
</html>
<?php include("include/php_includes_bottom.php"); ?>
