<?php
session_start();
include("../adminloginchk.php");
include("../database.php");

// Put your device token here (without spaces):
//$deviceToken = '4c4f56f7832cf1cd7a77dd986b1758cb05ec6a940c81be63abd10914242d2301';
//$deviceToken = 'f2a80b1cbf146f38cd7fd6380d4cda23fa64098f6e9dbab4939d9b57cf195bf6';
//$deviceToken = 'fe0667bad58d812cc36b74185e0efaa78f690a11d11f660eef0f8fa495d4f7ef';
//$deviceToken = 'c5833d534ce963580255a8643452c66ec378b5a30e8de208be1a86a182ac7a01';

//print "<PRE>";
//print_r($_POST);
if(isset($_POST['push_no']) && isset($_POST['message']) ){

	$deviceToken = trim($_POST['push_no']);
	
	$deviceToken = str_replace('<','',$deviceToken);
	$deviceToken = str_replace('>','',$deviceToken);
	$deviceToken = str_replace(' ','',$deviceToken);
	
	// Put your private key's passphrase here:
	$passphrase = 'akshay';
	
	// Put your alert message here:
	//$message = 'YJHD - Push Notifications';
	$message = trim($_POST['message']);
	
	$email = base64_decode($_POST['email']);

	if ($deviceToken) {
		$sql = "select * from tbl_user_push where device_token='$deviceToken'";
		//print $sql . "<br>";
		$result = mysql_query($sql);
	
		$num_rows = mysql_num_rows($result);
		//print "NUM ROWS : " . $num_rows . "<br>";
		
		//Added by Alvin  18/08/2013		Adding Insert Statement to save push notifications in tbl_notifications for ios.
		if($message!="" && !empty($message))
		{
		$sqlSave = mysql_query("insert into tbl_notifications(device_no, noti_msg) values('$deviceToken', '$message')");
		}
		//END
		
		if ($num_rows<1) { #echo "$num_rows Rows\n";exit;
	
			$insert_pushderails="insert into tbl_user_push(email,device_token,message) values ('$email','$deviceToken','$message')";
			$res=mysql_query($insert_pushderails) or die(mysql_error());
			
			//$ctx = stream_context_create();
			//stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			//stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
			
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
			// Open a connection to the APNS server
			$fp = stream_socket_client(
				'ssl://gateway.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
			if (!$fp){
				$err_msg	= '1';
				//exit("Failed to connect 2 : $err $errstr" . PHP_EOL);
			}
	
			//echo 'Connected to APNS' . PHP_EOL;
			//echo '[{"response":"Connected to APNS 1"}]';
			$err_msg	= '2';
	
			// Create the payload body
			$body['aps'] = array(
				'badge' => 2,
				'alert' => $message,
				'sound' => 'default'
				);
	
			// Encode the payload as JSON
			$payload = json_encode($body);
	
			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
			// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));
	
			if (!$result)
				$err_msg	= '3';
				//echo 'Message not delivered' . PHP_EOL;
				//echo '[{"response":"FAIL"}]';
			else
				$err_msg	= '4';
				//echo 'Message successfully delivered 4' . PHP_EOL;
				//echo '[{"response":"PASS"}]';
	
			// Close the connection to the server
			fclose($fp);
		}
		else
		{
			//$ctx = stream_context_create();
			//stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			//stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
			
			$ctx = stream_context_create();
			stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
			stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
			// Open a connection to the APNS server
			$fp = stream_socket_client(
				'ssl://gateway.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
			if (!$fp){
				$err_msg	= '1';
				//exit("Failed to connect 2 : $err $errstr" . PHP_EOL);
			}
	
			#echo 'Connected to APNS' . PHP_EOL;
			//echo '[{"response":"Connected to APNS 2"}]';	
			$err_msg	= '2';
	
			// Create the payload body
			$body['aps'] = array(
				'badge' => 1,				 
				'alert' => $message,
				'sound' => 'default'
				);
	
			// Encode the payload as JSON
			$payload = json_encode($body);
	
			// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
			// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));
	
			if (!$result)
				$err_msg	= '3';
				//echo 'Message not delivered' . PHP_EOL;
				//echo '[{"response":"FAIL"}]';
			else
				$err_msg	= '4';
				//echo 'Message successfully delivered 4' . PHP_EOL;
				//echo '[{"response":"PASS"}]';
	
			// Close the connection to the server
			fclose($fp);
		}
	}
	else
	{
		$err_msg	= '';
		//echo '[{"response":"FAIL"}]';	
	}
#$fp = fopen('data.txt', 'w');
#fwrite($fp, $deviceToken);

} // if(isset($_REQUEST['push_no']) && isset($_REQUEST['txt_message']) ) Ends Here
?>


<?php

if($err_msg == 1)
{
	$data = "<font size='3px' color='red'>Message not delivered</font>";
}

if($err_msg == 2)
{
	$data = "<font size='3px' color='#003300'>Message successfully delivered</font>";
}

if($err_msg == 3)
{
	$data = "<font size='3px' color='red'>Message not delivered</font>";
}

if($err_msg == 4)
{
	$data = "<font size='3px' color='#003300'>Message successfully delivered</font>";
}

$sql_device	= "Select * from tbl_user_push ORDER BY id";
$res_device	= mysql_query($sql_device);
//$row_device	= mysql_fetch_array($res_device);
//$user_name	= $row_usrnm['user_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
});

