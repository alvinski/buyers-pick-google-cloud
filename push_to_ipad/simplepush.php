<?php

// Put your device token here (without spaces):
$deviceToken[0] = 'fe0667bad58d812cc36b74185e0efaa78f690a11d11f660eef0f8fa495d4f7ef';

$deviceToken[1] = 'b3735f8d8303c96370270ffdf082910dfd43de2b02d563d95105b6af8f998879';

$deviceToken[2] = 'fb0ba5ea3136bdaaa5892c1567123de265e1e1e7136f3cc91ad5067a3dcff74d';
//$deviceToken[3] = 'fb0ba5ea3136bdaaa5892c1567123de265e1e1e7136f3cc91ad5067a3dcff74d';


// Put your private key's passphrase here:
$passphrase = 'akshay';

// Put your alert message here:
$message = 'YJHD Jagadish Backend Notification Message 3';

////////////////////////////////////////////////////////////////////////////////
for($i=0;$i<3;$i++){
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
	'badge' => 2,
	'alert' => $message,
	'sound' => 'default'
	);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken[$i]) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered 4' . PHP_EOL;

// Close the connection to the server
fclose($fp);
}
