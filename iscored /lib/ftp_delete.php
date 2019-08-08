<?php
$remote_file = "/".$mediaName;

$ftp=ftp_connect("ftp01.hddn.com");
ftp_login($ftp, "iscored.algie", "iscored1");

// try to delete $file
if (ftp_delete($ftp, $remote_file)) {
	$hddn = 1;
} else {
	$hddn = 0;
}

ftp_close($ftp);
?>