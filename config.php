<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "kenha_connect";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

// Optional: Set character encoding
$conn->set_charset("utf8mb4");
?>
