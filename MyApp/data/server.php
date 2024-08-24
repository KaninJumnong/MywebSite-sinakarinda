<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "test";

    $conn = new mysqli($server, $user, $pass, $db);

    if(!$conn) {
        die("Connected Faild" . $conn->connect_error);
    }
?>