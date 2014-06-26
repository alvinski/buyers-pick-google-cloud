<?php
//include('database.php');
/*
$json = json_decode($_POST['update_vendor'], true);
foreach($json as $key_vendor=>$values)
{
	$id = $_POST['id'];
	//$empty_id = "";
	$content_name = $_POST['content_name'];
	$vendor_id = $_POST['vendor_id'];
	$content_name = $_POST['content_name'];
	$path = $_POST['path'];
	$cloud_path = $_POST['cloud_path'];
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
	$update_status = 1;
}
*/
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

/******* CHECKING IF VENDOR PATH ALREADY EXISTS ************/
$content_name = $_POST['content_name'];
$path = $_POST['path'];
$cloud_path = $_POST['cloud_path'];
$gs_file = $_FILES["uploaded_files"]["tmp_name"];
$gs_name = $_FILES["uploaded_files"]['name'];
$gs_size = $_FILES["uploaded_files"]['size'];
$gs_error = $_FILES["uploaded_files"]['error'];
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
if(!is_dir("vendor/".$cloud_path))
{
	mkdir("vendor/".$cloud_path, 0777);
}
if(move_uploaded_file($gs_file, "vendor/".$cloud_path."/".$gs_name))
{
	//$public_url = CloudStorageTools::getPublicUrl("gs://buyerspick/".$cloud_path."/".$gs_name, true);
	$public_url = "http://apps.medialabs24x7.com/buyerspick/vendor/".$cloud_path."/".$gs_name;
	
	$id = $_POST['id'];
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
	$content_color = $_POST['content_color'];
	$sync_status = 1;
	$update_status = 0;

	$sqlInsert = mysql_query("update ba_tbl_content set content_name = '$content_name', vendor_id = '$vendor_id', tags = '$tags', title = '$title', content_size = '$content_size', description = '$description', website = '$website', created_date = '$created_date', update_date = '$update_date', is_deleted = '$is_deleted', delete_date = '$delete_date', path = '$path', sync_status = '$sync_status', industry_id = '$industry_id', type = '$type', cloud_path = '$cloud_path', public_url = '$public_url', update_status = '$update_status', content_color = '$content_color' where id = '$id'") or die(mysql_error());

	if(mysql_affected_rows()==1)
	{
		$sqlSelect = mysql_query("select * from ba_tbl_content where id = '$id'");
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		extract($rowSelect);
		$vendor_arr[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "sync_status"=> $sync_status, "industry_id"=>$industry_id, "type"=>$type, 'cloud_path'=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color);
		
		$arr_pass[] = array("response"=>"pass");
		$data["error"] = $arr_pass;
		$data["data"] = $vendor_arr;
		$json = json_encode($data);
		print_r($json);
	}
	else
	{
		$arr_pass[] = array("response"=>"vendor not updated");
		$data["error"] = $arr_pass;
		$json = json_encode($data);
		print_r($json);
		//echo '[{"response":"vendor not added"}]';
	}
}
else
{
	
	$arr_pass[] = array("response"=>"no post");
	$data["error"] = $arr_pass;
	$json = json_encode($data);
	print_r($json);
	//echo '[{"response":"file not uploaded"}]';
	//echo '[{"response":"'.$gs_error.'"}]';
}
?>