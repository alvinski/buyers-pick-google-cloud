<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_POST['email']) || $_POST['email']!="" || $_POST['password']!="" || $_POST['c_password']!="")
{
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	$c_password = $_POST['c_password'];
	
	if($password==$c_password)
	{
		/***** Selecting current password from user table to update old_password column in next update statement ****/
		$sqlSelect  = mysql_query("select email, password from ba_tbl_user where email = '$email'") or die(mysql_error());
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		$current_password = $rowSelect['password'];
		//END
	
		/**** Updating user table with new password  ****/
		$datetime = date('Y-m-d')." ".date('H:i:s');
		
		$sqlUpdate  = mysql_query("update ba_tbl_user set password = '$password', old_password = '$current_password', last_modified = '$datetime', password_mod = 0 where email = '$email'")  or die(mysql_error());
		$rowUpdate = mysql_fetch_assoc($sqlUpdate);
		
		if(mysql_affected_rows()==1)
		{
			//EMAIL confirmation to user about password reset.
			$message_body = "Your Buyers Pick account password has been Reset.. \n\r";
			//$message_body .= "http://skibuyerspick.appspot.com/reset/?r=$verification_key";

			$mail_options = [
				"sender" => "support@skiusainc.com",
				"to" => $email,
				"subject" => "Buyers Pick Password Reset Confirmation",
				"textBody" => $message_body
			];

			try {
				$message = new Message($mail_options);
				$message->send();
				//echo 'Email Sent.<br>';
			} catch (InvalidArgumentException $e) {
				//echo $e; 
				//echo 'Email Not Sent.';
			}
			echo "1";
		}
		else
		{
			echo "2";
			
		}
		//END
	}
	else
	{
		echo "Password Does not Match.<br>";
	}

}
else
{
	echo 'Please Try again.';
}
?>