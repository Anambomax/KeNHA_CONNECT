<?php
include 'config.php';

$result = $conn->query("SELECT i.*, u.name as user FROM incidents i JOIN users u ON i.user_id = u.id ORDER BY date_reported DESC");

$incidents = [];
while ($row = $result->fetch_assoc()) {
  $incidents[] = $row;
}
echo json_encode($incidents);
?>
