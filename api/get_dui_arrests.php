<?php
include '../config.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT COUNT(*) AS total, 
                                 DATE_FORMAT(arrest_date, '%Y-%m') AS month
                          FROM dui_arrests
                          GROUP BY month
                          ORDER BY month ASC");

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $results]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error fetching DUI arrests data', 'error' => $e->getMessage()]);
}
