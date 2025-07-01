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
    SELECT f.id, f.title, f.description, f.status, f.assigned_to, u.full_name AS reporter, u.department 
    FROM feedback f 
    JOIN users u ON f.user_id = u.id
";

// Fetch all admins for assignment
$admins = [];
try {
    $stmt2 = $conn->query("SELECT id, full_name FROM users WHERE role = 'admin'");
    $admins = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching admins: " . $e->getMessage());
}

// Fetch all feedback
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
    <div class="navbar">KeNHA Connect Admin Panel</div>
    <div class="container">
        <h2>All Feedback</h2>
        <?php if (count($feedback) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Reporter</th>
                <th>Department</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Assign To</th>
                <th>Action</th>
            </tr>
            <?php foreach ($feedback as $row): ?>
            <tr>
                <form method="POST" action="../api/update_status.php">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['reporter']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>

                    <!-- Status Dropdown -->
                    <td>
                        <select name="status" required>
                            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="in_progress" <?= $row['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="resolved" <?= $row['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </td>

                    <!-- Assign Dropdown -->
                    <td>
                        <select name="assigned_to" required>
                            <option value="">--Assign--</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?= $admin['id'] ?>" <?= ($row['assigned_to'] == $admin['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($admin['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <!-- Hidden Inputs + Submit -->
                    <td>
                        <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
                        <button type="submit">Update</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p style="text-align:center; color: gray;">No feedback submitted yet.</p>
        <?php endif; ?>

        <div class="footer">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
