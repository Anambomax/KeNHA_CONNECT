<?php
require 'config.php';
header('Content-Type: application/json');

$postId = $_GET['post'] ?? null;

if (!$postId) {
    echo json_encode(['status' => 'error', 'message' => 'Post ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("SELECT full_name, comment, created_at FROM comments WHERE post = ? ORDER BY created_at ASC");
    $stmt->execute([$postId]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $comments]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
