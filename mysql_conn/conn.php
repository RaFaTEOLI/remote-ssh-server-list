<?php

	// Connection Variables
	$server = "localhost";
	$user = "root";
	$password = "";
	$db = "servers";
	$port = "3306";

	// Open Connection
	$conn = mysqli_connect($server, $user, $password, $db);

	// Try Connection
	if (mysqli_connect_errno()) {
	    die("Failed to connect to database: " . mysqli_connect_errno());
	}
	
?>