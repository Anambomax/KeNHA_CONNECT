<?php
require_once 'config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$feedback_id = $_POST['feedback_id'] ?? null;
$type = $_POST['type'] ?? null;

$valid_types = ['like', 'dislike', 'star'];

if (!$feedback_id || !in_array($type, $valid_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

try {
    // Remove existing reaction by user on this feedback
    $delete = $conn->prepare("DELETE FROM reactions WHERE user = ? AND feedback = ?");
    $delete->execute([$user_id, $feedback_id]);

    // Add new reaction
    $insert = $conn->prepare("INSERT INTO reactions (user, feedback, type) VALUES (?, ?, ?)");
    $insert->execute([$user_id, $feedback_id, $type]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
