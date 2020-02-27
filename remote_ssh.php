<?php
/* ------------------------------------------------------------- */
/* --------------- Remote SSH ---------------------------------- */
/* --------------- Developed by Rafael Tessarolo --------------- */
/* --------------- Version 1.1 --------------------------------- */
/* ------------------------------------------------------------- */

	// Requires Connection to MySQL
    require_once("mysql_conn/conn.php");

    // Requires ssh functions
	require_once("functions/functions.php");
	
	// Requires DAO
    require_once("dao/remote_ssh.php");

	// Sets the variable select with the servers list
	$select = getServers($conn);

	// Sets the variable config with the program config
	$configIgnore = getConfigByName($conn, 'IGNORE_SERVER_AFTER_CMD');

	// Creates the variable command
	$command = "ifconfig";

	// Enters the while to execute the command on each server
	while($servers = mysqli_fetch_assoc($select)) {
	    echo "Executing command ($command) on {$servers["name"]}...<br>";

	    if ($servers["use_rsa"] == 1) {
			echo "Using RSA key..." . "<br>";
			// Calls the function to execute the command on SSH using RSA Key
			executeCommandWithRSAKey($command, $conn, $servers["ip"], $servers["user"], $servers["port"], $servers["key_path"], $servers["key_passphrase"]);
			if ($configIgnore["parameter"] == 1) {
				setIgnore($conn, $servers["id"]);
			}
	    } else {
			echo "Using Password Authentication..." . "<br>";
			// Calls the function to execute the command on SSH using Password Authentication
			executeCommand($command, $conn, $servers["ip"], $servers["user"], $servers["password"], $servers["port"]);
			if ($configIgnore["parameter"] == 1) {
				setIgnore($conn, $servers["id"]);
			}
	    }
		echo "<br>";
	}

    mysqli_close($conn);
?>