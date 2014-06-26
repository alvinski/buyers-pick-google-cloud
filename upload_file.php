<?php
$gs_file = $_FILES["uploaded_files"]["tmp_name"];
$gs_name = $_FILES["uploaded_files"]['name'];
$gs_size = $_FILES["uploaded_files"]['size'];
$gs_error = $_FILES["uploaded_files"]['error'];

$name = $_REQUEST['testing'];

if(!empty($name) && $name != "" && isset($name))
{
if(move_uploaded_file($gs_file, "vendor/".$gs_name))
{
	$arr_pass[] = array("response"=>"Uploaded");
	$data["error"] = $arr_pass;
	$json = json_encode($data);
	print_r($json);
}
else
{
	$arr_pass[] = array("response"=>"No Uploaded");
	$data["error"] = $arr_pass;
	$json = json_encode($data);
	print_r($json);
}
}
else
{
	$arr_pass[] = array("response"=>"post empty");
	$data["error"] = $arr_pass;
	$json = json_encode($data);
	print_r($json);
}
?>