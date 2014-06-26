<?php
include_once('database.php');

if(isset($_REQUEST['sender_email']) && isset($_REQUEST['receiver_email']))
{
	$old_id = $_REQUEST["id"];
	$sender_email = $_REQUEST['sender_email'];
	$receiver_email = $_REQUEST['receiver_email'];
	$item_id = $_REQUEST['item_id'];
	$share_permission = $_REQUEST['share_permission'];
	$delete_permission = $_REQUEST['delete_permission'];
	$sync_status = $_REQUEST['sync_status'];
	$is_deleted = $_REQUEST['is_deleted'];
	$update_status = $_REQUEST['update_status'];
	$status = $_REQUEST['status'];
	
	function save_primay_friend_share($old_id, $sender_email, $receiver_email, $item_id, $share_permission, $delete_permission, $sync_status, $is_deleted, $update_status, $status)
	{
		$sql = mysql_query("insert into ba_tbl_friend_share values('', '$sender_email', '$receiver_email', '$item_id', '$share_permission', '$delete_permission', '1', '$is_deleted', '$update_status', '$status')") or die(mysql_error());
		
		$inserted_id = mysql_insert_id();
		$sqlSelect = mysql_query("select * from ba_tbl_friend_share where id = '$inserted_id'");
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		extract($rowSelect);
		$arr_friend_share[] = array("old_id"=>$old_id, "id"=>$id, "sender_email"=>$sender_email, "receiver_email"=>$receiver_email, "item_id"=>$item_id, "share_permission"=>$share_permission, "delete_permission"=>$delete_permission, "sync_status"=>$sync_status, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "status"=>$status);
		
		$data["friend_share"] = $arr_friend_share;
		$json = json_encode($data);
		return print_r($json);
		
	}
	
	save_primay_friend_share($old_id, $sender_email, $receiver_email, $item_id, $share_permission, $delete_permission, $sync_status, $is_deleted, $update_status, $status);
}
?>