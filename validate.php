<?php
	$user = 'test';
	$pass = '12345';
	
	$admin = 'admin';
	$adminpass = '12345';
	
	if(isset($_POST['login'])){
		
		$_SESSION['loginname'] = $_POST['loginname'];
		$_SESSION['loginpw'] = $_POST['loginpw'];
		
		if(($_SESSION['loginname'] == $user) AND ($_SESSION['loginpw'] == $pass)){
			
			if(isset($_POST['rememberme'])){
				setcookie('loginname', $_SESSION['loginname'], time()+60*60*7);
				setcookie('loginpw', md5($_SESSION['loginpw']), time()+60*60*7);
			}
			$_SESSION['session'] = true;
			$_SESSION['usermode'] = "user";
			
		}else if (($_SESSION['loginname'] == $admin) AND ($_SESSION['loginpw'] == $adminpass)){
			
			if(isset($_POST['rememberme'])){
				setcookie('loginname', $_SESSION['loginname'], time()+60*60*7);
				setcookie('loginpw', $_SESSION['loginpw'], time()+60*60*7);
			}
			$_SESSION['session'] = true;
			$_SESSION['usermode'] = "admin";
		}
		
	}
	if($_SESSION['session'] == true){
		include "loggedin.php";
	}else{
		include "login.php";
	} 
?>