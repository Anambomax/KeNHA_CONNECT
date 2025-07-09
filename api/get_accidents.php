<?php
// File: api/traffic/get_accidents.php
header('Content-Type: application/json');
include '../config.php';

try {
    // Group by severity and date (optional)
    $stmt = $conn->query("SELECT severity, COUNT(*) AS count FROM accidents GROUP BY severity");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $results
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
