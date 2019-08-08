<?php 
include("include/php_includes_top.php"); 

$mediaFile = "videos/main/43_1_nz vs sl.flv";
$imgFile = "43_1_nz vs sl.jpg";
$cmdThumb = "/usr/local/bin/ffmpeg -itsoffset -8  -i ".$mediaFile." -vcodec mjpeg -vframes 1 -an -f rawvideo -s 122x69 videos/thumbs/".$imgFile;
$retValue = shell_exec($cmdThumb);
print($retValue);

include("include/php_includes_bottom.php"); 
?>
