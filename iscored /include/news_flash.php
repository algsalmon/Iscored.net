<div style="width:690px;">
	<div id="flash">
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="507" height="261">
			<param name="movie" value="flash/header_new.swf" />
			<param name="quality" value="high" />
			<embed src="flash/header_new.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="507" height="261"></embed>
		</object>
	</div>
	<div id="marqueecontainer" onMouseover="copyspeed2=pausespeed" onMouseout="copyspeed2=marqueespeed" style="position:relative;"> 
		<div id="vmarquee" style="float: left; position:absolute; width: 99%;"> 
			<table width="170" border="0" cellspacing="0" cellpadding="0" style="margin-left:5px;">
<?php
$result = "SELECT * FROM news ORDER BY news_id DESC";
$nResult = mysql_query($result);
if(mysql_num_rows($nResult)>0){
	while($rstRow=mysql_fetch_object($nResult)){
		if(strlen($rstRow->news_details) > 200){
			$des = substr($rstRow->news_details, 0, 200);
		}
		else{
			$des = $rstRow->news_details;
		}
?>
				<tr><td style="padding-top:8px; padding-bottom:6px;"><b class="heading_o_tes"><?php print($rstRow->news_headline);?></b></td></tr>
				<tr><td style="padding-bottom:6px;" class="txt_blk"><?php print($des);?></td></tr>
				<tr><td align="right" style="padding-bottom:6px;">&raquo;<a href="news.php?pid=3">Read More</a> </td></tr>
				<tr><td align="center">* * * * * * * * * * * </td></tr>
<?php
	}
}
?>
			</table>
		</div>
	</div>
</div>