<?php
$host = "localhost";             // Change if hosted elsewhere
$db_name = "kenha_connect";      // Your DB name
$username = "root";              // Your MySQL user (default for XAMPP)
$password = "";                  // Your MySQL password (blank if default)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
