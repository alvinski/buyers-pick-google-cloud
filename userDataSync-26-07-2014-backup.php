<?php
include_once('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	
	
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$sqlSelect = mysql_query("select * from ba_tbl_user where email = '$email' and password = '$password'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$num_row = mysql_num_rows($sqlSelect);
	
	$arr_pass[] = array("response"=>"pass");
	$arr_nouser[] = array("response"=>"no_user");
	$arr_nopost[] = array("response"=>"nopost");
	
	if($num_row>0)
	{
	/****** getting tbl_user *******/	
	$user_master_id = $rowSelect['id'];
	$email = $rowSelect['email'];
	$password = $rowSelect['password'];
	$f_name = $rowSelect['f_name'];
	$l_name = $rowSelect['l_name'];
	$device = $rowSelect['device'];
	$last_login = $rowSelect['last_login'];
	$active = $rowSelect['active'];
	$created_date = $rowSelect['created_date'];
	$verification_key = $rowSelect['verification_key'];
	$active_date = $rowSelect['active_date'];
	$old_password = $rowSelect['old_password'];
	$last_modified = $rowSelect['last_modified'];
	$created_by = $rowSelect['created_by'];
	$subscription_type = $rowSelect['subscription_type'];
	$user_type = $rowSelect['user_type'];
	$security_pin = $rowSelect['security_pin'];
	$password_mod = $rowSelect['password_mod'];
	$user_space_used = $rowSelect['user_space_used'];
	$contact_no = $rowSelect['contact_no'];
	$gender = $rowSelect['gender'];
	$dob = $rowSelect['dob'];
	$profile_image = $rowSelect['profile_image'];
	$sync_setting = $rowSelect['sync_setting'];

	
	$arr_user_details[] = array("id"=>$user_master_id, "email"=>$email, "password"=>$password, "f_name"=>$f_name, "l_name"=>$l_name, "device"=>$device, "last_login"=>$last_login, "active"=>$active, "created_date"=>$created_date, "verification_key"=>$verification_key, "active_date"=>$active_date, "old_password"=>$old_password, "last_modified"=>$last_modified, "created_by"=>$created_by, "subscription_type"=>$subscription_type, "user_type"=>$user_type, "security_pin"=>$security_pin, "password_mod"=>$password_mod, "user_space_used"=>$user_space_used, "gender"=>$gender, "contact_no"=>$contact_no, "dob"=>$dob, "profile_image"=>$profile_image, "sync_setting"=>$sync_setting);
	
	/************ END ***********/
	
	/***************** getting tbl_plan_user *******************/
	
	//$plan_request_id = $_REQUEST['plan_request_id'];
	$sqlPlan = mysql_query("select * from ba_tbl_plan_user where user_id = '$user_master_id'");
	$rowPlan = mysql_fetch_assoc($sqlPlan);
	$plan_id = $rowPlan['id'];
	$planid = $rowPlan['plan_id'];
	$plan_user_id = $rowPlan['user_id'];
	$created_date = $rowPlan['created_date'];
	$active = $rowPlan['active'];
	$last_modified = $rowPlan['last_modified'];
	
	$arr_plan[] = array("id"=>$plan_id, "plan_id"=>$planid, "user_id"=>$plan_user_id, "created_date"=>$created_date, "active"=>$active, "last_modified"=>$last_modified);
	
	/********************** END *******************************/
	
	/***************** getting tbl_attributes *******************/
	
	$attribute_request_id = $_REQUEST['attribute_request_id'];
	$sqlAttr = mysql_query("select * from ba_tbl_attributes where (user_id = 0 or user_id = '$user_master_id') and id > '$attribute_request_id' and is_deleted = '0'");
	while($rowAttr = mysql_fetch_assoc($sqlAttr))
	{
		extract($rowAttr);
		$arr_attributes[] = array("id"=>$id, "attribute"=>$attribute, "display_attribute"=>$display_attribute, "industry_id"=>$industry_id, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "master_attribute_id"=>$master_attribute_id, "created_by"=>$created_by, "sync_status"=>$sync_status, "user_id"=>$user_id);
	}
	
	/*********************** END *******************************/
	
	/***************** getting tbl_vendor_master *******************/
	//echo "USER ID : " . $user_id;
	
	$vendor_master_request_id = $_REQUEST['vendor_master_request_id'];
	//print_r();
	//echo "USER ID " . $user_master_id;
	//echo "VENDOR REQUEST ID : " . $vendor_master_request_id;
	$sqlVendorMaster = mysql_query("select * from ba_tbl_vendor_master where user_id = '$user_master_id' and id >= '$vendor_master_request_id' and is_deleted = '0'");
	while($rowVendorMaster = mysql_fetch_assoc($sqlVendorMaster))
	{
		extract($rowVendorMaster);
		
		$vendor_master_id[] = array("id"=>$id);
		
		$arr_vendor_master[] = array("id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "vendor_title"=>$vendor_title, "tags"=>$tags, "created_date"=>$created_date, "description"=>$description, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_mofied_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=>$current_location, "v_front_local"=>$v_front_local, "v_back_local"=>$v_back_local, "v_card_front"=>$v_card_front, "v_card_back"=>$v_card_back, "path"=>$path, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);	
	}
	
	//echo "<pre>";
	//print_r($arr_vendor_master);
	
	/*********************** END *******************************/
	/*
	echo "<pre>";
	print_r($vendor_master_id);
	*/
	/***************** getting tbl_vendor *******************/
	//$arr_vendor = array();
	
	$vendor_request_id = $_REQUEST['vendor_request_id'];
	foreach($vendor_master_id as $key_v_master=>$v_master_id)
	{
		$ven_mas_id = $v_master_id["id"];
	 $sqlVendor = mysql_query("select * from ba_tbl_vendor where id > '$vendor_request_id' and vendor_id = '$ven_mas_id' and is_deleted = '0'");
     while($rowVendor = mysql_fetch_assoc($sqlVendor))
	 {
	 	extract($rowVendor);
	 	$arr_vendor[] = array("id"=>$id, "vendor_id"=>$vendor_id, "website"=>$website, "email_id"=>$email_id, "address"=>$address, "contact_no"=>$contact_no, "sync_status"=>$sync_status, "street1"=>$street1, "street2"=>$street2, "city"=>$city, "state"=>$state, "country"=>$country, "is_deleted"=>$is_deleted, "update_status"=>$update_status);
		
	 }
    }
	/*********************** END *******************************/
	
	/***************** getting tbl_content *******************/
	
	$content_request_id = $_REQUEST['content_request_id'];
	foreach($vendor_master_id as $key_c_master=>$c_master_id)
	{
		$con_mas_id = $c_master_id["id"];
	 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$con_mas_id' and id > '$content_request_id' and is_deleted = '0'");
	 while($rowContent = mysql_fetch_assoc($sqlContent))
	 {
		 extract($rowContent);
		 
		 $content_master_id[] = array("id"=>$id);
		 
		 $arr_content[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "industry_id"=>$industry_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "type"=>$type, "sync_status"=>$sync_status, "cloud_path"=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color, "display_content_name"=>$display_content_name);
	 }
    }
	/*********************** END *******************************/
	/*
	echo "<pre>";
	print_r($vendor_master_id);
	
	echo "<pre>";
	print_r($content_master_id);
	*/
	/***************** getting tbl_attributes_content_link *******************/
	
	$attribute_content_request_id = $_REQUEST['attribute_content_request_id'];
	foreach($content_master_id as $key_con_master=>$con_master_id)
	{
		$c_mas_id = $con_master_id["id"];
		$sqlAttrContLink = mysql_query("select * from ba_tbl_attributes_content_link where content_id = '$c_mas_id' and id > '$attribute_content_request_id' and is_deleted = '0'");
		while($rowAttrContLink = mysql_fetch_assoc($sqlAttrContLink))
		{
			extract($rowAttrContLink);
			$arr_attr_content_link[] = array("id"=>$id, "attribute_id"=>$attribute_id, "content_id"=>$content_id, "value"=>$value, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "sync_status"=>$sync_status);
		}
	}
	
	/*********************** END *******************************/
	
	/***************** getting tbl_industry_master *******************/
	
	$industry_request_id = $_REQUEST['industry_request_id'];
	
		$sqlIndusMaster = mysql_query("select * from ba_tbl_industry_master where user_id = '0' or user_id = '$user_master_id' and id > '$industry_request_id' and is_deleted = '0'");
		while($rowIndusMaster = mysql_fetch_assoc($sqlIndusMaster))
		{
			extract($rowIndusMaster);
			$arr_industry_master[] = array("id"=>$id, "industry"=>$industry, "created_date"=>$created_date, "is_deleted"=>$is_deleted, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "user_id"=>$user_id);
		}

	/*********************** END *******************************/
	
	/***************** getting tbl_attributes *******************/
	$attribute_request_id = $_POST['attribute_request_id'];
/** getting attributes values from table ***/
$sqlAttr = mysql_query("select * from ba_tbl_attributes where user_id = '0' or user_id = '$user_master_id' and id > '$attribute_request_id' and is_deleted = '0'");
while($rowAttr = mysql_fetch_assoc($sqlAttr))
{
	extract($rowAttr);
 	$attr_arr[] = array("id"=>$id, "attribute"=>$attribute, "display_attribute"=>$display_attribute, "industry_id"=>$industry_id, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "master_attribute_id"=>$master_attribute_id, "created_by"=>$created_by, "user_id"=>$user_id, "sync_status"=>$sync_status);
}
	/*********************** END *******************************/
	
	/***************** getting tbl_friend_share *******************/
	$friend_share_request_id = $_REQUEST["friend_share_request_id"];
	$sqlFriendShare = mysql_query("select * from ba_tbl_friend_share where id > '$friend_share_request_id' and (sender_email = '$email' or receiver_email = '$email') and is_deleted = '0'");
	while($rowFriendShare = mysql_fetch_assoc($sqlFriendShare))
	{
		extract($rowFriendShare);
		$arr_friend_share[] = array("id"=>$id, "item_id"=>$item_id, "sender_email"=>$sender_email, "receiver_email"=>$receiver_email, "item_id"=>$item_id, "share_permission"=>$share_permission, "delete_permission"=>$delete_permission, "sync_status"=>$sync_status, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "status"=>$status, "item_type"=>$item_type);
		
		/*
		$v_mas_id = $item_id;
		$sql_v_mas = mysql_query("select * from ba_tbl_vendor_master where id = '$v_mas_id'");
		$row_v_mas = mysql_fetch_assoc($sql_v_mas);
		extract($row_v_mas);	
		$arr_friend_v_mas[] = array("id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "vendor_title"=>$vendor_title, "tags"=>$tags, "created_date"=>$created_date, "description"=>$description, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_mofied_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=>$current_location, "path"=>$path, "sync_status"=>$sync_status, "update_status"=>$update_status);
	
		$arr_v_mas_id[] = array("id"=>$id);
		*/
		
	}	
	/****************** END *********************/
	
	/***************** getting tbl_friend_share vendor ids *******************/
	$friend_share_request_id_vendor = $_REQUEST["friend_share_request_id"];
	$sqlFriendShareVendor = mysql_query("select * from ba_tbl_friend_share where id > '$friend_share_request_id_vendor' and (sender_email = '$email' or receiver_email = '$email') and is_deleted = '0' and item_type = '1'");
	while($rowFriendShareVendor = mysql_fetch_assoc($sqlFriendShareVendor))
	{
		extract($rowFriendShareVendor);
		
		$v_mas_id = $item_id;
		//echo "Vendor_ID : " . $v_mas_id."<br>";
		$sql_v_mas = mysql_query("select * from ba_tbl_vendor_master where id = '$v_mas_id'");
		$row_v_mas = mysql_fetch_assoc($sql_v_mas);
		extract($row_v_mas);	
		$arr_friend_v_mas[] = array("id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "vendor_title"=>$vendor_title, "tags"=>$tags, "created_date"=>$created_date, "description"=>$description, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_mofied_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=>$current_location, "v_front_local"=>$v_front_local, "v_back_local"=>$v_back_local, "v_card_front"=>$v_card_front, "v_card_back"=>$v_card_back, "path"=>$path, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
	
		$arr_v_mas_id[] = array("id"=>$id);
	}	
	/****************** END *********************/
	
	/******* creating vendor_master array from vendor ids in friend_share table *********/
	/*
	$sqlFriendShareV = mysql_query("select * from ba_tbl_friend_share where sender_email = '$email' or receiver_email = '$email' and is_deleted = '0' and id > '$friend_share_request_id' and item_type = '1'");
	while($rowFriendShareV = mysql_fetch_assoc($sqlFriendShareV))
	{
		extract($rowFriendShareV);
		//$arr_friend_share[] = array("id"=>$id, "item_id"=>$item_id, "sender_email"=>$sender_email, "receiver_email"=>$receiver_email, "item_id"=>$item_id, "share_permission"=>$share_permission, "delete_permission"=>$delete_permission, "sync_status"=>$sync_status, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "status"=>$status, "item_type"=>$item_type);
		
	$v_mas_id = $item_id;
	$sql_v_mas = mysql_query("select * from ba_tbl_vendor_master where id = '$v_mas_id'");
	$row_v_mas = mysql_fetch_assoc($sql_v_mas);
	extract($row_v_mas);	
	$arr_friend_v_mas[] = array("id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "vendor_title"=>$vendor_title, "tags"=>$tags, "created_date"=>$created_date, "description"=>$description, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_mofied_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=>$current_location, "path"=>$path, "sync_status"=>$sync_status, "update_status"=>$update_status);
	
	$arr_v_mas_id[] = array("id"=>$id);
	}
	*/
	/**** END *****/
	//print_r($arr_v_mas_id);
	

	//print_r($arr_v_mas_id);
			/********* Selecting only vendor_ids by querying on item_type = 1 ***********/
			
			/*
			function friend_share_table($item_type, $email)
			{
				$sqlFS = mysql_query("select * from ba_tbl_friend_share where item_type = '$item_type' and (sender_email = '$email' or receiver_email = '$email') and is_deleted = '0'");
				while($rowFS = mysql_fetch_assoc($sqlFS))
				{
					extract($rowFS);
					//$arr_ven_mas_id = array();
					$arr_ven_mas_id[] = array("id"=>$id);
				}
				return $arr_ven_mas_id;
				
			}
		
			//Calling friend_share_table() function to get all vendor ids
			$v_item_id = 1;
			$c_item_id = 0;
			$arr_v_mas_id[] = friend_share_table($v_item_id, $email);
			//echo "<pre>";
			//print_r($arr_v_mas_id);
			$arr_c_mas_id[] = friend_share_table($c_item_id, $email);
			*/
			/**************** END ****************/
		
		/************************************ END ***********************************/
	/*********************** END *******************************/	
		
		/******** Creating array of tbl_vendor from vendor_id retrieved from the above select query ************/
		
		foreach($arr_v_mas_id as $key_v_mas=>$v_mas_id)
		{
			$friend_v_mas_id = $v_mas_id["id"];
			
	   		$sqlVendor = mysql_query("select * from ba_tbl_vendor where vendor_id = '$friend_v_mas_id' and is_deleted = '0'");
			//echo "Friend Vendor IDS : " . $friend_v_mas_id."<br>"; 
	        while($rowVendor = mysql_fetch_assoc($sqlVendor))
	   	    {
	   	 	extract($rowVendor);
	   	 	$arr_friend_vendor[] = array("id"=>$id, "vendor_id"=>$vendor_id, "website"=>$website, "email_id"=>$email_id, "address"=>$address, "contact_no"=>$contact_no, "sync_status"=>$sync_status, "street1"=>$street1, "street2"=>$street2, "city"=>$city, "state"=>$state, "country"=>$country, "is_deleted"=>$is_deleted, "update_status"=>$update_status);
		
	     	}
			
		}
		
		/************************************ END ***********************************/
		
		/******** Creating array of tbl_content from vendor_id retrieved from the above select query ************/
		
		foreach($arr_v_mas_id as $key_c_master=>$friend_c_master_id)
		{
			$friend_con_mas_id = $friend_c_master_id["id"];
			//echo "Friend Cont IDS : " . $friend_con_mas_id."<br>"; 
		 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$friend_con_mas_id' and is_deleted = '0'");
		 while($rowContent = mysql_fetch_assoc($sqlContent))
		 {
			 extract($rowContent);
		 
			 $friend_content_master_id[] = array("id"=>$id);
		 
			 $friend_arr_content[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "industry_id"=>$industry_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "type"=>$type, "sync_status"=>$sync_status, "cloud_path"=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color);
		 }
	    }
		//print_r($friend_arr_content);
		/************************************ END ***********************************/
		
		/***************** Creating array of tbl_attribute_content_link from content_id retrieved from the above select query *******************/
	
		foreach($friend_content_master_id as $key_con_master=>$friend_con_master_id)
		{
			$friend_c_mas_id = $friend_con_master_id["id"];
			$sqlAttrContLink = mysql_query("select * from ba_tbl_attributes_content_link where content_id = '$friend_c_mas_id' and is_deleted = '0'");
			while($rowAttrContLink = mysql_fetch_assoc($sqlAttrContLink))
			{
				extract($rowAttrContLink);
				$friend_arr_attr_content_link[] = array("id"=>$id, "attribute_id"=>$attribute_id, "content_id"=>$content_id, "value"=>$value, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "sync_status"=>$sync_status);
			}
		}
	
		/*********************** END *******************************/
		
		/***************** getting tbl_friend_share content ids *******************/
		$friend_share_request_id_content = $_REQUEST["friend_share_request_id"];
		$sqlFriendShareContent = mysql_query("select * from ba_tbl_friend_share where id > '$friend_share_request_id_content' and (sender_email = '$email' or receiver_email = '$email') and is_deleted = '0' and item_type = '0'");
		while($rowFriendShareContent = mysql_fetch_assoc($sqlFriendShareContent))
		{
			extract($rowFriendShareContent);
		
			$c_mas_id = $item_id;
			$sql_c_mas = mysql_query("select * from ba_tbl_content where id = '$c_mas_id' and is_deleted = '0'");
			$row_c_mas = mysql_fetch_assoc($sql_c_mas);
			extract($row_c_mas);	
			$arr_friend_c_mas[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>"", "industry_id"=>$industry_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "type"=>$type, "sync_status"=>$sync_status, "cloud_path"=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color);
	
			//$arr_v_mas_id[] = array("id"=>$id);
		}	
		/****************** END *********************/
		
		/***************** getting tbl_friend_share deleted ids *******************/
		$sqlFriendShareDelete = mysql_query("select * from ba_tbl_friend_share where (sender_email = '$email' or receiver_email = '$email') and is_deleted = '1'");
		while($rowFriendShareDelete = mysql_fetch_assoc($sqlFriendShareDelete))
		{
			extract($rowFriendShareDelete);
			$arr_friend_delete[] = array("item_id"=>$item_id);
		}	
		/****************** END *********************/
		
		/***************** getting ba_tbl_vendor_master updated ids *******************/
		$sqlUpdated_ven_mas = mysql_query("select * from ba_tbl_vendor_master where user_id = '$user_master_id' and update_status = '1' and is_deleted = '0'");
		while($rowUpdated_ven_mas = mysql_fetch_assoc($sqlUpdated_ven_mas))
		{
			extract($rowUpdated_ven_mas);
			$vendor_master_id[] = array("id"=>$id);
			$arr_update_ven_mas[] = array("id"=>$id, "vendor_name"=>$vendor_name, "user_id"=>$user_id, "vendor_title"=>$vendor_title, "tags"=>$tags, "created_date"=>$created_date, "description"=>$description, "security_pin"=>$security_pin, "old_security_pin"=>$old_security_pin, "last_modified_security_pin"=>$last_modified_security_pin, "geo_latitude"=>$geo_latitude, "geo_longitude"=>$geo_longitude, "last_modified_date"=>$last_mofied_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "industry_id"=>$industry_id, "current_location"=>$current_location, "v_front_local"=>$v_front_local, "v_back_local"=>$v_back_local, "v_card_front"=>$v_card_front, "v_card_back"=>$v_card_back, "path"=>$path, "sync_status"=>$sync_status, "update_status"=>$update_status, "sync_timestamp"=>$sync_timestamp);
		}	
		/****************** END *********************/
		
		/***************** getting ba_tbl_vendor updated ids *******************/
		foreach($vendor_master_id as $key_v_master=>$v_master_id)
		{
			$ven_mas_id = $v_master_id["id"];
		 $sqlVendor = mysql_query("select * from ba_tbl_vendor where vendor_id = '$ven_mas_id' and update_status = '1");
	     while($rowVendor = mysql_fetch_assoc($sqlVendor))
		 {
		 	extract($rowVendor);
		 	$arr_update_vendor[] = array("id"=>$id, "vendor_id"=>$vendor_id, "website"=>$website, "email_id"=>$email_id, "address"=>$address, "contact_no"=>$contact_no, "sync_status"=>$sync_status, "street1"=>$street1, "street2"=>$street2, "city"=>$city, "state"=>$state, "country"=>$country, "is_deleted"=>$is_deleted, "update_status"=>$update_status);
		
		 }
	    }
		/****************** END *********************/
		
		/***************** getting tbl_content updated ids *******************/
	
		foreach($vendor_master_id as $key_c_master=>$c_master_id)
		{
			$con_mas_id = $c_master_id["id"];
		 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$con_mas_id' and update_status = '1'");
		 while($rowContent = mysql_fetch_assoc($sqlContent))
		 {
			 extract($rowContent);
		 
			 $content_master_id[] = array("id"=>$id);
		 
			 $arr_update_content[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "industry_id"=>$industry_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "type"=>$type, "sync_status"=>$sync_status, "cloud_path"=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color);
		 }
	    }
		/*********************** END *******************************/
		
		
		//////******** Deleted IDS **************//////////
		/***************** getting tbl_vendor_master *******************/
	
		$sqlVendorMaster = mysql_query("select * from ba_tbl_vendor_master where user_id = '$user_master_id' and is_deleted = 1");
		while($rowVendorMaster = mysql_fetch_assoc($sqlVendorMaster))
		{
			extract($rowVendorMaster);
		
			$vendor_master_id[] = array("id"=>$id);
		
			$arr_vendor_master_deleted[] = array("id"=>$id);	
		}
	
		/*********************** END *******************************/
		
		
		
		/***************** getting tbl_vendor *******************/

		foreach($vendor_master_id as $key_v_master=>$v_master_id)
		{
			$ven_mas_id = $v_master_id["id"];
		 $sqlVendor = mysql_query("select * from ba_tbl_vendor where is_deleted = '1' and vendor_id = '$ven_mas_id' and is_deleted = 1");
	     while($rowVendor = mysql_fetch_assoc($sqlVendor))
		 {
		 	extract($rowVendor);
		 	$arr_vendor_deleted[] = array("id"=>$id);
		
		 }
	    }
		/*********************** END *******************************/
		
		/***************** getting tbl_content *******************/
	
		foreach($vendor_master_id as $key_c_master=>$c_master_id)
		{
			$con_mas_id = $c_master_id["id"];
		 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$con_mas_id' and is_deleted = 1");
		 while($rowContent = mysql_fetch_assoc($sqlContent))
		 {
			 extract($rowContent);
		 
			 $content_master_id[] = array("id"=>$id);
		 
			 $arr_content_deleted[] = array("id"=>$id);
		 }
	    }
		/*********************** END *******************************/
		
		//////******** Deleted IDS **************//////////
	
	
	if($arr_user_details==null)
	{
		$arr_user_details = array();
	}
	if($arr_plan==null)
	{
		$arr_plan = array();
	}
	if($arr_attributes==null)
	{
		$arr_attributes = array();
	}
	if($arr_vendor_master==null)
	{
		$arr_vendor_master = array();
	}
	if($arr_vendor==null)
	{
		$arr_vendor = array();
	}
	if($arr_content==null)
	{
		$arr_content = array();
	}
	if($arr_attr_content_link==null)
	{
		$arr_attr_content_link = array();
	}
	if($arr_industry_master==null)
	{
		$arr_industry_master = array();
	}
	if($attr_arr==null)
	{
		$attr_arr = array();
	}
	if($arr_friend_share==null)
	{
		$arr_friend_share = array();
	}
	
	if($arr_friend_v_mas==null)
	{
		$arr_friend_v_mas = array();
	}
	if($arr_friend_vendor==null)
	{
		$arr_friend_vendor = array();
	}
	if($friend_arr_content==null)
	{
		$friend_arr_content = array();
	}
	if($friend_arr_attr_content_link==null)
	{
		$friend_arr_attr_content_link = array();
	}
	if($arr_friend_c_mas==null)
	{
		$arr_friend_c_mas = array();
	}
	if($arr_friend_delete==null)
	{
		$arr_friend_delete = array();
	}
	
	if($arr_update_ven_mas==null)
	{
		$arr_update_ven_mas = array();
	}
	if($arr_update_vendor==null)
	{
		$arr_update_vendor = array();
	}
	if($arr_update_content==null)
	{
		$arr_update_content = array();
	}
	
	if($arr_vendor_master_deleted==null)
	{
		$arr_vendor_master_deleted = array();
	}
	if($arr_vendor_deleted==null)
	{
		$arr_vendor_deleted = array();
	}
	if($arr_content_deleted==null)
	{
		$arr_content_deleted = array();
	}
	
	$data["error"] = $arr_pass;
	$data["user"] = $arr_user_details;
	$data["user_plan"] = $arr_plan;
	//$data["attributes"] = $arr_attributes;
	$data["vendor_master"] = $arr_vendor_master;
	$data["vendor"] = $arr_vendor;
	$data["content"] = $arr_content;
	
	$data["vendor_master_update"] = $arr_update_ven_mas;
	$data["vendor_update"] = $arr_update_vendor;
	$data["content_update"] = $arr_update_content;
	
	$data["attr_content_link"] = $arr_attr_content_link;
	$data["industry_custom"] = $arr_industry_master;
	$data["attributes"] = $attr_arr;
	$data["friend_share"] = $arr_friend_share;
	
	$data["friend_vendor_master"] = $arr_friend_v_mas;
	$data["friend_vendor"] = $arr_friend_vendor;
	$data["friend_content"] = $friend_arr_content;
	$data["friend_attr_content_link"] = $friend_arr_attr_content_link;
	$data["friend_single_content"] = $arr_friend_c_mas;
	$data["friend_deleted"] = $arr_friend_delete;
	
	$data["vendor_master_deleted"] = $arr_vendor_master_deleted;
	$data["vendor_deleted"] = $arr_vendor_deleted;
	$data["content_deleted"] = $arr_content_deleted;

	$final_data = json_encode($data);
	print_r($final_data);
	
	}
	else
	{
		
		$data["error"] = $arr_nouser;
		$final_data = json_encode($data);
		print_r($final_data);
	}
}
else
{
	$data["error"] = $arr_nopost;
	$final_data = json_encode($data);
	print_r($final_data);
}