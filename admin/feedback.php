<?php
session_start();
include '../api/config.php';

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Prepare SQL to get feedback joined with user info
$query = "
    SELECT f.id, f.title, f.description, f.status, u.full_name AS reporter, u.department 
    FROM feedback f 
    JOIN users u ON f.user_id = u.id
";

try {
    $stmt = $conn->query($query);
    $feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving feedback: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Feedback - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>
    <div class="container">
        <h2>All Feedback</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Reporter</th>
                <th>Department</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
            <?php foreach ($feedback as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['reporter']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="footer">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
