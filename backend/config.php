<?php
$host = "localhost";
$db = "kenha";
$user = "root";
$pass = ""; // blank if default XAMPP

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
