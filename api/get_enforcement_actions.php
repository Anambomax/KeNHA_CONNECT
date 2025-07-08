<?php
include 'config.php';

header('Content-Type: application/json');

try {
    // Fetch monthly enforcement activity counts
    $stmt = $conn->query("SELECT 
        DATE_FORMAT(enforced_at, '%Y-%m') AS month, 
        COUNT(*) AS total, 
        SUM(CASE WHEN action_type = 'Stop' THEN 1 ELSE 0 END) AS stops,
        SUM(CASE WHEN action_type = 'Warning' THEN 1 ELSE 0 END) AS warnings
        FROM enforcement_actions
        GROUP BY month
        ORDER BY month ASC");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $results]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
