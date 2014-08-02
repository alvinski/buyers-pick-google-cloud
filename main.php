<?php
/*
	require_once 'google/appengine/api/users/UserService.php';
	//use google\appengine\users\User;
	//use google\appengine\users\UserService;
	
	$user = UserService::getCurrentUser();
	
	if($user)
	{
		echo "HELLO " . htmlspecialchars($user->getNickname());	
	}
	else
	{
		header("Location: ".UserService::createLoginURL($_SERVER['REQUEST_URI']));
	}
*/
?>	
<!DOCTYPE html>
<html>
<head>
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
	
	.msgBox{
		width:440px;
		height:102px;
		margin:0px auto;
		background: url(http://www.buyerspicks.com/images/BG_1.png) no-repeat center;
		font-family:Helvetica Neue;
		font-weight:bold;
		padding-top:45px;
		//padding-left:50px;
		font-size:22px;
		text-align:center;
	
	}
	.msgBox img{
		
	}
	.socialMedia
	{
		width:400px;
		margin:0px auto;
		color:grey;
		font-family:Helvetica Neue;
	}
	.success{
		margin-right:10px;
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
		.message, .success{
			display:block;
			font-size:18px;
		}
		.msgBox{
			width:282px;
			height:124px;
			margin:0px auto;
			background: url(http://www.buyerspicks.com/images/BG_2.png) no-repeat center;
	
		}
	}
	</style>
</head>
<body>
<div class="wrapper">
	<p><center><img src="http://www.buyerspicks.com/images/logo.jpg" width="206" height="154" alt="" border="0" /></center></p>
	<p>&nbsp;</p>
	<div class="msgBox">

<p><center> Welcome to Buyers Pic(k)'s </center></p>        
</div>
       
</div>
        <div class="socialMedia"><center><a href="https://plus.google.com/u/0/b/115302655080223880566/115302655080223880566/"><img src="http://www.buyerspicks.com/images/gplus.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="https://www.facebook.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/fb.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="http://www.pinterest.com/Buyerspicks/"><img src="http://www.buyerspicks.com/images/pin.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;
        <a href="https://twitter.com/BuyersPicks"><img src="http://www.buyerspicks.com/images/twt.jpg" width="15" height="17" alt="" border="0" /></a>&nbsp;</center>
		
		<p><center>&copy; Copyright Buyers Pic(k)'s <?php echo date("Y");?></center></p>
		</div>
</body>
</html>

