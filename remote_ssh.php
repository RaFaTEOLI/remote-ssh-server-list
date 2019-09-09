<?php
/* ------------------------------------------------------------- */
/* --------------- Remote SSH ---------------------------------- */
/* --------------- Developed by Rafael Tessarolo --------------- */
/* --------------- Version 1.0 --------------------------------- */
/* ------------------------------------------------------------- */

	// Requires Connection to MySQL
    require_once("mysql_conn/conn.php");

    // Requires ssh functions
    require_once("functions/functions.php");

	// Builds the select query
	$query_servers = "SELECT * FROM servers WHERE ignore_server <> 1 LIMIT 500";
	$select = mysqli_query($conn, $query_servers);

	// Sees if it returns an error
	if (!$select) {
		die("Failed to execute query!");
	}

	// Creates the variable command
	$command = "ifconfig";


	// Enters the while to execute the command on each server
	while($servers = mysqli_fetch_assoc($select)) {
	    echo "Executing command ($command) on {$servers["name"]}...<br>";

	    if ($servers["use_rsa"] == 1) {
	    	echo "Using RSA key..." . "<br>";
	    	executeCommandWithRSAKey($command, $servers["ip"], $servers["user"], $servers["port"], $servers["key_path"], $servers["key_passphrase"]);
	    } else {
	    	echo "Using Password Authentication..." . "<br>";
	    	executeCommand($command, $servers["ip"], $servers["user"], $servers["password"], $servers["port"]);
	    }
		echo "<br>";
	}

    mysqli_close($conn);
?>