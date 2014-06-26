<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
/*
$(document).ready(function(){
	$('#resetForm').submit(function(event){
		event.preventDefault();
		$.post('resetpassword.php', $('#resetForm').serialize(), function(data){
			$('#result').html(data)
		})
	});	
});
*/
</script>
<script type="text/javascript">
$(document).ready(function(){
	$('#resetForm').submit(function(event){
		var count = $('#password').val().length;
		var count_c = $('#c_password').val().length;
		if(count<6 || count_c<6)
		{
			alert('Please specify a password of Minimum 6 alphanumeric characters...');
			return false;
		}
	});
});
</script>
<?php
/******** Google App Engine Mail API includes below ***********/
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
/*** END ****/
include('database.php');
if(isset($_REQUEST['id']) && $_REQUEST['id']!="")
{
	
	$email = base64_decode($_REQUEST['id']);
	$verification_key = $_REQUEST['r'];
	
	$sqlSelect  = mysql_query("select email, verification_key from ba_tbl_user where email = '$email'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numRows = mysql_num_rows($sqlSelect);
	$verification_key = $rowSelect['verification_key'];
	if($numRows>0)   /*** Showing password reset form if info from query string is valid  ***/
	{	
		?>
		<form action="http://skibuyerspick.appspot.com/resetpassword" id="resetForm" method="post">
		<table cellpadding="10" cellspacing="10" border="0">
		<tr>
			<td>	
		 	New Password :
			</td>
			<td> <input type="password" name="password" id="password" /></td>
		</tr>
		<tr>
			<td>
			Confirm Password : 
			</td>
			<td>
			<input type="password" name="c_password" id="c_password" />
			</td>
		</tr>
		<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
		<tr>
			<td>
				<input type="submit" name="submit" id="submit"  value="Update" />
			</td>
		</tr>
		</table>	
			
		</form><br>
		<div id="result"></div>	
		<?
	}
	else
	{
		echo '[{"response":"no matching email"}]';
	}
}
else
{
	echo '[{"response":"no email"}]';
}
?>