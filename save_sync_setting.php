<?php
include('database.php');
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!="")
{
	$user_id = $_REQUEST["user_id"];
	$sync_setting = $_REQUEST["sync_setting"];
	
	//Checking if user is a valid user
	$sqlSelect = mysql_query("select * from ba_tbl_user where id = '$user_id'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$num_row = mysql_num_rows($sqlSelect);
	
	if( $num_row > 0 )
	{
		$sqlUpdate = mysql_query("update ba_tbl_user set sync_setting = '$sync_setting' where id = '$user_id'");
		
		if( mysql_affected_rows() == 1 )
		{
			
			$arr_sync_setting = array("user_id"=>$user_id, "sync_setting"=>$sync_setting);
			
			$arr_pass[] = array("response"=>"pass");
			$data["error"] = $arr_pass;
			$data["data"] = $arr_sync_setting;
			$json = json_encode($data);
			print_r($json);
		}
		else
		{
			$arr_pass[] = array("response"=>"fail");
			$data["error"] = $arr_pass;
			$json = json_encode($data);
			print_r($json);
		}
	}
	else
	{
		$arr_pass[] = array("response"=>"fail");
		$data["error"] = $arr_pass;
		$json = json_encode($data);
		print_r($json);
	}
		
}	
else
{
	$arr_pass[] = array("response"=>"fail");
	$data["error"] = $arr_pass;
	$json = json_encode($data);
	print_r($json);
}
?>