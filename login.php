<form action="validate.php" id='loginform' enctype="multipart/form-data" method='post'>
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
<?php
    if($_SESSION['invalidUser']){
	echo "Wrong User Name or Password";
    }
?>
