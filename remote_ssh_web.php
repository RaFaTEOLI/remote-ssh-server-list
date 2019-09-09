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

    // Verifies if the command field has a value
    if (isset($_POST["command"])) {
        $command = $_POST["command"];

        // Builds the select query
        $query_servers = "SELECT * FROM servers WHERE ignore_server <> 1 LIMIT 500";
        $select = mysqli_query($conn, $query_servers);

        // Sees if it returns an error
        if (!$select) {
            die("Failed to execute query!");
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Remote Web SSH</title>

    <!-- Style -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
    </style>
</head>

<body>

<main>
    <div id="center">
    <div id="command">
        <h2>Remote Web SSH - All servers at once</h2>
        <form action="remote_ssh_web.php" method="post">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="command">Command: </label>
                    <input type="text" class="form-control" name="command" aria-describedby="command" placeholder="Command">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Execute</button>
        </form>
    </div>
    <br>
    <div id="output">
        <div class="row">
            <div class="form-group col-md-12">
                <?php

                if (isset($command)) {
                    while($servers = mysqli_fetch_assoc($select)) {
                        ?>
                        <label for ="output">Output for command (<?php echo $command ?>) on <?php echo "{$servers["name"]}"; ?></label>
                        <?php 
                        if ($servers["use_rsa"] == 1) {
                            echo "Using RSA key...";
                        ?>
                            <div class="well"><?php executeCommandWithRSAKey($command, $servers["ip"], $servers["user"], $servers["port"], $servers["key_path"], $servers["key_passphrase"]); ?></div>
                        <?php    
                        } else {
                        ?>
                        <div class="well"><?php executeCommand($command, $servers["ip"], $servers["user"], $servers["password"], $servers["port"]); ?></div>
                        <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </div>
</main>
</body>
</html>
<?php

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

    mysqli_close($conn);
?>