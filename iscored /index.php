<?php include("include/php_includes_top.php"); ?>
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
<?php
	$clipDuration = 20;
	$rsLatestVid = mysql_query("SELECT * FROM videos WHERE vstatus_id=1 AND vid_home=1 ORDER BY vid_id DESC LIMIT 0,1");
	if(mysql_num_rows($rsLatestVid)>0){
		$rowLatestVid=mysql_fetch_object($rsLatestVid);
		//$clipPath = "videos/clips/".$rowLatestVid->vid_file_path;
		$mediaPath = "videos/main/".$rowLatestVid->vid_file_path;
?>
                        <h2><?php print($rowLatestVid->vid_name);?></h2>
						<div class="video_area"><!--<img src="images/media_player.jpg" alt="player" width="608" height="403" />-->
							<!--<div class="pageultype1sub1"><a href="vod/iscored.algie/3_test.flv" style="display:block;width:608px;height:496px;" id="player1"></a></div>-->
							<div class="pageultype1sub1"><a href="vod/iscorednew.algie/<?php print($rowLatestVid->vid_file_path);?>" style="display:block;width:608px;height:496px;" id="player1"></a></div>
							<?php include("include/flowplayer.php");?>						
						</div>
                        <br />
<?php } ?>
						<div class="banner_area_left"><?php showBanner1(1, "TopLeft"); ?></div>
						<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
						<div class="tabs_area tmarging">
                        	<ul>
								<li id="tab[0]" class="selected"><a href="javascript: showHideTab('0', '2');" title="Featured">Featured</a></li>
								<li id="tab[1]"><a href="javascript: showHideTab('1', '2');" title="Most Discussed">Most Discussed</a></li>
                            </ul>
                        </div>
                        <div  id="tdata[0]" style="visibility:hidden; display:none;"class="featured_area">
                        	<div class="featured_area_inner">
<?php
	$countFeatured = 0;
	$rsFeatured = mysql_query("SELECT * FROM videos WHERE vstatus_id=1 AND vid_featured=1 ORDER BY vid_id DESC LIMIT 0,4");
	if(mysql_num_rows($rsFeatured)>0){
		while($rowFeatured=mysql_fetch_object($rsFeatured)){
			$showDateFeatured = "";
			if($rowFeatured->vid_dateadded!=""){
				$vidDate = explode("-", $rowFeatured->vid_dateadded);
				$showDateFeatured = @date("M j, Y", mktime (0, 0, 0, $vidDate[1],$vidDate[2],$vidDate[0]));
			}
			//$imgFile = "images/thumb1.jpg";
			$imgFile = "images/no_image1.jpg";
			if(!empty($rowFeatured->vid_thumb)){
				$imgFile = "videos/thumbs/".$rowFeatured->vid_thumb;
				if(!file_exists($imgFile)){
					$imgFile = "images/no_image1.jpg";
				}
			}
			if($countFeatured>0){
?>
				<div class="featured_box_devider"></div>
<?php
			}
			$countFeatured++;
?>
                            	<div class="featured_box">
                                	<img class="imgShow" src="<?php print($imgFile);?>" width="122" height="69" alt="" />
                                    <p><?php print($showDateFeatured);?></p>
                                    <h5><a href="view_video.php?vid=<?php print($rowFeatured->vid_id);?>" title="<?php print($rowFeatured->vid_name); ?>"><?php print($rowFeatured->vid_name); ?></a></h5>
									<div class="price2">&pound; <?php print($rowFeatured->vid_price);?></div>
                                    <p><a href="view_video.php?vid=<?php print($rowFeatured->vid_id);?>" title="Watch Now">Watch Now</a></p>
								<?php if(isset($_SESSION["UserID"])){ ?>
									<p>
										<span><a href="javascript: insertOrder(<?php print($rowFeatured->vid_id);?>, <?php print($rowFeatured->cat_id);?>, '<?php print($rowFeatured->vid_name);?>', '<?php print($rowFeatured->vid_price);?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
										<span><a href="javascript: insertOrder2(<?php print($rowFeatured->vid_id);?>, <?php print($rowFeatured->cat_id);?>, '<?php print($rowFeatured->vid_name);?>', '<?php print($rowFeatured->vid_price);?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
									</p>
									<!--<p><span><a href="javascript: insertOrder(<?php print($rowFeatured->vid_id);?>, <?php print($rowFeatured->cat_id);?>, '<?php print($rowFeatured->vid_name);?>', '<?php print($rowFeatured->vid_price);?>');" title="Buy this video">Buy this video</a></span></p>-->
								<?php } else{ ?>
									<p><span>Login to Buy</span></p>
								<?php } ?>
                                </div>
<?php
		} 
	} 
?>
                            </div>
                        </div>
						<div  id="tdata[1]" style="visibility:hidden; display:none;" class="featured_area">
                        	<div class="featured_area_inner">
