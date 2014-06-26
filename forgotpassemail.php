<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include_once('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	
	$email = $_REQUEST['email'];
	
	$sqlSelect  = mysql_query("select email, verification_key from ba_tbl_user where email = '$email'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numRows = mysql_num_rows($sqlSelect);
	$verification_key = $rowSelect['verification_key'];
	if($numRows>0)
	{	
		
		$message_body = "Click on the below link to reset password : \n\r";
		$message_body .= "http://skibuyerspick.appspot.com/reset/?id=".base64_encode($email)."&r=$verification_key";

		$mail_options = [
			"sender" => "support@skiusainc.com",
			"to" => $email,
			"subject" => "Buyers Pick Password Reset",
			"textBody" => $message_body
		];

		try {
			$message = new Message($mail_options);
			$message->send();
			echo '[{"response":"success"}]';
		} catch (InvalidArgumentException $e) {
			//echo $e; 
			echo '[{"response":"Mail not sent!!"}]';
		}
	}
	else
	{
		echo '[{"response":"User not registered!!"}]';
	}
}
else
{
	echo '[{"response":"Something went wrong!!"}]';
}
?>