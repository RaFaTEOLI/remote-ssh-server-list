<?php
/* ------------------------------------------------------------- */
/* --------------- Remote SSH ---------------------------------- */
/* --------------- Developed by Rafael Tessarolo --------------- */
/* --------------- Version 1.1 --------------------------------- */
/* ------------------------------------------------------------- */

    // Requires Connection to MySQL
    require_once("mysql_conn/conn.php");

    // Requires SSH functions
    require_once("functions/functions.php");

    // Requires DAO
    require_once("dao/remote_ssh.php");

    // Verifies if the command field has a value and if it does, it executes the select
    if (isset($_POST["command"])) {
        $command = $_POST["command"];

        // Sets the variable select with the servers list
        $select = getServers($conn);

        // Sets the variable config with the program config
	    $config = getConfig($conn);
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Remote Web SSH</title>

    <!-- Style -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
    </style>
</head>
<body>
<main>
    <div id="center">
    <div id="command">
        <h2>Remote Web SSH - All servers at once</h2>
        <form action="remote_ssh_web.php" method="post" class="run_command">
            <!-- <label for="command" class="alinhar_centro">Command: </label> -->
            <div class="row">
                <div id="run_command">
                    <input type="text" class="form-control" name="command" aria-describedby="command" placeholder="Type the command..." required>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-running"></i> Run</button>
                </div>
            </div>
        </form>
    </div>
    <div id="line"></div>
    <br>
    <div id="output">
        <div class="row">
            <div class="form-group col-md-12">
                <?php
                if (isset($command)) {
                    while($servers = mysqli_fetch_assoc($select)) {
                        ?>
                        <label for="output">Output for command <i>(<?php echo $command ?>)</i> on <?php echo "{$servers["name"]}"; ?></label>
                        <?php 
                        if ($servers["use_rsa"] == 1) {
                            echo "Using RSA key...";
                        ?>
                            <div class="well"><?php executeCommandWithRSAKey($command, $conn, $servers["ip"], $servers["user"], $servers["port"], $servers["key_path"], $servers["key_passphrase"]); ?></div>
                        <?php
                            if ($config["ignoreServer_afterCmd"] == 1) {
                                setIgnore($conn, $servers["id"]);
                            }
                        } else {
                            echo "Using Password Authentication...";
                        ?>
                            <div class="well"><?php executeCommand($command, $conn, $servers["ip"], $servers["user"], $servers["password"], $servers["port"]); ?></div>
                        <?php
                            if ($config["ignoreServer_afterCmd"] == 1) {
                                setIgnore($conn, $servers["id"]);
                            }
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
    mysqli_close($conn);
?>