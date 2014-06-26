<?php
include_once('database.php');

if(isset($_REQUEST['id']))					//POST receiving from App
{
	$id = $_REQUEST["id"];					//POST receiving from App
	$status = $_REQUEST["status"];			//POST receiving from App
	
	
	function friend_status($error, $id_val="", $status_val="")
	{
		$arr_status[] = array("error"=>$error, "id"=>$id_val, "status"=>$status_val);
	
		$data["friend_request_status"] = $arr_status;
		$json = json_encode($data);
		return print_r($json);
	}
	
	$sql = mysql_query("update ba_tbl_friend_share set status = '$status' where id = '$id'");			//Updating row value if "id" matches
	if(mysql_affected_rows()==1)
	{
		friend_status("pass", $id, $status);
	}
	else
	{
		friend_status("fail");
	}
}
else
{
	friend_status("nopost");
}

?>