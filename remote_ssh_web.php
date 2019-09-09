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
                            echo "Using Password Authentication...";
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
    mysqli_close($conn);
?>