<?php
$host = "173.194.111.85";
	$username = "root";
	$password = "javed@77";
	$dbname = "skibuyerspick:buyerspick";

	$conn = mysql_connect($host, $username, $password);
	$dbselect = mysql_select_db("buyerspick", $conn) or die(mysql_error());
	if(!$dbselect)
	{
		die("Could not select Database : ". mysql_error());
	}
	else
	{
		//echo "DB SELECTED..";
	}
	if(!$conn)
	{
		die("Could not connect to MySql Google Server : ". mysql_error());
	}
	else
	{
		//echo "DB CONNECTED..";
	}
if(isset($_REQUEST['user_id']) && isset($_REQUEST['plan_id']))
{
	$user_id = $_REQUEST["user_id"];
	$plan_id = $_REQUEST["plan_id"];
	/********* Selecting space allocation information from tbl_plan_master ******/
	
	$sqlPlanMaster = mysql_query("select * from ba_tbl_plan_master where id = '$plan_id'");
	$rowPlanMaster = mysql_fetch_assoc($sqlPlanMaster);
	$plan_master_id = $rowPanMaster['size_allocated'];
	
	/************** END *****************/
	$sqlPlan = mysql_query("update ba_tbl_user set subscription_type = '$plan_id' where id = '$user_id'");
	if(mysql_affected_rows()==1)
	{
		echo '[{"response":"user plan upgraded", "subscription_type":"'.$plan_id.'"}]';
		//echo "user plan upgraded";
	}
	else
	{
		echo '[{"response":"no upgrade"}]';
		//echo "no upgrade";
	}
}
else
{
	echo '[{"response":"no post"}]';
}

?>
