<?php
session_start();
require_once "../db/db.php";

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'staff') {
    http_response_code(403);
    exit("Unauthorized");
}

$id = $_POST['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("UPDATE feedback SET status = 'resolved' WHERE id = ?");
    $stmt->execute([$id]);
    echo "Feedback marked as resolved.";
} else {
    echo "Missing feedback ID.";
}
