<?php
/******** Google App Engine Mail API includes below ***********
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	
	$sqlUser = mysql_query("select * from ba_tbl_user where email = '$email' and password = '$password'");
	$rowUser = mysql_fetch_assoc($sqlUser);
	$numUser = mysql_num_rows($sqlUser);
	$email = $rowUser['email'];
	$active = $rowUser['active'];
	if($numUser>0)
	{
	$arr_status[] = array("email"=>$email, "active"=>$active);
	
	if($arr_status)
	{
		$data = json_encode($arr_status);
		print_r($data);
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
}
?>