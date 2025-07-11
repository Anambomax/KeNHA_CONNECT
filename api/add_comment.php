<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email']) || !isset($_POST['feedback_id']) || !isset($_POST['comment'])) {
    http_response_code(400);
    echo 'Invalid request';
    exit;
}

$email = $_SESSION['email'];
$feedback_id = $_POST['feedback_id'];
$comment = trim($_POST['comment']);

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $user['id'];

$stmt = $conn->prepare("INSERT INTO comments (feedback, user, comment, created_at) VALUES (?, ?, ?, NOW())");
$stmt->execute([$feedback_id, $user_id, $comment]);

echo 'success';
