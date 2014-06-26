<?php
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;

$options = [ 'gs_bucket_name' => 'buyerspick' ];
$upload_url = CloudStorageTools::createUploadUrl('/savecontent', $options);
echo '[{"response":"'.$upload_url.'"}]';
?>

<?php /*?>
<form action="<?php echo $upload_url?>" enctype="multipart/form-data" method="post">
Files to upload: <br>
<input type="file" name="uploaded_files">
<input type="submit" value="Send">
</form>
<?php */?>
