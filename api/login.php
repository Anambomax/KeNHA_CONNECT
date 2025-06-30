<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // Prepare query using PDO
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login, store session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'] ?? $user['email'];
            $_SESSION['county'] = $user['county'] ?? 'Nairobi'; // Fixed from 'location'
            $_SESSION['role'] = $user['role'];

            header("Location: ../public/dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: ../public/index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = "Server error: " . $e->getMessage();
        header("Location: ../public/index.php");
        exit();
    }
}
