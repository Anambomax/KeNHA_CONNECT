<?php
require 'config.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$full_name = $_SESSION['full_name'];
$email = $_SESSION['email'];
$post = $_POST['post'] ?? null;
$comment = trim($_POST['comment'] ?? '');

if (!$post || !$comment) {
    echo json_encode(['status' => 'error', 'message' => 'Post ID and comment are required']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO comments (post, full_name, email, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$post, $full_name, $email, $comment]);

    echo json_encode(['status' => 'success', 'message' => 'Comment added']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
