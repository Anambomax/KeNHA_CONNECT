<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo 'unauthorized';
    exit();
}

$user_email = $_SESSION['email'];

// Fetch user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$user_email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    http_response_code(403);
    echo 'user not found';
    exit();
}

$user_id = $user['id'];
$feedback_id = $_POST['feedback_id'] ?? null;
$type = $_POST['type'] ?? null;

$valid_types = ['like', 'dislike', 'star'];
if (!$feedback_id || !in_array($type, $valid_types)) {
    http_response_code(400);
    echo 'invalid data';
    exit();
}

try {
    // Check if user already reacted to this feedback
    $stmt = $conn->prepare("SELECT id, type FROM reactions WHERE feedback_id = ? AND user_id = ?");
    $stmt->execute([$feedback_id, $user_id]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        if ($existing['type'] === $type) {
            // Same reaction → remove it (toggle off)
            $stmt = $conn->prepare("DELETE FROM reactions WHERE id = ?");
            $stmt->execute([$existing['id']]);
        } else {
            // Different reaction → update
            $stmt = $conn->prepare("UPDATE reactions SET type = ?, created_at = NOW() WHERE id = ?");
            $stmt->execute([$type, $existing['id']]);
        }
    } else {
        // No existing reaction → insert new
        $stmt = $conn->prepare("INSERT INTO reactions (feedback_id, user_id, type) VALUES (?, ?, ?)");
        $stmt->execute([$feedback_id, $user_id, $type]);
    }

    echo 'success';
} catch (PDOException $e) {
    http_response_code(500);
    echo 'db error';
}
