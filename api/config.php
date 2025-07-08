<?php
// Database configuration
$host = 'localhost'; // or your database host``
$dbname = 'kenha_connect';
$username = 'root'; // or your MySQL username
$password = '';     // or your MySQL password

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Enable exception mode for debugging
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Stop execution and print error
    die("Database connection failed: " . $e->getMessage());
}
?>
