<?php
include_once('database.php');
if(isset($_POST['email']) && $_POST['email']!="")
{
	$email = $_POST['email'];
	$sqlSelect = mysql_query("select * from ba_tbl_user where email = '$email'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$num_row = mysql_num_rows($sqlSelect);
	if($num_row>0)
	{
	$id = $rowSelect['id'];	
	$email = $rowSelect['email'];
	$password = $rowSelect['password'];
	$f_name = $rowSelect['f_name'];
	$l_name = $rowSelect['l_name'];
	$device = $rowSelect['device'];
	$last_login = $rowSelect['last_login'];
	$active = $rowSelect['active'];
	$created_date = $rowSelect['created_date'];
	$verification_key = $rowSelect['verification_key'];
	$active_date = $rowSelect['active_date'];
	$old_password = $rowSelect['old_password'];
	$last_modified = $rowSelect['last_modified'];
	$created_by = $rowSelect['created_by'];
	$subscription_type = $rowSelect['subscription_type'];
	$security_pin = $rowSelect['security_pin'];
	$password_mod = $rowSelect['password_mod'];

	
	$arr_user_details[] = array("id"=>$id, "email"=>$email, "password"=>$password, "f_name"=>$f_name, "l_name"=>$l_name, "device"=>$device, "last_login"=>$last_login, "active"=>$active, "created_date"=>$created_date, "verification_key"=>$verification_key, "active_date"=>$active_date, "old_password"=>$old_password, "last_modified"=>$last_modified, "created_by"=>$created_by, "subscription_type"=>$subscription_type, "user_type"=>$user_type, "security_pin"=>$security_pin, "password_mod"=>$password_mod);
	if($arr_user_details)
	{
		$userdetails = json_encode($arr_user_details);
		print_r($userdetails);
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
	/*
	$sqlInsert = mysql_query("insert into ba_tbl_user (email, password, f_name, l_name, device, last_login, active, created_date, verification_key, active_date, 
	old_password, last_modified, created_by, subscription_type, user_type) values('$email', '$password', '$f_name', '$l_name', '$device', '$last_login', '$active', '$created_date', '$verification_key', '$active_date', 
	'$old_password', '$last_modified', '$created_by', '$subscription_type', '$user_type')");
	$inserted_id = mysql_insert_id();
	
	if($inserted_id)
	{
		echo '[{"response":"success"}]';
	}
	else
	{
		echo '[{"response":"fail"}]';
	}
	*/
}
else
{
	echo '[{"response":"nopost"}]';
}
?>