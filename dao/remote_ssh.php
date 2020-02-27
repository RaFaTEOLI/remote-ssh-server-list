<?php

// Function that returns the servers list
function getServers($conn) {
    // Builds the select query
    $query_servers = "SELECT * FROM servers_sincportab WHERE ignore_server <> 1 LIMIT 500";
    $select = mysqli_query($conn, $query_servers);

    // Sees if it returns an error
    if (!$select) {
        die("Failed to execute query!");
    }

    return $select;
}

// Function that returns the program config
function getConfigByName($conn, $name) {
    // Builds the select query
    $query_config = "SELECT * FROM config WHERE name = '{$name}' LIMIT 1";
    $select = mysqli_query($conn, $query_config);

    // Sees if it returns an error
    if (!$select) {
        die("Failed to execute query!");
    }

    $config = mysqli_fetch_assoc($select);
    return $config;
}

function setIgnore($conn, $id) {
    // Builds the update query
    $query_update = "UPDATE servers_sincportab SET ignore_server = 1 WHERE id = {$id}";
    $update = mysqli_query($conn, $query_update);

    // Sees if it returns an error
    if (!$update) {
        die("Failed to execute query!");
    }
    return true;
}

?>