<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $county = trim($_POST['county'] ?? '');

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password) || empty($county)) {
        $_SESSION['register_error'] = "All fields are required.";
        header("Location: ../public/register.php");
        exit();
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Invalid email address.";
        header("Location: ../public/register.php");
        exit();
    }

    // Phone validation
    if (!preg_match("/^07\d{8}$/", $phone)) {
        $_SESSION['register_error'] = "Phone must start with 07 and be 10 digits.";
        header("Location: ../public/register.php");
        exit();
    }

    // Password strength (minimum 6 characters only)
    if (strlen($password) < 6) {
        $_SESSION['register_error'] = "Password must be at least 6 characters long.";
        header("Location: ../public/register.php");
        exit();
    }

    // Confirm password
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: ../public/register.php");
        exit();
    }

    try {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['register_error'] = "Email is already registered.";
            header("Location: ../public/register.php");
            exit();
        }

        // Hash and insert
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, county, role)
                                VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->execute([$full_name, $email, $phone, $hashedPassword, $county]);

        // Auto-login after successful registration
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['email'] = $email;
        $_SESSION['user_name'] = $full_name;
        $_SESSION['county'] = $county;
        $_SESSION['role'] = 'user';

        header("Location: ../public/dashboard.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['register_error'] = "Registration failed: " . $e->getMessage();
        header("Location: ../public/register.php");
        exit();
    }
}
