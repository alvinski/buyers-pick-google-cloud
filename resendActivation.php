<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	$email = $_REQUEST['email'];
	$verification_key = $_REQUEST['verification_key'];
	$sqlActive = mysql_query("select * from ba_tbl_user where email = '$email'");
	$rowActive = mysql_fetch_assoc($sqlActive);
	$active_status = $rowActive['active'];
	$f_name = $rowUser['f_name'];
	$l_name = $rowUser['l_name'];
	if($active_status==0)
	{
	
	$sqlInsert = mysql_query("update ba_tbl_user set verification_key = '$verification_key' where email = '$email'") or die(mysql_error());
	$updated_id = mysql_affected_rows();
	$sqlUser = mysql_query("select * from ba_tbl_user where email = '$email'");
	$rowUser = mysql_fetch_assoc($sqlUser);
	$verification_key = $rowUser['verification_key'];
	if($updated_id>0)
	{
		//$message_body = "Buyers Pick Email Verification. Click on the below Link.... \n\r";
		//$message_body .= "http://skibuyerspick.appspot.com/verification/?q=$verification_key \n\r";
		
		$message_body = '
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title> Buyers Picks Registration </title>

			<style type="text/css">
					*{padding:0; margin:0;}
					.ReadMsgBody {width: 100%;}
			      	.ExternalClass {width: 100%;}
			      	.appleBody a {color:#ffffff; text-decoration: none;}
			      	.appleFooter a {color:#999999; text-decoration: none;}
		
					span[class="adrt"]{
			      			display:none !important;}
		

					@media screen and (max-width: 480px) {
		
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
			                        <td style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 20px 0 0px 40px;">
			                        	Hello '.$f_name.' '.$l_name.',

			                        </td>
			                      </tr>
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 15px 0 0px 40px; ">
			                        	Thank you for registering on Buyers Picks Mobile Application.
			                        </td>
			                      </tr>
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 15px 0 0px 40px;">
			                        	Please click on this link to confirm and complete your registration:
			                        </td>
			                      </tr>
                      
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#424242; font-size:15px; padding: 15px 0 5px 40px;">
			                        	<a href="http://skibuyerspick.appspot.com/verification/?q='.$verification_key.'" style="color:red; text-decoration:none;"><img src="http://www.buyerspicks.com/images/activebtn.png" border="0" /></a>
			                        </td>
			                      </tr>
                      
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 15px 0 5px 40px; line-height:20px;">
			                        	If you are still facing a problem, please get in touch with us at <a href="#" style="color:#415161;">support@buyerpicks.com</a>

			                        </td>
			                      </tr>
                      
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 15px 0 5px 40px; line-height:20px;">
			                        	If you have not registered with us, we regret the inconvenience and request you to delete this mail.

			                        </td>
			                      </tr>
                      
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 25px 0 0px 40px;">
			                        	Thanks,
			                        </td>
			                      </tr>
			                      <tr>
			                        <td style="font-family:Helvetica, Arial, sans-serif; color:#415161; font-size:15px; padding: 5px 0 20px 40px;">
			                        	Buyers Picks Team
			                        </td>
			                      </tr>
			                    </table>
			                </td>
			              </tr>
              
			              <tr>
			                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#415161; font-size:24px; padding: 7px 0 7px 0px;">
			                	 Let us help <span style="color:#3498db;">you better</span>
			                </td>
			              </tr>
			              <tr>
			                <td align="center" style="font-family: Helvetica, Arial, sans-serif; color:#838383; font-size:14px; line-height:20px; padding: 15px 10px 7px 40px;">
			                	 Click on the tabs below to get any questions on the app,solve any queires or get in touch with us. 
			We are there for you every minute.
			                </td>
			              </tr>
              
              
			              <tr>
			                <td align="left" style="font-family: Helvetica, Arial, sans-serif; color:#838383; font-size:14px; line-height:20px; padding: 15px 10px 20px 20px;">
			                	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                      <tr>
			                        <td align="left" valign="top">
			                           <table align="left" width="202" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
			                              <tr>
			                                <td align="center"><a href="http://www.buyerspicks.com/support.html"><img src="http://www.buyerspicks.com/images/get_support.jpg" width="202" height="63" alt="" border="0"/></a></td>
			                              </tr>
			                            </table>
                            
			                            <table align="left" width="223" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
			                              <tr>
			                                <td align="center"><a href="http://www.buyerspicks.com/download.html"><img src="http://www.buyerspicks.com/images/download_app.jpg" width="223" height="63" alt="" border="0" /></a></td>
			                              </tr>
			                            </table>
                            
			                            <table align="left" width="223" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
			                              <tr>
			                                <td align="center"><a href="http://www.buyerspicks.com/upgrade.html"><img src="http://www.buyerspicks.com/images/app_upgrad.jpg" width="223" height="63" alt="" border="0" /></a></td>
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
			                           <table align="left" width="202" border="0" cellspacing="0" cellpadding="0"  class="responsive-table">
			                              <tr>
			                                <td>© Copyright Buyer pic(k) '.date("Y").'</td>
			                              </tr>
			                            </table>
                            
			                            <table align="right" width="140" border="0" cellspacing="0" cellpadding="0"  class="responsive-table" style="padding-right:35px;">
			                              <tr>
  		                                <td><a href="https://plus.google.com/u/0/b/115302655080223880566/115302655080223880566/"><img src="http://www.buyerspicks.com/images/gplus.jpg" width="15" height="17" alt="" border="0" /></a></td>
  		                                <td><a href="https://www.facebook.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/fb.jpg" width="15" height="17" alt="" border="0" /></a></td>
  		                                <td><a href="http://www.pinterest.com/Buyerspicks/"><img src="http://www.buyerspicks.com/images/pin.jpg" width="15" height="17" alt="" border="0" /></a></td>
  		                                <td><a href="https://twitter.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/twt.jpg" width="15" height="17" alt="" border="0" /></a></td>
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
		$message_body .= "OR \n\r";
		$message_body .= "Use the Below Authorization Key. \n\r";
		$message_body .= "$verification_key \n\r";
		*/
		$mail_options = [
		"sender" => "support@skiusainc.com",
		"to" => $email,
		"subject" => "Welcome to Buyers Pick",
		"htmlBody" => $message_body
		];

		try {
		$message = new Message($mail_options);
			$message->send();
			echo '[{"response":"Verification Mail Sent Successfully"}]';
		} catch (InvalidArgumentException $e) {
			//echo $e; 
			echo '[{"response":"Verification Mail Not Sent. Try Again!!"}]';
		}
		
	}
	else
	{
		echo '[{"response":"User Not Registered!!"}]';
	}
	}
	else
	{
		echo '[{"response":"User Already Verified!!"}]';
	}
}
else
{
	echo '[{"response":"Something went wrong!!"}]';
}

?>