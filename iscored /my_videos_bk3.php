<?php 
include("include/php_includes_top.php"); 
if(!isset($_SESSION['UserID'])){
	header("location: login.php");
}
if(isset($_REQUEST['btnUpload'])){
	$op = 1;
	$cbocat     = $_REQUEST['cbocat'];
	$vidname    = $_REQUEST['vidname'];
	$vidprice   = $_REQUEST['vidprice'];
	$viddetails = $_REQUEST['viddetails'];
	$vidid = getMaximum("videos","vid_id");
	$dirName = "videos/main";
	//$dirClip = "videos/clips";
	$dirThumb = "videos/thumbs";
	//$dirSmall = "videos/small";
	$mfileName = "";
	if (!empty($_FILES["vFile"]["name"])){
		$getFileName = explode(".", $_FILES["vFile"]["name"]);
		$tmpFile = $dirName."/".$vidid."_".str_replace(" ", "_", $_FILES["vFile"]["name"]);
		$mfileName = $vidid."_".str_replace(" ", "_", $getFileName[0]).".flv";
		$imgFile = $vidid."_".str_replace(" ", "_", $getFileName[0]).".jpg";
		$mediaFile = $dirName."/".$mfileName;
		if(move_uploaded_file($_FILES['vFile']['tmp_name'], $tmpFile)){
			// Convert File to FLV
			$getDuration = "/usr/bin/ffmpeg -i ".$tmpFile." 2>&1 | grep \"Duration\" | cut -d \" \" -f 4 - | sed s/,//";
			$retDuration = shell_exec($getDuration);
			$vidTime = convert_time_seconds($retDuration);
			if($getFileName[1] != 'flv'){
				$cmdMain = "/usr/bin/ffmpeg -i ".$tmpFile." -ab 56 -y -ar 44100 -s 640x480 -f flv ".$mediaFile;
				$retValue = shell_exec($cmdMain);
			}
			// Create a short clip from a file
			//$cmdClip = "/usr/local/bin/ffmpeg -i ".$mediaFile." -sameq -ss 00:00:00 -t 00:00:30 ".$dirClip."/".$mfileName;
			//$retValue = shell_exec($cmdClip);
			// Create a thumbnail image
			$cmdThumb = "/usr/bin/ffmpeg -itsoffset -8  -i ".$mediaFile." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 122x69 ".$dirThumb."/".$imgFile;
			$retValue = shell_exec($cmdThumb);
			// Create a small image
			//$cmdSmall = "/usr/local/bin/ffmpeg  -itsoffset -8  -i ".$mediaFile." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 60x54 ".$dirSmall."/".$imgFile;
			//$retValue = shell_exec($cmdSmall);
			// Delete the original file
			if($getFileName[1] != 'flv'){
				//@unlink($tmpFile);
			}
		}
		else{
			$op = 3;
		}
	}
	mysql_query("INSERT INTO videos (vid_id, mem_id, cat_id, vid_name, vid_price, vid_file_path, vid_thumb, vid_details, vid_dateadded, vstatus_id, vid_length) VALUES(".$vidid.", ".$_SESSION["UserID"].", '".$cbocat."', '".$vidname."', '".$vidprice."', '".$mfileName."', '".$imgFile."', '".$viddetails."', '".@date("Y-m-d")."', 1, ".$vidTime.")");
	$arrTag = explode(",", $_REQUEST['txttags']);
	for($i=0; $i<count($arrTag); $i++){
		$tagID = returnID("tag_id", "tags", "tag_name", trim($arrTag[$i]));
		if($tagID == 0){
			$tagID = getMaximum("tags","tag_id");
			mysql_query("INSERT tags (tag_id, tag_name) VALUES (".$tagID.", '".trim($arrTag[$i])."')");
			mysql_query("INSERT video_tags (vid_id, tag_id) VALUES (".$vidid.", ".$tagID.")");
		}
		else{
			mysql_query("INSERT video_tags (vid_id, tag_id) VALUES (".$vidid.", ".$tagID.")");
		}
	}
	include("lib/transfer.php");
	header("Location: my_videos.php?op=".$op."&hddn=".$hddn);
}
elseif(isset($_REQUEST['udt'])){
	if(isset($_REQUEST['btnUpdate'])){
		$vidid     = $_REQUEST['vidid'];
		$cbocat     = $_REQUEST['cbocat'];
		$vidname    = $_REQUEST['vidname'];
		$vidprice   = $_REQUEST['vidprice'];
		$viddetails = $_REQUEST['viddetails'];
		$mfileName = $_REQUEST['mfileName'];
		$thumbName = $_REQUEST['thumbName'];
		$dirName = "videos/main";
		//$dirClip = "videos/clips";
		$dirThumb = "videos/thumbs";
		//$dirSmall = "videos/small";
		if (!empty($_FILES["vFile"]["name"])){
			@unlink($dirName."/".$mfileName);
			//@unlink($dirClip."/".$mfileName);
			@unlink($dirThumb."/".$mfileName);
			//@unlink($dirSmall."/".$mfileName);
			$getFileName = explode(".", $_FILES["vFile"]["name"]);
			$tmpFile = $dirName."/".$vidid."_".str_replace(" ", "_", $_FILES["vFile"]["name"]);
			$mfileName = $vidid."_".str_replace(" ", "_", $getFileName[0]).".flv";
			$imgFile = $vidid."_".str_replace(" ", "_", $getFileName[0]).".jpg";
			$mediaFile = $dirName."/".$mfileName;
			
			//$mfileName = $vidid."_".$_FILES["vFile"]["name"];
			//@move_uploaded_file($_FILES['vFile']['tmp_name'], $dirName."/".$mfileName);
			if(move_uploaded_file($_FILES['vFile']['tmp_name'], $tmpFile)){
				// Convert File to FLV
				$getDuration = "/usr/bin/ffmpeg -i ".$tmpFile." 2>&1 | grep \"Duration\" | cut -d \" \" -f 4 - | sed s/,//";
				$retDuration = shell_exec($getDuration);
				$vidTime = convert_time_seconds($retDuration);
			
				// Convert File to FLV
				$cmdMain = "/usr/bin/ffmpeg -i ".$tmpFile." -ab 56 -y -ar 44100 -s 640x480 -f flv ".$mediaFile;
				$retValue = shell_exec($cmdMain);
				// Create a short clip from a file
				//$cmdClip = "/usr/local/bin/ffmpeg -i ".$mediaFile." -sameq -ss 00:00:00 -t 00:00:30 ".$dirClip."/".$mfileName;
				//$retValue = shell_exec($cmdClip);
				// Create a thumbnail image
				$cmdThumb = "/usr/bin/ffmpeg  -itsoffset -8  -i ".$mediaFile." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 122x69 ".$dirThumb."/".$imgFile;
				$retValue = shell_exec($cmdThumb);
				// Create a small image
				//$cmdSmall = "/usr/local/bin/ffmpeg  -itsoffset -8  -i ".$mediaFile." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 60x54 ".$dirSmall."/".$imgFile;
				//$retValue = shell_exec($cmdSmall);
				// Delete the original file
				//@unlink($tmpFile);
			}
			else{
				$mfileName = $_REQUEST['mfileName'];
				$thumbName = $_REQUEST['thumbName'];
 				$op = 3;
			}
		}
		mysql_query("UPDATE videos SET cat_id = '".$cbocat."', vid_name = '".$vidname."', vid_price = '".$vidprice."', vid_file_path = '".$mfileName."', vid_thumb='".$thumbName."', vid_details = '".$viddetails."', vid_length=".$vidTime." WHERE vid_id = ".$vidid);
		mysql_query("DELETE FROM video_tags WHERE vid_id=".$vidid);
		$arrTag = explode(",", $_REQUEST['txttags']);
		for($i=0; $i<count($arrTag); $i++){
			$tagID = returnID("tag_id", "tags", "tag_name", trim($arrTag[$i]));
			if($tagID == 0){
				$tagID = getMaximum("tags","tag_id");
				mysql_query("INSERT tags (tag_id, tag_name) VALUES (".$tagID.", '".trim($arrTag[$i])."')");
				mysql_query("INSERT video_tags (vid_id, tag_id) VALUES (".$vidid.", ".$tagID.")");
			}
			else{
				mysql_query("INSERT video_tags (vid_id, tag_id) VALUES (".$vidid.", ".$tagID.")");
				mysql_query("UPDATE tags SET tag_total=tag_total+1 WHERE tag_id=".$tagID);
			}
		}
		$strMSG = "Your Video has been updated successfully.";
		include("lib/transfer.php");
		header("Location: my_videos.php?op=".$op."&hddn=".$hddn);
	}
	else{
		$nResult = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST["vidid"]);
		if(mysql_num_rows($nResult)>=1){
			$vrow = mysql_fetch_object($nResult);
			$cbocat     = $vrow->cat_id;
			$vidname    = $vrow->vid_name;
			$vidprice   = $vrow->vid_price;
			$mfileName = $vrow->vid_file_path;
			$thumbName = $vrow->vid_thumb;
			$viddetails = $vrow->vid_details;
			$txttags = videoTags($_REQUEST["vidid"]);
		}
	}
}
elseif(isset($_REQUEST['del'])){
	$isExist = chkExist("ord_id", "orders", "WHERE vid_id=".$_REQUEST['vidid']);
	if($isExist == 0){
		$rs1 = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST['vidid']);
		if(mysql_num_rows($rs1)>0){
			$rVid=mysql_fetch_object($rs1);
			$vidName = $rVid->vid_name;
			$mediaName = $rVid->vid_file_path;
			$clipPath = "videos/clips/".$rVid->vid_clip_path;
			$mediaPath = "videos/main/".$rVid->vid_file_path;
			$thumbName = "videos/thumbs".$rVid->vid_thumb;
			@unlink($clipPath);
			@unlink($mediaPath);
			@unlink($thumbName);
			mysql_query("DELETE FROM videos WHERE vid_id=".$_REQUEST['vidid']);
			include("lib/ftp_delete.php");
			if($hddn==1){
				$strMSG = "Record Deleted";
			}
			else{
				//$strMSG = "Record Deleted but media file not deleted from Media Server.";
				$strMSG = "Record Deleted";
			}
		}
		else{
			$strMSG = "Record Not Found!";
		}
	}
	else{
		$strMSG = "You can't delete this as this video is purchased by other users and if you delete then it will no longer be available to view for paid members.";
	}
}
else{
	$cbocat="";
	$vidname="";
	$vidprice="";
	$vFILE = "";
	$viddetails="";
	$txttags=""; 
}

