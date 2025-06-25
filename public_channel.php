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
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3>Public Channel – Resolved Issues</h3>
  <div class="list-group">
    <?php while ($row = $res->fetch_assoc()): ?>
      <div class="list-group-item">
        <strong><?= htmlspecialchars($row['description']) ?></strong><br>
        <small>By: <?= $row['name'] ?> | <?= $row['created_at'] ?></small><br>
        <?php if ($row['image_path']): ?>
          <img src="uploads/<?= $row['image_path'] ?>" width="100" class="mt-2">
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
  <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
</body>
</html>
