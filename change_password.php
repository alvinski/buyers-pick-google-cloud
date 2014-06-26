<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_POST['email']) && $_POST['email']!="")
{
	$arr_pass[] = array("response"=>"pass");
	$arr_fail[] = array("response"=>"fail");
	$arr_nouser[] = array("response"=>"no_user");
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	$new_password = $_POST['new_password'];
	$sqlSelect = mysql_query("select * from ba_tbl_user where email = '$email' and password = '$password'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$num_row = mysql_num_rows($sqlSelect);
	$old_password = $rowSelect["password"];
	$user_id = $rowSelect["id"];
	
	if($num_row>0)
	{
		$sqlUpdate = mysql_query("update ba_tbl_user set password = '$new_password', old_password = '$old_password' where id = '$user_id'");
		if(mysql_affected_rows()==1)
		{
			$message_body = "Buyers Pick Password Change. \n\r\n\r";
			$message_body .= "Your account password has been updated. If you did not change your account password please report at admin@buyerspicks.com \n\r";

			$mail_options = [
			"sender" => "support@skiusainc.com",
			"to" => $email,
			"subject" => "Password Update Notification",
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
			$data["error"] = $arr_pass;
			$arr_result[] = array("response"=>"updated");
			$data["data"] = $arr_result;
			$final_data = json_encode($data);
			print_r($final_data);
		}
		else
		{
			$data["error"] = $arr_fail;
			$arr_result[] = array("response"=>"not updated");
			$data["data"] = $arr_result;
			$final_data = json_encode($data);
			print_r($final_data);
		}
	}
	else
	{
		$data["error"] = $arr_nouser;
		$final_data = json_encode($data);
		print_r($final_data);
	}
	}
else
{
	$arr_nopost[] = array("response"=>"nopost");
	$data["error"] = $arr_nopost;
	$final_data = json_encode($data);
	print_r($final_data);
}
?>