function setTextVal(id){
	document.getElementById('regId').value=id;
}
</script>
<?php include("../common_includes.php"); ?>
<body> 
<!-- Start: page-top-outer -->
<?php include("../top.php"); ?>
<!-- End: page-top-outer -->
<div class="clear">&nbsp;</div>
<!--  start nav-outer-repeat................................................................................................. START -->
<?php include("../menu.php"); ?>
<!--  start nav-outer-repeat................................................... END -->
<div class="clear"></div>

<div id="content-outer">
	<!-- start content -->
	<div id="content">
		<div id="page-heading"><h1>Send Push To Single User Iphone</h1></div>
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
			<tr>
				<th rowspan="3" class="sized"><img src="http://apps.medialabs24x7.com/besharam/backend/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
				<th class="topleft"></th>
				<td id="tbl-border-top">&nbsp;</td>
				<th class="topright"></th>
				<th rowspan="3" class="sized"><img src="http://apps.medialabs24x7.com/besharam/backend/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
			</tr>
			<tr>
				<td id="tbl-border-left"></td>
				<td>
				<!--  start content-table-inner -->		
					<div id="content-table-inner">
						<form id="frm_pushnotifications" name="" method="post" action="http://apps.medialabs24x7.com/besharam/backend/push_to_iphone/iphone_push_to_many.php">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center"><?php echo $data; ?></td>
								</tr>
								<tr>
									<td></td>
								</tr>
								<tr>
									<td></td>
								</tr>
								<tr valign="top">
									<td>
										<!--  start step-holder -->
										<div id="step-holder">
											<div class="clear"></div>
										</div>
										<!--  end step-holder -->
										<!-- start id-form -->
										<table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%">
                                    	<tr>
												<th valign="top"></th>
												<td></td>
												<td></td>
											</tr>  
											<tr>
												<th align="right">Select User</th>
												<td>
                                                	<select style="width:150px;" name="push_no" id="push_no" onChange="setTextVal(this.value)">
                                                        <option value="" selected="selected">---- Select User ---</option>
                                                        <?php
														while ($row = mysql_fetch_array($res_device)) {
															$deviceno	= $row["device_token"];
															$sql_usrnm	= "Select email, user_name from tbl_user_detail WHERE device_no='$deviceno'";
															//print $sql_usrnm . "<br>";
															$res_usrnm	= mysql_query($sql_usrnm);
															$row_usrnm	= mysql_fetch_array($res_usrnm);
															$user_name	= $row_usrnm['user_name'];
															
															if($user_name == '' || $user_name == NULL)
																$user_name = $row["device_token"];
														?>
                                                        <option value="<?php echo $row["device_token"]; ?>">
														<?php
														if($row_usrnm['email']!="")
														{
														 echo $row_usrnm['email'];
														}
														else
														{
															echo $user_name;	
														}
														 ?>
                                                         </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
												<td></td>
											</tr>
                                            <!--<tr>
												<th valign="top">Yeh Jawani Hai Dewani Notification News Title</th>
												<td>
                                                	<input type="text" class="inp-form" name="title" id="title" value=""/>
                                                </td>
												<td></td>
											</tr>-->
                                            <tr>
												<th valign="top" align="right">Yeh Jawani Hai Dewani Notification Text To For User</th>
												<td>
                                                	<textarea rows="5" name="message" cols="60" class="txt_message" placeholder="Type message here"></textarea>
													<input type="hidden" name="regId" id="regId" class="txt_gcmid" value="" readonly="readonly" />
                                                </td>
												<td></td>
											</tr>
											<tr>
												<th>&nbsp;</th>
												<td valign="top">
													<input type="submit" class="form-submit" value="Send" onClick=""/>	
												</td>
												<td></td>
											</tr>
										</table>
										<!-- end id-form  -->
									</td>
									<td></td>
								</tr>
								<tr>
									<td><img src="http://apps.medialabs24x7.com/besharam/backend/images/shared/blank.gif" width="695" height="1" alt="" /></td>
									<td></td>
								</tr>
							</table>
						</form>
						<div class="clear"></div>
					</div>
					<!--  end content-table-inner  -->
				</td>
				<td id="tbl-border-right"></td>
			</tr>
			<tr>
				<th class="sized bottomleft"></th>
				<td id="tbl-border-bottom">&nbsp;</td>
				<th class="sized bottomright"></th>
			</tr>
		</table>
		<div class="clear">&nbsp;</div>
	</div>
	<!--  end content -->
	<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
<!-- start footer -->         
<div id="footer">
	<!--  start footer-left -->
	<div id="footer-left">
	Quantum Technology &copy; Copyright SKIUSINC <a href="http://www.skiusainc.com">www.skiusainc.com</a>. All rights reserved.</div>
	<!--  end footer-left -->
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
 </body>
</html>
</body>
</html>
