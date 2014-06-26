<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include_once('database.php');

$json = json_decode($_REQUEST['friend_share'], true);

$arr_pass[] = array("response"=>"pass");
$arr_nouser[] = array("response"=>"no_user");
$arr_nopost[] = array("response"=>"nopost");
//print_r($json);

//print_r($json);

foreach($json as $values)
{
	//$old_id = $values["id"];
	//echo "<pre>";
	//print $values["id"];
	/*
	foreach($values["ids"] as $key_id_auto=>$val_id_auto)
	{
		$old_id[] = $val_id_auto["auto_id"];
	}
	*/
	$sender_email = $values["sender_email"];
	$share_permission = $values['share_permission'];
	//$delete_permission = $values['delete_permission'];
	//$sync_status = $values['sync_status'];
	$sync_status = 1;
	$is_deleted = $values['is_deleted'];
	$update_status = $values['update_status'];
	$status = $values['status'];
	$item_type = $values["item_type"];
	
	foreach($values["item_id"] as $key_id=>$val_id)
	{
		//echo $val_id["id"]."<br>";
		$item_id = $val_id["id"];
		foreach($values["receiver_email_ids"] as $key_email=>$val_email)
		{
		//echo $val_email["email"]."<br>";
		$receiver_email = $val_email["email"];
		
		//checking if item_id and receiver_email already exits...
		$sqlCheck = mysql_query("select item_id, receiver_email from ba_tbl_friend_share where item_id = '$item_id' and receiver_email = '$receiver_email'");
		$num_check = mysql_num_rows($sqlCheck);
		if($num_check == 0)
		{
		/******** SENDING email to receiver **************/
		if($item_type == 1)
		{
			$sql = mysql_query("insert into ba_tbl_friend_share (item_id, sender_email, receiver_email, share_permission, sync_status, is_deleted, update_status, status, item_type) values('$item_id', '$sender_email', '$receiver_email', '$share_permission', '$sync_status', '$is_deleted', '$update_status', '$status', '$item_type')") or die(mysql_error());
			$inserted_id = mysql_insert_id();
			/******* Retrieving vendor master data from tbl_vendor_master *****/
			$sql_v_mas = mysql_query("select * from ba_tbl_vendor_master where id = '$item_id' and is_deleted = '0'");
			$row_v_mas = mysql_fetch_assoc($sql_v_mas);
			//extract($row_v_mas);
			$vendor_name = $row_v_mas["vendor_name"];
			$vendor_title = $row_v_mas["vendor_title"];
			$description = $row_v_mas["description"];
			$tags = $row_v_mas["tags"];
			$industry_id = $row_v_mas["industry_id"];
				/***** getting info industry from industry_id *****/
				$sqlIndus = mysql_query("select industry from ba_tbl_industry_master where id = '$industry_id'");
				$rowIndus = mysql_fetch_assoc($sqlIndus);
				$industry_name = $rowIndus["industry"];
				/************ END ***********/
			
			/****** END *******/
			
			/*********** Retrieving vendor contact info from tbl_vendor using above vendor_master_id *********/
	   		$sqlVendor = mysql_query("select * from ba_tbl_vendor where vendor_id = '$item_id' and is_deleted = '0'");
			//echo "Friend Vendor IDS : " . $friend_v_mas_id."<br>"; 
	        while($rowVendor = mysql_fetch_assoc($sqlVendor))
	   	    {
				$contact_id[] = $rowVendor["id"];
	   	 		$contact_email_id[] = $rowVendor["email"];
				$contact_address[] = $rowVendor["address"];
				$contact_contact_no[] = $rowVendor["contact_no"];
				$street1[] = $rowVendor["street1"];
				$street2[] = $rowVendor["street2"];
				$city[] = $rowVendor["city"];
				$state[] = $rowVendor["state"];
				$country[] = $rowVendor["country"];
		
	     	}
			/****** END *******/
			
			/*********** Retrieving vendor content info from tbl_content using above vendor_master_id *********/
   			 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$item_id' and is_deleted = '0'");
   			 while($rowContent = mysql_fetch_assoc($sqlContent))
   			 {
		 		$content_name[] = $rowContent["content_name"];
				$tags = $rowContent["tags"];
				$storage_path[] = $rowContent["storage_path"];
				$content_color[] = $rowContent["content_color"];
			 }	
				
   			 //$friend_arr_content[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "industry_id"=>$industry_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "type"=>$type, "sync_status"=>$sync_status, "cloud_path"=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color);
			/****** END *******/
			$message_body = "<html><head></head><body>"; 
			$message_body .= "Shared By ".$sender_email."<br>";
			$message_body .= "Name : " . $vendor_name."<br>";
			$message_body .= "Title : " . $vendor_title . "<br>";
			$message_body .= "Description : " . $description . "<br>";
			$message_body .= "Tags : " . $tags . "<br>";
			$message_body .= "Industry : " . $industry_name . "<br>";
			foreach($contact_id as $key_contact=>$contact_display)
			{
				$message_body .= "Contact Email : " . $contact_email_id[$key_contact] . "<br>";
				$message_body .= "Address : " . $contact_address[$key_contact] . "<br>";
				$message_body .= "Contact No. : " . $contact_contact_no[$key_contact] . "<br>";
				$message_body .= "Street 1 : " . $street1[$key_contact] . "<br>";
				$message_body .= "Street 2 : " . $street2[$key_contact] . "<br>";
				$message_body .= "City : " . $city[$key_contact] . "<br>";
				$message_body .= "State : " . $state[$key_contact] . "<br>";
				$message_body .= "Country : " . $country[$key_contact] . "<br>";
			}
			foreach($content_name as $key_content=>$content_display)
			{
				$message_body .= "Content Name : " . $content_display . "<br>";
				$message_body .= "<a href='".$storage_path[$key_content]."' target='_blank'><img src='".$storage_path[$key_content]."' style='max-width:150px;' /></a><br>";
				$message_body .= "Tags : " . $tags[$key_content] . "<br>";
				$message_body .= "Color : " . $content_color[$key_content] . "<br><br>";
			}
			$message_body .= "</body></html>";
			//$message_body .= "http://skibuyerspick.appspot.com/reset/?id=".base64_encode($email)."&r=$verification_key";

			$mail_options = [
			"sender" => "support@skiusainc.com",
			"to" => $receiver_email,
			"subject" => "Buyers Pick Shared Information",
			"htmlBody" => $message_body
			];

			try {
			$message = new Message($mail_options);
			$message->send();
				//echo '[{"response":"success"}]';
			} catch (InvalidArgumentException $e) {
			//echo $e; 
				//echo '[{"response":"Mail not sent!!"}]';
			}
		}
		else
		{
			/***************** For Sharing single content *********************/
			/*********** Retrieving vendor content info from tbl_content using above vendor_master_id *********/
   			 $sqlContent = mysql_query("select * from ba_tbl_content where id = '$item_id' and is_deleted = '0'");
   			 while($rowContent = mysql_fetch_assoc($sqlContent))
   			 {
		 		$single_content_name[] = $rowContent["content_name"];
				$single_tags = $rowContent["tags"];
				$storage_path_single[] = $rowContent["storage_path"];
				$content_color_single[] = $rowContent["content_color"];
				$content_type[] = $rowContent["type"];
				
				
			 }
			$sql = mysql_query("insert into ba_tbl_friend_share (item_id, sender_email, receiver_email, share_permission, sync_status, is_deleted, update_status, status, item_type) values('$item_id', '$sender_email', '$receiver_email', '$share_permission', '$sync_status', '$is_deleted', '$update_status', '$status', '$item_type')") or die(mysql_error());
			$inserted_id = mysql_insert_id();
			
			
			 $audioimg = "http://apps.medialabs24x7.com/buyerspick/images/audioimg.png";
			 $videoimg = "http://apps.medialabs24x7.com/buyerspick/images/videoimg.png";
			 $textimg = "http://apps.medialabs24x7.com/buyerspick/images/textimg.jpg";	
 			foreach($single_content_name as $key_single_content=>$single_content_display)
 			{
				$message_body = "<html><head></head><body>";
			
				$message_body .= "Content Name : " . $single_content_display . "<br>";
				if($content_type[$key_single_content]=="image")
				{
					$message_body .= "<a href='".$storage_path_single[$key_single_content]."' target='_blank'><img src='".$storage_path_single[$key_single_content]."' style='max-width:150px;' /></a><br>";
				}
				else if($content_type[$key_single_content]=="audio")
				{
					$message_body .= "<a href='".$storage_path_single[$key_single_content]."' target='_blank'><img src='".$storage_path_single[$key_single_content]."' style='max-width:150px;' /></a><br>";
				}
				else if($content_type[$key_single_content]=="video")
				{
					$message_body .= "<a href='".$storage_path_single[$key_single_content]."' target='_blank'><img src='".$storage_path_single[$key_single_content]."' style='max-width:150px;' /></a><br>";
				}
				else if($content_type[$key_single_content]=="text")
				{
					$message_body .= "<a href='".$storage_path_single[$key_single_content]."' target='_blank'><img src='".$storage_path_single[$key_single_content]."' style='max-width:150px;' /></a><br>";
				}
				$message_body .= "Tags : " . $single_tags[$key_single_content] . "<br>";
				$message_body .= "Color : " . $content_color_single[$key_single_content] . "<br><br>";
			
				$message_body .= "</body></html>";
			}
			//$message_body .= "http://skibuyerspick.appspot.com/reset/?id=".base64_encode($email)."&r=$verification_key";

			$mail_options = [
			"sender" => "support@skiusainc.com",
			"to" => $receiver_email,
			"subject" => "Buyers Pick Shared Information",
			"htmlBody" => $message_body
			];

			try {
			$message = new Message($mail_options);
			$message->send();
				//echo '[{"response":"success"}]';
			} catch (InvalidArgumentException $e) {
			//echo $e; 
				//echo '[{"response":"Mail not sent!!"}]';
			}
		}
		
		/*************** END ***************************/
			
		
		//echo "INSERTED ID : " . $inserted_id . "<br>";
		$sqlSelect = mysql_query("select * from ba_tbl_friend_share where id = '$inserted_id'");
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		extract($rowSelect);
		//$arr_friend_share[] = array("old_id"=>$old_id[$key_id],"id"=>$id, "sender_email"=>$sender_email, "receiver_email"=>$receiver_email, "item_id"=>$item_id, "share_permission"=>$share_permission, "delete_permission"=>$delete_permission, "sync_status"=>$sync_status, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "status"=>$status);
		$arr_friend_share[] = array("id"=>$id, "sender_email"=>$sender_email, "receiver_email"=>$receiver_email, "item_id"=>$item_id, "share_permission"=>$share_permission, "delete_permission"=>$delete_permission, "sync_status"=>$sync_status, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "status"=>$status, "item_type"=>$item_type);
		}
		
		}
		
	}
	
}


