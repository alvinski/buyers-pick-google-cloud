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
	$sqlSender = mysql_query("select f_name, l_name from ba_tbl_user where email = '$sender_email'");
	$rowSender = mysql_fetch_assoc($sqlSender);
	$s_f_name = $rowSender["f_name"];
	$s_l_name = $rowSender["l_name"];
	$share_permission = $values['share_permission'];
	//$delete_permission = $values['delete_permission'];
	//$sync_status = $values['sync_status'];
	$sync_status = 1;
	$is_deleted = $values['is_deleted'];
	$update_status = $values['update_status'];
	$status = $values['status'];
	$item_type = $values["item_type"];
	
	
	foreach($values["receiver_email_ids"] as $key_email=>$val_email)
	{
		foreach($values["item_id"] as $key_id=>$val_id)
		{
				//echo $val_id["id"]."<br>";
				$item_id = $val_id["id"];
		//echo $val_email["email"]."<br>";
		$receiver_email = $val_email["email"];
		/********* Getting receivers information using emai id of the receiver. *****/
		$sqlReceiver = mysql_query("select f_name, l_name from ba_tbl_user where email = '$receiver_email'");
		$rowReceiver = mysql_fetch_assoc($sqlReceiver);
		$f_name = $rowReceiver["f_name"];
		$l_name = $rowReceiver["l_name"];
		/****** END *****/
		
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
			/*
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
			*/
			/****** END *******/
			
			/*********** Retrieving vendor content info from tbl_content using above vendor_master_id *********/
   			 $sqlContent = mysql_query("select * from ba_tbl_content where vendor_id = '$item_id' and is_deleted = '0'");
   			 while($rowContent = mysql_fetch_assoc($sqlContent))
   			 {
		 		$content_name[] = $rowContent["content_name"];
				$tags = $rowContent["tags"];
				$storage_path[] = $rowContent["storage_path"];
				$content_color[] = $rowContent["content_color"];
				$content_type[] = $rowContent["type"];
			 }	
				
   			 //$friend_arr_content[] = array("id"=>$id, "content_name"=>$content_name, "vendor_id"=>$vendor_id, "industry_id"=>$industry_id, "tags"=>$tags, "title"=>$title, "content_size"=>$content_size, "description"=>$description, "website"=>$website, "created_date"=>$created_date, "update_date"=>$update_date, "is_deleted"=>$is_deleted, "delete_date"=>$delete_date, "path"=>$cloud_path, "type"=>$type, "sync_status"=>$sync_status, "cloud_path"=>$cloud_path, "storage_path"=>$storage_path, "update_status"=>$update_status, "content_color"=>$content_color);
			/****** END *******/
			
			$message_body = '
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title> Buyers Picks - Friend Share </title>

				<style type="text/css">
						*{padding:0; margin:0;}
						.ReadMsgBody {width: 100%;}
				      	.ExternalClass {width: 100%;}
				      	.appleBody a {color:#ffffff; text-decoration: none;}
				      	.appleFooter a {color:#999999; text-decoration: none;}
		
						span[class="adrt"]{
				      			display:none !important;}
				
						td[class="padd"]{
								padding-left:25px;}
		

						@media screen and (max-width: 480px) {
			
							td[class="padd"]{
								padding: 0 10px !important;}
		
				      		table[class="wrapper"]{
				              width:100% !important;}
			  
						
							span[class="adrt"]{
				      			display:block !important;}
			  
				      		td[class="logo"]{
				      			text-align: left;
				      			padding: 10px 0 20px 20px !important;}
				
							td[class="main-banner"]{
				      			text-align: center !important;}
      			
				      		td[class="mobile-hide"]{
				      			display:none !important;}
      			
				      		td[class="no-padding-in-mobile"]{
				      			padding:0 !important;}
								
				      		td[class="logo_td"] img{
				      			margin:0 auto !important;}
				
							img[class="logo"]{
				            width:100% !important;
				            height:auto;}
			
				      		table[class="button"]{
				      			width:85% !important;
				      			height:auto}
				
				      		td[class="button"]{
				      			font-size: 20px !important;
				      			padding: 10px !important;}
			
				      		td[class="footer"]{
				      			text-align:center;
				      			font-size:12px !important;
				      			line-height:22px !important;
				      			-webkit-text-size-adjust: none;}
      			
				      		table[class="responsive-table"]{
				      			width:100% !important;
								margin:0 !important;
								padding:0 !important;}
			
							table[class="responsive-table2"]{
				      			width:90% !important;
								margin:0 !important;
								padding-left:0;
								padding-right:0;}
				
							table[class="responsive-table3"]{
				      			width:331px !important;
								margin:0 !important;
								padding-left:0;
								padding-right:0;}
				
							table[class="responsive-table4"]{
				      			width:100%;
								margin:0 !important;}
				
						    table[class="responsive-table5"]{
				      			width:100% !important;
								margin:0 !important;
								text-align:center;}
				
							table[class="responsive-table6"]{
				      			width:100% !important;
								margin:0 !important;
								text-align:left !important;
								padding-left:0!important;}
				
				      		td[class="mobile-paragraph"]{
				      			font-size:18px !important;
				      			line-height:25px !important;
				      			padding-bottom:40px !important;
				      			padding-right:10px !important;
				      			padding-left:10px !important;}
      			
				      		td[class="mobile-show"]{
				      			display:block !important;}
			
							span[class=emailh2],a[class=emailh2]
							{font-size:22px !important;
							line-height:26px !important;}
			
			
							a[class="emailmobbutton"]
							{display:block !important;
							font-size:14px !important;
							font-weight:bold !important;
							padding:4px 4px 6px 4px !important;
							line-height:18px !important;
							background-color:#dddddd !important;
							border-radius:5px !important;
							margin:10px auto !important; 
							width:60% !important;
							text-align:center; 
							color:#613f02 !important; 
							text-decoration:none;}
			
							span[class="mobile-hide"]{
								display:none !important;}
				
							td[class="mobile-hide"]{
								display:none !important;}
				
							td[class="align1"]{
								padding:10px 0 11px 10px !important;
								margin:0 !important;}
			
							img[class="emailwrap300"]
							{width:300px !important;
							height:auto !important;}
			
							img[class="emailwrap331"]
							{width:331px !important;
							height:auto !important;}
			
							img[class="emailwrap280"]
							{width:280px !important;
							height:auto !important;}
			
							img[class="emailwrap220"]
							{width:220px !important;
							height:auto !important;
							padding-top:0;}
			
							img[class="emailheadline"]{
								padding-top:10px !important;
								width:300px !important;}
				
							span[class="emailbodytext"],a[class="emailbodytext"]
							{font-size:16px !important;
							line-height:21px !important;}
			
							a[class=emailmobbutton2]
							{display:block !important;
							font-size:14px !important;
							font-weight:bold !important;
							padding:6px 4px 8px 4px !important;
							line-height:18px !important;
							background-color:#3651a4 !important;
							border-radius:5px !important;
							margin:10px auto !important;
							width:70% !important;
							text-align:center;
							color:#cccccc !important;
							text-decoration:none;}
			
							td[class=footer-text]{
								padding-left:0 !important;}
				
			
				
						}
		

	

				</style>

				</head>

				<body style="margin: 0 auto; padding: 0;">

					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0; margin:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:100%; background-color:#fff;">
				      <tr>
				        <td class="mobile-show" align="center">
				        	<table width="700" border="0" cellspacing="0" cellpadding="0" class="wrapper" style="background-color:#e9e9e9;">
				              <tr>
				                <td align="left" valign="top">
				                	<table width="700" border="0" cellspacing="0" cellpadding="0" class="responsive-table">
				                      <tr>
				                        <td align="center" valign="top" style="padding: 0 0 0 0px;">
				           	    	    	<a href="#"><img src="http://www.buyerspicks.com/images/logo.jpg" width="206" height="154" alt="" border="0" /></a>
				                        </td>
				                      </tr>
				                    </table>
				                </td>
				              </tr>
				              <tr>
				                <td align="left" valign="top">
				                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="responsive-table">
				                      <tr>
				                        <td style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 20px 0 0px 15px;">
				                        	Hello '.$f_name.' '.$l_name.',

				                        </td>
				                      </tr>
				                      <tr>
				                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 15px 0 0px 15px; ">
				                        	<span style="color:#fd0000;">'.$s_f_name.' '.$s_l_name.',</span> wants to share these files with you.
				                        </td>
				                      </tr>
                      
				                    </table>
				                </td>
				              </tr>              
              
				              <tr>
				                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:24px; padding: 10px 0 10px 0px;">
				           	    	<img src="http://www.buyerspicks.com/images/vendor_file.jpg" width="685" height="60" alt="" class="logo" />
				                </td>
				              </tr>    
              
				               <tr>
				                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; color:#415161; padding: 10px 10px 10px 10px;">
				           	    	<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="background:#f0efef; border:1px solid #fff; -webkit-border-radius: 10px 10px 10px 10px;
				border-radius: 10px 10px 10px 10px;">
				                      <tr>
				                        <td align="center" valign="top" class="padd" style="padding-left:25px;">
											';
											foreach($content_name as $key_content=>$content_display){
								
								$message_body .= '
				                        	<table align="left" width="301" border="0" cellspacing="0" cellpadding="0"  class="responsive-table" style="padding-right:25px;">
				                              <tr>
				                                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; font-size:12px; color:#576573; padding:15px 0px">
				                                	File Name: <span style="color:#ce7e7e;">'.$content_display.'</span>
				                                </td>
				                              </tr>
				                              <tr>
				                                <td align="left" valign="top">';
												if($content_type[$key_content]=="image")
												{
													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="'.$storage_path[$key_content].'" width="301" height="339" alt="" class="logo" /></a>';
												}
												else if($content_type[$key_content]=="text")
												{
													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="http://www.buyerspicks.com/images/note.png" width="301" height="339" alt="" class="logo" /></a>';
												}
												else if($content_type[$key_content]=="audio")
												{
													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="http://www.buyerspicks.com/images/audio.png" width="301" height="339" alt="" class="logo" /></a>';
												}
												else if($content_type[$key_content]=="video")
												{
													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="http://www.buyerspicks.com/images/video.png" width="301" height="339" alt="" class="logo" /></a>';
												}
				                               $message_body .=  '</td>
				                              </tr>
				                              <tr>
				                                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; font-size:12px; color:#576573; padding:15px 0px">
				                                	Tags:  <span style="color:#6e9cbb">'.$tags[$key_content].'</span>
				                                </td>
				                              </tr>
				                              <tr>
				                                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; font-size:12px; color:#576573; padding:5px 0px 15px 0px">
				                               	Color:  <span style="color:#6e9cbb"></span> '.$content_color[$key_content].'</td>
				                              </tr>
				                            </table>
                            				';
										}
				                       $message_body .= '</td>
				                      </tr>
				                    </table>
				                </td>
				              </tr>              
              
				              <tr>
				                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:24px; padding: 15px 0 0px 0px;">
				                	 The power of <span style="color:#3498db;">tagging and sharing</span> your <span style="color:#3498db;">“picks”</span>
				                </td>
				              </tr>
				              <tr>
				                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#838383; font-size:14px; line-height:20px; padding: 5px 10px 7px 40px;">
				                	 Download the App now or get in touch with us if you have any questions!
				                </td>
				              </tr>
              
              
				              <tr>
				                <td align="left" style="font-family: Helvetica, Arial, sans-serif; color:#838383; font-size:14px; line-height:20px; padding: 15px 10px 20px 20px;">
				                	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
				                      <tr>
				                        <td align="left" valign="top">
				                           <table align="left" width="202" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
				                              <tr>
				                                <td align="center"><a href="#"><img src="http://www.buyerspicks.com/images/get_support.jpg" width="202" height="63" alt="" border="0"/></a></td>
				                              </tr>
				                            </table>
                            
				                            <table align="left" width="223" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
				                              <tr>
				                                <td align="center"><a href="#"><img src="http://www.buyerspicks.com/images/download_app.jpg" width="223" height="63" alt="" border="0" /></a></td>
				                              </tr>
				                            </table>
                            
				                            <table align="left" width="223" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
				                              <tr>
				                                <td align="center"><a href="#"><img src="http://www.buyerspicks.com/images/app_upgrad.jpg" width="223" height="63" alt="" border="0" /></a></td>
				                              </tr>
				                            </table>
                            
				                        </td>
				                      </tr>
				                    </table>
				                </td>
				              </tr>
              
              
				              <tr>
				                <td style="background-color:#ededed; font-family:Helvetica, Arial, sans-serif; color:#afafaf; font-size:11px; padding: 10px 0 10px 40px;">
                	
				                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
				                      <tr>
				                        <td align="left" valign="top">
				                           <!--<table align="left" width="202" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
				                              <tr>
				                                <td>© Copyright Buyer pic(k) '.date("Y").'</td>
				                              </tr>
				                            </table>-->
                            
				                            <table align="right" width="140" border="0" cellspacing="0" cellpadding="0"  class="responsive-table" style="padding-right:35px;">
				                              <tr>
				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/gplus.jpg" width="15" height="17" alt="" border="0" /></a></td>
				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/fb.jpg" width="15" height="17" alt="" border="0" /></a></td>
				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/pin.jpg" width="15" height="17" alt="" border="0" /></a></td>
				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/twt.jpg" width="15" height="17" alt="" border="0" /></a></td>
				                              </tr>
				                            </table>
                            
				                        </td>
				                      </tr>
				                    </table>
                    
				                </td>
				              </tr>
				            </table>
				        </td>
				      </tr>
				    </table>

				</body>
				</html>
				';
			
				/*
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
				*/
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
			unset($content_name);
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
				 /*
		 		$single_content_name[] = $rowContent["content_name"];
				$single_tags = $rowContent["tags"];
				$storage_path_single[] = $rowContent["storage_path"];
				$content_color_single[] = $rowContent["content_color"];
				$content_type[] = $rowContent["type"];
				*/
		 		$content_name[] = $rowContent["content_name"];
				$tags = $rowContent["tags"];
				$storage_path[] = $rowContent["storage_path"];
				$content_color[] = $rowContent["content_color"];
				$content_type[] = $rowContent["type"];
				
				
			 }
			$sql = mysql_query("insert into ba_tbl_friend_share (item_id, sender_email, receiver_email, share_permission, sync_status, is_deleted, update_status, status, item_type) values('$item_id', '$sender_email', '$receiver_email', '$share_permission', '$sync_status', '$is_deleted', '$update_status', '$status', '$item_type')") or die(mysql_error());
			$inserted_id = mysql_insert_id();
			
			
			 /*
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
			*/
			 
 			$message_body = '
 				<html>
 				<head>
 				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 				<title> Buyers Picks - Friend Share </title>

 				<style type="text/css">
 						*{padding:0; margin:0;}
 						.ReadMsgBody {width: 100%;}
 				      	.ExternalClass {width: 100%;}
 				      	.appleBody a {color:#ffffff; text-decoration: none;}
 				      	.appleFooter a {color:#999999; text-decoration: none;}
		
 						span[class="adrt"]{
 				      			display:none !important;}
				
 						td[class="padd"]{
 								padding-left:25px;}
		

 						@media screen and (max-width: 480px) {
			
 							td[class="padd"]{
 								padding: 0 10px !important;}
		
 				      		table[class="wrapper"]{
 				              width:100% !important;}
			  
						
 							span[class="adrt"]{
 				      			display:block !important;}
			  
 				      		td[class="logo"]{
 				      			text-align: left;
 				      			padding: 10px 0 20px 20px !important;}
				
 							td[class="main-banner"]{
 				      			text-align: center !important;}
      			
 				      		td[class="mobile-hide"]{
 				      			display:none !important;}
      			
 				      		td[class="no-padding-in-mobile"]{
 				      			padding:0 !important;}
								
 				      		td[class="logo_td"] img{
 				      			margin:0 auto !important;}
				
 							img[class="logo"]{
 				            width:100% !important;
 				            height:auto;}
			
 				      		table[class="button"]{
 				      			width:85% !important;
 				      			height:auto}
				
 				      		td[class="button"]{
 				      			font-size: 20px !important;
 				      			padding: 10px !important;}
			
 				      		td[class="footer"]{
 				      			text-align:center;
 				      			font-size:12px !important;
 				      			line-height:22px !important;
 				      			-webkit-text-size-adjust: none;}
      			
 				      		table[class="responsive-table"]{
 				      			width:100% !important;
 								margin:0 !important;
 								padding:0 !important;}
			
 							table[class="responsive-table2"]{
 				      			width:90% !important;
 								margin:0 !important;
 								padding-left:0;
 								padding-right:0;}
				
 							table[class="responsive-table3"]{
 				      			width:331px !important;
 								margin:0 !important;
 								padding-left:0;
 								padding-right:0;}
				
 							table[class="responsive-table4"]{
 				      			width:100%;
 								margin:0 !important;}
				
 						    table[class="responsive-table5"]{
 				      			width:100% !important;
 								margin:0 !important;
 								text-align:center;}
				
 							table[class="responsive-table6"]{
 				      			width:100% !important;
 								margin:0 !important;
 								text-align:left !important;
 								padding-left:0!important;}
				
 				      		td[class="mobile-paragraph"]{
 				      			font-size:18px !important;
 				      			line-height:25px !important;
 				      			padding-bottom:40px !important;
 				      			padding-right:10px !important;
 				      			padding-left:10px !important;}
      			
 				      		td[class="mobile-show"]{
 				      			display:block !important;}
			
 							span[class=emailh2],a[class=emailh2]
 							{font-size:22px !important;
 							line-height:26px !important;}
			
			
 							a[class="emailmobbutton"]
 							{display:block !important;
 							font-size:14px !important;
 							font-weight:bold !important;
 							padding:4px 4px 6px 4px !important;
 							line-height:18px !important;
 							background-color:#dddddd !important;
 							border-radius:5px !important;
 							margin:10px auto !important; 
 							width:60% !important;
 							text-align:center; 
 							color:#613f02 !important; 
 							text-decoration:none;}
			
 							span[class="mobile-hide"]{
 								display:none !important;}
				
 							td[class="mobile-hide"]{
 								display:none !important;}
				
 							td[class="align1"]{
 								padding:10px 0 11px 10px !important;
 								margin:0 !important;}
			
 							img[class="emailwrap300"]
 							{width:300px !important;
 							height:auto !important;}
			
 							img[class="emailwrap331"]
 							{width:331px !important;
 							height:auto !important;}
			
 							img[class="emailwrap280"]
 							{width:280px !important;
 							height:auto !important;}
			
 							img[class="emailwrap220"]
 							{width:220px !important;
 							height:auto !important;
 							padding-top:0;}
			
 							img[class="emailheadline"]{
 								padding-top:10px !important;
 								width:300px !important;}
				
 							span[class="emailbodytext"],a[class="emailbodytext"]
 							{font-size:16px !important;
 							line-height:21px !important;}
			
 							a[class=emailmobbutton2]
 							{display:block !important;
 							font-size:14px !important;
 							font-weight:bold !important;
 							padding:6px 4px 8px 4px !important;
 							line-height:18px !important;
 							background-color:#3651a4 !important;
 							border-radius:5px !important;
 							margin:10px auto !important;
 							width:70% !important;
 							text-align:center;
 							color:#cccccc !important;
 							text-decoration:none;}
			
 							td[class=footer-text]{
 								padding-left:0 !important;}
				
			
				
 						}
		

	

 				</style>

 				</head>

 				<body style="margin: 0 auto; padding: 0;">

 					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:0; margin:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:100%; background-color:#fff;">
 				      <tr>
 				        <td class="mobile-show" align="center">
 				        	<table width="700" border="0" cellspacing="0" cellpadding="0" class="wrapper" style="background-color:#e9e9e9;">
 				              <tr>
 				                <td align="left" valign="top">
 				                	<table width="700" border="0" cellspacing="0" cellpadding="0" class="responsive-table">
 				                      <tr>
 				                        <td align="center" valign="top" style="padding: 0 0 0 0px;">
 				           	    	    	<a href="#"><img src="http://www.buyerspicks.com/images/logo.jpg" width="206" height="154" alt="" border="0" /></a>
 				                        </td>
 				                      </tr>
 				                    </table>
 				                </td>
 				              </tr>
 				              <tr>
 				                <td align="left" valign="top">
 				                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="responsive-table">
 				                      <tr>
 				                        <td style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 20px 0 0px 15px;">
 				                        	Hello '.$f_name.' '.$l_name.',

 				                        </td>
 				                      </tr>
 				                      <tr>
 				                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 15px 0 0px 15px; ">
 				                        	<span style="color:#fd0000;">'.$s_f_name.' '.$s_l_name.',</span> wants to share these files with you.
 				                        </td>
 				                      </tr>
                      
 				                    </table>
 				                </td>
 				              </tr>              
              
 				              <tr>
 				                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:24px; padding: 10px 0 10px 0px;">
 				           	    	<img src="http://www.buyerspicks.com/images/vendor_file.jpg" width="685" height="60" alt="" class="logo" />
 				                </td>
 				              </tr>    
              
 				               <tr>
 				                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; color:#415161; padding: 10px 10px 10px 10px;">
 				           	    	<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="background:#f0efef; border:1px solid #fff; -webkit-border-radius: 10px 10px 10px 10px;
 				border-radius: 10px 10px 10px 10px;">
 				                      <tr>
 				                        <td align="center" valign="top" class="padd" style="padding-left:25px;">
 											';
 											foreach($content_name as $key_content=>$content_display){
								
 								$message_body .= '
 				                        	<table align="left" width="301" border="0" cellspacing="0" cellpadding="0"  class="responsive-table" style="padding-right:25px;">
 				                              <tr>
 				                                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; font-size:12px; color:#576573; padding:15px 0px">
 				                                	File Name: <span style="color:#ce7e7e;">'.$content_display.'</span>
 				                                </td>
 				                              </tr>
 				                              <tr>
 				                                <td align="left" valign="top">';
 												if($content_type[$key_content]=="image")
 												{
 													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="'.$storage_path[$key_content].'" width="301" height="339" alt="" class="logo" /></a>';
 												}
 												else if($content_type[$key_content]=="text")
 												{
 													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="http://www.buyerspicks.com/images/note.png" width="301" height="339" alt="" class="logo" /></a>';
 												}
 												else if($content_type[$key_content]=="audio")
 												{
 													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="http://www.buyerspicks.com/images/audio.png" width="301" height="339" alt="" class="logo" /></a>';
 												}
 												else if($content_type[$key_content]=="video")
 												{
 													$message_body .= '<a href="'.$storage_path[$key_content].'" target="_blank"><img src="http://www.buyerspicks.com/images/video.png" width="301" height="339" alt="" class="logo" /></a>';
 												}
 				                               $message_body .=  '</td>
 				                              </tr>
 				                              <tr>
 				                                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; font-size:12px; color:#576573; padding:15px 0px">
 				                                	Tags:  <span style="color:#6e9cbb">'.$tags[$key_content].'</span>
 				                                </td>
 				                              </tr>
 				                              <tr>
 				                                <td align="left" valign="top" style="font-family: Helvetica, Arial, sans-serif; font-size:12px; color:#576573; padding:5px 0px 15px 0px">
 				                               	Color:  <span style="color:#6e9cbb"></span> '.$content_color[$key_content].'</td>
 				                              </tr>
 				                            </table>
                             				';
 										}
 				                       $message_body .= '</td>
 				                      </tr>
 				                    </table>
 				                </td>
 				              </tr>              
              
 				              <tr>
 				                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:24px; padding: 15px 0 0px 0px;">
 				                	 The power of <span style="color:#3498db;">tagging and sharing</span> your <span style="color:#3498db;">“picks”</span>
 				                </td>
 				              </tr>
 				              <tr>
 				                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#838383; font-size:14px; line-height:20px; padding: 5px 10px 7px 40px;">
 				                	 Download the App now or get in touch with us if you have any questions!
 				                </td>
 				              </tr>
              
              
 				              <tr>
 				                <td align="left" style="font-family: Helvetica, Arial, sans-serif; color:#838383; font-size:14px; line-height:20px; padding: 15px 10px 20px 20px;">
 				                	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 				                      <tr>
 				                        <td align="left" valign="top">
 				                           <table align="left" width="202" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
 				                              <tr>
 				                                <td align="center"><a href="#"><img src="http://www.buyerspicks.com/images/get_support.jpg" width="202" height="63" alt="" border="0"/></a></td>
 				                              </tr>
 				                            </table>
                            
 				                            <table align="left" width="223" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
 				                              <tr>
 				                                <td align="center"><a href="#"><img src="http://www.buyerspicks.com/images/download_app.jpg" width="223" height="63" alt="" border="0" /></a></td>
 				                              </tr>
 				                            </table>
                            
 				                            <table align="left" width="223" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
 				                              <tr>
 				                                <td align="center"><a href="#"><img src="http://www.buyerspicks.com/images/app_upgrad.jpg" width="223" height="63" alt="" border="0" /></a></td>
 				                              </tr>
 				                            </table>
                            
 				                        </td>
 				                      </tr>
 				                    </table>
 				                </td>
 				              </tr>
              
              
 				              <tr>
 				                <td style="background-color:#ededed; font-family:Helvetica, Arial, sans-serif; color:#afafaf; font-size:11px; padding: 10px 0 10px 40px;">
                	
 				                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
 				                      <tr>
 				                        <td align="left" valign="top">
 				                           <!--<table align="left" width="202" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
 				                              <tr>
 				                                <td>© Copyright Buyer pic(k) '.date("Y").'</td>
 				                              </tr>
 				                            </table>-->
                            
 				                            <table align="right" width="140" border="0" cellspacing="0" cellpadding="0"  class="responsive-table" style="padding-right:35px;">
 				                              <tr>
 				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/gplus.jpg" width="15" height="17" alt="" border="0" /></a></td>
 				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/fb.jpg" width="15" height="17" alt="" border="0" /></a></td>
 				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/pin.jpg" width="15" height="17" alt="" border="0" /></a></td>
 				                                <td><a href="#"><img src="http://www.buyerspicks.com/images/twt.jpg" width="15" height="17" alt="" border="0" /></a></td>
 				                              </tr>
 				                            </table>
                            
 				                        </td>
 				                      </tr>
 				                    </table>
                    
 				                </td>
 				              </tr>
 				            </table>
 				        </td>
 				      </tr>
 				    </table>

 				</body>
 				</html>
 				';
			 
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