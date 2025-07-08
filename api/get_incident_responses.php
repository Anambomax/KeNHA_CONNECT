<?php
// File: api/get_incident_responses.php

include 'config.php';
header('Content-Type: application/json');

try {
    // Get optional filters
    $location = $_GET['location'] ?? null;
    $date_from = $_GET['from'] ?? null;
    $date_to = $_GET['to'] ?? null;

    $conditions = [];
    $params = [];

    if (!empty($location)) {
        $conditions[] = "location LIKE ?";
        $params[] = "%$location%";
    }
    if (!empty($date_from)) {
        $conditions[] = "responded_at >= ?";
        $params[] = $date_from;
    }
    if (!empty($date_to)) {
        $conditions[] = "responded_at <= ?";
        $params[] = $date_to;
    }

    $whereSQL = count($conditions) ? ('WHERE ' . implode(' AND ', $conditions)) : '';

    $stmt = $conn->prepare("SELECT id, incident_type, location, responded_at, officer_in_charge FROM incident_responses $whereSQL ORDER BY responded_at DESC LIMIT 100");
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
