<?php
ob_start();

session_start();
// Unset all of the session variables.
session_unset();
// Finally, destroy the session.
session_destroy();

ob_end_flush();
?>
<html>
<head>
<title>.:: Admin Control Panel ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="mainTable">
	<tr><td width="100%" class="Header"><?php include("header.php");?></td></tr>
    <tr>
		<td width="100%" valign="top" class="mainBody">
            <table align="center" width="500" border="0" cellpadding="2" cellspacing="0" class="FormTables">
                <tr><th class="TableHeads">Logged Out</th></tr>
                <tr>
                    <td align="center">
                        <br><br>
                        You have been logged out successfully.
                        <br><br>
                        [<a href="login.php" title="Click Here">Click Here</a>] to login again.
                        <br><br>
                        [<a href="../index.php" title="Click Here">Click Here</a>] to go to Home Page.
                        <br><br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td valign="top" align="center" class="Footer"><?php include("footer.php");?></td></tr>
</table>
</body>
</html>
