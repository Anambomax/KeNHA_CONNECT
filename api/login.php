<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // Prepare and execute user lookup
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['county'] = $user['county'] ?? 'Nairobi';

            // REDIRECTION based on role
            $role = strtoupper($user['role']); // Normalize role case
            if ($role === 'ADMIN') {
                header("Location: ../admin/dashboard.php");
                exit();
            } else {
                header("Location: ../dashboard.php");
                exit();
            }
        } else {
            // Login failed
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        // Handle database error
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        header("Location: ../index.php");
        exit();
    }
} else {
    // Block direct GET access
    http_response_code(403);
    echo "Access Denied.";
    exit();
}
