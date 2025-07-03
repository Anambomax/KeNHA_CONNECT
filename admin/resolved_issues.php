<?php
session_start();
include '../api/config.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "
    SELECT f.id, f.title, f.description, f.status, u.full_name AS reporter, u.department
    FROM feedback f
    JOIN users u ON f.user_id = u.id
    WHERE f.status = 'Resolved'
";

try {
    $stmt = $conn->query($query);
    $resolved = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving resolved issues: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resolved Issues - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>
    <div class="navbar">KeNHA Connect Admin Panel</div>
    <div class="container">
        <h2>Resolved Issues</h2>

        <?php if (count($resolved) > 0): ?>
        <table>
            <tr></tr>
                <th>Reporter</th>
                <th>Department</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
            <?php foreach ($resolved as $row): ?>
            <tr>
                
                <td><?= htmlspecialchars($row['reporter']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <p style="text-align:center; color: gray;">No resolved issues found.</p>
        <?php endif; ?>

        <div class="footer">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
