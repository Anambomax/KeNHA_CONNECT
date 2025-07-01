<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = $_POST['feedback_id'];
    $type = $_POST['type'];
    $user = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM reactions WHERE feedback = ? AND user = ?");
    $stmt->execute([$feedback_id, $user]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $conn->prepare("UPDATE reactions SET type = ?, created_at = NOW() WHERE feedback = ? AND user = ?");
        $stmt->execute([$type, $feedback_id, $user]);
    } else {
        $stmt = $conn->prepare("INSERT INTO reactions (feedback, user, type, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$feedback_id, $user, $type]);
    }

    echo "success";
}
?>
