<?php
session_start();
include '../db/connection.php';

if ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'ADMIN') {
  exit('Unauthorized');
}

$feedback_id = $_POST['feedback_id'];
$update_text = trim($_POST['update_text']);
$added_by = $_SESSION['id'];

$query = "INSERT INTO submissions (feedback_id, update_text, added_by) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "isi", $feedback_id, $update_text, $added_by);
mysqli_stmt_execute($stmt);

header("Location: ../staff_dashboard.php");
exit();
