<?php
session_start();
include("includes/config.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profile | KeNHA Connect</title>
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
  <h3 style="color: #ffc107;">Your Profile</h3>
  <div class="card shadow">
    <div class="card-body">
      <table class="table">
        <tr><th>Name</th><td><?= $user['name'] ?></td></tr>
        <tr><th>Email</th><td><?= $user['email'] ?></td></tr>
        <tr><th>County</th><td><?= $user['county'] ?></td></tr>
        <tr><th>Phone</th><td><?= $user['phone'] ?></td></tr>
        <tr><th>Joined</th><td><?= $user['created_at'] ?></td></tr>
      </table>
      <a href="dashboard.php" class="btn btn-outline-dark">Back</a>
    </div>
  </div>
</div>
</body>
</html>
