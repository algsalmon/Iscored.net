<?php
include("include/php_includes_top.php");
ob_start();
//include("lib/openCon.php");

if(isset($_REQUEST['vid'])){
	$clipDuration = 20;
	$rs1 = mysql_query("SELECT v.*, m.mem_name, (SELECT COUNT(c.vcom_id) FROM vid_comments AS c WHERE c.vstatus_id=1 AND c.vid_id=v.vid_id) AS totalComments FROM videos As v, members AS m WHERE m.mem_id=v.mem_id AND v.vid_id=".$_REQUEST['vid']);
	if(mysql_num_rows($rs1)>0){
		$rVid=mysql_fetch_object($rs1);
		$catID = $rVid->cat_id;
		$clipPath = "videos/clips/".$rVid->vid_file_path;
		$mediaPath = "videos/main/".$rVid->vid_file_path;
		$mediaName = $rVid->vid_file_path;
		$vidName = $rVid->vid_name;
		$vidDetails = $rVid->vid_details;
		$vidViews = $rVid->vid_views;
		$totalComments = $rVid->totalComments;
		$memberName = $rVid->mem_name;
		$videoPrice = $rVid->vid_price;
		$videoDate = "";
		if($rVid->vid_dateadded!=""){
			$vidDate = explode("-", $rVid->vid_dateadded);
			$videoDate = @date("M j, Y", mktime (0, 0, 0, $vidDate[1],$vidDate[2],$vidDate[0]));
		}
		$totleView = $vidViews + 1;
		updateTBL("videos", "vid_views=".$totleView, "vid_id", $_REQUEST['vid']);
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
	mysql_query("INSERT INTO vid_comments(vcom_id, vid_id, mem_id, vcom_comment, vcom_date, vstatus_id) VALUES(".$comid.", ".$_REQUEST['vid'].", ".$_SESSION["UserID"].", '".$_REQUEST['txtcomments']."', '".@date("Y-m-d")."', 1)");
	header("Location: view_video.php?op=1&vid=".$_REQUEST['vid']);
}

if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
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
				<div class="video_area">
					<div class="pageultype1sub1"><a href="vod/iscorednew.algie/<?php print($mediaName);?>" style="display:block;width:608px;height:496px;" id="player1"></a></div>
					<?php include("include/flowplayer.php");?>
				</div>
				<br />
				<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
				<div class="vid_box">
					<div class="video_details2">
						<p><?php print($vidDetails); ?></p>
						<p class="p_padding">Tags: <?php print(videoTags($_REQUEST['vid']));?></p>
						<p class="p_padding">
							Uploaded By <b><?php print($memberName);?></b> | 
							Dated: <?php print($videoDate);?> | 
							Views: <?php print($vidViews);?> | 
							Comments: <?php print($totalComments);?>
						</p>
					</div>
					<div align="right" class="video_links">
						<div class="price">&pound; <?php print($videoPrice);?></div>
						<p>
							<?php if(isset($_SESSION["UserID"])){ ?>
									<span><a href="javascript: insertOrder(<?php print($_REQUEST['vid']);?>, <?php print($catID);?>, '<?php print($vidName);?>', '<?php print($row->vid_price);?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
									<span><a href="javascript: insertOrder2(<?php print($_REQUEST['vid']);?>, <?php print($catID);?>, '<?php print($vidName);?>', '<?php print($row->vid_price);?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
									<!--<span><a href="javascript: insertOrder(<?php print($_REQUEST['vid']);?>, <?php print($catID);?>, '<?php print($vidName);?>', '<?php print($row->vid_price);?>');" title="Buy this video">Buy this video</a></span>-->
							<?php } else{ ?>
									<span><a href="login.php?ref=1" title="Login to Buy">Login to Buy</a></span>
							<?php } ?>
						</p>
					</div>
				</div>
				<div class="clearer" style="height:10px;"></div>
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
				<br />
<?php if(!isset($_SESSION["UserID"])){ 
		$strMSG = "Please login to post comments";
?>
				<p align="center" class="clsred"><?php print($strMSG); ?></p>
				<br />
<?php } else{ ?>
				<p align="center" class="clsred"><?php print($strMSG); ?></p>
				<br />
				<h4><a name="comments"></a>Post Comments</h4>
				<br/>
				<table width="100%" border="0" cellpadding="2" cellspacing="0">
				<form name="frm" method="post" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>">
					<tr>
						<td width="100" align="right" valign="top">Comments: </td>
						<td valign="top"><textarea name="txtcomments" id="txtcomments" class="input" style="width:450px; height:100px;"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="left"><input type="submit" name="btnComments" id="btnComments" value="Submit"></td>
					</tr>
				</form>
				</table>
<?php } ?>
			<div class="banner_area_left"><?php showBanner1(2, "BottomLeft"); ?></div>
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
