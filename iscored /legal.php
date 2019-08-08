<?php include("include/php_includes_top.php"); 
$rsCnt = mysql_query("SELECT * FROM contents WHERE cnt_id=3");
if(mysql_num_rows($rsCnt)>0){
	$rCnt = mysql_fetch_object($rsCnt);
	$strHead = $rCnt->cnt_heading;
	$strMSG = $rCnt->cnt_details;
}
else{
	$strHead = "Page not found";
	$strMSG = "page you are looking for is not available or not found";
	include("message.php");
	die();
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
						<div id="showMSG" class="clsred" align="center" style="display:none; visibility:hidden;"></div>
						<p><?php print($strMSG);?></p>
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
