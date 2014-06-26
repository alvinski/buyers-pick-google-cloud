<?php
if (isset($_POST["regId"]) && isset($_POST["message"])) {
    $regId = $_POST["regId"];
    $message = $_POST["message"];
    //echo $regId;
	//echo $message; 
    include_once 'GCM.php';
     
    $gcm = new GCM();
 
    $registatoin_ids = array($regId);
    $message = array("price" => $message);
 
    $result = $gcm->send_notification($registatoin_ids, $message);
 
    echo $result;
}
?>