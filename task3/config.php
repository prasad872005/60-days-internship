<?php

/* =====================================================
   TASK 3 - DATABASE CONNECTION
===================================================== */

$host = "localhost";
$username = "root";
$password = "";
$database = "task3_user_management";

/* Create database connection */

$conn = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);


/* Check connection */

if (!$conn) {

    die(
        "Database connection failed: " .
        mysqli_connect_error()
    );

}


/* Set UTF-8 character set */

mysqli_set_charset($conn, "utf8mb4");

?>