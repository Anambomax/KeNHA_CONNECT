<?php
require_once 'config.php';

if (!isset($_GET['feedback_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing feedback ID"]);
    exit();
}

$feedback_id = intval($_GET['feedback_id']);

$stmt = $conn->prepare("SELECT user, comment, created_at FROM comments WHERE feedback = ? ORDER BY created_at ASC");
$stmt->execute([$feedback_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($comments);
