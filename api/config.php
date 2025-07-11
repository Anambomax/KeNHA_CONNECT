<?php
// Database configuration
$host     = 'localhost';         // Change if not using localhost
$dbname   = 'kenha_connect';     // Your database name
$username = 'root';              // Default XAMPP username
$password = '';                  // Default XAMPP password

try {
    // Set DSN
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    // PDO options for security and performance
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return rows as associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
    ];

    // Create PDO instance
    $conn = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    // Show connection error
    die("Database connection failed: " . $e->getMessage());
}
?>
