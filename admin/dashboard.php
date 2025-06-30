<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
    <h1>Welcome, <?= $_SESSION['admin_name'] ?></h1>
    <ul>
        <li><a href="users.php">Manage Users</a></li>
        <li><a href="feedback.php">View Feedback</a></li>
        <li><a href="resolved_issues.php">Resolved Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
