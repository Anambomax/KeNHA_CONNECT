<?php
/*  toggle_user_status.php
 *  Switch a user between active / inactive
 *  URL example: /api/toggle_user_status.php?id=7&status=inactive
 --------------------------------------------------------------- */
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    // only a logged‑in admin can toggle users
    header("Location: ../admin/login.php");
    exit();
}

$id     = $_GET['id']     ?? '';
$status = $_GET['status'] ?? '';

if (!$id || !in_array($status, ['active','inactive'])) {
    header("Location: ../admin/users.php?msg=bad_request");
    exit();
}

// update user row
try {
    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    header("Location: ../admin/users.php?msg=status_ok");
    exit();
} catch (PDOException $e) {
    // optional: log $e->getMessage()
    header("Location: ../admin/users.php?msg=status_fail");
    exit();
}
