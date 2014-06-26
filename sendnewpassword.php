<?php
include('database.php');
if(isset($_POST['email']) && $_POST['email']!="")
{
	
	$email = $_POST['email'];
	
		/***** Selecting current password from user table to update old_password column in next update statement ****/
		$sqlSelect  = mysql_query("select email, password, last_modified, password_mod from ba_tbl_user where email = '$email'") or die(mysql_error());
		$rowSelect = mysql_fetch_assoc($sqlSelect);
		//END
		$numRows = mysql_num_rows($sqlSelect);
		if($numRows>0)
		{
			$email = $rowSelect['email'];
			$password = $rowSelect['password'];
			$last_modified = $rowSelect['last_modified'];
			$password_mod = $rowSelect['password_mod'];
			$arr_user_details[] = array("email"=>$email, "password"=>$password, "last_modified"=>$last_modified, "password_mod"=>$password_mod);
			if($arr_user_details)
			{
				$userdetails = json_encode($arr_user_details);
				print_r($userdetails);
			}
			else
			{
				$arr_user_details = array();
				$userdetails = json_encode($arr_user_details);
				print_r($userdetails);
				//echo '[{"response":"empty array"}]';
			}
		}
		else
		{
			echo '[{"response":"no data found"}]';
			
		}
		//END
}
else
{
	echo '[{"response":"no email provided"}]';
}
?>