<?php
/* ------------------------------------------------------------- */
/* --------------- Remote SSH ---------------------------------- */
/* --------------- Developed by Rafael Tessarolo --------------- */
/* --------------- Version 1.0 --------------------------------- */
/* ------------------------------------------------------------- */

	// Requires Connection to MySQL
    require_once("mysql_conn/conn.php");

	// Includes the phpseclib
    include('phpseclib/Net/SSH2.php');
    include('phpseclib/Crypt/RSA.php');
	set_include_path(get_include_path().PATH_SEPARATOR.'phpseclib');

	// Builds the select query
	$query_servers = "SELECT * FROM servers LIMIT 500";
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
		executeCommand($command, $servers["ip"], $servers["user"], $servers["password"], $servers["port"]);
		echo "<br>";
	}

    mysqli_close($conn);

	// Function that receives the parameters to execute the command on ssh with authentication by password
	function executeCommand($command, $ip, $user, $password, $port) {
		$ssh = new Net_SSH2($ip, $port);

		// Connects to SSH server
		if (!$ssh->login($user, $password)) {
       		exit('Login Failed');
    	}

    	// Executes the command
    	echo $ssh->exec($command);
        echo $ssh->exec('exit');
    	echo "<br>";
	}

	// Function that receives the parameters to execute the command on ssh with authentication by rsa key
	function executeCommandWithRSAKey($command, $ip, $user, $port, $key_path, $passphrase) {
		$ssh = new Net_SSH2($ip, $port);
		$key = new Crypt_RSA();

		$key->setPassword($passphrase);
		$key->loadKey(file_get_contents($key_path));

		// Connects to SSH server
		if (!$ssh->login($user, $key)) {
    		exit('Login Failed');
		}

    	// Executes the command
    	echo $ssh->exec($command);
        echo $ssh->exec('exit');
    	echo "<br>";
	}
?>