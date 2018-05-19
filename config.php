<?php
	$servername = "localhost";
	$username = "testy";
	$password = "Testy_12345";
	$dbname = "login";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	if (mysqli_connect_errno()) {
	    die ("database connection failed\n". mysqli_connect_error());
	}
?>
