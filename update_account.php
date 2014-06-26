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

if(isset($_REQUEST['user_id']) && $_REQUEST['user_id']!="")
{
	$user_id = $_REQUEST['user_id'];
	$f_name = $_POST['f_name'];
	$l_name = $_POST['l_name'];
	$gender = $_POST['gender'];
	$contact_no = $_POST['contact_no'];
	$dob = $_POST['dob'];
	
	$gs_file = $_FILES["uploaded_files"]["tmp_name"];
	$gs_name = $_FILES["uploaded_files"]['name'];
	$gs_size = $_FILES["uploaded_files"]['size'];
	$gs_error = $_FILES["uploaded_files"]['error'];
	
	if(!is_dir("profile/".$user_id))
	{
		mkdir("profile/".$user_id, 0777);
	}
	if($gs_size>0)
	{
		move_uploaded_file($gs_file, "profile/".$user_id."/".$gs_name);
		$profile_pic_url = "http://apps.medialabs24x7.com/buyerspick/profile/".$user_id."/".$gs_name;
		$sqlUpdate = mysql_query("update ba_tbl_user set f_name = '$f_name', l_name = '$l_name', gender = '$gender', contact_no = '$contact_no', dob = '$dob', profile_image = '$profile_pic_url' where id = '$user_id'") or die(mysql_error());
		if(mysql_affected_rows()==1)
		{
			echo '[{"response":"updated", "user_id":"'.$user_id.'", "profile_pic_url" : "'.$profile_pic_url.'"}]';
		}
		else
		{
			echo '[{"response":"no update", "user_id":"'.$user_id.'"}]';
		}
	}
	else
	{
		$sqlUpdate = mysql_query("update ba_tbl_user set f_name = '$f_name', l_name = '$l_name', gender = '$gender', contact_no = '$contact_no', dob = '$dob' where id = '$user_id'") or die(mysql_error());
		if(mysql_affected_rows()==1)
		{
			echo '[{"response":"updated", "user_id":"'.$user_id.'"}]';
		}
		else
		{
			echo '[{"response":"no update", "user_id":"'.$user_id.'"}]';
		}
	}
	
}
else
{
	echo '[{"response":"no post"}]';
}
?>