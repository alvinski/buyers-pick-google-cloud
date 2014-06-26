<?php
error_reporting(-1);
$host = "173.194.111.85";
$username = "root";
$password = "javed@77";
$dbname = "skibuyerspick:buyerspick";

$conn = mysql_connect($host, $username, $password);
$dbselect = mysql_select_db("buyerspick", $conn) or die(mysql_error());
if(!$dbselect)
{
	die("Could not select Database : ". mysql_error());
}
else
{
	//echo "DB SELECTED..";
}
if(!$conn)
{
	die("Could not connect to MySql Google Server : ". mysql_error());
}
else
{
	//die("Could not connect to MySql Google Server : ". mysql_error());
}
// Put your device token here (without spaces):
//$deviceToken = '4c4f56f7832cf1cd7a77dd986b1758cb05ec6a940c81be63abd10914242d2301';
//$deviceToken = 'f2a80b1cbf146f38cd7fd6380d4cda23fa64098f6e9dbab4939d9b57cf195bf6';
//$deviceToken = 'fe0667bad58d812cc36b74185e0efaa78f690a11d11f660eef0f8fa495d4f7ef';
//$deviceToken = 'c5833d534ce963580255a8643452c66ec378b5a30e8de208be1a86a182ac7a01';
//$deviceToken = '4c4f56f7832cf1cd7a77dd986b1758cb05ec6a940c81be63abd10914242d2301';



// Put your private key's passphrase here:
$passphrase = 'akshay';

// Put your alert message here:
//$message = 'Hiiiiiiiiiiiii!!!';
$message = $_REQUEST['message'];
//echo $message;exit;
////////////////////////////////////////////////////////////////////////////////
/*
$con = mysql_connect("localhost", "ski-besharam", "javed77");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//Database Selection Start Here
mysql_select_db("ski_besharam", $con);	
*/


$email = base64_decode($_REQUEST['email']);


//$devices = array();
////////////////////////////////////////////////////////////////////////////////

$sql = "select * from ba_tbl_ios_push where device_token != '(null)'";
$result = mysql_query($sql) or die(mysql_error());

$num_rows = mysql_num_rows($result);
//$devices = array();

//$devices = array();
if ($num_rows>0)  {
   while ($row = mysql_fetch_array($result)) {
    #printf("ID: %s  Name: %s", $row[1], $row[2]);  
   //array_push($devices,$row["device_token"]);
  
   $devices[] = $row['device_token'];
 
}


//print_r($devices);
//exit();

//update message
//$updt = "UPDATE tbl_user_push SET message = mysql_real_escape_string($message)";
//$resultupdt = mysql_query($updt);

//$message = "Thank you for downloading Buyers Picks";
//$one = 
//$devices = array("1febc219171a992e6551a30a224a3774ef9ebb76cf977d1594b074ceddf03ae6","6991a43778c92567e512be2382c1fc550a3e56d4008f9be0ca782690a6888858");
////////////////////////////////////////////////////////////////////////////////

//print_r($devices);


$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

//for($i=1; $i<=sizeof($devices); $i++)
foreach ($devices as $v)
{
	//echo $v;
// Build the binary notification
	
	  $msg = chr(0) . pack('n', 32) . pack('H*', $v) . pack('n', strlen($payload)) . $payload;
	  
	  // Send it to the server
	  $result_push = fwrite($fp, $msg, strlen($msg));
	  
	  
	  /*
	  $sqlSave = mysql_query("insert into tbl_notifications(device_no, noti_msg) values('$v', '$message')");
	  */
	  if (!$result_push)
	  {
		//echo 'Message not delivered' . PHP_EOL;
		echo "Delivered : ". $v."<br>";
	  }
	  else
	  {
		//echo 'Message successfully delivered 4' . PHP_EOL;
		echo "Failed : ". $v."<br>";
	  }
	//echo $v."<br>";
	  
}

// Close the connection to the server
fclose($fp);
}