<?php
include("includes/config.php");
$res = $conn->query("SELECT incidents.*, users.name FROM incidents 
                     JOIN users ON users.id = incidents.user_id
                     WHERE status = 'resolved' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Resolved Issues | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; color: #000; }
    .card { border-left: 5px solid #ffc107; }
    .btn-yellow { background-color: #ffc107; border: none; color: black; }
    .btn-yellow:hover { background-color: #e0a800; }
  </style>
</head>
<body>
<div class="container mt-5">
  <h3 style="color: #ffc107;">Public Channel – Resolved Issues</h3>
  <?php while ($row = $res->fetch_assoc()): ?>
    <div class="card mb-3">
      <div class="card-body">
        <strong><?= htmlspecialchars($row['description']) ?></strong><br>
        <small>By: <?= $row['name'] ?> | <?= $row['created_at'] ?></small><br>
        <?php if ($row['image_path']): ?>
          <img src="uploads/<?= $row['image_path'] ?>" width="100" class="mt-2">
        <?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>
  <a href="dashboard.php" class="btn btn-outline-dark">Back to Dashboard</a>
</div>
</body>
</html>
