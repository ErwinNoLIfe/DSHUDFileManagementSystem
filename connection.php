<?php
// Set default timezone
date_default_timezone_set("Asia/Manila");


// Database configuration
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "doc_db";

// Create connection
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set charset for proper encoding
mysqli_set_charset($con, "utf8mb4");
?>
