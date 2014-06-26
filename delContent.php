<?php
include('database.php');
$json = json_decode($_REQUEST['content_id'], true);
//print_r($json);
foreach($json as $key=>$values)
{

	$id = $values['id'];
	
	
		$sqlDel = mysql_query("update ba_tbl_content set is_deleted = '1' where id = '$id'") or die(mysql_error());
		if(mysql_affected_rows()==1)
		{
			/******* Updating is_deleted column from tbl_friend_share table *******/
			$sqlDelFriendShare = mysql_query("update ba_tbl_friend_share set is_deleted = '1' where item_id = '$id'");
			/***************************** END ***********************************/
			$sqlSelect = mysql_query("select id from ba_tbl_content where id = '$id'");
			$rowSelect = mysql_fetch_assoc($sqlSelect);
			$updated_id = $rowSelect["id"];
			$arr_content[] = array("id"=>$updated_id);
		}
	
}

if($arr_content==null)
{
		$arr_content = array();	
}	
$new_json['content'] = $arr_content;
$final_json = json_encode($new_json);
print_r($final_json);
?>