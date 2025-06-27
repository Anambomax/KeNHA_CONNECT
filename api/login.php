<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic input validation
    if (!$email || !$password) {
        die("Both email and password are required.");
    }

    // Fetch user by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Correct credentials
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        header("Location: ../public/dashboard.php");
        exit();
    } else {
        // Wrong credentials
        die("Invalid email or password.");
    }
} else {
    die("Invalid request.");
}
