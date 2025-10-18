<?php
    date_default_timezone_set('Asia/Manila');
    
    $host = "localhost";
    $user = "root";
    $password = "";     
    $db_name = "user_db";

    $conn = new mysqli($host, $user, $password, $db_name);

    if ($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
    }
?>

