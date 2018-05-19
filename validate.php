<?php
	include("config.php");
      
      	$myusername = mysqli_real_escape_string($db,$_POST['loginname']);
      	$mypassword = mysqli_real_escape_string($db,$_POST['loginpw']); 
      
	$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
	$stmt->bind_param("s", $myusername);
      	$result = mysqli_query($db,$stmt);
      	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      	$active = $row['active'];
     
	if(isset($_POST['login'])){
		
		$_SESSION['loginname'] = $_POST['loginname'];
		$_SESSION['loginpw'] = $_POST['loginpw'];
		
		if($result == $mypassword){
			
			if(isset($_POST['rememberme'])){
				setcookie('loginname', $_SESSION['loginname'], time()+60*60*7);
				setcookie('loginpw', md5($_SESSION['loginpw']), time()+60*60*7);
			}
			$_SESSION['session'] = true;
			$_SESSION['usermode'] = "user";
			
		}
		
	}
	if($_SESSION['session'] == true){
		include "loggedin.php";
	}else{
		$_SESSION['invalidUser'] = true;
		include "login.php";
	}
?>
