<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['username'];
$userData = $conn->query("SELECT id FROM users WHERE username='$user'")->fetch_assoc();
$user_id = $userData['id'];

$result = $conn->query("SELECT * FROM feedback WHERE user_id=$user_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Feedback</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>My Feedback</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <h2><?= htmlspecialchars($row['subject']) ?></h2>
            <span><?= htmlspecialchars($row['category']) ?> | <?= $row['created_at'] ?></span>
            <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
            <small>Status: <?= $row['status'] ?></small>
        </div>
        <hr>
    <?php } ?>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
