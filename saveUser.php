<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$f_name = $_REQUEST['f_name'];
	$l_name = $_REQUEST['l_name'];
	$device = $_REQUEST['device'];
	$last_login = $_REQUEST['last_login'];
	$active = $_REQUEST['active'];
	$created_date = $_REQUEST['created_date'];
	$verification_key = $_REQUEST['verification_key'];
	$active_date = $_REQUEST['active_date'];
	$old_password = $_REQUEST['old_password'];
	$last_modified = $_REQUEST['last_modified'];
	$created_by = $_REQUEST['created_by'];
	$subscription_type = $_REQUEST['subscription_type'];
	$user_type = $_REQUEST['user_type'];
	
	$sqlInsert = mysql_query("insert into ba_tbl_user (email, password, f_name, l_name, device, last_login, active, created_date, verification_key, active_date, 
	old_password, last_modified, created_by, subscription_type, user_type) values('$email', '$password', '$f_name', '$l_name', '$device', '$last_login', '$active', '$created_date', '$verification_key', '$active_date', 
	'$old_password', '$last_modified', '$created_by', '$subscription_type', '$user_type')");
	$inserted_id = mysql_insert_id();
	$sqlUser = mysql_query("select * from ba_tbl_user where id = '$inserted_id'");
	$rowUser = mysql_fetch_assoc($sqlUser);
	$verification_key = $rowUser['verification_key'];
	if($inserted_id)
	{
		/***************** ADDING USER PLAN INFO ***********************/
		$sqlPlan = mysql_query("insert into ba_tbl_plan_user(plan_id, user_id, created_date, active, last_modified) values('1', '$inserted_id', '$created_date', '1', '$last_modified')");
		$plan_insert_id = mysql_insert_id();
		/*
		$sqlUserPlan = mysql_query("select * from ba_tbl_plan_user where id = '$plan_isert_id'");
		$rowUserPlan = mysql_fetch_assoc($sqlUserPlan);
		
		$plan_id = $rowUserPlan['id'];
		$user_plan_id = $rowUserPlan['plan_id'];
		$user_id_plan = $rowUserPlan['user_id'];
		$created_date =$rowUserPlan['created_date'];
		$active = $rowUserPlan['active'];
		$last_modified = $rowUserPlan['last_modified'];	
		$arr_user_plan["plan_user"] = array("id"=>$plan_id, "plan_id"=>$user_plan_id, "user_id"=>$user_id_plan, "created_date"=>$created_date, "active"=>$active, "last_modified"=>$last_modified);
		*/
		
		$message_body = "Buyers Pick Email Verification. Click on the below Link.... \n\r";
		$message_body .= "http://skibuyerspick.appspot.com/verification/?q=$verification_key \n\r";
		/*
		$message_body .= "OR \n\r";
		$message_body .= "Use the Below Authorization Key. \n\r";
		$message_body .= "$verification_key \n\r";
		//$message_body .= "http://skibuyerspick.appspot.com/verification";
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
	echo '[{"response":"noREQUEST"}]';
}

?>