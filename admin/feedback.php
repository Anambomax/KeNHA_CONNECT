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

        <!-- ✅ SUCCESS MESSAGE -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
            <div id="success-msg" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 1rem;">
                ✅ Feedback updated successfully!
            </div>
        <?php endif; ?>

        <?php if (count($feedback) > 0): ?>
        <table>
            <tr>
                <th>Reporter</th>
                <th>Department</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Assign To Admin</th>
                <th>Assign To Department</th>
                <th>Action</th>
            </tr>
            <?php foreach ($feedback as $row): ?>
            <tr>
                <form method="POST" action="../api/update_status.php">
        
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

                    <!-- Assign To Admin Dropdown -->
                    <td>
                        <select name="assigned_to">
                            <option value="">-- Select Admin --</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?= $admin['id'] ?>" <?= ($admin['id'] == $row['assigned_to']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($admin['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <!-- Assign To Department Dropdown -->
                    <td>
                        <select name="department">
                            <option value="">-- Select Department --</option>
                            <option value="Maintenance" <?= $row['department'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                            <option value="Drainage" <?= $row['department'] == 'Drainage' ? 'selected' : '' ?>>Drainage</option>
                            <option value="Traffic" <?= $row['department'] == 'Traffic' ? 'selected' : '' ?>>Traffic</option>
                            <option value="Safety" <?= $row['department'] == 'Safety' ? 'selected' : '' ?>>Safety</option>
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

    <!-- ✅ Auto-hide Success Message -->
    <script>
      setTimeout(() => {
        const msg = document.getElementById('success-msg');
        if (msg) msg.style.display = 'none';
      }, 3000);
    </script>
</body>
</html>
