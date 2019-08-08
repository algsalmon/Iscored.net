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
                    	<h2>Latest Video</h2>
<?php
	$rsLatestVid = mysql_query("SELECT * FROM videos WHERE vstatus_id=1 ORDER BY vid_id DESC LIMIT 0,1");
	if(mysql_num_rows($rsLatestVid)>0){
		$rowLatestVid=mysql_fetch_object($rsLatestVid);
		//$clipPath = "videos/clips/".$rowLatestVid->vid_file_path;
		$mediaPath = "videos/main/".$rowLatestVid->vid_file_path;
	}
?>
                        <div class="video_area"><!--<img src="images/media_player.jpg" alt="player" width="608" height="403" />-->
							<div class="pageultype1sub1"><a href="vod/iscored.algie/3_test.flv" style="display:block;width:608px;height:496px;" id="player1"></a></div>
<script type="text/javascript">
flowplayer("player1", "flowplayer/flowplayer-3.2.2.swf", {
    log: {
        level: 'debug',
        filter: 'org.flowplayer.slowmotion.*'
    },
    plugins: {
        slowmotion: {
            url: 'flowplayer/flowplayer.slowmotion-3.2.0.swf'
        },
        rtmp: {
            url: 'flowplayer/flowplayer.rtmp-3.2.1.swf',
            netConnectionUrl: 'rtmp://rtmp01.hddn.com/play'
        },
        speedIndicator: {
            url: 'flowplayer/flowplayer.content-3.2.0.swf',
            bottom: 50,
            right: 15,
            width: 135,
            height: 30,
            border: 'none',
            style: {
                body: {
                    fontSize: 12,
                    fontFamily: 'Arial',
                    textAlign: 'center',
                    color: '#ffffff'
                }
            },
            backgroundColor: 'rgba(20, 20, 20, 0.5)',
            display: 'none'
        },
        controls: {
            tooltips: {
                buttons: true
            }
        }
    },
    clip: {
        provider: 'rtmp',
        scaling: 'orig'
    }
});
$f().onLoad(function () {
    $("#actions").css("opacity", 1);
    $("#actions button").removeAttr("disabled")
});
$f().onUnload(function () {
    $("#actions").css("opacity", 0.5);
    $("#actions button").attr("disabled", true)
});
var actions = {
    backward: function (speed) {
        $f().getPlugin('slowmotion').backward(speed)
    },
    forward: function (speed) {
        $f().getPlugin('slowmotion').forward(speed)
    },
    normal: function () {
        $f().getPlugin('slowmotion').normal()
    }
}
</script>
<div id="actions" style="text-align:center;opacity:1;width:640px;margin-top: 10px;">
<button type="button" class="custom low small" disabled onclick="actions.backward(8)"> Back 8 x </button>
<button type="button" class="custom low small" disabled onclick="actions.backward(4)"> Back 4 x </button>
<button type="button" class="custom low small" disabled onclick="actions.backward(2)"> Back 2 x </button>
<button type="button" class="custom low small" disabled onclick="actions.normal()"> Normal </button>
<button type="button" class="custom low small" disabled onclick="actions.forward(2)"> Fwd 2 x </button>
<button type="button" class="custom low small" disabled onclick="actions.forward(4)"> Fwd 4 x </button>
<button type="button" class="custom low small" disabled onclick="actions.forward(8)"> Fwd 8 x </button>
<!--<button type="button" class="custom low large" disabled onclick="actions.backward(0.25)"> Backward 1/4 </button>
<button type="button" class="custom low large" disabled onclick="actions.backward(0.5)"> Backward half </button>
<button type="button" class="custom low large" disabled onclick="actions.forward(0.5)"> Forward half </button>
<button type="button" class="custom low large" disabled onclick="actions.forward(0.25)"> Forward 1/4 </button>-->
</div>
							
							
							
							<!--<div style="width:608px;height:496px;" id="player"></div>-->
							<script language="JavaScript">
								/*flowplayer(
									"player", 
									"flowplayer-3.2.2.swf", 
									"vod/iscored.algie/3_test.flv<?php //print($mediaPath);?>"
								);*/
						/*		
								// Working Fine
								flowplayer("player", "flowplayer-3.2.2.swf", {
									clip: {
										url: 'vod/iscored.algie/3_test.flv',
										autoPlay: true,
										provider: 'rtmp'
									},
									plugins: {
										rtmp: {
											url: 'flowplayer.rtmp-3.2.1.swf',
											netConnectionUrl: 'rtmpte://rtmp01.hddn.com/play'
										}
									}
								});
						*/		
							</script>
							<!--
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="608" height="496">
								<param name="movie" value="VideoPlayer.swf?url=<?php //print($mediaPath);?>&slowMotion=true&autoplay=false" />
								<param name="quality" value="high" />
								<param name="allowfullscreen" value="true" />
								<embed src="VideoPlayer.swf?url=<?php //print($mediaPath);?>&slowMotion=true&autoplay=false" allowfullscreen="true" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="608" height="496"></embed>
							</object>
							-->
						</div>
                        <br />
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
			$imgFile = "images/thumb1.jpg";
			if(!empty($rowFeatured->vid_thumb)){
				$imgFile = "videos/thumbs/".$rowFeatured->vid_thumb;
			}
			if($countFeatured>0){
?>
				<div class="featured_box_devider"></div>
<?php
			}
			$countFeatured++;
