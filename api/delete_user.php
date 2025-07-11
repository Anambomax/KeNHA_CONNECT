<?php
/*  delete_user.php
 *  Permanently delete a user record
 *  URL example: /api/delete_user.php?id=7
 --------------------------------------------------------------- */
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}

$id = $_GET['id'] ?? '';

if (!$id) {
    header("Location: ../admin/users.php?msg=bad_request");
    exit();
}

// 🚨  Safety check: prevent admin from deleting themself
if ($id == $_SESSION['admin_id']) {
    header("Location: ../admin/users.php?msg=self_delete_blocked");
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: ../admin/users.php?msg=delete_ok");
    exit();
} catch (PDOException $e) {
    // optional: log $e->getMessage()
    header("Location: ../admin/users.php?msg=delete_fail");
    exit();
}
