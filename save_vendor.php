<?php
	//include('database.php');
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
			$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "tags"=>$tags, "description"=>$description, "path"=>$path, "created_date"=>$created_date, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_modified_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=> $current_location, "v_front_local"=>$v_front_local, "v_back_local"=>$v_back_local, "v_card_front"=>$v_card_front, "v_card_back"=>$v_card_back, "vendor_title"=>$vendor_title, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
		
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
		$v_front_local = $_POST['v_front_local'];
		$v_back_local = $_POST['v_back_local'];
		$v_card_front = $_POST['v_card_front'];
		$v_card_back = $_POST['v_card_back'];
		//$cloud_path = $_POST['cloud_path'];
		$gs_file = $_FILES["uploaded_files"]["tmp_name"];
		$gs_name = $_FILES["uploaded_files"]['name'];
		$gs_size = $_FILES["uploaded_files"]['size'];
		$gs_error = $_FILES["uploaded_files"]['error'];
		
		$gs_file_back = $_FILES["uploaded_files_back"]["tmp_name"];
		$gs_name_back = $_FILES["uploaded_files_back"]['name'];
		$gs_size_back = $_FILES["uploaded_files_back"]['size'];
		$gs_error_back = $_FILES["uploaded_files_back"]['error'];
		//echo "FILE SIZE : " . $gs_size."<br>";
		//echo "FILE NAME : " . $gs_name . "<br>";
		//echo " v_front_local : " .$v_front_local."<br>";
		if($gs_size>0)
		{
			//Selecting user plan/subscription type of user
			$sqlUser = mysql_query("select * from ba_tbl_user where id = '$user_id'");	
			$rowUser = mysql_fetch_assoc($sqlUser);
			$subscription_type = $rowUser['subscription_type'];
			//echo '[{"sub type":"'.$subscription_type.'"}]';
			$user_space_used = $rowUser['user_space_used'];
			//echo '[{"user space":"'.$user_space_used.'"}]';
				//Selecting space allocated to user as per selected place
			$sqlPlan = mysql_query("select * from ba_tbl_plan_master where id = '$subscription_type'");	
			$rowPlan = mysql_fetch_assoc($sqlPlan);
	
			$space_allocated = $rowPlan['size_allocated'];
			//echo '[{"space allocated":"'.$space_allocated.'"}]';
	
			$new_upload_size = $gs_size + $user_space_used;
	
			if( $user_space_used < $space_allocated && $new_upload_size < $space_allocated )
			{
				if(!is_dir("vendor/".$path))
				{
					mkdir("vendor/".$path, 0777);
				}
				if(move_uploaded_file($gs_file, "vendor/".$path."/".$gs_name))
				{
					//$public_url = CloudStorageTools::getPublicUrl("gs://buyerspick/".$cloud_path."/".$gs_name, true);
					$public_url_front = "http://apps.medialabs24x7.com/buyerspick/vendor/".$path."/".$gs_name;
					if(move_uploaded_file($gs_file_back, "vendor/".$path."/".$gs_name_back))
					{
						$public_url_back = "http://apps.medialabs24x7.com/buyerspick/vendor/".$path."/".$gs_name_back;
					}
					$sync_timestamp = date("Y-d-m h:i:s");
					$sqlInsert = mysql_query("insert into ba_tbl_vendor_master values('$empty_id', '$vendor_name', '$user_id', '$tags', '$description', '$path', '$created_date', '$security_pin', '$old_security_pin', '$last_modified_security_pin', '$geo_latitude', '$geo_longitude', '$last_modified_date', '$is_deleted', '$delete_date', '$industry_id', '$current_location', '$v_front_local', '$v_back_local', '$public_url_front', '$public_url_back', '$vendor_title', '$sync_status', '$update_status', '$sync_timestamp')") or die(mysql_error());
					/***** Checking if vendor is inserted ******/
					$inserted_id = mysql_insert_id();
					if($inserted_id)
					{
						$sqlSelect = mysql_query("select * from ba_tbl_vendor_master where id = '$inserted_id'");
						$rowSelect = mysql_fetch_assoc($sqlSelect);
						extract($rowSelect);
						$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "tags"=>$tags, "description"=>$description, "path"=>$path, "created_date"=>$created_date, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_modified_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=> $current_location, "v_front_local"=>$v_front_local, "v_back_local"=>$v_back_local, "v_card_front"=>$v_card_front, "v_card_back"=>$v_card_back, "vendor_title"=>$vendor_title, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
			
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
			}
		}
		else
		{
			$sync_timestamp = date("Y-d-m h:i:s");
			$sqlInsert = mysql_query("insert into ba_tbl_vendor_master values('$empty_id', '$vendor_name', '$user_id', '$tags', '$description', '$path', '$created_date', '$security_pin', '$old_security_pin', '$last_modified_security_pin', '$geo_latitude', '$geo_longitude', '$last_modified_date', '$is_deleted', '$delete_date', '$industry_id', '$current_location', '$v_front_local', '$v_back_local', '$public_url_front', '$public_url_back', '$vendor_title', '$sync_status', '$update_status', '$sync_timestamp')") or die(mysql_error());
			/***** Checking if vendor is inserted ******/
			$inserted_id = mysql_insert_id();
			if($inserted_id)
			{
				$sqlSelect = mysql_query("select * from ba_tbl_vendor_master where id = '$inserted_id'");
				$rowSelect = mysql_fetch_assoc($sqlSelect);
				extract($rowSelect);
				$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "tags"=>$tags, "description"=>$description, "path"=>$path, "created_date"=>$created_date, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_modified_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=> $current_location, "v_front_local"=>$v_front_local, "v_back_local"=>$v_back_local, "v_card_front"=>$v_card_front, "v_card_back"=>$v_card_back, "vendor_title"=>$vendor_title, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
			
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
		
		
	}
?>