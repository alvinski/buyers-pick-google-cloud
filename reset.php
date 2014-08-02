<!DOCTYPE html>
<html>
<head>
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
		event.preventDefault();
		$("#passwordError").html("");
		$("#cpasswordError").html("");
		var count = $('#password').val().length;
		var count_c = $('#c_password').val().length;
		var password = $('#password').val();
		var c_password = $('#c_password').val();
		if(count<6)
		{
			//alert('Please specify a password of Minimum 6 alphanumeric characters...');
			$("#passwordError").html("Minimum 6 characters required!!");
			return false;
		}
		if(count_c<6)
		{
			$("#cpasswordError").html("Minimum 6 characters required!!");
			return false;
		}
		if(password != c_password)
		{
			$('#cpasswordError').html("Password does not match");
			return false;
		}
		$.post("http://skibuyerspick.appspot.com/resetpassword", $("#resetForm").serialize(), function(data){
			//alert(data);
			if(data=="2")
			{
				$('#result').html('Password Reset Not Successful. Please Try Again.');
			}
			else if(data=="1")
			{
				$('#result').html('<p style="color:green;">Password Reset Successful</p>');
			}
		})
	});
});
</script>
<style>
body{
	background-color:#e9e9e9;
	font-family:Helvetica Neue;
}
#result, #passwordError, #cpasswordError{
	color:red;
}
.wrapper{
	
	margin:0px auto;
	position:relative;
	padding:20px;
}

.resetBox{
	background-color:white;
	width:400px;
	height:auto;
	border:0;
	margin:0px auto;
	position:relative;
	padding:20px;
	-webkit-box-shadow:  0px 0px 2px 2px rgba(0,0,0,0.2);
	box-shadow:  0px 0px 2px 2px rgba(0,0,0,0.2);
	border-radius:8px;
	
}
.inputBox{
width: 90%;
padding: 12px 12px 12px 12px;
border: 0;
-webkit-box-shadow: inset 1px 1px 1px 1px rgba(0,0,0,0.2);
box-shadow: inset 1px 1px 1px 1px rgba(0,0,0,0.2);
margin-top: 15px;
color: #8f8f8f;
font-size: 14px;
border-radius:5px;
}
.resetBtn{
	background: url(http://www.buyerspicks.com/images/updatepass.png) center center no-repeat;
	width: 103px;
	height: 35px;
	border: 0;
	background-color: transparent;
	
}
.socialMedia
{
	width:400px;
	margin:0px auto;
	color:grey;
	font-family:Helvetica Neue;
}
	
@media screen and (max-width: 480px) {
	.inputBox{
	width: 90%;
	}
	.resetBox{
		width:90%;
	}
	.socialMedia
	{
		width:90%;
	}
}
</style>
</head>
<body>
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
	
	$sqlSelect  = mysql_query("select email, verification_key, profile_image from ba_tbl_user where email = '$email' and verification_key = '$verification_key'");
	$rowSelect = mysql_fetch_assoc($sqlSelect);
	$numRows = mysql_num_rows($sqlSelect);
	$verification_key = $rowSelect['verification_key'];
	$profile_image = $rowSelect["profile_image"];
	if($numRows>0)   /*** Showing password reset form if info from query string is valid  ***/
	{	
		?>
		<div class="wrapper">
		<form action="http://skibuyerspick.appspot.com/resetpassword" id="resetForm" method="post">
		
		
			<p><center><img src="http://www.buyerspicks.com/images/logo.jpg" width="206" height="154" alt="" border="0" /></center></p>
			<p><center style="color:grey;">Reset your password</center></p>
		
		<div class="resetBox">		
		<p>
			<?
			if($profile_image!="" || !empty($profile_image))
			{
				?>
				<center><img src="<?php echo $profile_image; ?>" width="133" height="133" style="border-radius:100px; -webkit-border-radius: 100px; -moz-border-radius: 100px;" /></center>
				<?
			}
			else
			{
			?>
			<center><img src="http://www.buyerspicks.com/images/profile.png" /></center>
			<?
			}	
			?>
			</p>
		 	<p>
		
	<input type="password" name="password" id="password" class="inputBox" placeholder="New Password" maxlength="25" /></p>
		 <div id="passwordError"></div>
			<p>
		 
			<input type="password" name="c_password" id="c_password" class="inputBox" placeholder="Confirm New Password" maxlength="25" /></p>
	<div id="cpasswordError"></div>
		<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
	
			<p><center><input type="submit" name="submit" id="submit" class="resetBtn" value /></center></p>
		<p><center><div id="result"></div>	</center></p>
		</div>	
	
		
		</form><br>
        <div class="socialMedia"><center><a href="https://plus.google.com/u/0/b/115302655080223880566/115302655080223880566/"><img src="http://www.buyerspicks.com/images/gplus.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="https://www.facebook.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/fb.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="http://www.pinterest.com/Buyerspicks/"><img src="http://www.buyerspicks.com/images/pin.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="https://twitter.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/twt.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;</center>
		
		<p><center>&copy; Copyright Buyers Pic(k)'s <?php echo date("Y");?></center></p>
		</div>
		</div>
		<?
	}
	else
	{
		?>
		<div class="wrapper">

			<p><center><img src="http://www.buyerspicks.com/images/logo.jpg" width="206" height="154" alt="" border="0" /></center></p>
			<p><center style="color:grey;">Reset your password</center></p>
		
		<div class="resetBox">		
		<p>
			
			<center><img src="http://www.buyerspicks.com/images/profile.png" /></center>
		
			</p>
			<p><center class="socialMedia">Link has Expired!! Please try again.</center></p>
		 	<p>
		
	
        <div class="socialMedia"><center><a href="https://plus.google.com/u/0/b/115302655080223880566/115302655080223880566/"><img src="http://www.buyerspicks.com/images/gplus.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="https://www.facebook.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/fb.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="http://www.pinterest.com/Buyerspicks/"><img src="http://www.buyerspicks.com/images/pin.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="https://twitter.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/twt.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;</center>
		
		<p><center>&copy; Copyright Buyers Pic(k)'s <?php echo date("Y");?></center></p>
		</div>
		</div>
		<?
	}
}
else
{
	echo '[{"response":"no email"}]';
}
?>
</body>
</html>