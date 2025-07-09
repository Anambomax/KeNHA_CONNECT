<?php
// get_speed_violations.php
header('Content-Type: application/json');
include 'config.php';

try {
    $query = "
        SELECT 
            DATE_FORMAT(date_reported, '%Y-%m') AS month,
            COUNT(*) AS total,
            SUM(CASE WHEN speed > 100 THEN 1 ELSE 0 END) AS over_100,
            SUM(CASE WHEN speed > 120 THEN 1 ELSE 0 END) AS over_120,
            SUM(CASE WHEN speed > 140 THEN 1 ELSE 0 END) AS over_140
        FROM speed_violations
        GROUP BY month
        ORDER BY month DESC
        LIMIT 12
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
