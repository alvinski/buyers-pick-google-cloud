<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	
	$email = $_REQUEST['email'];
	
	$sqlSelect  = mysql_query("select security_pin from ba_tbl_user where email = '$email'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numRows = mysql_num_rows($sqlSelect);
	$security_pin = $rowSelect['security_pin'];
	if($numRows>0)
	{	
	$message_body = "Your Security Pin : \n\r";
	$message_body .= "$security_pin";

	$mail_options = [
	"sender" => "support@skiusainc.com",
	"to" => $email,
	"subject" => "Buyers Pick Security Pin",
	"textBody" => $message_body
	];

	try {
	$message = new Message($mail_options);
		$message->send();
		echo '[{"response":"success"}]';
	} catch (InvalidArgumentException $e) {
		//echo $e; 
		echo '[{"response":"fail"}]';
	}
	}
	else
	{
		echo '[{"response":"fail"}]';
	}
}
else
{
	echo '[{"response":"fail"}]';
}
?>