<?php
include_once('database.php');
//$old_id = $_POST['id'];
$id = $_POST['id'];
$empty_id = "";
$vendor_name = $_POST['vendor_name'];
$user_id = $_POST['user_id'];
//$user_id = 167;
$tags = $_POST['tags'];
//$alias = $_POST['alias'];
$description = $_POST['description'];
$path = $_POST['path'];
$created_date = $_POST['created_date'];
$security_pin = $_POST['security_pin'];
$old_security_pin = $_POST['old_security_pin'];
$last_modified_security_pin = $_POST['last_modified_security_pin'];
$geo_latitude = $_POST['geo_latitude'];
$geo_longitude = $_POST['geo_longitude'];
$last_modified_date = $_POST['last_modified_date'];
$is_deleted = $_POST['is_deleted'];
$delete_date = $_POST['delete_date'];
$industry_id = $_POST['industry_id'];
$current_location = $_POST['current_location'];
$vendor_title = $_POST['vendor_title'];
$sync_status = 1;
$sync_timestamp = $_POST["sync_timestamp"];

$arr_pass[] = array("response"=>"pass");
$arr_fail[] = array("response"=>"fail");

/********* Retrieving email id of user using user_id *********/

$sqlUserCheck = mysql_query("select email from ba_tbl_user where id = '$user_id'");
$rowUserCheck = mysql_fetch_assoc($sqlUserCheck);
$user_email = $rowUserCheck["email"];

/*************** END *****************************************/

/******* CHECKING IF VENDOR PATH ALREADY EXISTS ************/
$sqlPath = mysql_query("select * from ba_tbl_vendor_master where path = '$path'");
$rowPath = mysql_fetch_assoc($sqlPath);
$vendor_id = $rowPath['id'];
$check_sync_timestamp = $rowPath['sync_timestamp'];
$numPath = mysql_num_rows($sqlPath);

if($numPath > 0)
{
	//Checking if sync_timestamp matches
	if($check_sync_timestamp==$sync_timestamp)
	{
		$sync_timestamp = date("Y-d-m h:i:s");
	$sqlUpdate = mysql_query("update ba_tbl_vendor_master set vendor_name = '$vendor_name', user_id = '$user_id', tags = '$tags', description = '$description', path = '$path',  created_date = '$created_date', security_pin = '$security_pin',  old_security_pin = '$old_security_pin', last_modified_security_pin = '$last_modified_security_pin', geo_latitude = '$geo_latitude', geo_longitude = '$geo_longitude', last_modified_date = '$last_modified_date', is_deleted = '$is_deleted', delete_date = '$delete_date', industry_id = '$industry_id', current_location = '$current_location', vendor_title = '$vendor_title', sync_status = '$sync_status', update_status = '1', sync_timestamp = '$sync_timestamp' where id = '$id'");
	
	if(mysql_affected_rows()==1)
	{
		$vendor_arr[] = array("old_id"=>$id, "id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "tags"=>$tags, "description"=>$description, "path"=>$path, "created_date"=>$created_date, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_modified_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=> $current_location, "vendor_title"=>$vendor_title, "sync_status"=>$sync_status, "sync_timestamp"=>$sync_timestamp);
		$json["error"] = $arr_pass;
		$json['data'] = $vendor_arr;
		$data = json_encode($json);
		print_r($data);
	}
	else
	{
		$data["error"] = $arr_fail;	
		$final_data = json_encode($data);
		print_r($final_data);
	}
	
	/*** checking if vendor is shared by checking POST parameters for item_id from friend_share table. *****/
	if(isset($_REQUEST["item_id"]) && !empty($_REQUEST["item_id"]));
	{
		/******* Updating update_status column from tbl_friend_share table *******/
		$sqlDelFriendShare = mysql_query("update ba_tbl_friend_share set update_status = '1' where item_id = '$id'");
		/***************************** END ***********************************/
	}
	/******* END *******/
	
	}
	else
	{
		/******* Updating sync_conflict column of tbl_friend_share table *******/
		$sqlDelFriendShare = mysql_query("update ba_tbl_friend_share set sync_conflict = '2' where item_id = '$id' and (sender_email = '$user_email' or receiver_email = '$user_email')");
		/***************************** END ***********************************/
		if(mysql_affected_rows()==1)
		{
			$vendor_arr[] = array("id"=>$id, "sync_conflict"=>"2");
			$json["error"] = $arr_pass;
			$json['data'] = $vendor_arr;
			$data = json_encode($json);
			print_r($data);
			//echo '[{"response":"No Update"}]';
		}
		else
		{
			$data["error"] = $arr_fail;	
			$final_data = json_encode($data);
			print_r($final_data);
		}
	}
}
else
{
	echo '[{"response":"No Vendor Found"}]';
}
?>