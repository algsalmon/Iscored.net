<?php
$remote_file = "/myfile.flv";
$file = "/home/iscored/public_html/videos/main/4_consumer_plus.flv";

$ftp=ftp_connect("ftp01.hddn.com");
ftp_login($ftp, "iscored.algie", "iscored1");
// upload a file
if (ftp_put($ftp, $remote_file, $file, FTP_ASCII)) {
	echo "successfully uploaded $file\n";
} else {
	echo "There was a problem while uploading $file\n";
}
ftp_close($ftp);
?>