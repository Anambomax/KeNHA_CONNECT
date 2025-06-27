<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize POST data
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $county = $_POST['county'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Validate fields
    if (!$full_name || !$email || !$phone || !$county || !$password || !$confirm) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (!preg_match('/^07[0-9]{8}$/', $phone)) {
        die("Phone number must start with 07 and be 10 digits.");
    }

    if ($password !== $confirm) {
        die("Passwords do not match.");
    }

    // Check for existing email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        die("Email already registered.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, county, password) 
                            VALUES (:full_name, :email, :phone, :county, :password)");
    $stmt->execute([
        'full_name' => $full_name,
        'email' => $email,
        'phone' => $phone,
        'county' => $county,
        'password' => $hashed_password
    ]);

    // Set session and redirect
    $_SESSION['user_id'] = $conn->lastInsertId();
    $_SESSION['email'] = $email;

    header("Location: ../public/dashboard.php");
    exit();
} else {
    die("Invalid request method.");
}
?>
