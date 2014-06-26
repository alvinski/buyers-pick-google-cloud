<?php
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;

// Get the public URL. The permission is controlled by the object's ACL.
/*
$gs_file = $_FILES["uploaded_files"]['tmp_name'];
$gs_name = $_FILES["uploaded_files"]['name'];
$gs_size = $_FILES["uploaded_files"]['size'];
//var_dump($_FILES);
/*
$fp = fopen("gs://photouploads/alvin.jpg", "w");
fwrite($fp, $gs_file);
fclose($fp);
*/
/*
$options = [ "gs" => [ "Content-Type" => "image/png" ]];
$ctx = stream_context_create($options);
file_put_contents("gs://photouploads/".$gs_name, $gs_file, 0, $ctx);
*/
$path = $_POST['path'];
$gs_file = $_FILES["uploaded_files"]["tmp_name"];
$gs_name = $_FILES["uploaded_files"]['name'];
$gs_size = $_FILES["uploaded_files"]['size'];

/*
$options = [ "gs" => [ "Content-Type" => "image/png", "acl" => "public-read-write" ]];
$ctx = stream_context_create($options);
file_put_contents("gs://photouploads/".$gs_name, $gs_file, 0, $ctx);
*/
//echo "NAME : " . $gs_name."<br>";
//echo "SIZE : " . $gs_size."<br>";


move_uploaded_file($gs_file, "gs://buyerspick/".$path."/".$gs_name);

$public_url = CloudStorageTools::getPublicUrl("gs://buyerspick/".$path."/".$gs_name, true);
//echo "UPLOAD FILE PHP : ";

echo '[{"response":"'.$public_url.'"}]';

?>
