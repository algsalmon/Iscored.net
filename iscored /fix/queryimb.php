<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

</head>

<body>
<?php
try 
{
  $client = new SoapClient("http://ip.authenticdataproducts.com/ipservice.asmx?WSDL");
  $ip = "59.154.204.8";
  $response = $client->GetIPDetail(array("IP" => $ip));
 
  $weightResult = $response->GetIPDetailResult;
  echo 'Done<br />';
  echo $weightResult;
  }
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?> 

</body>
</html>
