<?php
function SendConfirmation($webName, $webAdd, $mName, $mTo, $mID, $rendCode){
	//sending email for Registration confirmation...
	$fromMail = "noreply@".$webAdd;
	$subject = "Please Verify Your Email. (".$webName.")";
	$welcome = "Hi ".$mName."
	\n\n You are added as a team member on a team, recently added for 'filmed free match' on ".$webName."!
	\n\n To Verify Yourself, just click the link below to confirm that your email is working:
	\n http://".$webAdd."/get_filmed.php?activate=1&mem_id=".$mID."&ver_code=".$rendCode."
	\n\n If clicking the link does not work, type or copy and paste the link Above into your web browser.
	\n Make sure to copy the address exactly and do not add extra spaces.
	\n ".$webAdd."
	\n This is an automatic generated message. Do not reply to this message.
	\n In case you’ll like to contact us, please use the contact form on our website.";
	$message = $welcome;
	$headers = "From: ".$webName." <" . $fromMail . ">"; 	
	return @mail($mTo, $subject, $message, $headers);
}

function SendLoginDetails($mTo, $mPass){
	//sending email for Registration confirmation...
	$fromMail = "noreply@i-scored.net";
	$subject = "Iscored Login Details";
	
	$welcome = "Dear Member,
	\n\nPlease find your login details below!
	\n\n
	\nEmail Address: ".$mTo."
	\nPassword: ".$mPass."

	\n\nPlease keep your login info in a safe place and let us know in case any further issue. Thanks
	
	\n\nFrom
	\nThe Staff
	\nIscored.com
	
	\n\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please contact us at contact@iscored.com";
	
	$message = $welcome;
				
	$headers = "From: Iscored <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function SendCard($mName, $mTo, $cardID, $senderID, $fromName){
	//sending email for Registration confirmation...
	$fromMail = "noreply@wondercardz.com";
	$subject = "Greetings - Wonder Cardz";
	
	$welcome = "Hi ".$mName."
	\n\n".$fromName." send you an eCard. Please follow the link below to see your card.

	\n\nTo view your card WonderCardz just click the link below:
	\nhttp://www.wondercardz.com/view_card.php?mcard_id=".$cardID."&sendid=".$senderID."
	\n\nIf clicking the link does not work, type or copy and paste the link into your web browser. 
	\nMake sure to copy the address exactly and do not add extra spaces.
	
	\nhttp://www.wondercardz.com
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: WonderCardz <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}
function SendCardView($mName, $mTo, $mReceiver){
	//sending email for Registration confirmation...
	$fromMail = "noreply@wondercardz.com";
	$subject = "Wonder Cardz Confirmation";
	
	$welcome = "Hi ".$mName."
	\n\nThanks for using WonderCardz!
	\n\nYour card has been viewed by ".$mReceiver."
	
	\nhttp://www.wondercardz.com
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: WonderCardz <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function mailSendNow($mName, $uName){
	//sending notification for send now pmail...
	$mTo = "urgent@HollandOffice.com";
	$fromMail = "noreply@hollandoffice.com";
	$subject = "Urgent Mail Send Request";

	$welcome = "Hi,
	\n\n!Mr. ".$mName." wants to send mail now
	\n\nThe username is ".$uName."
	\n\nPlease see further details in Admin Panel\n\n Thanks
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function SendNLConfirmation($mTo, $mID){
	//sending email for Registration confirmation...
	$fromMail = "noreply@hollandoffice.com";
	$subject = "Newsletter Confirmation";
	
	$welcome = "Dear Holland Office visitor, \"Thank you for your interest in our company\". We received your request for our monthly newsletter and messages concerning your privacy.
	\n\nIn order to verify the validity of this request and to prevent the sending of unwanted e-mail, we ask our subscibers to confirm this request by clicking on the link below. http://www.hollandoffice.com/nl_activate.php?memid=".$mID." This is a so called ‘opt-in procedure’ which you can reverse (opting-out) by sending us a request by e-mail. If the above address does not appear as a clickable link, cut/copy and paste it into your browser's address bar

	\n\nNeedless to say... We don’t sell your e-mail address. As a matter of fact; your privacy is our very existance! WELCOME TO HOLLAND OFFICE!
	
	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function sendAddPMail($mTo, $mFName, $mUName){
	//sending email for Registration confirmation...
	$fromMail = "noreply@hollandoffice.com";
	$subject = "New P-Mail Notification";
	
	$welcome = "Dear ".$mFName.", you received new p-mail at your service address. Please login in at Holland Office with your username ".$mUName." and check for details. We send this message to you as a reminder to check your mail regularly.

	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

function sendSubsPayment($mTo, $mUName, $subs, $duration, $psource){
	//sending email for Registration confirmation...
	$fromMail = "noreply@hollandoffice.com";
	$subject = "Payment Received";
	
	$welcome = "We successfully received your payment for your subscription to Holland Office.  \n\nYour details: [".$subs.", ".$duration.", through: ".$psource."].\n\nPlease login to your account with your username ".$mUName." and start using our services.

	\n\nThis is an automatic generated message. Do not reply to this message. In case you’ll like to contact us, please use the contact form on our website.";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}

/*
function SendContact($mName, $mTo, $mID){
	//sending email for Registration confirmation...
	$fromMail = "admin@HollandOffice.com";
	$mTo = "info@hollandoffice.com";
	$subject = "Holland Office Account Confirmation";
	
	$welcome = "Hi ".$mName."
	\n\nWelcome and thanks for joining Holland Office!

	\n\nTo activate your account and begin using Holland Office just click the link below to confirm that your email is working:
	\nhttp://www.safysolutions.net/yourlocaloffice/activate.php?memid=".$mID."
	\n\nIf clicking the link does not work, type or copy and paste the link into your web browser. 
	\nMake sure to copy the address exactly and do not add extra spaces.
	
	\nhttp://www.HollandOffice.com";
	
	$message = $welcome;
				
	$headers = "From: HollandOffice <" . $fromMail . ">"; 	

	@mail($mTo, $subject, $message, $headers);
}
*/
?>
