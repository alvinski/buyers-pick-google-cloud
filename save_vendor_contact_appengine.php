<?php
	include('database.php');
	$old_id = $_POST['id'];
	$empty_id = "";
	$vendor_id = $_POST['vendor_id'];
	//$vendor_id = 10;
	$website = $_POST['website'];
	//$user_id = 167;
	$email_id = $_POST['email_id'];
	$address = $_POST['address'];
	$contact_no = $_POST['contact_no'];
	$street1 = $_POST['street1'];
	$street2 = $_POST['street2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$country = $_POST['country'];
	$sync_status = 1;
	$update_status = 0;
	
	$sqlInsert = mysql_query("insert into ba_tbl_vendor values('$empty_id', '$vendor_id', '$website', '$email_id', '$address', '$contact_no', '$sync_status',  '$street1', '$street2', '$city', '$state', '$country', '0', '$update_status')") or die(mysql_error());
	/***** Checking if vendor is inserted ******/
	$inserted_id = mysql_insert_id();
	if($inserted_id)
	{
		$sqlSelect = mysql_query("select * from ba_tbl_vendor where id = '$inserted_id'");
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		extract($rowSelect);
		$vendor_arr[] = array("old_id"=> $old_id, "id"=>$id, "vendor_id"=>$vendor_id, "website"=>$website, "email_id"=> $email_id, "address"=>$address, "contact_no"=>$contact_no, "sync_status"=>$sync_status, "street1"=>$street1, "street2"=>$street2, "city"=>$city, "state"=>$state, "country"=>$country, "is_deleted"=>$is_deleted, "update_status"=>$update_status);
		
		$arr_pass[] = array("response"=>"pass");
		$data["error"] = $arr_pass;
		$data["data"] = $vendor_arr;
		$json = json_encode($data);
		//$data = json_encode($vendor_arr);
		print_r($json);
	}
	else
	{
		$arr_fail[] = array("response"=>"fail");
		$data["error"] = $arr_fail;
		$data["data"] = array("response"=>"vendor contact not added");
		$json = json_encode($data);
		print_r($json);
		//echo '[{"response":"vendor contact not added"}]';
	}
?>