<?php if(isset($_SESSION["UserID"])){ ?>
<h1>My Account</h1>
<div class="recent_uploaded_box">
	<div class="inner">
		<ul>
			<li><a href="my_account.php" title="My Home">My Home</a></li>
			<li><a href="register.php?udt=1" title="Edit Profile">Edit Profile</a></li>
			<li><a href="my_videos.php" title="Uploaded Videos">Uploaded Videos</a></li>
			<li><a href="video_viewed.php" title="Purchased Videos">Purchased Videos</a></li>
			<li><a href="logout.php" title="Logout">Logout</a></li>
		</ul>
	</div>
</div>

<div class="banner_area_right"><?php showBanner1(3, "TopRight"); ?></div>
<?php }?>
<h1>Recently Uploaded</h1>
<div class="recent_uploaded_box">
	<div class="inner">
<?php
	$rsLatest = mysql_query("SELECT * FROM videos WHERE vstatus_id=1 ORDER BY vid_id DESC LIMIT 0,3");
	if(mysql_num_rows($rsLatest)>0){
		while($rowLatest=mysql_fetch_object($rsLatest)){
			//$imgPath = "images/small1.jpg";
			$imgPath = "images/no_image2.jpg";
			if(!empty($rowLatest->vid_thumb)){
				$imgPath = "videos/thumbs/".$rowLatest->vid_thumb;
				if(!file_exists($imgPath)){
					$imgPath = "images/no_image2.jpg";
				}
			}
?>
		<div class="recent_vid_box">
			<div class="img"><img src="<?php print($imgPath);?>" width="60" alt="<?php print($rowLatest->vid_name);?>" /></div>
			<div class="img_right">
				<h4><a href="view_video.php?vid=<?php print($rowLatest->vid_id);?>" title="<?php print($rowLatest->vid_name);?>"><?php print($rowLatest->vid_name);?></a></h4>
				<div class="img_right_links">
					<p><a href="view_video.php?vid=<?php print($rowLatest->vid_id);?>" title="Watch Now">Watch Now</a></p>
				<?php if(isset($_SESSION["UserID"])){ ?>
					<!--<p>
						<span><a href="javascript: insertOrder(<?php print($rowLatest->vid_id);?>, <?php print($rowLatest->cat_id);?>, '<?php print($rowLatest->vid_name);?>', '<?php print(str_replace(".", "", $rowLatest->vid_price));?>');" title="Buy this video - RBS WorldPay"><img src="images/btn_rbs.jpg" width="110" height="23" alt="Buy this video - RBS WorldPay" title="Buy this video - RBS WorldPay" border="0" style="padding-top:3px;" /></a></span>
						<span><a href="javascript: insertOrder2(<?php print($rowLatest->vid_id);?>, <?php print($rowLatest->cat_id);?>, '<?php print($rowLatest->vid_name);?>', '<?php print(str_replace(".", "", $rowLatest->vid_price));?>');" title="Buy this video - Paypal"><img src="images/btn_paypal.jpg" width="110" height="23" alt="Buy this video - Paypal" title="Buy this video - Paypal" border="0" style="padding-top:3px;" /></a></span>
					</p>-->
					<!--<p><span><a href="javascript: insertOrder(<?php print($rowLatest->vid_id);?>, <?php print($rowLatest->cat_id);?>, '<?php print($rowLatest->vid_name);?>', '<?php print(str_replace(".", "", $rowLatest->vid_price));?>');" title="Buy this video">Buy this video</a></span></p>-->
				<?php } else{ ?>
					<p><span><a href="login.php?ref=1" title="Login to Buy">Login to Buy</a></span></p>
				<?php } ?>
				</div>
				<div class="img_right_price">&pound; <?php print($rowLatest->vid_price);?></div>
			</div>
		</div>
<?php
		} 
	} 
?>
	</div>
</div>
<div style="margin:10px 0px;"><a href="get_filmed.php" title="Get Match Filmed Free"><img src="images/btn.png" width="287" height="65" border="0" /></a></div>
<div class="banner_area_right"><?php showBanner1(4, "MiddleRight"); ?></div>
<h1>By Category</h1>
<div class="recent_uploaded_box">
	<div class="inner">
		<ul>
<?php
$strCatQry="SELECT * FROM categories ORDER BY cat_id";
$nResultCat = mysql_query($strCatQry) or die(mysql_error());
if(mysql_num_rows($nResultCat)>=1){
	while($rowCat=mysql_fetch_object($nResultCat)){
?>
	<li><a href="videos.php?cid=<?php print($rowCat->cat_id);?>" title="<?php print($rowCat->cat_name);?>"><?php print($rowCat->cat_name);?></a></li>
<?php
	}
}
?>
		</ul>
	</div>
</div>
<div class="banner_area_right"><?php showBanner1(5, "BottomRight"); ?></div>
