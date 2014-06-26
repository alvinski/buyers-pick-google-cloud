<?php
session_start();
//include("adminloginchk.php");
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

$sql = "select * from ba_tbl_ios_push";
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);

?>
<!--		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php //include("common_includes.php"); ?>

<body> 
<!-- Start: page-top-outer -->
<?php //include("top.php"); ?>
<!-- End: page-top-outer -->
<!--<div class="clear">&nbsp;</div>-->
<!--  start nav-outer-repeat................................................................................................. START -->
<?php //include("menu.php"); ?>
<!--  start nav-outer-repeat................................................... END -->
<!--
<div class="clear"></div>

<div id="content-outer">
	<!-- start content -->
    <!--
	<div id="content">
		<div id="page-heading"><h1>Send Push To All Users IPHONE</h1></div>
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
			<tr>
				<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
				<th class="topleft"></th>
				<td id="tbl-border-top">&nbsp;</td>
				<th class="topright"></th>
				<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
			</tr>
			<tr>
				<td id="tbl-border-left"></td>
				<td>
				<!--  start content-table-inner -->	
                <!--	
					<div id="content-table-inner">
						<!--<form name="bslink" method="POST" action="../push_to_iphone/send_push_to_many.php" enctype="multipart/form-data">-->
                        <form name="bslink" method="POST" action="push_to_many.php" enctype="multipart/form-data"> 
							
										<table border="0" cellpadding="10" cellspacing="10"  id="id-form" width="100%">
										<tr>
												<th valign="top"><?php if($_REQUEST['msg']) { echo $msg; } ?></th>
												<td name="push_no" id="push_no">
												</td>
												<td></td>
											</tr>  
                                    	<tr>
												<th valign="top">Send Push To:</th>
												<td name="push_no" id="push_no">All	<?php if ($num_rows) { echo "(".$num_rows." Devices)"; } ?>
												<!--<select style="width:150px;" name="push_no" id="push_no">
													<option value="0" selected="selected">---- Select Option ---</option>
													<option value="1">Single Device</option>
													<option value="2">All</option>
												</select>-->
												</td>
												<td></td>
											</tr>  
											<tr>
												<th valign="top">Send Message To All Users</th>
												<td><textarea class="inp-form" name="message" id="message" cols="40" rows="6"></textarea></td>
												<td></td>
											</tr>

											<tr>
												<th>&nbsp;</th>
												<td valign="top">
													<input type="Submit" value="send-push" class="form-submit" name="Submit"/>
													<?php /*?><input type="reset" value="" class="form-reset"  /><?php */?>
												</td>
												<td></td>
											</tr>
										</table>
									
						</form>
                        <!--
						<div class="clear"></div>
					</div>
					<!--  end content-table-inner  -->
                    <!--
				</td>
				<td id="tbl-border-right"></td>
			</tr>
			<tr>
				<th class="sized bottomleft"></th>
				<td id="tbl-border-bottom">&nbsp;</td>
				<th class="sized bottomright"></th>
			</tr>
		</table>
		<div class="clear">&nbsp;</div>
	</div>
	<!--  end content -->
    <!--
	<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer -->
<!--
<div class="clear">&nbsp;</div>
<!-- start footer -->     
<!--    
<div id="footer">
	<!--  start footer-left -->
    <!--
	<div id="footer-left">
	Quantum Technology &copy; Copyright SKIUSINC <a href="http://www.skiusainc.com">www.skiusainc.com</a>. All rights reserved.</div>
	<!--  end footer-left -->
    <!--
	<div class="clear">&nbsp;</div>
</div>
<!-- end footer -->
 <!--
</body>
</html>
-->