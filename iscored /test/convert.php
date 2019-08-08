<?php
//Bhai i am sending file name with full path in $_POST['realname'] variable
//I am sending Number in $_POST['vidnum'] variable.

//$fileEXT = explode(".", $_POST['realname']);

//$origFilePath = $_POST['realname'];
//$newfileName = "Video".$_POST['vidnum'].".flv";
//$newfilefullpath = $_POST['filepath']."/".$newfileName;


//$cmd = "/usr/local/bin/ffmpeg -i data/".$_POST['realname']." -ab 56 -y -ar 44100 -s 320x240 -f flv data/".$newfileName;
$cmd = "/usr/local/bin/ffmpeg -i 2people.wmv -ab 56 -y -ar 44100 -s 640x480 -f flv 2people.flv";
//$retValue = shell_exec($cmd);

$cmdImage = "/usr/local/bin/ffmpeg  -itsoffset -8  -i 2people.flv -vcodec mjpeg -vframes 1 -an -f rawvideo -s 320x240 test.jpg";
//$retValue = shell_exec($cmdImage);

//$cmdClip = "/usr/local/bin/ffmpeg -i 2people.flv -sameq -ss 00:00:00 -t 00:00:30 clip_2people.flv";
$cmdClip = "/usr/local/bin/ffmpeg -i 2people.flv -sameq -ss 00:00:00 -t 00:00:05 clip_2people.flv";
$retValue = shell_exec($cmdClip);

//$cmdSlowMotion1 = "/usr/local/bin/ffmpeg -i 2people.flv tmp/%d.jpg";
//$retValue = shell_exec($cmdSlowMotion1);

//$cmdSlowMotion2 = "/usr/local/bin/ffmpeg -r 10 -b 1800 -i tmp/%d.jpg sl_2people.flv";
//$retValue = shell_exec($cmdSlowMotion2);

//@unlink("data/".$_POST['realname']);  // To delete the original file

print("converted");
?>