<?php 
include("include/php_includes_top.php"); 

if(isset($_REQUEST['cid'])){
	$vidQry = "SELECT v.*, m.mem_name, (SELECT COUNT(vcom_id) FROM vid_comments WHERE vstatus_id=1 AND vid_id=v.vid_id) AS totalComments FROM videos AS v, members AS m WHERE m.mem_id=v.mem_id AND v.vstatus_id=1 AND v.cat_id=".$_REQUEST['cid']." ORDER BY v.vid_id DESC";
	$strHead = returnName("cat_name", "categories", "cat_id", $_REQUEST['cid']);
}
else{
	$vidQry = "SELECT v.*, m.mem_name, (SELECT COUNT(vcom_id) FROM vid_comments WHERE vstatus_id=1 AND vid_id=v.vid_id) AS totalComments FROM videos AS v, members AS m WHERE m.mem_id=v.mem_id AND v.vstatus_id=1 ORDER BY v.vid_id DESC";
	$strHead = "Latest Videos";
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
                    	<h3><?php print($strHead);?></h3>
						<div class="banner_area_left"><?php showBanner1(1, "TopLeft"); ?></div>
						<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
<?php
	//Selecting all Messages...
	$counter=0;
	/* Show many results per page? */ 
	$limit = 12; 
	/* Find the start depending on $_GET['page'] (declared if it's null) */ 
	$start = $p->findStart($limit); 
	/* Find the number of rows returned from a query; Note: Do NOT use a LIMIT clause in this query */ 
	$count = mysql_num_rows(mysql_query($vidQry)); 
	/* Find the number of pages based on $count and $limit */ 
	$pages = $p->findPages($count, $limit); 
	/* Now we use the LIMIT clause to grab a range of rows */ 
	//$nResult = mysql_query($Query." LIMIT ".$start.", ".$limit);
	$rs = mysql_query($vidQry." LIMIT ".$start.", ".$limit);
	//$rs = mysql_query($vidQry);
	if(mysql_num_rows($rs)>0){
		while($row=mysql_fetch_object($rs)){
			$showDate = "";
			if($row->vid_dateadded!=""){
				$vidDate = explode("-", $row->vid_dateadded);
				$showDate = @date("M j, Y", mktime (0, 0, 0, $vidDate[1],$vidDate[2],$vidDate[0]));
			}
			//$imgFile = "images/thumb1.jpg";
			$imgFile = "images/no_image1.jpg";
			if(!empty($row->vid_thumb)){
				$imgFile = "videos/thumbs/".$row->vid_thumb;
				if(!file_exists($imgFile)){
					$imgFile = "images/no_image1.jpg";
				}
			}
?>
						<div align="center" class="vid_box">
                            <div class="vid_box_left"><img src="<?php print($imgFile);?>" alt="" /></div>
                            <div align="left" class="vid_box_right">
                                <div class="video_details">
									<h4><a href="view_video.php?vid=<?php print($row->vid_id);?>" title="<?php print($row->vid_name);?>"><?php print($row->vid_name);?></a></h4>
									<p><?php print($row->vid_details);?></p>
									<p>
										Dated: <?php print($showDate);?> | 
										Views: <?php print($row->vid_views);?> | 
										<a href="view_video.php?vid=<?php print($row->vid_id);?>#comments" title="View Comments">Comments: <?php print($row->totalComments);?></a>
										<br />Uploaded By <b><?php print($row->mem_name);?></b>
									</p>
								</div>
								<div align="right" class="video_links">
									<div class="price">&pound; <?php print($row->vid_price);?></div>
									<p>
										<a href="view_video.php?vid=<?php print($row->vid_id);?>" title="Watch Now">Watch Now</a><br />
										<!--<span><a href="buy_now.php?vid=<?php print($row->vid_id);?>" title="Buy this video">Buy this video</a></span>-->
								<?php if(isset($_SESSION["UserID"])){ ?>
										<span><a href="javascript: insertOrder(<?php print($row->vid_id);?>, <?php print($row->cat_id);?>, '<?php print($row->vid_name);?>', '<?php print($row->vid_price);?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
										<span><a href="javascript: insertOrder2(<?php print($row->vid_id);?>, <?php print($row->cat_id);?>, '<?php print($row->vid_name);?>', '<?php print($row->vid_price);?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
										<!--<span><a href="javascript: insertOrder(<?php print($row->vid_id);?>, <?php print($row->cat_id);?>, '<?php print($row->vid_name);?>', '<?php print($row->vid_price);?>');" title="Buy this video">Buy this video</a></span>-->
								<?php } else{ ?>
										<span><a href="login.php?ref=1" title="Login to Buy">Login to Buy</a></span>
								<?php } ?>
									</p>
								</div>
								
                            </div>
                        </div>
                        <div class="clearer" style="height:4px;"></div>
<?php
		}
?>
						<div class="paging">
							<div class="paging_left"><?php print("Page <b>".$_GET['page']."</b> of ".$pages);?></div>
							<div class="paging_right">
							<?php	
								$next_prev = $p->nextPrev($_GET['page'], $pages, "");
								print($next_prev);
							?>
							</div>
						</div>
<?php
	}
	else{
?>
					<p>Sorry, there are no videos available for this category. Please visit again.</p>
<?php
	}
?>
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