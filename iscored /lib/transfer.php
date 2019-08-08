<?php
//$mfileNam = "";
$remote_file = "/".$mfileName;
$file = "/home/iscored/public_html/videos/main/".$mfileName;

$ftp=ftp_connect("ftp.iscorednew.algie.netdna-cdn.com");
ftp_login($ftp, "iscorednew.algie", "iscored1new");
// upload a file
if (ftp_put($ftp, $remote_file, $file, FTP_ASCII)) {
	//echo "successfully uploaded $file\n";
	$hddn = 1;
} else {
	//echo "There was a problem while uploading $file\n";
	$hddn = 0;
}
ftp_close($ftp);
?>