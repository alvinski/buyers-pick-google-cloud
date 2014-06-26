<?php
include('database.php');
/** getting inductry values from table ***/

if($_POST['id']!="")
{
	$industry_id = $_POST['id']; 
$sqlIndus = mysql_query("select * from ba_tbl_industry_master where id > '$industry_id'");
while($rowIndus = mysql_fetch_assoc($sqlIndus))
{
	extract($rowIndus);
 	$industryarr[] = array("id"=>$id, "industry"=>$industry, "created_date"=>$created_date, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified);
}

if($industryarr==null)
{
	$industryarr = array();
}

$data['industry'] = $industryarr;

$json = json_encode($data);
print_r($json);
}
else
{
	echo '[{"response":"fail"}]';
}
?>