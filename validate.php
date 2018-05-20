<?php
	include("config.php");
	$salt = "salt";
	
	$loggedIn = false;
     
	if(isset($_POST['login'])){
      		$myusername = mysqli_real_escape_string($conn,$_POST['loginname']);
      		$mypassword = mysqli_real_escape_string($conn,$_POST['loginpw']); 

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
		
		$_SESSION['loginname'] = $_POST['loginname'];
		$_SESSION['loginpw'] = $_POST['loginpw'];
		
		if($result == $pwdhash){
			
			if(isset($_POST['rememberme'])){

				#domain 'localhost': only accessible by localhost domain, 
				#secure true: only set if secure connection, 
				#httponly true: only accessible by http protocol (not by scripting languages)	
				setcookie('loginname', $_SESSION['loginname'], time()+60*60*7, '/', 'localhost', true, true); 
				setcookie('loginpw', md5($_SESSION['loginpw']), time()+60*60*7, '/', 'localhost', true, true);
			}
			$loggedIn = true;
		}
		
	}else if(isset($_POST['digestlogin'])){	
		$realm = "Realm";
		if( ! empty($_SERVER['PHP_AUTH_DIGEST']))
		{
			// Decode the data the client gave us
			$default = array('nounce', 'nc', 'cnounce', 'qop', 'username', 'uri', 'response');
			preg_match_all('~(\w+)="?([^",]+)"?~', $_SERVER['PHP_AUTH_DIGEST'], $matches);
			$data = array_combine($matches[1] + $default, $matches[2]);
			
			if ($stmt = $conn->prepare("SELECT username, password FROM user WHERE username = ?")) {
				$stmt->bind_param('s', $data['username']);
				$stmt->execute();
				
				$res = $stmt->get_result();
				$pw = "";
				$username = "";
				if ($res) 
				{
					if (mysqli_num_rows($res) == 1) 
					{
						
						while ($u = mysqli_fetch_object($res)) 
						{
							$pw = $u ->password;
							$username = $u -> username;
						}
					}
				}
			}

				
				
			//$pwHash = md5($users[$data['username']]);
			$A1 = md5($data['username'] . ':' . $realm . ':' . $pw);
			$A2 = md5(getenv('REQUEST_METHOD').':'.$data['uri']);
			$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);
			// Compare with what was sent
			if($data['response'] === $valid_response)
			{ 
				$_SESSION['loginname'] = $username;
				$_SESSION['loginpw'] = $pw;
				$loggedIn = true;
			}
		}else{
			// Failed, or haven't been prompted yet
			header('HTTP/1.1 401 Unauthorized');
			header('WWW-Authenticate: Digest realm="' . $realm.'",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"');
			exit();
		}

	}
	if(($_SESSION['loginname'] == "" || $_SESSION['loginpw'] == "")&&isset($_POST['login'])){
		$_SESSION['notFilled'] = true;
		include "login.php";
	}else if($loggedIn){
		include "loggedin.php";
	}else{
		$_SESSION['invalidUser'] = true;
		include "login.php";
	}
?>
