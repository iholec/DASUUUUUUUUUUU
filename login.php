<form action="index.php" id='loginform' enctype="multipart/form-data" method='post'>
<h3>User Login </h3>
<table border=0>
      <tr valign='top'><td>Benutzer:</td><td>
      <input type='text' id="username" name='loginname' size=20></td></tr>
      <tr valign='top'><td>Kennwort:</td><td>
      <input type='password' id='pass' name='loginpw' size=20></td></tr>
	  <tr valign='top'><td>Remember me:</td><td><input type='checkbox' name='rememberme' value='1'></td><td></td></tr>
      <tr valign='top'><td></td><td><input class = 'loginbutton' type='submit' name='login' value='Login'></td><td></td></tr>
</table>
</form>

<form id="loginform" method="POST" action="index.php">
    <h3>User Login </h3>
    Username <input type="text" id="username" name="username"></br>
    Password <input type="password" id="pass" name="password"></br>
    Remember Me <input type="checkbox" name="rememberme" value="1"><br>
    <input type="submit" id="loginbutton" name="login" value="Login!">
</form>
<?php
    if(isset($_COOKIE['username']) AND isset($_COOKIE['password'])){

        $username = $_COOKIE['username'];
        $password = $_COOKIE['password'];
        $_SESSION['session'] = true;

    }
?>
