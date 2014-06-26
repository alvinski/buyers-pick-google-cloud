<?php
include('database.php');

$sqlGet = mysql_query("select * from ba_tbl_privacy_policy");
$rowGet = mysql_fetch_assoc($sqlGet);
extract($rowGet);
$privacy_arr[] = array("content"=>$content);
$data["privacy"] = $privacy_arr;
$json = json_encode($data);
print_r($json);	
?>
