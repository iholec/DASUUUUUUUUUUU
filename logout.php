<?php
	session_start();
	if($_SESSION['csrf_token'] !== $_POST['csrf']){
		echo 'Invalid csrf token! '.$_SESSION['csrf_token'].', '.$_POST['csrf'];
		include 'loggedin.php';
	}else{
		session_destroy();
		if(isset($_COOKIE['username']) AND isset($_COOKIE['password'])){
			$username = $_COOKIE['username'];
			$password = $_COOKIE['password'];
			setcookie('username', $username, time()-1);
			setcookie('password', $password, time()-1);
		}
		session_start();
		unset($_SESSION['session']);
		unset($_SESSION['loginname']);
		unset($_SESSION['loginpw']);
		unset($_SESSION['invalidUser']);
		unset($_SESSION['notFilled']);
		unset($_SESSION['loggedIn']);
	}
	//header('HTTP/1.1 401 Unauthorized');
	header('Location: index.php');
	exit();
?>
