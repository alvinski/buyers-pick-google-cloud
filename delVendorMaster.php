<?php
include_once('database.php');
$json = json_decode($_REQUEST['vendor_master_id'], true);
foreach($json as $key=>$values)
{

	$id = $values['id'];
	//$friend_share_del_flag = $values["friend_share_del_flag"];
	/*
	$vendor_name = $values['vendor_name'];
	$vendor_title = $values['vendor_title'];
	$tags = $values['tags'];
	$created_date = $values['created_date'];
	$description = $values['description'];
	$security_pin = $values['security_pin'];
	$old_security_pin = $values['old_security_pin'];
	$last_modified_security_pin = $values['last_modified_security_pin'];
	$geo_latitude = $values['geo_latitude'];
	$geo_longitude = $values['geo_longitude'];
	$last_modified_date = $values['last_modified_date'];
	$is_deleted = $values['is_deleted'];
	$delete_date = $values['delete_date'];
	$industry_id = $values['industry_id'];
	$last_modified = $values['last_modified'];
	*/
	//echo "ID : " . $id."<br>";
	//if($id!="")
	//{
		$sqlDel = mysql_query("update ba_tbl_vendor_master set is_deleted = '1' where id = '$id'");
		if(mysql_affected_rows()==1)
		{
			/***** Checking if delete from secondary user side ******/
			//if($friend_share_del_flag==1)
			//{
				/******* Updating is_deleted column from tbl_friend_share table *******/
				$sqlDelFriendShare = mysql_query("update ba_tbl_friend_share set is_deleted = '1' where item_id = '$id'");
				/***************************** END ***********************************/
		 	//}
			/* 17/07/2014. Commented as vendor will now be deleted from all the tables.
			if($friend_share_del_flag==0)
			{
				/****** Selecting email_id of all receivers of the specific item_id *****
				$sqlSelect = mysql_query("select * from ba_tbl_friend_share where item_id = '$id'");
				while($rowSelect = mysql_fetch_assoc($sqlSelect))
				{
					$arr_receiver_email[] = $rowSelect["receiver_email"];
					$arr_receiver_userid[] = $rowSelect["id"];
				}
				/**** END *****
				/*** Selecting email_id/user information from tbl_user using email from the above array ****
				
				foreach($arr_receiver_email as $key_email=>$user_email)
				{
					$sqlUser = mysql_query("select * from ba_tbl_user where email = '$user_email'");
					$rowUser = mysql_fetch_assoc($sqlUser);
					$user_id = $rowUser["id"];
					//inserting vendor info in vendor_master table for secondary user
					$sqlVMas = mysql_query("select * from ba_tbl_vendor_master where id = '$id'");
					$rowVMas = mysql_fetch_assoc($sqlVMas);
					extract($rowVMas);
					//$sqlInsert = mysql_query("insert into ba_tbl_vendor_master values('', '$vendor_name', '$arr_receiver_userid[$key_email]', '$tags', '$description', '$path', '$created_date', '$security_pin', '$old_security_pin', '$last_modified_security_pin', '$geo_latitude', '$geo_longitude', '$last_modified_date', '$is_deleted', '$delete_date', '$industry_id', '$current_location', '$v_front_local', '$v_back_local', '$public_url_front', '$public_url_back', '$vendor_title', '0', '$update_status', '$sync_timestamp')") or die(mysql_error());
					$sqlInsert = mysql_query("insert into ba_tbl_vendor_master values('', '$vendor_name', '$user_id', '$tags', '$description', '$path', '$created_date', '$security_pin', '$old_security_pin', '$last_modified_security_pin', '$geo_latitude', '$geo_longitude', '$last_modified_date', '$is_deleted', '$delete_date', '$industry_id', '$current_location', '$v_front_local', '$v_back_local', '$public_url_front', '$public_url_back', '$vendor_title', '0', '$update_status', '$sync_timestamp')") or die(mysql_error());
					//selecting vendor contact info from tbl_vendor using vendor id from post request
					$sqlVendorContact = mysql_query("select * from ba_tbl_vendor where vendor_id = '$id'") or die(mysql_error());
					while($rowVendorContact = mysql_fetch_assoc($sqlVendorContact))
					{
						extract($rowVendorContact);
						$sqlVContact = mysql_query("insert into ba_tbl_vendor values('', '$vendor_id', '$website', '$email_id', '$address', '$contact_no', '0',  '$street1', '$street2', '$city', '$state', '$country', '0', '$update_status')") or die(mysql_error());
					}
					
					//Selecting content info from tbl_content as per above vendor_id
					$sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$id'");
					while($rowContent = mysql_fetch_assoc($sqlContent))
					{
						extract($rowContent);
					$sqlVContent = mysql_query("insert into ba_tbl_content values('', '$content_name', '$vendor_id', '$tags', '$title', '$content_size', '$description', '$website', '$created_date', '$update_date', '$is_deleted', '$delete_date', '$path', '0', '$industry_id', '$type', '$cloud_path', '$public_url', '$update_status', '$content_color')") or die(mysql_error());
					
					$arr_content_ids[] = $rowContent["id"];
					}
					
					//Selecting attributes related to content from tbl_attributes_content_link\
					foreach($arr_content_ids as $key_cont=>$cont_ids)
					{
						$sqlAttrCont = mysql_query("select * from ba_tbl_attributes_content_link where id = '$cont_ids'");
						while($rowAttrCont = mysql_fetch_assoc($sqlAttrCont))
						{
							$extract($rowAttrCont);
							$sql = mysql_query("insert into ba_tbl_attributes_content_link (attribute_id, content_id, value, is_deleted, last_modified, sync_status) values('$attribute_id', '$content_id', '$value', '$is_deleted', '$last_modified', '$sync_status')") or die(mysql_error());
						}
					}
				}
				
				/***** END *****
			}
			*/
			/******** END *******/
			
			$sqlSelect = mysql_query("select id from ba_tbl_vendor_master where id = '$id'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			$updated_id = $rowSelect["id"];
			$arr_vendor_master[] = array("id"=>$updated_id);
			
			/************** changing/updating rows in tbl_vendor related to the deleted vendor_master **************/
			
			$sqlVendorUpdate = mysql_query("update ba_tbl_vendor set is_deleted = '1' where vendor_id = '$updated_id'"); //Updating all rows related to vendor_master_id
			
			$sqlVendorSelect = mysql_query("select id from ba_tbl_vendor where vendor_id = '$updated_id'"); //Selecting all updated ids related to vendor master
			while($rowVendorSelect = mysql_fetch_assoc($sqlVendorSelect))
			{
				$arrayVendor[] = array("id"=>$rowVendorSelect["id"]); //Creating array of ids from ba_tbl_vendor
			}
			
			/******************** END ******************/
			
			/************** changing/updating rows in tbl_content related to the deleted vendor_master **************/
			
			$sqlContentUpdate = mysql_query("update ba_tbl_content set is_deleted = '1' where vendor_id = '$updated_id'"); //Updating all rows releted to vendor_master_id
			
			$sqlContentSelect = mysql_query("select id from ba_tbl_content where vendor_id = '$updated_id'"); //Selecting all updated ids related to vendor master
			while($rowContentSelect = mysql_fetch_assoc($sqlContentSelect))
			{
				$arrayContent[] = array("id"=>$rowContentSelect["id"]); //Creating array of ids from ba_tbl_vendor
			}
			
			/******************** END ******************/
		}
		//}
	
	
}
if($arr_vendor_master==null)
{
		$arr_vendor_master = array();	
}
if($arrayVendor==null)
{
		$arrayVendor = array();	
}	
if($arrayContent==null)
{
		$arrayContent = array();	
}		
$data['vendor'] = $arr_vendor_master;
$data['vendor_contact'] = $arrayVendor;
$data['content'] = $arrayContent;
$json_final = json_encode($data);
print_r($json_final);
?>