<?php
require_once 'config.php';

$feedback_id = $_GET['feedback_id'] ?? null;
if (!$feedback_id) {
    echo json_encode([]);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT type, COUNT(*) as count FROM reactions WHERE feedback_id = ? GROUP BY type");
    $stmt->execute([$feedback_id]);
    $counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['like' => 5, 'dislike' => 1]
    echo json_encode($counts);
} catch (PDOException $e) {
    echo json_encode([]);
}
