<?php
session_start();
$_SESSION['csrf_token'] = uniqid('', true);
if(!isset($_SESSION['session'])){
    $_SESSION['session'] = false;
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
			if($_SESSION['session']){
				include "loggedin.php";
			}else{
            			include "login.php";
			}
		?>
        </div>
    </body>
</html>
