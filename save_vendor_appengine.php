<?php
	include('database.php');
	$old_id = $_POST['id'];
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
	$update_status = 0;
	$sync_timestamp = $_POST["sync_timestamp"];
	
	$arr_pass[] = array("response"=>"pass");
	$arr_fail[] = array("response"=>"fail");
	
	/******* CHECKING IF VENDOR PATH ALREADY EXISTS ************/
	$sqlPath = mysql_query("select * from ba_tbl_vendor_master where path = '$path'");
	$rowPath = mysql_fetch_assoc($sqlPath);
	$vendor_id = $rowPath['id'];
	$numPath = mysql_num_rows($sqlPath);
	
	if($numPath > 0)
	{
		/*
		$sqlUpdate = mysql_query("update ba_tbl_vendor_master set vendor_name = '$vendor_name', user_id = '$user_id', tags = '$tags', description = '$description', created_date = '$created_date', security_pin = '$security_pin', old_security_pin = '$old_security_pin',  last_modified_security_pin = '$last_modified_security_pin', geo_latitude = '$geo_latitude', geo_longitude = '$geo_longitude', last_modified_date = '$last_modified_date', is_deleted = '$is_deleted', delete_date = '$delete_date', industry_id = '$industry_id', current_location = '$current_location', vendor_title = '$vendor_title', sync_status = '$sync_status' where path = '$path'") or die(mysql_error());
		echo '[{"response":"'.mysql_affected_rows().'"}]';
		if(mysql_affected_rows()==1)
		{
			$sqlSelect = mysql_query("select * from ba_tbl_vendor_master where path = '$path'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			extract($rowSelect);
		*/
			extract($rowPath);
			$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "tags"=>$tags, "description"=>$description, "path"=>$path, "created_date"=>$created_date, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_modified_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=> $current_location, "vendor_title"=>$vendor_title, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
		
			$data["error"] = $arr_pass;	
			$data["data"] = $vendor_arr;
			$final_data = json_encode($data);
			print_r($final_data);
			/*
		}
		else
		{
			echo '[{"response":"vendor not updated"}]';
		}
		*/
	}
	/**** END *****/
	else
	{
		$sqlInsert = mysql_query("insert into ba_tbl_vendor_master values('$empty_id', '$vendor_name', '$user_id', '$tags', '$description', '$path', '$created_date', '$security_pin', '$old_security_pin', '$last_modified_security_pin', '$geo_latitude', '$geo_longitude', '$last_modified_date', '$is_deleted', '$delete_date', '$industry_id', '$current_location', '$vendor_title', '$sync_status', '$update_status', '$sync_timestamp')") or die(mysql_error());
		/***** Checking if vendor is inserted ******/
		$inserted_id = mysql_insert_id();
		if($inserted_id)
		{
			$sqlSelect = mysql_query("select * from ba_tbl_vendor_master where id = '$inserted_id'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			extract($rowSelect);
			$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "tags"=>$tags, "description"=>$description, "path"=>$path, "created_date"=>$created_date, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_modified_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=> $current_location, "vendor_title"=>$vendor_title, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
			
			$data["error"] = $arr_pass;	
			$data["data"] = $vendor_arr;
			$final_data = json_encode($data);
			print_r($final_data);
		}
		else
		{
			$data["error"] = $arr_fail;	
			$final_data = json_encode($data);
			print_r($final_data);
			//echo '[{"response":"vendor not added"}]';
		}
	}
?>