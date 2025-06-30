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
$reaction_type = $_POST['reaction_type'] ?? null;
$user = $_SESSION['user_name'] ?? 'Anonymous';

$valid_reactions = ['like', 'dislike', 'love'];

if (!$feedback_id || !in_array($reaction_type, $valid_reactions)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

// Optional: Prevent duplicate reactions from same user
$stmt = $conn->prepare("SELECT * FROM reactions WHERE feedback = ? AND user = ?");
$stmt->execute([$feedback_id, $user]);
$existing = $stmt->fetch();

if ($existing) {
    // Update existing reaction
    $stmt = $conn->prepare("UPDATE reactions SET reaction_type = ?, created_at = NOW() WHERE feedback = ? AND user = ?");
    $stmt->execute([$reaction_type, $feedback_id, $user]);
} else {
    // Insert new reaction
    $stmt = $conn->prepare("INSERT INTO reactions (feedback, user, reaction_type) VALUES (?, ?, ?)");
    $stmt->execute([$feedback_id, $user, $reaction_type]);
}

echo json_encode(["success" => true]);
