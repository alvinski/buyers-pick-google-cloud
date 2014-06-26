<?php
include_once('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	
	
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$sqlSelect = mysql_query("select * from ba_tbl_user where email = '$email' and password = '$password'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$num_row = mysql_num_rows($sqlSelect);
	$user_id = $rowSelect['id'];	
	if($num_row>0)
	{
		/***************** getting tbl_attributes *******************/
	
		$sqlAttr = mysql_query("select * from ba_tbl_attributes where user_id = '$user_id' and update_status = '1'");
		while($rowAttr = mysql_fetch_assoc($sqlAttr))
		{
			extract($rowAttr);
			//$arr_attributes[] = array("id"=>$id, "attribute"=>$attribute, "display_attribute"=>$display_attribute, "industry_id"=>$industry_id, "is_deleted"=>$is_deleted, "last_modified"=>$last_modified, "master_attribute_id"=>$master_attribute_id, "created_by"=>$created_by, "sync_status"=>$sync_status, "user_id"=>$user_id);
			$arr_attributes[] = array("id"=>$id);
		}
		
		/*********************** END *******************************/
		
		/***************** getting tbl_vendor_master *******************/
	
		$sqlVendorMaster = mysql_query("select * from ba_tbl_vendor_master where user_id = '$user_id' and update_status = '1'");
		while($rowVendorMaster = mysql_fetch_assoc($sqlVendorMaster))
		{
			extract($rowVendorMaster);
		
			$vendor_master_id[] = array("id"=>$id);
		
			$arr_vendor_master[] = array("id"=>$id);	
		}
	
		/*********************** END *******************************/
		
		
		
		/***************** getting tbl_vendor *******************/

		foreach($vendor_master_id as $key_v_master=>$v_master_id)
		{
			$ven_mas_id = $v_master_id["id"];
		 $sqlVendor = mysql_query("select * from ba_tbl_vendor where update_status = '1' and vendor_id = '$ven_mas_id'");
	     while($rowVendor = mysql_fetch_assoc($sqlVendor))
		 {
		 	extract($rowVendor);
		 	$arr_vendor[] = array("id"=>$id);
		
		 }
	    }
		/*********************** END *******************************/
		
		/***************** getting tbl_content *******************/
	
		foreach($vendor_master_id as $key_c_master=>$c_master_id)
		{
			$con_mas_id = $c_master_id["id"];
		 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$con_mas_id' and update_status = '1'");
		 while($rowContent = mysql_fetch_assoc($sqlContent))
		 {
			 extract($rowContent);
		 
			 $content_master_id[] = array("id"=>$id);
		 
			 $arr_content[] = array("id"=>$id);
		 }
	    }
		/*********************** END *******************************/
		
		/***************** getting tbl_attributes_content_link *******************/

		foreach($content_master_id as $key_con_master=>$con_master_id)
		{
			$c_mas_id = $con_master_id["id"];
			$sqlAttrContLink = mysql_query("select * from ba_tbl_attributes_content_link where content_id = '$c_mas_id' and update_status = '1'");
			while($rowAttrContLink = mysql_fetch_assoc($sqlAttrContLink))
			{
				extract($rowAttrContLink);
				$arr_attr_content_link[] = array("id"=>$id);
			}
		}
	
		/*********************** END *******************************/
		
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
	
		$data["attributes"] = $arr_attributes;
		$data["vendor_master"] = $arr_vendor_master;
		$data["vendor"] = $arr_vendor;
		$data["content"] = $arr_content;
		$data["attr_content_link"] = $arr_attr_content_link;
	
		$final_data = json_encode($data);
		print_r($final_data);
		
	}
	else
	{
			echo '[{"response":"no user"}]';
	}	
}
else
{
	echo '[{"response":"nopost"}]';
}
?>