<?php

// Put your device token here (without spaces):
//$deviceToken = '4c4f56f7832cf1cd7a77dd986b1758cb05ec6a940c81be63abd10914242d2301';
//$deviceToken = 'f2a80b1cbf146f38cd7fd6380d4cda23fa64098f6e9dbab4939d9b57cf195bf6';
//$deviceToken = 'fe0667bad58d812cc36b74185e0efaa78f690a11d11f660eef0f8fa495d4f7ef';
//$deviceToken = 'c5833d534ce963580255a8643452c66ec378b5a30e8de208be1a86a182ac7a01';


//$deviceToken = trim($_REQUEST['device_token']);

//$deviceToken = str_replace('<','',$deviceToken);
//$deviceToken = str_replace('>','',$deviceToken);
//$deviceToken = str_replace(' ','',$deviceToken);

// Put your private key's passphrase here:
$passphrase = 'javed77';

// Put your alert message here:
//$message = 'Dabang 2 Push Notifications';
$message = $_REQUEST['message'];


$devices = array();

////////////////////////////////////////////////////////////////////////////////

$con = mysql_connect("localhost", "ski-dabang", "javed77");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//Database Selection Start Here
mysql_select_db("dabang", $con);	

$email = base64_decode($_REQUEST['email']);

////////////////////////////////////////////////////////////////////////////////



	//$sql = "select * from tbl_user_push where device_token='4c4f56f7832cf1cd7a77dd986b1758cb05ec6a940c81be63abd10914242d2301'";
	$sql = "select * from tbl_user_push";
	$result = mysql_query($sql);

	$num_rows = mysql_num_rows($result);
	
    if ($num_rows>=1)  {
       while ($row = mysql_fetch_array($result)) {
         #printf("ID: %s  Name: %s", $row[1], $row[2]);  
         array_push($devices,$row[2]);
	   }
     }	
	 
	 #print_r($devices);exit;
   
    	$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);

		#echo 'Connected to APNS' . PHP_EOL;
		echo '[{"response":"Connected to APNS"}]';	

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default'
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

for ($i = 0; $i <= count($devices); $i++) {
        
		//echo $devices[$i];
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $devices[$i]) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result)
			//echo 'Message not delivered' . PHP_EOL;
		    echo '[{"response":"FAIL"}]';	
		else
			//echo 'Message successfully delivered 4' . PHP_EOL;
		    echo '[{"response":"PASS"}]';	

}

		// Close the connection to the server
		fclose($fp);




#$fp = fopen('data.txt', 'w');
#fwrite($fp, $deviceToken);