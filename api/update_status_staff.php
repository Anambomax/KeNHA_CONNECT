<?php
session_start();
include '../db/connection.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'staff') {
  exit('Unauthorized access');
}

$feedback_id = $_POST['feedback_id'] ?? null;
$new_status = $_POST['status'] ?? null;

$allowed_statuses = ['pending', 'resolved', 'escalated'];
if (!$feedback_id || !in_array($new_status, $allowed_statuses)) {
  exit('Invalid status');
}

$stmt = $conn->prepare("UPDATE feedback SET status = ? WHERE id = ?");
$stmt->bind_param("si", $new_status, $feedback_id);
$stmt->execute();

header("Location: ../staff/staff_dashboard.php");
exit();
