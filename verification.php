<?php
/******** Google App Engine Mail API includes below ***********
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['q']) && $_REQUEST['q']!="")
{
	
	$q = $_REQUEST['q'];
	//echo "Q STRING : " . $q."<br>";
	$sqlUpdate = mysql_query("update ba_tbl_user set active = 1 where verification_key = '$q'");
	if(mysql_affected_rows()==1)
	{	 		
	 echo "Verification Successful.....";
	}
	else
	{
	echo "Verification Not Successfull";
	}
}

else
{
	echo 'Invalid Link..';
}

?>