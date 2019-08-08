<?php
$mResult = mysql_query("SELECT * FROM menu ORDER BY menu_id");
if(mysql_num_rows($mResult)>0){
	while($mRow=mysql_fetch_object($mResult)){
		switch($mRow->menu_id) {
			case 1:
				$menuHome = $mRow->menu_title;
				break;
			case 2:
				$menuAbout = $mRow->menu_title;
				break;
			case 4:
				$menuLegal = $mRow->menu_title;
				break;
			case 5:
				$menuContact = $mRow->menu_title;
				break;
			case 6:
				$menuSitemap = $mRow->menu_title;
				break;
			case 7:
				$menuAdvertise = $mRow->menu_title;
				break;
		}
	}
}
?>
<div id="header_area">
	<div id="top_bar">
		<a href="contact.php" title="<?php print($menuContact);?>"><?php print($menuContact);?></a> | <a href="sitemap.php" title="<?php print($menuSitemap);?>"><?php print($menuSitemap);?></a> | <a href="advertise.php" title="<?php print($menuAdvertise);?>"><?php print($menuAdvertise);?></a>
	</div>
	<div id="header">
		<div id="logo"><img src="images/logo_red.png" width="178" height="110" alt="ISCORED" class="clsLogo" /></div>
		<div id="logo_right">
		<form name="frmSearch" method="post" action="search.php">
			<input type="text" name="txtSearch" value="<?php @print($txtSearch);?>" class="input" /> <input type="submit" name="btnSearch" value="" class="btn" />
		</form>
		</div>
	</div>
	<div id="menu">
		<ul>
			<li><a href="index.php" title="<?php print($menuHome);?>"><?php print($menuHome);?></a></li>
			<li class="menu_devider"></li>
			<li><a href="about_us.php" title="<?php print($menuAbout);?>"><?php print($menuAbout);?></a></li>
			<li class="menu_devider"></li>
			<li><a href="videos.php" title="videos">VIDEOS</a></li>
	<?php if(isset($_SESSION["UserID"])){ ?>
			<li class="menu_devider"></li>
			<li><a href="my_account.php" title="My Account">My ACCOUNT</a></li>
	<?php } else{?>
			<li class="menu_devider"></li>
			<li><a href="login.php" title="User Login">USER LOGIN</a></li>
			<li class="menu_devider"></li>
			<li><a href="register.php" title="Register">REGISTER</a></li>
	<?php }?>
			<li class="menu_devider"></li>
			<li><a href="search.php" title="Search">SEARCH</a></li>
			<li class="menu_devider"></li>
			<li><a href="legal.php" title="<?php print($menuLegal);?>"><?php print($menuLegal);?></a></li>
	<?php if(isset($_SESSION["UserID"])){ ?>
			<li class="menu_devider"></li>
			<li><a href="logout.php" title="Logout">LOGOUT</a></li>
	<?php }?>
		</ul>
	</div>
</div>
<form action="https://secure.wp3.rbsworldpay.com/wcc/purchase" name="BuyForm" method="POST">
<!--<form action="test.php" name="BuyForm" method="POST">-->
<!--<form action="https://select-test.wp3.rbsworldpay.com/wcc/purchase" name="BuyForm" method="POST">-->
	<input type="hidden" name="instId"  value="248208">
	<input type="hidden" name="cartId" id="cartId" value="">
	<input type="hidden" name="currency" value="GBP">
	<input type="hidden" name="amount" id="amount"  value="0">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="testMode" value="0">
	<input type="hidden" name="MC_callback" value="http://www.i-scored.net/payment_response.php">
	<input type="hidden" name="MC_orderID" id="MC_orderID" value="">
</form>

<form action="https://www.paypal.com/cgi-bin/webscr" name="BuyFormPaypal" method="post">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="upload" value="1">
	<input type="hidden" name="business" value="cityemails@wealthpublishing.co.uk">
	<input type="hidden" name="item_number" id="item_number" value="">
	<input type="hidden" name="item_name" id="item_name" value="">
	<input type="hidden" name="amount" value="0">
	<input type="hidden" name="currency_code" value="GBP">
	<input type="hidden" name="custom" value="<?php @print($_SESSION["UserID"]);?>">
	<input type="hidden" name="invoice" id="invoice" value="">
	<input type="hidden" name="notify_url" value="http://www.i-scored.net/paypal_notify.php">
	<input type="hidden" name="return" value="http://www.i-scored.net/paypal_success.php">
	<input type="hidden" name="cancel_return" value="http://www.i-scored.net/paypal_cancel.php">
</form> 