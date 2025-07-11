<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // ✅ Set session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['county']    = $user['county'] ?? 'Nairobi';

            // ✅ Redirect to dashboard
            header("Location: ../dashboard.php?role={$user['role']}");
            exit();
        }

        // ❌ Invalid
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: ../public/index.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        header("Location: ../public/index.php");
        exit();
    }

} else {
    http_response_code(403);
    echo "Access denied.";
    exit();
}
