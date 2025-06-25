<?php
session_start();
include("includes/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM incidents WHERE user_id = $user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; color: #000; }
    .card { border-left: 5px solid #ffc107; }
    .btn-yellow { background-color: #ffc107; border: none; color: black; }
    .btn-yellow:hover { background-color: #e0a800; }
  </style>
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 style="color: #ffc107;">Welcome, <?= $_SESSION['user_name'] ?></h4>
    <div>
      <a href="add_incident.php" class="btn btn-yellow">+ Report Incident</a>
      <a href="profile.php" class="btn btn-outline-dark">Profile</a>
      <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
  </div>
  <h5 class="mb-3">Your Reported Incidents</h5>
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card mb-3">
      <div class="card-body">
        <strong><?= htmlspecialchars($row['description']) ?></strong><br>
        <small>Status: <?= ucfirst($row['status']) ?> | <?= $row['created_at'] ?></small><br>
        <?php if ($row['image_path']): ?>
          <img src="uploads/<?= $row['image_path'] ?>" width="100" class="mt-2">
        <?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>
  <a href="public_channel.php" class="btn btn-outline-secondary mt-3">View Resolved Incidents</a>
</div>
</body>
</html>
