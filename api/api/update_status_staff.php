<?php
session_start();
include '../db/connection.php';

// ✅ Ensure user is logged in and is staff
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'staff') {
  exit('Unauthorized access');
}

// ✅ Get values from form
$feedback_id = $_POST['feedback_id'] ?? null;
$new_status = $_POST['status'] ?? null;

// ✅ Validate input
$allowed_statuses = ['pending', 'resolved', 'escalated'];
if (!$feedback_id || !$new_status || !in_array($new_status, $allowed_statuses)) {
  exit('Invalid input');
}

// ✅ Update the feedback status
$stmt = $conn->prepare("UPDATE feedback SET status = ? WHERE id = ?");
$stmt->bind_param("si", $new_status, $feedback_id);
$stmt->execute();

// ✅ Redirect back to staff dashboard
header("Location: ../staff_dashboard.php");
exit();
