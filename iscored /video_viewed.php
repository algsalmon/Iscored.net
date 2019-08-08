<?php 
include("include/php_includes_top.php"); 
if(!isset($_SESSION['UserID'])){
	header("location: login.php");
}
if(isset($_REQUEST['vid'])){
	$rs1 = mysql_query("SELECT * FROM videos WHERE vid_id=".$_REQUEST['vid']);
	if(mysql_num_rows($rs1)>0){
		$rVid=mysql_fetch_object($rs1);
		$vidName = $rVid->vid_name;
		$clipPath = "videos/clips/".$rVid->vid_file_path;
		$mediaPath = "videos/main/".$rVid->vid_file_path;
		$vidDuration = $rVid->vid_length;
		$mediaName = $rVid->vid_file_path;
	}
}
if(isset($_REQUEST['btnComments'])){
	$comid = getMaximum("vid_comments","vcom_id");
	mysql_query("INSERT INTO vid_comments(vcom_id, vid_id, mem_id, vcom_comment, vcom_date, vstatus_id) VALUES(".$comid.", ".$_REQUEST['vid'].", ".$_SESSION["UserID"].", '".$_REQUEST['txtcomments']."', '".@date("Y-m-d")."', 0)");
	header("Location: ".$_SERVER['PHP_SELF']."?op=1&vid=".$_REQUEST['vid']);
}

if(isset($_REQUEST['op'])){
	switch ($_REQUEST['op']) {
		case 1:
			$strMSG = "Comments Added Successfully";
			break;
		case 2:
			$strMSG = "You already puchased the video, please see below the list of videos.";
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
                        <h3>PURCHASED VIDEOS</h3>
						<div id="showMSG" class="clsred" align="center" style="display:block; visibility:visible;"><?php print($strMSG);?></div>
                   	<?php if(isset($_REQUEST['show'])){ 
						$clipDuration = $vidDuration;
					?>
						<h4><?php print($vidName); ?></h4>
                        <div class="video_area">
							<div class="pageultype1sub1"><a href="vod/iscorednew.algie/<?php print($mediaName);?>" style="display:block;width:608px;height:496px;" id="player1"></a></div>
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
                    <br />
						<p>
						<table width="100%" border="0" cellpadding="2" cellspacing="1" class="ListTables">
							<tr>
								<td align="center" class="TableHeads" height="28" width="30">#</td>
								<td align="center" class="TableHeads" height="28">Video Name</td>
								<td align="center" class="TableHeads" height="28" width="100">Date</td>
								<td align="center" class="TableHeads" height="28" width="60">Status </td>
                                <td align="center" class="TableHeads tbl_rightCornor" height="28" width="120">Transaction</td>
							</tr>
			<?php
		$count=0;
		$strClass = "ListRow1";
		$rs = mysql_query("SELECT o.*, v.vid_name, v.vid_price, s.pstatus_name FROM orders AS o, videos AS v, pay_status AS s WHERE s.pstatus_id=o.pstatus_id AND v.vid_id=o.vid_id AND o.mem_id=".$_SESSION['UserID']." ORDER BY o.ord_id DESC");
		//$rs = mysql_query("SELECT v.*, s.vstatus_name FROM videos AS v, vstatus AS s WHERE s.vstatus_id=v.vstatus_id AND mem_id=".$_SESSION['UserID']." ORDER BY vid_id DESC");
		if(mysql_num_rows($rs)>0){
			while($row=mysql_fetch_object($rs)){
				$count++;
				$showDate = "";
				if($row->ord_date!=""){
					$ordDate = explode("-", $row->ord_date);
					$showDate = @date("M j, Y", mktime (0, 0, 0, $ordDate[1],$ordDate[2],$ordDate[0]));
				}
				if($count%2==0){
					$strClass = "ListRow1";
				}
				else{
					$strClass = "ListRow1";
				}
	?>
                <tr>
                    <td class="<?php print($strClass);?>" align="right" style="padding-right:2px;"><?php print($count);?></td>
                    <td class="<?php print($strClass);?>" align="left">
					<?php if($row->pstatus_id == 1){ ?>
						<a href="<?php print($_SERVER['PHP_SELF']."?show=1&vid=".$row->vid_id);?>" title="<?php print($row->vid_name);?>"><?php print($row->vid_name);?></a>
					<?php } else{
							print($row->vid_name);
						}
					?>
					</td>
                    <td class="<?php print($strClass);?>" align="center"><?php print($showDate);?></td>
                    <td class="<?php print($strClass);?>" align="center"><?php print($row->pstatus_name);?></td>
                    <td class="<?php print($strClass);?>" align="center"><?php ?>
					<?php if($row->pstatus_id == 1){ 
							print($row->ord_trans_id);
						  } else{ ?>
							<!--<input type="button" name="btnPayNow" value="RBS" onclick="javascript: payNow('<?php //print($row->ord_id);?>', '<?php //print($row->vid_price);?>', '<?php //print($row->vid_name);?>');" />
							<input type="button" name="btnPayNow" value="Paypal" onclick="javascript: payNowPaypal('<?php //print($row->ord_id);?>', '<?php //print($row->vid_price);?>', '<?php //print($row->vid_id);?>', '<?php //print($row->vid_name);?>');" />-->
							<span><a href="javascript: payNow('<?php print($row->ord_id);?>', '<?php print($row->vid_price);?>', '<?php print($row->vid_name);?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
							<span><a href="javascript: payNowPaypal('<?php print($row->ord_id);?>', '<?php print($row->vid_price);?>', '<?php print($row->vid_id);?>', '<?php print($row->vid_name);?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
					<?php } ?>
					</td>
                </tr>
							<?php
			}
		}
		else{
	?>
				<tr><td colspan="5" align="center" class="ListRow1">No Record Found</td></tr>
	<?php
		}
	?>
						</table>
						</p>
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
