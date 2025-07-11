<?php
// api/reset_password.php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $defaultPassword = password_hash("Kenha@123", PASSWORD_DEFAULT); // Default reset password

    try {
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$defaultPassword, $userId]);
        header("Location: ../admin/users.php?msg=password_reset_ok");
    } catch (PDOException $e) {
        header("Location: ../admin/users.php?msg=password_reset_fail");
    }
} else {
    header("Location: ../admin/users.php?msg=bad_request");
}
