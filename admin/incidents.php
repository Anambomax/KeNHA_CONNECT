<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "
    SELECT i.id, i.title, i.description, i.status, u.full_name AS reporter, u.department 
    FROM incidents i 
    JOIN users u ON i.user_id = u.id
";

$stmt = $pdo->query($query);
$incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>All Incidents</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Reporter</th>
        <th>Department</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    <?php foreach ($incidents as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['reporter'] ?></td>
        <td><?= $row['department'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['status'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>
