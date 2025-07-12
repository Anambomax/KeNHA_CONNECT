<?php
require_once 'config.php';
header('Content-Type: application/json');

$feedback_id = $_GET['feedback_id'] ?? null;

if (!$feedback_id) {
    echo json_encode(['count' => 0, 'comments' => []]);
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT c.comment, c.created_at, u.full_name 
        FROM comments c 
        JOIN users u ON c.user = u.id 
        WHERE c.feedback = ? 
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$feedback_id]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'count' => count($comments),
        'comments' => $comments
    ]);
} catch (PDOException $e) {
    echo json_encode(['count' => 0, 'comments' => []]);
}
?>
