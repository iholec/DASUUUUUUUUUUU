
<form id="loginout" method="POST" action="logout.php">
	<input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_token'];?>"/>
	<input type="submit" id="logoutbutton" name="submit" value="Logout!"/>
</form>
