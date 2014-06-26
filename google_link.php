<?php
require_once "Google_Utils.php";
require_once "Google_P12Signer.php";
//require_once "Google_Client.php";
$bucketName = 'buyerspick';
$id = 'VENDOR_1393825130494/Photo_1393825142135.png';
$serviceAccountName = '65601957423-6t2fkgbg75hgd3shakmon2nnjqp2lnu8@developer.gserviceaccount.com';

$privateKey = file_get_contents("f80df47c17ed0de02b7ee07d623cedfbfecb9504-privatekey.p12");
$signer = new Google_P12Signer($privateKey, "notasecret");
$ttl = time() + 3600;
$stringToSign = "GET\n\r" . "\n" . "\n" . $ttl . "\n". '/' . $bucketName . '/' . $id;
$signature = $signer->sign(utf8_encode($stringToSign));
$finalSignature = Google_Utils::urlSafeB64Encode($signature);
$host = "https://".$bucketName.".storage.googleapis.com";
echo  $host. "/".$id."?GoogleAccessId=" . $serviceAccountName . "&Expires=" . $ttl . "&Signature=" . $finalSignature;
echo "\r\n";
echo "<br><br>";
echo "STRING TO SIGN : ". $stringToSign;
echo "<br><br>";
echo "SIGNATURE : ". $signature;
echo "<br><br>";
echo "FINAL SIGNATURE : ". $finalSignature;


//https://buyerspick.storage.googleapis.com/VENDOR_1393825130494/Photo_1393825142135.png
?>