if(isset($_REQUEST['vid'])){
	$rs1 = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST['vid']);
	if(mysql_num_rows($rs1)>0){
		$rVid=mysql_fetch_object($rs1);
		$vidName = $rVid->vid_name;
		$clipPath = "videos/clips/".$rVid->vid_clip_path;
		$mediaPath = "videos/main/".$rVid->vid_file_path;
		$vidDuration = $rVid->vid_length;
		$mediaName = $rVid->vid_file_path;
	}
}

if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$strMSG2 = "";
			if($_REQUEST['hddn']==0){
				$strMSG2 = " but your file is not transferred at our Media Server. Please try again and if see the same message again and contact our site admin.";
			}
			$strMSG = "Record Added Successfully".$strMSG2;
			break;
		case 2:
			if($_REQUEST['hddn']==0){
				$strMSG2 = " but your file is not transferred at our Media Server. Please try again and if see the same message again and contact our site admin.";
			}
			$strMSG = "Record Updated Successfully".$strMSG2;
			break;
		case 3:
			$strMSG = "File not uploaded. Please try again!";
			break;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include("include/html_head.php"); ?>
<script language="JavaScript">
function checkRequired(){
	if (document.form1.vidname.value=="" || IsBlank("form1","vidname")==false){
		alert("Video Title Required!");
		document.form1.vidname.focus();
		return (false);
	}
	if (document.vidprice.txtpass.value=="" || IsBlank("form1","vidprice")==false){
		alert("Video Price Required!");
		document.form1.vidprice.focus();
		return (false);
	}
	if (document.form1.viddetails.value=="" || IsBlank("form1","viddetails")==false){
		alert("Video Details Required!");
		document.form1.viddetails.focus();
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
					<h3>MY VIDEOS</h3>
					<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
					<p align="center" class="clsred"><?php print($strMSG);?></p>
					<br />
					<?php if(isset($_REQUEST['show'])){ 
						$clipDuration = $vidDuration;
					?>
						<h4><?php print($vidName); ?></h4>
                        <div class="video_area">
							<div class="pageultype1sub1"><a href="vod/iscored.algie/<?php print($mediaName);?>" style="display:block;width:608px;height:496px;" id="player1"></a></div>
							<?php include("include/flowplayer.php");?>
                        </div>
						<br />
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
					<?php } elseif(isset($_REQUEST['action'])){ ?>
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<form name="form1" method="post" action="<?php print($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);?>" enctype="multipart/form-data" onsubmit="return checkRequired();">
							<tr>
								<td align="right" width="180">Caterory: </td>
								<td><select id="cbocat" name="cbocat" class="select">
										<?php FillSelected("categories", "cat_id", "cat_name", $cbocat); ?>
									</select>
									&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /> </td>
							</tr>
							<tr>
								<td align="right">Video Title: </td>
								<td><input type="text" name="vidname" value="<?php print($vidname);?>" class="input" style="width:280px;"  />
									&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
							</tr>
							<tr>
								<td align="right">Price: </td>
								<td><input type="text" name="vidprice" value="<?php print($vidprice);?>" class="input" style="width:100px; text-align: right;" />
									&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
							</tr>
							<tr>
								<td align="right">Video: </td>
								<td><input type="file" name="vFile" style="width:280px;"  />
									&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
							</tr>
							<tr>
								<td align="right" valign="top" style="padding-top:4px;">Tags / Keywords: </td>
								<td><textarea name="txttags" class="input" style="width:330px; height:60px;"><?php print($txttags);?></textarea></td>
							</tr>
							<tr>
								<td align="right" valign="top" style="padding-top:4px;">Details: </td>
								<td><textarea name="viddetails" class="input" style="width:330px; height:60px;"><?php print($viddetails);?></textarea>
									&nbsp;&nbsp;<img src="images/required.gif" width="9" height="10" border="0" alt="Required Field" title="Required Field" /></td>
							</tr>
							<tr>
								<td align="right"></td>
								<td height="40"><?php if(isset($_REQUEST['udt'])){?>
									<input type="hidden" name="mfileName" value="<?php print($mfileName);?>" />
									<input type="hidden" name="thumbName" value="<?php print($thumbName);?>" />
									<input type="submit" name="btnUpdate" value="Update >> >>" />
									<?php } else{ ?>
									<input type="submit" name="btnUpload" value="Upload >> >>" />
									<?php } ?>
									&nbsp;&nbsp;
									<input type="button" name="btnCancel" value="Cancel >> >>" onclick="javascript: window.location='my_videos.php';" />
								</td>
							</tr>
						</form>
					</table>
					<br />
					<?php } else{ ?>
					<p>
					<table width="100%" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td align="right"><a href="<?php print($_SERVER['PHP_SELF']."?action=1");?>" title="Upload Video">Upload Video</a></td>
						</tr>
					</table>
					<table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
						<tr>
							<td align="center" class="TableHeads" height="28" width="30">#</td>
							<td align="center" class="TableHeads" height="28">Name</td>
                            <td align="center" class="TableHeads" height="28">No of Comments </td>
							<td align="center" class="TableHeads" height="28" width="60">Views</td>
							<td align="center" class="TableHeads" height="28" width="60">Status</td>
							<td align="center" class="TableHeads tbl_rightCornor" height="28" width="100">Actions</td>
						</tr>
						<?php
	$count=0;
	$strClass = "ListRow1";
	$rs = mysql_query(" SELECT v.*, s.vstatus_name, (SELECT COUNT(vcom_id) FROM vid_comments WHERE vstatus_id=1 AND vid_id=v.vid_id) AS totalComments FROM videos AS v, vstatus AS s WHERE s.vstatus_id=v.vstatus_id AND mem_id=".$_SESSION['UserID']." ORDER BY vid_id DESC
");
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_object($rs)){
			$count++;
			if($count%2==0){
				$strClass = "ListRow1";
			}
			else{
				$strClass = "ListRow1";
			}
?>
						<tr>
							<td class="<?php print($strClass);?>" align="right" style="padding-right:2px;"><?php print($count);?></td>
							<td class="<?php print($strClass);?>" align="left"><a href="<?php print($_SERVER['PHP_SELF']."?show=1&vid=".$row->vid_id);?>"><?php print($row->vid_name);?></a></td>
                            <td class="<?php print($strClass);?>" align="center"><a href="comment_video.php?vid=<?php print($row->vid_id);?>#comments" title="View Comments"><?php print($row->totalComments);?></a></td>
							<td class="<?php print($strClass);?>" align="center"><?php print($row->vid_views);?></td>
							<td class="<?php print($strClass);?>" align="center"><?php print($row->vstatus_name);?></td>
							<td class="<?php print($strClass);?>" align="center"><a href="<?php print($_SERVER['PHP_SELF']."?action=1&udt=1&vidid=".$row->vid_id);?>" title="Edit">Edit</a> | <a href="<?php print($_SERVER['PHP_SELF']."?del=1&vidid=".$row->vid_id);?>" title="Delete">Delete</a></td>
						</tr>
						<?php
		}
	}else{
			?>
								<tr>
									<td colspan="7" class="ListRow1" align="center"><b>No Record Found</b></td>
								</tr>
								<?php
					}
			?>
					</table>
					</p>
					<?php } ?>
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
