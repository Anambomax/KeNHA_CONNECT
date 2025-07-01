<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $county = $_POST['county'];

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: ../register.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $_SESSION['register_error'] = "Email already registered.";
            header("Location: ../register.php");
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user';

        $insert = $conn->prepare("INSERT INTO users (full_name, email, phone, password, county, role) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
        $insert->execute([$full_name, $email, $phone, $hashed_password, $county, $role]);

        $_SESSION['register_success'] = "Registration successful! Please log in.";
        header("Location: ../index.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['register_error'] = "Database error: " . $e->getMessage();
        header("Location: ../register.php");
        exit();
    }
} else {
    http_response_code(403);
    echo "Access Denied.";
    exit();
}
