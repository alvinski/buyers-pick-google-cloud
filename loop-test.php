<?php
include('database.php');
/*
$arr[] = array("name"=>"Alvin", "surname"=>"Chettiar");

$encode = json_encode($arr);

print_r($encode);
*/	
$json = json_decode($_POST['user_attr'], true);
//print_r($json);

foreach($json as $key=>$values)
{
	$id = "";
	$old_id = $values['id'];
	$attribute_id = $values['attribute_id'];
	$content_id = $values['content_id'];
	$value = $values['value'];
	$is_deleted = $values['is_deleted'];
	$last_modified = $values['last_modified'];
	$sync_status = 1;
	
	
	$sql = mysql_query("insert into ba_tbl_attributes_content_link (id, attribute_id, content_id, value, is_deleted, last_modified, sync_status) values('$id', '$attribute_id', '$content_id', '$value', '$is_deleted', '$last_modified', '$sync_status')") or die(mysql_error());
	$new_id = mysql_insert_id();
	
	$sqlSelect = mysql_query("select * from ba_tbl_attributes_content_link where id = '$new_id'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	extract($rowSelect);
	$arr_attr[] = array("old_id"=>$old_id, "id"=>$id, "attribute_id"=>$attribute_id, "content_id"=>$content_id, "value"=>$value, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "sync_status"=>$sync_status);
	
	
}	
$new_json = json_encode($arr_attr);
print_r($new_json);
/*
	foreach($_POST['id'] as $key=>$id_loop)
	{
		$id = $_POST['id'];
		$is_deleted = $_POST['is_deleted'];
		$value = $_POST['value'];
		$content_id = $_POST['content_id'];
		$attribute_id = $_POST['attribute_id'];
		$last_modified = $_POST['last_modified'];
	}
*/
?>