if($arr_friend_share==null)
{
	$arr_friend_share = array();
}		
//print_r($old_id);
$data["error"] = $arr_pass;
$data["friend_share"] = $arr_friend_share;
$json = json_encode($data);
print_r($json);
	
		//foreach($)
			/*
	function save_primay_friend_share($old_id, $sender_email, $receiver_email, $item_id, $share_permission, $delete_permission, $sync_status, $is_deleted, $update_status, $status)
	{
		$sql = mysql_query("insert into ba_tbl_friend_share values('', '$sender_email', '$receiver_email', '$item_id', '$share_permission', '$delete_permission', '1', '$is_deleted', '$update_status', '$status')") or die(mysql_error());
		
		$inserted_id = mysql_insert_id();
		$sqlSelect = mysql_query("select * from ba_tbl_friend_share where id = '$inserted_id'");
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		extract($rowSelect);
		$arr_friend_share[] = array("old_id"=>$old_id, "id"=>$id, "sender_email"=>$sender_email, "receiver_email"=>$receiver_email, "item_id"=>$item_id, "share_permission"=>$share_permission, "delete_permission"=>$delete_permission, "sync_status"=>$sync_status, "is_deleted"=>$is_deleted, "update_status"=>$update_status, "status"=>$status);
		
		$data["friend_share"] = $arr_friend_share;
		$json = json_encode($data);
		return print_r($json);
		
	}
		*/
	
	//save_primay_friend_share($old_id, $sender_email, $receiver_email, $item_id, $share_permission, $delete_permission, $sync_status, $is_deleted, $update_status, $status);


?>