<?php
include('database.php');
if(isset($_POST['device_token']) && isset($_POST['email']))
{
	$email = $_POST['email'];
	$device_token = $_POST['device_token'];
	$message = "Buyers Pick Push Notification";
	/******** Checking if device no already registered *********************/
	
	$sqlSelect = mysql_query("select device_token from ba_tbl_ios_push where device_token = '$device_token'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numSelect = mysql_num_rows($sqlSelect);
	if($numSelect==0)
	{
	/***************** END ************************************************/
	$sql = mysql_query("insert into ba_tbl_ios_push ( email, device_token, message ) values('$email', '$device_token', '$message')");
	$insert_id = mysql_insert_id();
	}
	else if($numSelect==1)
	{
		$sqlUpdate = mysql_query("update ba_tbl_ios_push set email = '$email', device_token = '$device_token' where device_token = '$device_token'");
	}
	echo '[{"response":"sent"}]';
}
else
{
	echo '[{"response":"no post"}]';
}
?>