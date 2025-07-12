<?php
require_once 'config.php';
session_start();

header('Content-Type: application/json');

$feedback_id = $_GET['feedback_id'] ?? null;

if (!$feedback_id) {
    echo json_encode(['counts' => ['like' => 0, 'dislike' => 0, 'star' => 0], 'user_reaction' => null]);
    exit;
}

try {
    // Get total reaction counts per type
    $stmt = $conn->prepare("
        SELECT type, COUNT(*) as total 
        FROM reactions 
        WHERE feedback = ?
        GROUP BY type
    ");
    $stmt->execute([$feedback_id]);

    $counts = ['like' => 0, 'dislike' => 0, 'star' => 0];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $counts[$row['type']] = (int)$row['total'];
    }

    // Get user's reaction if logged in
    $user_reaction = null;
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT type FROM reactions WHERE user = ? AND feedback = ?");
        $stmt->execute([$user_id, $feedback_id]);
        $user_reaction = $stmt->fetchColumn();
    }

    echo json_encode(['counts' => $counts, 'user_reaction' => $user_reaction]);
} catch (PDOException $e) {
    echo json_encode(['counts' => ['like' => 0, 'dislike' => 0, 'star' => 0], 'user_reaction' => null]);
}
?>
