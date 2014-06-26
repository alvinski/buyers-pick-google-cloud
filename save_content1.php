<?php
	include('database.php');
	require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
	use google\appengine\api\cloud_storage\CloudStorageTools;

	// Get the public URL. The permission is controlled by the object's ACL.
	/*
	$gs_file = $_FILES["uploaded_files"]['tmp_name'];
	$gs_name = $_FILES["uploaded_files"]['name'];
	$gs_size = $_FILES["uploaded_files"]['size'];
	//var_dump($_FILES);
	/*
	$fp = fopen("gs://photouploads/alvin.jpg", "w");
	fwrite($fp, $gs_file);
	fclose($fp);
	*/
	/*
	$options = [ "gs" => [ "Content-Type" => "image/png" ]];
	$ctx = stream_context_create($options);
	file_put_contents("gs://photouploads/".$gs_name, $gs_file, 0, $ctx);
	*/
	/******* CHECKING IF VENDOR PATH ALREADY EXISTS ************/
	$content_name = $_POST['content_name'];
	$old_id = $_POST['id'];
	$sqlPath = mysql_query("select * from ba_tbl_content where content_name = '$content_name'");
	$rowPath = mysql_fetch_assoc($sqlPath);
	//$vendor_id = $rowPath['id'];
	$numPath = mysql_num_rows($sqlPath);
	
	if($numPath > 0)
	{
		$sqlSelect = mysql_query("select * from ba_tbl_content where content_name = '$content_name'");
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		extract($rowSelect);
		$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "sync_status"=> $sync_status, "industry_id"=>$industry_id, "type"=>$type, 'cloud_path'=>$cloud_path, "storage_path"=>$storage_path, "update"=>"No insert only Update");
	
		$arr_pass[] = array("response"=>"pass");
		$data["error"] = $arr_pass;
		$data["data"] = $vendor_arr;
		$json = json_encode($data);
		print_r($json);
		//$data = json_encode($vendor_arr);
		//print_r($data);
	}
	else
	{
	$path = $_POST['path'];
	$cloud_path = $_POST['cloud_path'];
	$gs_file = $_FILES["uploaded_files"]["tmp_name"];
	$gs_name = $_FILES["uploaded_files"]['name'];
	$gs_size = $_FILES["uploaded_files"]['size'];
	$gs_error = $_FILES["uploaded_files"]['error'];
	/*
	$options = [ "gs" => [ "Content-Type" => "image/png", "acl" => "public-read-write" ]];
	$ctx = stream_context_create($options);
	file_put_contents("gs://photouploads/".$gs_name, $gs_file, 0, $ctx);
	*/
	//echo "NAME : " . $gs_name."<br>";
	//echo "SIZE : " . $gs_size."<br>";
	/********** GETTING USER ID TO CALCULATE SPACE ALLOCATED TO USER *******/
	$user_id = $_POST['user_id'];
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
	if(move_uploaded_file($gs_file, "gs://buyerspick/".$cloud_path."/".$gs_name))
	{
		$public_url = CloudStorageTools::getPublicUrl("gs://buyerspick/".$cloud_path."/".$gs_name, true);
	
		$old_id = $_POST['id'];
		$empty_id = "";
		$content_name = $_POST['content_name'];
		$vendor_id = $_POST['vendor_id'];
		//$vendor_id = 10;
		//$user_id = 167;
		$tags = $_POST['tags'];
		$title = $_POST['title'];
		$content_size = $_POST['content_size'];
		$description = $_POST['description'];
		$website = $_POST['website'];
		$created_date = $_POST['created_date'];
		$update_date = $_POST['update_date'];
		$is_deleted = $_POST['is_deleted'];
		$delete_date = $_POST['delete_date'];
		$path = $_POST['path'];
		//$sync_status = $_POST['sync_status'];
		$industry_id = $_POST['industry_id'];
		$type = $_POST['type'];
		$type = $_POST['type'];
		$sync_status = 1;
		
		/******* ADDING / UPDATING USER SPACE USED AS PER CURRENT FILE SIZE ***********/
		$updated_user_space = $user_space_used + $gs_size;
		$sqlUpdate = mysql_query("update ba_tbl_user set user_space_used = '$updated_user_space' where id = '$user_id'");
		/********** END ***********/
		
		$sqlInsert = mysql_query("insert into ba_tbl_content values('$empty_id', '$content_name', '$vendor_id', '$tags', '$title', '$content_size', '$description', '$website', '$created_date', '$update_date', '$is_deleted', '$delete_date', '$path', '$sync_status', '$industry_id', '$type', '$cloud_path', '$public_url')") or die(mysql_error());
		
		/***** Checking if vendor is inserted ******/
		$inserted_id = mysql_insert_id();
		if($inserted_id)
		{
			$sqlSelect = mysql_query("select * from ba_tbl_content where id = '$inserted_id'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			extract($rowSelect);
			$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "sync_status"=> $sync_status, "industry_id"=>$industry_id, "type"=>$type, 'cloud_path'=>$cloud_path, "storage_path"=>$storage_path);
			
			$arr_pass[] = array("response"=>"pass");
			$data["error"] = $arr_pass;
			$data["data"] = $vendor_arr;
			$json = json_encode($data);
			print_r($json);
		}
		else
		{
			$arr_pass[] = array("response"=>"vendor not added");
			$data["error"] = $arr_pass;
			$json = json_encode($data);
			print_r($json);
			//echo '[{"response":"vendor not added"}]';
		}
	}
	else
	{
		
		$arr_pass[] = array("response"=>"'.$gs_error.'");
		$data["error"] = $arr_pass;
		$json = json_encode($data);
		print_r($json);
		//echo '[{"response":"file not uploaded"}]';
		//echo '[{"response":"'.$gs_error.'"}]';
	}
	}
	else
	{
		$arr_pass[] = array("response"=>"no space");
		$data["error"] = $arr_pass;
		$json = json_encode($data);
		print_r($json);
		//echo '[{"response":"no space"}]';
	}
	}
?>