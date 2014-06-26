<?php
include_once('database.php');
/*
$arr[] = array("name"=>"Alvin", "surname"=>"Chettiar");

$encode = json_encode($arr);

print_r($encode);
*/	
$arr_pass[] = array("response"=>"pass");
$arr_fail[] = array("response"=>"fail");
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
	if($content_id!="")
	{
	$sql = mysql_query("insert into ba_tbl_attributes_content_link (id, attribute_id, content_id, value, is_deleted, last_modified, sync_status) values('$id', '$attribute_id', '$content_id', '$value', '$is_deleted', '$last_modified', '$sync_status')") or die(mysql_error());
	$new_id = mysql_insert_id();
	
	$sqlSelect = mysql_query("select * from ba_tbl_attributes_content_link where id = '$new_id'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	extract($rowSelect);
	$arr_attr[] = array("old_id"=>$old_id, "id"=>$id, "attribute_id"=>$attribute_id, "content_id"=>$content_id, "value"=>$value, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "sync_status"=>$sync_status);
	}
	
}
if($arr_attr==null)
{
		$arr_attr = array();	
}
$data["error"] = $arr_pass;	
$data['attribute_content'] = $arr_attr;
//print_r($new_json);
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
/********************** CHECKING DATA FOR tbl_attributes ***********************/
$json_custom = json_decode($_POST['attribute_custom'], true);
//print_r($json);

foreach($json_custom as $key_custom=>$values_custom)
{
	$id = "";
	$old_id = $values_custom['id'];
	$attribute = $values_custom['attribute'];
	$display_attribute = $values_custom['display_attribute'];
	$industry_id = $values_custom['industry_id'];
	$is_deleted = $values_custom['is_deleted'];
	$last_modified = $values_custom['last_modified'];
	$master_attribute_id = $values_custom['master_attribute_id'];
	$created_by = $values_custom['created_by'];
	$user_id = $values_custom['user_id'];
	$sync_status_custom = 1;
	if($user_id!="")
	{
	$sqlCustom = mysql_query("insert into ba_tbl_attributes (id, attribute, display_attribute, industry_id, is_deleted, last_modified, master_attribute_id, created_by, user_id, sync_status) values('$id', '$attribute', '$display_attribute', '$industry_id', '$is_deleted', '$last_modified', '$master_attribute_id', '$created_by', '$user_id', '$sync_status_custom')") or die(mysql_error());
	$new_id_Custom = mysql_insert_id();
	
	$sqlSelectCustom = mysql_query("select * from ba_tbl_attributes where id = '$new_id_Custom'");
	$rowSelectCustom = mysql_fetch_assoc($sqlSelectCustom);
	extract($rowSelectCustom);
	$arr_attr_custom[] = array("old_id"=>$old_id, "id"=>$id, "attribute"=>$attribute, "display_attribute"=>$display_attribute, "industry_id"=>$industry_id, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "master_attribute_id"=>$master_attribute_id, "created_by"=>$created_by, "user_id"=>$user_id, "sync_status"=>$sync_status);
	}
	
}
if($arr_attr_custom==null)
{
		$arr_attr_custom = array();	
}
$data["error"] = $arr_pass;		
$data['attribute_custom'] = $arr_attr_custom;
$new_json = json_encode($data);
print_r($new_json);
?>