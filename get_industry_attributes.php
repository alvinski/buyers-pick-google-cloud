<?php
include('database.php');
/** getting inductry values from table ***/
$sqlIndus = mysql_query("select * from ba_tbl_industry_master");
while($rowIndus = mysql_fetch_assoc($sqlIndus))
{
	extract($rowIndus);
 	$industryarr[] = array("id"=>$id, "industry"=>$industry, "created_date"=>$created_date, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified);
}

/** getting attributes values from table ***/
$sqlAttr = mysql_query("select * from ba_tbl_attributes");
while($rowAttr = mysql_fetch_assoc($sqlAttr))
{
	extract($rowAttr);
 	$attr_arr[] = array("id"=>$id, "attribute"=>$attribute, "display_attribute"=>$display_attribute, "industry_id"=>$industry_id, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "master_attribute_id"=>$master_attribute_id, "created_by"=>$created_by);
}

if($industryarr==null)
{
	$industryarr = array();
}
if($attr_arr==null)
{
	$attr_arr = array();
}

$data['industry'] = $industryarr;
$data['attribute'] = $attr_arr;

$json = json_encode($data);
print_r($json);
?>