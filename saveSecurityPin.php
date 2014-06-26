<?php
/******** Google App Engine Mail API includes below ***********\
require_once 'google/appengine/api/mail/Message.php';\
use google\\appengine\\api\\mail\\Message;\
/*** END ****/
include('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	
	//$q = $_REQUEST['q'];\
	//echo "Q STRING : " . $q."<br>";\
	$email = $_REQUEST['email'];
	$security_pin = $_REQUEST['security_pin'];

	$sqlUpdate = mysql_query("update ba_tbl_user set security_pin = '$security_pin' where email = '$email'");
	if(mysql_affected_rows()==1)
	{	 		
	 echo '[{"response":"success"}]';
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