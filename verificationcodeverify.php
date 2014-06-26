<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_POST['email']) && $_POST['email']!="")
{
	
	$email = $_POST['email'];
	$verification_key = $_POST['verification_key'];
	
	//echo '[{"email":"'.$email.'", "verification_key":"'.$verification_key.'"}]';
	
	$sqlSelect  = mysql_query("select * from ba_tbl_user where email = '$email' and verification_key = '$verification_key'");
	//echo '[{"1st select":"'.$sqlSelect.'"}]';
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numRows = mysql_num_rows($sqlSelect);
	
	if($numRows>0)
	{
		$sqlUpdate = mysql_query("update ba_tbl_user set active  = 1 where email = '$email' and verification_key = '$verification_key'");
		//echo '[{"updatequery":"'.$sqlUpdate.'"}]';
		$numUpdate = mysql_affected_rows();
		if($numUpdate>0)
		{
			$sqlSelectActive  = mysql_query("select active from ba_tbl_user where email = '$email' and verification_key = '$verification_key'");
			//echo '[{"2nd select":"'.$sqlSelectActive.'"}]';
			$rowSelectActive = mysql_fetch_assoc($sqlSelectActive);
			$active = $rowSelectActive['active'];
			echo '[{"active":"'.$active.'"}]';
			$message_body = "Account has been Verified successfully...";

			$mail_options = [
				"sender" => "support@skiusainc.com",
				"to" => $email,
				"subject" => "Buyers Pick Verification",
				"textBody" => $message_body
			];

			try {
				$message = new Message($mail_options);
				$message->send();
				//echo '[{"response":"success"}]';
			} catch (InvalidArgumentException $e) {
				//echo $e; 
				//echo '[{"response":"fail"}]';
			}
		}
		else
		{
				$sqlSelectActive  = mysql_query("select active from ba_tbl_user where email = '$email' and verification_key = '$verification_key'");
				//echo '[{"2nd select":"'.$sqlSelectActive.'"}]';
				$rowSelectActive = mysql_fetch_assoc($sqlSelectActive);
				$active_status = $rowSelectActive['active'];
				echo '[{"active":"'.$active_status.'"}]';
		}
		
		
	}
	else
	{
		echo '[{"active":"no user"}]';
	}
}
else
{
	echo '[{"active":"no email"}]';
}
?>