<?php
include_once('database.php');
$json = json_decode($_POST['vendor_id'], true);
foreach($json as $key=>$values)
{

	$id = $values['id'];
	$vendor_id = $values['vendor_id'];
	$website = $values['website'];
	$email_id = $values['email_id'];
	$address = $values['address'];
	$contact_no = $values['contact_no'];
	$sync_status = $values['sync_status'];
	$street1 = $values['street1'];
	$street2 = $values['street2'];
	$city = $values['city'];
	$state = $values['state'];
	$country = $values['country'];
	$is_deleted = $values['is_deleted'];
	$last_modified = $values['last_modified'];
	if($id!="")
	{
		$sqlDel = mysql_query("update ba_tbl_vendor set is_deleted = '1' where id = '$id'");
		if(mysql_affected_rows()==1)
		{
			
			$sqlSelect = mysql_query("select id from ba_tbl_vendor where id= '$id'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			$updated_id = $rowSelect["id"];
			$arr_vendor[] = array("id"=>$updated_id);
		}
	}
	
}
if($arr_vendor==null)
{
		$arr_vendor = array();	
}	
$new_json['vendor'] = $arr_vendor;
$new_json = json_encode($new_json);
print_r($new_json);
?>