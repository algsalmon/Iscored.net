<div id="logos" style="width:100%; height:50px; background-color:#FFFFFF;">
	<div id="logos_left" style="width:600px; text-align:left; float:left; color:#FFFFFF; padding-left:10px;">
		<img src="images/logos/mastercard.gif" width="62" height="40" alt="Master Card payments supported by RBS WorldPay" title="Master Card payments supported by RBS WorldPay" />&nbsp;&nbsp;&nbsp;
		<img src="images/logos/visa_debit.gif" width="66" height="40" alt="VISA payments supported by RBS WorldPay" title="VISA payments supported by RBS WorldPay" />&nbsp;&nbsp;&nbsp;
		<img src="images/logos/SOLO.gif" height="40" alt="SOLO payments supported by RBS WorldPay" title="SOLO payments supported by RBS WorldPay" />&nbsp;&nbsp;&nbsp;
		<img src="images/logos/JCB.gif" width="52" height="40" alt="JCB payments supported by RBS WorldPay" title="JCB payments supported by RBS WorldPay" />&nbsp;&nbsp;&nbsp;
		<img src="images/logos/maestro.gif" width="63" height="40" alt="Maestro payments supported by RBS WorldPay" title="Maestro payments supported by RBS WorldPay" />&nbsp;&nbsp;&nbsp;
		<img src="images/logos/paypal.png" width="63" height="40" alt="Paypal" title="Paypal" />&nbsp;&nbsp;&nbsp;
	</div>
	<div id="logos_right" style="width:140px; float:right; padding-right:10px; padding-top:10px;"><a href="http://www.rbsworldpay.com" title="Powered By RBS WorldPay"><img src="images/logos/poweredByRBSWorldPay.gif" width="139" height="33" border="0" alt="Powered By RBS WorldPay" /></a></div>
</div>
<div id="footer">
	<a href="index.php" title="<?php print($menuHome);?>"><?php print($menuHome);?></a> 
	| <a href="about_us.php" title="<?php print($menuAbout);?>"><?php print($menuAbout);?></a>
	| <a href="videos.php" title="videos">videos</a>
<?php if(isset($_SESSION["UserID"])){ ?>
	| <a href="my_account.php" title="My Account">My Account</a>
<?php } else{?>
	| <a href="login.php" title="User Login">User Login</a>
	| <a href="register.php" title="Register">Register</a>
<?php }?>
	| <a href="search.php" title="Search">Search</a>
	| <a href="legal.php" title="<?php print($menuLegal);?>"><?php print($menuLegal);?></a>
	| <a href="refund_policy.php" title="Refund Policy">Refund Policy</a>
<?php if(isset($_SESSION["UserID"])){ ?>
	| <a href="logout.php" title="Logout">Logout</a>
<?php }?>
	<br />
&copy; iscored.co.uk 2010. All Rights Reserved.
</div>