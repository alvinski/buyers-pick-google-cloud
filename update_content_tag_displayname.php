<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include_once('database.php');

$id = $_REQUEST['id'];
$path = $_REQUEST['path'];
$user_id = $_REQUEST['user_id'];
$tags = $_REQUEST['tags'];
$display_content_name = $_REQUEST["display_content_name"];
$sync_status = 1;
$update_status = 1;

$sqlInsert = mysql_query("update ba_tbl_content set tags = '$tags', update_status = '$update_status', display_content_name = '$display_content_name' where id = '$id'") or die(mysql_error());

if(mysql_affected_rows()==1)
{
	$sqlSelect = mysql_query("select * from ba_tbl_content where id = '$id'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	extract($rowSelect);
	$vendor_arr[] = array("id"=>$id, "tags"=>$tags, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "display_content_name"=>$display_content_name);
	
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
?>