<?php
	$countDiscussed = 0;
	$rsDiscussed = mysql_query("SELECT v.*, (SELECT COUNT(vcom_id) FROM vid_comments WHERE vstatus_id=1 AND vid_id=v.vid_id) AS totalComments FROM videos AS v WHERE v.vstatus_id=1 ORDER BY totalComments DESC LIMIT 0,4");
	if(mysql_num_rows($rsDiscussed)>0){
		while($rowDiscussed=mysql_fetch_object($rsDiscussed)){
			$showDateDiscussed = "";
			if($rowDiscussed->vid_dateadded!=""){
				$vidDate = explode("-", $rowDiscussed->vid_dateadded);
				$showDateDiscussed = @date("M j, Y", mktime (0, 0, 0, $vidDate[1],$vidDate[2],$vidDate[0]));
			}
			//$imgFile = "images/thumb1.jpg";
			$imgFile = "images/no_image1.jpg";
			if(!empty($rowDiscussed->vid_thumb)){
				$imgFile = "videos/thumbs/".$rowDiscussed->vid_thumb;
				if(!file_exists($imgFile)){
					$imgFile = "images/no_image1.jpg";
				}
			}
			if($countDiscussed>0){
?>
				<div class="featured_box_devider"></div>
<?php
			}
			$countDiscussed++;
?>
                            	<div class="featured_box">
                                	<img class="imgShow" src="<?php print($imgFile);?>" alt="" />
                                    <p><?php print($showDateDiscussed);?></p>
									<h5><a href="view_video.php?vid=<?php print($rowDiscussed->vid_id);?>" title="<?php print($rowDiscussed->vid_name); ?>"><?php print($rowDiscussed->vid_name); ?></a></h5>
                                    <div class="price2">&pound; <?php print($rowDiscussed->vid_price);?></div>
									<p><a href="view_video.php?vid=<?php print($rowDiscussed->vid_id);?>" title="Watch Now">Watch Now</a></p>
								<?php if(isset($_SESSION["UserID"])){ ?>
									<p>
										<span><a href="javascript: insertOrder(<?php print($rowDiscussed->vid_id);?>, <?php print($rowDiscussed->cat_id);?>, '<?php print($rowDiscussed->vid_name);?>', '<?php print($rowDiscussed->vid_price);?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
										<span><a href="javascript: insertOrder2(<?php print($rowDiscussed->vid_id);?>, <?php print($rowDiscussed->cat_id);?>, '<?php print($rowDiscussed->vid_name);?>', '<?php print($rowDiscussed->vid_price);?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
									</p>
									<!--<p><span><a href="javascript: insertOrder(<?php print($rowDiscussed->vid_id);?>, <?php print($rowDiscussed->cat_id);?>, '<?php print($rowDiscussed->vid_name);?>', '<?php print($rowDiscussed->vid_price);?>');" title="Buy this video">Buy this video</a></span></p>-->
								<?php } else{ ?>
									<p><span>Login to Buy</span></p>
								<?php } ?>
                                </div>
<?php
		} 
	} 
?>
                            </div>
                        </div>
<script language="javascript">showHideTab('0', '2');</script>
                        <br />
						<div class="tabs_area tmarging">
                        	<ul>
								<li class="selected">Most Viewed</li>
                            </ul>
						</div>
                         <div class="featured_area">
                         	<div class="featured_area_inner">
<?php
	$countViewed = 0;
	$rsViewed = mysql_query("SELECT * FROM videos WHERE vstatus_id=1 ORDER BY vid_views DESC LIMIT 0,4");
	if(mysql_num_rows($rsViewed)>0){
		while($rowViewed=mysql_fetch_object($rsViewed)){
			$showDateViewed = "";
			if($rowViewed->vid_dateadded!=""){
				$vidDate = explode("-", $rowViewed->vid_dateadded);
				$showDateViewed = @date("M j, Y", mktime (0, 0, 0, $vidDate[1],$vidDate[2],$vidDate[0]));
			}
			//$imgFile = "images/thumb1.jpg";
			$imgFile = "images/no_image1.jpg";
			if(!empty($rowViewed->vid_thumb)){
				$imgFile = "videos/thumbs/".$rowViewed->vid_thumb;
				if(!file_exists($imgFile)){
					$imgFile = "images/no_image1.jpg";
				}
			}
			if($countViewed>0){
?>
				<div class="featured_box_devider"></div>
<?php
			}
			$countViewed++;
?>
                            	<div class="featured_box">
                                	<img class="imgShow" src="<?php print($imgFile);?>" alt="" />
                                    <p><?php print($showDateViewed);?></p>
									<h5><a href="view_video.php?vid=<?php print($rowViewed->vid_id);?>" title="<?php print($rowViewed->vid_name); ?>"><?php print($rowViewed->vid_name); ?></a></h5>
									<div class="price2">&pound; <?php print($rowViewed->vid_price);?></div>
								    <p><a href="view_video.php?vid=<?php print($rowViewed->vid_id);?>" title="Watch Now">Watch Now</a></p>
								<?php if(isset($_SESSION["UserID"])){ ?>
									<p>
										<span><a href="javascript: insertOrder(<?php print($rowViewed->vid_id);?>, <?php print($rowViewed->cat_id);?>, '<?php print($rowViewed->vid_name);?>', '<?php print($rowViewed->vid_price);?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
										<span><a href="javascript: insertOrder2(<?php print($rowViewed->vid_id);?>, <?php print($rowViewed->cat_id);?>, '<?php print($rowViewed->vid_name);?>', '<?php print($rowViewed->vid_price);?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
									</p>
									<!--<p><span><a href="javascript: insertOrder(<?php print($rowViewed->vid_id);?>, <?php print($rowViewed->cat_id);?>, '<?php print($rowViewed->vid_name);?>', '<?php print($rowViewed->vid_price);?>');" title="Buy this video">Buy this video</a></span></p>-->
								<?php } else{ ?>
									<p><span><a href="login.php?ref=1" title="Login to Buy">Login to Buy</a></span></p>
								<?php } ?>
                                </div>
<?php
		} 
	} 
?>
                            </div>
                         </div>
						 <br />
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
