<?php
// Site configuration constants

$QryConfig = "SELECT * FROM site_config WHERE config_id = 1";
$RsConfig = mysql_query($QryConfig);
if (mysql_num_rows($RsConfig)>=1){
	$rowConfig=mysql_fetch_object($RsConfig);
	define("SITE_NAME", $rowConfig->config_sitename);
	define("SITE_TITLE", $rowConfig->config_sitetitle);
	define("SITE_META_KEYWORDS", $rowConfig->config_metakey);
	define("SITE_META_DESCRIPTION", $rowConfig->config_metades);
}
else{
	define("SITE_NAME", "IsCored.co.uk");
	define("SITE_TITLE", "IsCored.co.uk");
	define("SITE_META_KEYWORDS", "IsCored.co.uk");
	define("SITE_META_DESCRIPTION", "IsCored.co.uk");
}

if($rowConfig->status_id == 0){
	include("not_available.php");
	die();
}

?>