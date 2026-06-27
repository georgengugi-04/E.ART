<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "safari";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // Use die() for clarity and stop execution
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set character set to UTF-8
$conn->set_charset("utf8mb4");
?>
