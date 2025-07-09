<?php
session_start();
include '../api/config.php';

// Redirect if not logged in as traffic admin
if (!isset($_SESSION['traffic_admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch traffic-related feedback only
try {
    $stmt = $conn->prepare("
        SELECT f.id, f.title, f.description, f.status, u.full_name AS reporter, f.created_at
        FROM feedback f
        JOIN users u ON f.user_id = u.id
        WHERE f.department = 'Traffic'
        ORDER BY f.created_at DESC
    ");
    $stmt->execute();
    $feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching traffic feedback: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Traffic Incidents - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <style>
        textarea {
            resize: vertical;
            width: 100%;
        }
        table td select, table td button {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        Traffic Admin Panel | <?= $_SESSION['traffic_admin_name'] ?? 'Traffic Officer' ?> |
        <a href="logout.php" style="float:right;">Logout</a>
    </div>

    <div class="container">
        <h2>Traffic Incidents</h2>

        <?php if (count($feedback) > 0): ?>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Reported By</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
                <?php foreach ($feedback as $row): ?>
                <tr>
                    <form method="POST" action="../api/update_status.php">
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['reporter']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="department" value="Traffic">

                            <select name="status" required>
                                <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="in_progress" <?= $row['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="resolved" <?= $row['status'] == 'resolved' ? 'selected' : '' ?>>Resolved</option>
                            </select>

                            <textarea name="comment" rows="2" placeholder="Optional comment..."></textarea>
                            <button type="submit">Update</button>
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:gray;">No traffic feedback available.</p>
        <?php endif; ?>

        <div class="footer">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
