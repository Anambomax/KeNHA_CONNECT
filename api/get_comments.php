<?php
require_once 'config.php';

$feedback_id = $_GET['feedback_id'];

$stmt = $conn->prepare("SELECT c.comment, c.created_at, u.full_name FROM comments c JOIN users u ON c.user = u.id WHERE feedback = ? ORDER BY c.created_at ASC");
$stmt->execute([$feedback_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($comments);
?>
