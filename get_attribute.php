<?php
include('database.php');

if($_POST['id']!="")
{
	$attribute_id = $_POST['id'];
/** getting attributes values from table ***/
$sqlAttr = mysql_query("select * from ba_tbl_attributes where id > '$attribute_id'");
while($rowAttr = mysql_fetch_assoc($sqlAttr))
{
	extract($rowAttr);
 	$attr_arr[] = array("id"=>$id, "attribute"=>$attribute, "display_attribute"=>$display_attribute, "industry_id"=>$industry_id, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "master_attribute_id"=>$master_attribute_id, "created_by"=>$created_by, "user_id"=>$user_id, "sync_status"=>$sync_status);
}

if($attr_arr==null)
{
	$attr_arr = array();
}

$data['attribute'] = $attr_arr;

$json = json_encode($data);
print_r($json);
}
else
{
	echo '[{"response":"fail"}]';
}
?>