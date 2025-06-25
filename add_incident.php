<?php
session_start();
include("includes/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $desc = $_POST['description'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($tmp, $target);

    $stmt = $conn->prepare("INSERT INTO incidents (user_id, description, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $_SESSION['user_id'], $desc, $image);
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        $msg = "Failed to report incident.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Report Incident | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h4>Report New Incident</h4>
  <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Upload Photo</label>
      <input type="file" name="image" class="form-control" required>
    </div>
    <button class="btn btn-success">Submit Report</button>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>
