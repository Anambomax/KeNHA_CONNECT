<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "
   SELECT f.id, f.title, f.description, u.full_name 
    FROM feedback f
    JOIN users u ON f.user_id = u.id
    WHERE f.status = 'closed'
";

$stmt = $conn->query($query);
$resolved = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Resolved Feedback</title></head>
<body>
<h2>Resolved Feedback</h2>
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
</body>
</html>
