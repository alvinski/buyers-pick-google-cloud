<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	$email = $_REQUEST['email'];
	$verification_key = $_REQUEST['verification_key'];
	$sqlActive = mysql_query("select * from ba_tbl_user where email = '$email'");
	$rowActive = mysql_fetch_assoc($sqlActive);
	$active_status = $rowActive['active'];
	if($active_status==0)
	{
	
	$sqlInsert = mysql_query("update ba_tbl_user set verification_key = '$verification_key' where email = '$email'") or die(mysql_error());
	$updated_id = mysql_affected_rows();
	$sqlUser = mysql_query("select * from ba_tbl_user where email = '$email'");
	$rowUser = mysql_fetch_assoc($sqlUser);
	$verification_key = $rowUser['verification_key'];
	if($updated_id>0)
	{
		$message_body = "Buyers Pick Email Verification. Click on the below Link.... \n\r";
		$message_body .= "http://skibuyerspick.appspot.com/verification/?q=$verification_key \n\r";
		/*
		$message_body .= "OR \n\r";
		$message_body .= "Use the Below Authorization Key. \n\r";
		$message_body .= "$verification_key \n\r";
		*/
		$mail_options = [
		"sender" => "support@skiusainc.com",
		"to" => $email,
		"subject" => "Welcome to Buyers Pick",
		"textBody" => $message_body
		];

		try {
		$message = new Message($mail_options);
			$message->send();
			echo '[{"response":"Verification Mail Sent"}]';
		} catch (InvalidArgumentException $e) {
			//echo $e; 
			echo '[{"response":"Verification Mail Not Sent. Try Again!!"}]';
		}
		
	}
	else
	{
		echo '[{"response":"User Not Registered!!"}]';
	}
	}
	else
	{
		echo '[{"response":"User Already Verified!!"}]';
	}
}
else
{
	echo '[{"response":"Something went wrong!!"}]';
}

?>