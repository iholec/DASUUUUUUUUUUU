<?php
	include("config.php");
      	$myusername = mysqli_real_escape_string($conn,$_POST['loginname']);
      	$mypassword = mysqli_real_escape_string($conn,$_POST['loginpw']); 
	$salt = "salt";

	if ($stmt = $conn->prepare("SELECT password FROM user WHERE username = ? AND password = ?")) {
		
		$pwdhash = (string)hash('sha256',$mypassword.$salt);

	    	$stmt->bind_param("ss", $myusername, $pwdhash);

	    	/* execute query */
	    	$stmt->execute();

      		$result = mysqli_query($conn,$stmt);

	    	/* bind result variables */
	    	$stmt->bind_result($result);

	    	/* fetch value */
	    	$stmt->fetch();

	    	/* close statement */
	    	$stmt->close();
	}else{
		echo "Invalid Query";	
	}
	
	$loggedIn = false;
     
	if(isset($_POST['login'])){
		
		$_SESSION['loginname'] = $_POST['loginname'];
		$_SESSION['loginpw'] = $_POST['loginpw'];
		
		if($result == $pwdhash){
			
			if(isset($_POST['rememberme'])){
				setcookie('loginname', $_SESSION['loginname'], time()+60*60*7);
				setcookie('loginpw', hash('sha256',$_SESSION['loginpw'].$salt), time()+60*60*7);
			}

			$loggedIn = true;
		}
		
	}


	if($myusername == "" || $mypassword == ""){
		$_SESSION['invalidUser'] = true;
		include "login.php";
	}else if($loggedIn){
		include "loggedin.php";
	}else{
		$_SESSION['invalidUser'] = true;
		include "login.php";
	}
?>
