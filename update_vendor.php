<?php
include('database.php');
$json = json_decode($_POST['update_vendor'], true);
foreach($json as $key_vendor=>$values)
{
	$id = $values['id'];
	$vendor_id = $values['vendor_id'];
	//$vendor_id = 10;
	$website = $values['website'];
	//$user_id = 167;
	$email_id = $values['email_id'];
	$address = $values['address'];
	$contact_no = $values['contact_no'];
	$street1 = $values['street1'];
	$street2 = $values['street2'];
	$city = $values['city'];
	$state = $values['state'];
	$country = $values['country'];
	$sync_status = $values['sync_status'];
	$is_deleted = $values['is_deleted'];
	$update_status = 1;
	$sqlSelect = mysql_query("select * from ba_tbl_vendor where id = '$id'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numSelect = mysql_num_rows($sqlSelect);
	if($numSelect>0)
	{
		$sqlUpdate = mysql_query("update ba_tbl_vendor set '$empty_id', '$vendor_id', '$website', '$email_id', '$address', '$contact_no', '$sync_status',  '$street1', '$street2', '$city', '$state', '$country', '$is_deleted', '$update_status')") or die(mysql_error());
		if(mysql_affected_rows()==1)
		{
			$vendor_arr[] = array("id"=>$id, "vendor_id"=>$vendor_id, "website"=>$website, "email_id"=> $email_id, "address"=>$address, "contact_no"=>$contact_no, "sync_status"=>$sync_status, "street1"=>$street1, "street2"=>$street2, "city"=>$city, "state"=>$state, "country"=>$country, "is_deleted"=>$is_deleted, "update_status"=>$update_status);
			
		}
		else
		{
			echo '[{"response":"No Update"}]';
		}
	}
	else
	{
		echo '[{"response":"No Vendor Contact Found"}]';
	}
}	

if($vendor_arr==null)
{
	$vendor_arr = array();
}

$json['vendor'] = $vendor_arr;
$data = json_encode($json);
print_r($data);



?>