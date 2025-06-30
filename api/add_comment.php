<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method"]);
    exit();
}

$feedback_id = $_POST['feedback_id'] ?? null;
$comment = trim($_POST['comment'] ?? '');
$user = $_SESSION['user_name'] ?? 'Anonymous';

if (!$feedback_id || !$comment) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required fields"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO comments (feedback, user, comment) VALUES (?, ?, ?)");
$success = $stmt->execute([$feedback_id, $user, $comment]);

if ($success) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to save comment"]);
}
