<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'config.php';

$response = [];

$query = "SELECT i.description, i.image, r.resolved_by, r.resolved_at 
          FROM resolved_issues r 
          JOIN incidents i ON r.incident_id = i.id 
          ORDER BY r.resolved_at DESC";

$result = $conn->query($query);

$reports = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}

$response['success'] = true;
$response['reports'] = $reports;

echo json_encode($response);
?>
