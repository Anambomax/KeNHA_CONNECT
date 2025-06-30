<?php
require_once 'config.php';

if (!isset($_GET['feedback_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing feedback ID"]);
    exit();
}

$feedback_id = intval($_GET['feedback_id']);

$stmt = $conn->prepare("
    SELECT 
        reaction_type, COUNT(*) AS count
    FROM 
        reactions
    WHERE 
        feedback = ?
    GROUP BY 
        reaction_type
");
$stmt->execute([$feedback_id]);
$reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format as key => count
$formatted = [];
foreach ($reactions as $r) {
    $formatted[$r['reaction_type']] = $r['count'];
}

header('Content-Type: application/json');
echo json_encode($formatted);
