<?php
session_start();
require_once '../api/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../index.php");
    exit();
}

$department = $_SESSION['department'] ?? 'General';

try {
    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM feedback WHERE assigned_department = ?");
    $stmt2 = $conn->prepare("SELECT COUNT(*) FROM feedback WHERE assigned_department = ? AND status = 'Resolved'");
    $stmt3 = $conn->prepare("SELECT COUNT(*) FROM feedback WHERE assigned_department = ? AND (status IS NULL OR status = 'Pending')");

    $stmt1->execute([$department]);
    $stmt2->execute([$department]);
    $stmt3->execute([$department]);

    $total = $stmt1->fetchColumn();
    $resolved = $stmt2->fetchColumn();
    $pending = $stmt3->fetchColumn();

} catch (PDOException $e) {
    die("Error fetching stats: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Department Overview - KeNHA Connect</title>
  <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
  <h2>📊 <?= htmlspecialchars($department) ?> Department Overview</h2>
  <div class="info-box">
    <p><strong>Total Assigned:</strong> <?= $total ?></p>
    <p><strong>Resolved:</strong> <?= $resolved ?></p>
    <p><strong>Pending:</strong> <?= $pending ?></p>
  </div>
  <a href="view_assigned.php">📌 View Assigned Feedback</a>
</body>
</html>
