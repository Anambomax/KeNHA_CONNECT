<?php
require_once 'config.php';

if (!isset($_GET['feedback_id'])) {
    echo json_encode(['error' => 'Missing feedback ID']);
    exit;
}

$feedback_id = $_GET['feedback_id'];

try {
    $stmt = $conn->prepare("SELECT c.comment, c.created_at, u.full_name FROM comments c JOIN users u ON c.user = u.id WHERE c.feedback = ? ORDER BY c.created_at DESC");
    $stmt->execute([$feedback_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comments);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error fetching comments']);
}
