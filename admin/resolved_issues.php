<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "
    SELECT i.id, i.title, i.description, u.full_name 
    FROM incidents i 
    JOIN users u ON i.user_id = u.id 
    WHERE i.status = 'closed'
";

$stmt = $pdo->query($query);
$resolved = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Resolved Incidents</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Reporter</th>
        <th>Title</th>
        <th>Description</th>
    </tr>
    <?php foreach ($resolved as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['full_name'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['description'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="dashboard.php">Back to Dashboard</a>
