<?php
session_start();
include("includes/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desc = trim($_POST["description"]);
    $user_id = $_SESSION["user_id"];
    $filename = "";

    if (!empty($_FILES["image"]["name"])) {
        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $filename);
    }

    $stmt = $conn->prepare("INSERT INTO incidents (user_id, description, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $desc, $filename);

    if ($stmt->execute()) {
        $msg = "Incident reported successfully.";
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
  <style>
    body { background-color: #f8f9fa; color: #000; }
    .card { border-left: 5px solid #ffc107; }
    .btn-yellow { background-color: #ffc107; border: none; color: black; }
    .btn-yellow:hover { background-color: #e0a800; }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="col-md-7 mx-auto">
    <div class="card shadow">
      <div class="card-body">
        <h4 style="color: #ffc107;">Report an Incident</h4>
        <?php if ($msg): ?><div class="alert alert-info"><?= $msg ?></div><?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Upload Image</label>
            <input type="file" name="image" class="form-control">
          </div>
          <button class="btn btn-yellow">Submit Report</button>
        </form>
        <a href="dashboard.php" class="btn btn-outline-dark mt-3">Back to Dashboard</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
