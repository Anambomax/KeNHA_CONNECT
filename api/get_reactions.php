<?php
require_once 'config.php';

$feedback_id = $_GET['feedback_id'];

$stmt = $conn->prepare("SELECT type, COUNT(*) as count FROM reactions WHERE feedback = ? GROUP BY type");
$stmt->execute([$feedback_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = [
    'like' => 0,
    'dislike' => 0,
    'star' => 0
];

foreach ($results as $r) {
    $response[$r['type']] = (int)$r['count'];
}

echo json_encode($response);
?>