?>
                            	<div class="featured_box">
                                	<img src="<?php print($imgFile);?>" width="122" height="69" alt="" />
                                    <p><?php print($showDateFeatured);?></p>
                                    <h5><a href="view_video.php?vid=<?php print($rowFeatured->vid_id);?>" title="<?php print($rowFeatured->vid_name); ?>"><?php print($rowFeatured->vid_name); ?></a></h5>
									<div class="price2">$ <?php print($rowFeatured->vid_price);?></div>
                                    <p><a href="view_video.php?vid=<?php print($rowFeatured->vid_id);?>" title="Watch Now">Watch Now</a></p>
								<?php if(isset($_SESSION["UserID"])){ ?>
									<p><span><a href="javascript: insertOrder(<?php print($rowFeatured->vid_id);?>, <?php print($rowFeatured->cat_id);?>, '<?php print($rowFeatured->vid_name);?>', '<?php print($rowFeatured->vid_price);?>');" title="Buy this video">Buy this video</a></span></p>
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
			$imgFile = "images/thumb1.jpg";
			if(!empty($rowDiscussed->vid_thumb)){
				$imgFile = "videos/thumbs/".$rowDiscussed->vid_thumb;
			}
			if($countDiscussed>0){
?>
				<div class="featured_box_devider"></div>
<?php
			}
			$countDiscussed++;
?>
                            	<div class="featured_box">
                                	<img src="<?php print($imgFile);?>" alt="" />
                                    <p><?php print($showDateDiscussed);?></p>
									<h5><a href="view_video.php?vid=<?php print($rowDiscussed->vid_id);?>" title="<?php print($rowDiscussed->vid_name); ?>"><?php print($rowDiscussed->vid_name); ?></a></h5>
                                    <div class="price2">$ <?php print($rowDiscussed->vid_price);?></div>
									<p><a href="view_video.php?vid=<?php print($rowDiscussed->vid_id);?>" title="Watch Now">Watch Now</a></p>
								<?php if(isset($_SESSION["UserID"])){ ?>
									<p><span><a href="javascript: insertOrder(<?php print($rowDiscussed->vid_id);?>, <?php print($rowDiscussed->cat_id);?>, '<?php print($rowDiscussed->vid_name);?>', '<?php print($rowDiscussed->vid_price);?>');" title="Buy this video">Buy this video</a></span></p>
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
			$imgFile = "images/thumb1.jpg";
			if(!empty($rowViewed->vid_thumb)){
				$imgFile = "videos/thumbs/".$rowViewed->vid_thumb;
			}
			if($countViewed>0){
?>
				<div class="featured_box_devider"></div>
<?php
			}
			$countViewed++;
?>
                            	<div class="featured_box">
                                	<img src="<?php print($imgFile);?>" alt="" />
                                    <p><?php print($showDateViewed);?></p>
									<h5><a href="view_video.php?vid=<?php print($rowViewed->vid_id);?>" title="<?php print($rowViewed->vid_name); ?>"><?php print($rowViewed->vid_name); ?></a></h5>
									<div class="price2">$ <?php print($rowViewed->vid_price);?></div>
								    <p><a href="view_video.php?vid=<?php print($rowViewed->vid_id);?>" title="Watch Now">Watch Now</a></p>
								<?php if(isset($_SESSION["UserID"])){ ?>
									<p><span><a href="javascript: insertOrder(<?php print($rowViewed->vid_id);?>, <?php print($rowViewed->cat_id);?>, '<?php print($rowViewed->vid_name);?>', '<?php print($rowViewed->vid_price);?>');" title="Buy this video">Buy this video</a></span></p>
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
