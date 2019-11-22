<?php
function getServers() {
    // Builds the select query
    $query_servers = "SELECT * FROM servers WHERE ignore_server <> 1 LIMIT 500";
    $select = mysqli_query($conn, $query_servers);

    // Sees if it returns an error
    if (!$select) {
        die("Failed to execute query!");
    }

    return $select;
}

?>