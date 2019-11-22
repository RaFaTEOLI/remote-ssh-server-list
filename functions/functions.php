<?php
	// Includes the phpseclib
    include('../phpseclib/Net/SSH2.php');
    include('../phpseclib/Crypt/RSA.php');
    set_include_path(get_include_path().PATH_SEPARATOR.'phpseclib');

	// Function that receives the parameters to execute the command on ssh with authentication by password
    function executeCommand($command, $ip, $user, $password, $port) {
        $ssh = new Net_SSH2($ip, $port);

        // Connects to SSH server
        if (!$ssh->login($user, $password)) {
            exit('Login Failed');
            //echo "Login Failed";
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
            //echo "Login Failed";
        }

        // Executes the command
        echo $ssh->exec($command);
        echo $ssh->exec('exit');
        echo "<br>";
    }
?>