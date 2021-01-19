<?php

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

/**
 * Returns the user's role
 */
function getUserRole(){

    global $connection;

    global $response;

    $stmt = $connection->stmt_init();

    $stmt->prepare("SELECT role FROM skymake_roles WHERE username=?");

    $stmt->bind_param("s",$_GET["username"]);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1){

        $row = $result->fetch_assoc();

        $response["result"]["string"] = $row["role"];

    } else {

        $response["result"]["string"] = "unverified";

    }

    $response["status"]["code"] = "200";

}