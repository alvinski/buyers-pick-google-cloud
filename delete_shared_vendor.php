<?php
/** Deleting shared vendor for the specific user and not displaying this vendor in shared section **/

include_once('database.php');
$json = json_decode($_REQUEST['item_id'], true);
//print_r($json);
foreach($json as $key=>$values)
{
	$email = $values["email"];
	foreach($values["id"] as $key=>$vals)
	{
	$arr_pass = array("response"=>"pass");
	$arr_fail = array("response"=>"fail");
	$id = $vals["id"];
	//$friend_share_del_flag = $values["friend_share_del_flag"];
	
	//echo "ID : " . $id . "<br>";
	//echo "email : " . $email . "<br>";
	/***** Checking if delete from secondary user side ******/
	//if($friend_share_del_flag==1)
	//{
		/******* Updating is_deleted column from tbl_friend_share table *******/
		$sqlDelFriendShare = mysql_query("update ba_tbl_friend_share set is_deleted = '1' where item_id = '$id' and receiver_email = '$email'");
		/***************************** END ***********************************/
		//}
		if(mysql_affected_rows()==1)
		{
			$sqlSelect = mysql_query("select id, is_deleted from ba_tbl_friend_share where item_id = '$id' and receiver_email = '$email'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			$_id = $rowSelect["id"];
			$is_deleted = $rowSelect["is_deleted"];
			$response = $arr_pass;
			$arr_friendsharedel[] = array("id"=>$_id, "is_deleted"=>$is_deleted);
			
		}
		else
		{
			$response = $arr_fail;
			$arr_friendsharedel = array("response"=>"fail");
			
		}
	}
		
	
}
if($arr_friendsharedel==null)
{
		$arr_friendsharedel = array();
}	
	
$data["error"] = $response;
$data['friend_share_delete'] = $arr_friendsharedel;
$json_final = json_encode($data);
print_r($json_final);

?>