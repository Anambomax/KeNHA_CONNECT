<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>All Users</title></head>
<body>
<h2>All Users</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Department</th>
    </tr>
    <?php foreach ($users as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['full_name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['role'] ?></td>
        <td><?= $row['department'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
