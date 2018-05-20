<?php
session_start();
if(!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = uniqid('', true);
}
if(!isset($_SESSION['session'])){
    $_SESSION['session'] = false;
}
if(!isset($_SESSION['loggedIn'])){
    $_SESSION['loggedIn'] = false;
}

if(!isset($_SESSION['invalidUser'])){
    $_SESSION['invalidUser'] = false;
}

if(!isset($_SESSION['notFilled'])){
    $_SESSION['notFilled'] = false;
}

if(!isset($_SESSION['loginname'])){
    $_SESSION['loginname'] = "";
}

if(!isset($_SESSION['loginpw'])){
    $_SESSION['loginpw'] = "";
}
if(isset($_COOKIE['loginname']) AND isset($_COOKIE['loginpw'])){

    $loginname = $_COOKIE['loginname'];
    $loginpw = $_COOKIE['loginpw'];
    $_SESSION['session'] = true;
}
if(!$_SESSION['loggedIn']){
	ob_start();
	require ("/var/www/html/SECURE_LOGIN/vendor/autoload.php");
	//Step 1: Enter you google account credentials
	$g_client = new Google_Client();
	$g_client->setClientId("617536422477-t5ef1uv1pd6se1io2qcdaua1a1sjbfsr.apps.googleusercontent.com");
	$g_client->setClientSecret("Yy-PUNd4rMH1I_6W23I_nW7f");
	$g_client->setRedirectUri("http://localhost/SECURE_LOGIN/index.php");
	$g_client->setScopes("email");
	//Step 2 : Create the url
	$auth_url = $g_client->createAuthUrl();
	echo "<a href='$auth_url'>Login with Google!</a>";
	//Step 3 : Get the authorization  code

	if(isset($_GET['code'])){
		$code = $_GET['code'];
	}
	//Step 4: Get access token
	if(isset($code)) {
		try {
			$token = $g_client->fetchAccessTokenWithAuthCode($code);
			$g_client->setAccessToken($token);
		}catch (Exception $e){
			var_dump($token);
			$e->getMessage();
		}
		try {
			$pay_load = $g_client->verifyIdToken();
			$_SESSION['loggedIn'] = true;
			ob_end_clean();
		}catch (Exception $e) {
			echo $e->getMessage();
		}
	} else{
		$pay_load = null;
	}
}

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>LOGIN SECURE</title>
        <!--<link rel="stylesheet" type="text/css" href="stylesheet.css" />-->
    </head>
    <body>
	<div id="login">
		<?php 
			if($_SESSION['loggedIn']){
				include "loggedin.php";
			}else{
            			include "login.php";
			}
		?>
        </div>
    </body>
</html>
