<link rel="stylesheet" href="../public/css/admin.css">
<?php
include '../api/config.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
$result = $conn->query("SELECT * FROM users");
?>
<h2>All Users</h2>
<table border="1">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Department</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['full_name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['role'] ?></td>
        <td><?= $row['department'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="dashboard.php">Back to Dashboard</a>
