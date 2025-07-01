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
    $role = 'user'; // default role

    // Email must be Gmail
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        $_SESSION['register_error'] = "Only Gmail addresses are allowed.";
        header("Location: ../public/register.php");
        exit();
    }

    // Phone number validation
    if (!preg_match('/^(07|01|\+2547|\+2541)[0-9]{7}$/', $phone)) {
        $_SESSION['register_error'] = "Phone must start with 07, 01, +2547, or +2541.";
        header("Location: ../public/register.php");
        exit();
    }

    // Password validation
    if (strlen($password) < 8) {
        $_SESSION['register_error'] = "Password must be at least 8 characters long.";
        header("Location: ../public/register.php");
        exit();
    }

    // Password match check
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = "Passwords do not match.";
        header("Location: ../public/register.php");
        exit();
    }

    try {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $_SESSION['register_error'] = "Email already exists.";
            header("Location: ../public/register.php");
            exit();
        }

        // Insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, county, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $phone, $hashed_password, $county, $role]);

        $_SESSION['login_success'] = "Registration successful. Please log in.";
        header("Location: ../public/index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['register_error'] = "Database error: " . $e->getMessage();
        header("Location: ../public/register.php");
        exit();
    }
} else {
    http_response_code(403);
    echo "Access denied.";
    exit();
}
