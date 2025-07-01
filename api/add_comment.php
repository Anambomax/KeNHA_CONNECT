<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = $_POST['feedback_id'];
    $comment = trim($_POST['comment']);
    $user = $_SESSION['user_id'];

    if ($comment === '') {
        http_response_code(400);
        echo "Empty comment.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO comments (feedback, user, comment, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$feedback_id, $user, $comment]);
    echo "success";
}
?>
