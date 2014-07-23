<?php
include_once('database.php');
if(isset($_REQUEST['email']) && $_REQUEST['email']!="")
{
	$arr_pass[] = array("response"=>"pass");
	$arr_fail[] = array("response"=>"fail");
	$arr_nouser[] = array("response"=>"no_user");
	$arr_nopost[] = array("response"=>"nopost");
	
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	//checking if email is correct
	$sqlEmail = mysql_query("select * from ba_tbl_user where email = '$email'");
	$rowEmail = mysql_fetch_assoc($sqlEmail);
	$numEmail = mysql_num_rows($sqlEmail);
	
	if($numEmail>0)
	{
		//checking if password is correct
		$sqlPassword = mysql_query("select * from ba_tbl_user where email = '$email' and password = '$password'");
		$rowPassword = mysql_fetch_assoc($sqlPassword);
		$numPassword = mysql_num_rows($sqlPassword);
		
		if($numPassword > 0)
		{
			$data["status"] = $arr_pass;
			$data["message"] = array("message"=>"Successful Login..");
			$final_data = json_encode($data);
			print_r($final_data);
		}
		else
		{
			$data["status"] = $arr_fail;
			$data["message"] = array("message"=>"Incorrect Password!!");
			$final_data = json_encode($data);
			print_r($final_data);
		}
		
		
	}
	else
	{
		$data["status"] = $arr_fail;
		$data["message"] = array("message"=>"Incorrect Email!!");
		$final_data = json_encode($data);
		print_r($final_data);
	}
	
	/*
	//Checking if email and password is correct
	$sqlSelect = mysql_query("select * from ba_tbl_user where email = '$email' and password = '$password'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$num_row = mysql_num_rows($sqlSelect);
	
	
	
	if($num_row>0)
	{
		
	}
	else
	{
		$data["error"] = $arr_nouser;
		$final_data = json_encode($data);
		print_r($final_data);
	}
	*/
	
}
else
{
	$data["status"] = $arr_nopost;
	$data["message"] = array("message"=>"No Data Received!!");
	$final_data = json_encode($data);
	print_r($final_data);
}
?>