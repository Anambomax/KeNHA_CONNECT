<?php
$host = "localhost";
$user = "root";
$pass = ""; // Leave empty for default XAMPP MySQL
$dbname = "kenha_connect";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
