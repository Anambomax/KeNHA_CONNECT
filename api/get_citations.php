<?php
include 'config.php';
header('Content-Type: application/json');

try {
    // Basic filters (optional)
    $filters = [];
    $params = [];

    if (!empty($_GET['violation_type'])) {
        $filters[] = "violation_type = ?";
        $params[] = $_GET['violation_type'];
    }

    if (!empty($_GET['location'])) {
        $filters[] = "location LIKE ?";
        $params[] = '%' . $_GET['location'] . '%';
    }

    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $filters[] = "issued_at BETWEEN ? AND ?";
        $params[] = $_GET['start_date'] . " 00:00:00";
        $params[] = $_GET['end_date'] . " 23:59:59";
    }

    $where = count($filters) > 0 ? ('WHERE ' . implode(' AND ', $filters)) : '';

    $sql = "SELECT id, citation_number, violation_type, location, officer_name, issued_at 
            FROM traffic_citations 
            $where
            ORDER BY issued_at DESC 
            LIMIT 100";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $citations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $citations]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
