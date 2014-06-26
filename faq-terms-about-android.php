<?php
include('database.php');

/********************* getting tbl_about **************************/
$sqlAbout = mysql_query("select * from ba_tbl_about");
$rowAbout = mysql_fetch_assoc($sqlAbout);
extract($rowAbout);
$arr_about[] = array("id"=>$id, "content"=>$content);
/************************** END *********************************/

/********************** getting tbl_about ************************/
$sqlTerms = mysql_query("select * from ba_tbl_terms");
$rowTerms = mysql_fetch_assoc($sqlTerms);
extract($rowTerms);
$arr_terms[] = array("id"=>$id, "content"=>$content);
/********************** END *************************************/

/********************** getting tbl_faq ************************/
$sqlFaq = mysql_query("select * from ba_tbl_faq where faq_type = 'Global' or faq_type = 'Android'");
while($rowFaq = mysql_fetch_assoc($sqlFaq))
{
extract($rowFaq);
$arr_faq[] = array("id"=>$id, "faq_type"=>$faq_type, "title"=>$title, "content"=>$content);
}
/********************** END *************************************/

if($arr_about==null)
{
	$arr_about = array();
}
if($arr_terms==null)
{
	$arr_terms = array();
}
if($arr_faq==null)
{
	$arr_faq = array();
}

$data["about"] = $arr_about;
$data["terms"] = $arr_terms;
$data["faq"] = $arr_faq;
$json = json_encode($data);
print_r($json);

?>