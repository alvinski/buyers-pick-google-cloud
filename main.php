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
    echo 'Hello world!';
?>
