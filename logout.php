<?php
	if($_SESSION['csrf_token'] !== $_POST['csrf']){
		echo 'Invalid csrf token!';
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
		unset($_SESSION['usermode']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['content']);
		unset($_SESSION['section']);
		header('Location: index.php');
	}
	include 'loggedin.php';
?>
