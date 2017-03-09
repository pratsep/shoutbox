<?php
    $servername = "localhost";
    $username = "test";
    $password = "t3st3r123";
    $dbname = "test";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ei saanud ühendada: ".$conn->connect_error);
    }
?>
