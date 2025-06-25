<?php
session_start();
include("includes/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$res = $conn->query("SELECT * FROM incidents WHERE user_id = $user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <div class="d-flex justify-content-between mb-3">
    <h4>Welcome, <?= $_SESSION['user_name'] ?>!</h4>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>

  <a href="add_incident.php" class="btn btn-primary mb-3">+ Report Incident</a>

  <h5>Your Reported Incidents</h5>
  <div class="list-group">
    <?php while ($row = $res->fetch_assoc()): ?>
      <div class="list-group-item">
        <strong><?= htmlspecialchars($row['description']) ?></strong><br>
        <small>Status: <?= $row['status'] ?> | <?= $row['created_at'] ?></small><br>
        <?php if ($row['image_path']): ?>
          <img src="uploads/<?= $row['image_path'] ?>" width="100" class="mt-2">
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
