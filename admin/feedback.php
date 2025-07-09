 <?php
session_start();
include '../api/config.php';

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Prepare SQL to get feedback joined with user info
$where = [];
$params = [];

// Filtering logic
if (!empty($_GET['status'])) {
    $where[] = "f.status = ?";
    $params[] = $_GET['status'];
}
if (!empty($_GET['department'])) {
    $where[] = "f.department = ?";
    $params[] = $_GET['department'];
}
if (!empty($_GET['assigned_to'])) {
    $where[] = "f.assigned_to = ?";
    $params[] = $_GET['assigned_to'];
}

$filterQuery = '';
if (count($where) > 0) {
    $filterQuery = 'WHERE ' . implode(' AND ', $where);
}

$query = "
    SELECT f.id, f.title, f.description, f.status, f.assigned_to, u.full_name AS reporter, f.department 
    FROM feedback f 
    JOIN users u ON f.user_id = u.id
    $filterQuery
";

// Fetch all admins for assignment
$admins = [];
try {
    $stmt2 = $conn->query("SELECT id, full_name FROM users WHERE role = 'admin'");
    $admins = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching admins: " . $e->getMessage());
}

// Fetch filtered feedback
try {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving feedback: " . $e->getMessage());
}

// Count filtered feedback statuses
$counts = [
    'total' => count($feedback),
    'pending' => 0,
    'in_progress' => 0,
    'resolved' => 0
];
foreach ($feedback as $f) {
    if ($f['status'] === 'pending') $counts['pending']++;
    elseif ($f['status'] === 'in_progress') $counts['in_progress']++;
    elseif ($f['status'] === 'resolved') $counts['resolved']++;
}

// Fetch overall stats (not affected by filter)
try {
    $stats = [
        'total' => $conn->query("SELECT COUNT(*) FROM feedback")->fetchColumn(),
        'pending' => $conn->query("SELECT COUNT(*) FROM feedback WHERE status = 'pending'")->fetchColumn(),
        'in_progress' => $conn->query("SELECT COUNT(*) FROM feedback WHERE status = 'in_progress'")->fetchColumn(),
        'resolved' => $conn->query("SELECT COUNT(*) FROM feedback WHERE status = 'resolved'")->fetchColumn(),
    ];
} catch (PDOException $e) {
    $stats = ['total' => 0, 'pending' => 0, 'in_progress' => 0, 'resolved' => 0];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Feedback - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <style>
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 1rem;
        }
        .stats .card {
            background: #f4f6f8;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .stats .card strong {
            color: #005baa;
        }
    </style>
</head>
<body>
    <div class="navbar">KeNHA Connect Admin Panel</div>
    <div class="container">
        <h2>All Feedback</h2>

        <!-- 🔢 Filter Summary Counts -->
        <?php if (!empty($_GET)): ?>
        <div style="margin: 1rem 0; padding: 10px; background-color: #eef5f9; border-left: 5px solid #005baa;">
            <strong>Filtered Feedback Summary:</strong><br>
            Showing <?= $counts['total'] ?> result(s) —
            Pending: <?= $counts['pending'] ?>,
            In Progress: <?= $counts['in_progress'] ?>,
            Resolved: <?= $counts['resolved'] ?>
        </div>
        <?php endif; ?>

        <!-- ✅ SUCCESS MESSAGE -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div id="success-msg" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 1rem;">
            ✅ Feedback updated successfully!
        </div>
        <?php endif; ?>

        <!-- 📊 FEEDBACK STATS -->
        <div class="stats">
            <div class="card">Total: <strong><?= $stats['total'] ?></strong></div>
            <div class="card">Pending: <strong><?= $stats['pending'] ?></strong></div>
            <div class="card">In Progress: <strong><?= $stats['in_progress'] ?></strong></div>
            <div class="card">Resolved: <strong><?= $stats['resolved'] ?></strong></div>
        </div>

        <!-- 🔍 FILTER FORM -->
        <form method="GET" style="margin-bottom: 1rem; display: flex; gap: 10px;">
            <select name="status">
                <option value="">Filter by Status</option>
                <option value="pending" <?= isset($_GET['status']) && $_GET['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="in_progress" <?= isset($_GET['status']) && $_GET['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="resolved" <?= isset($_GET['status']) && $_GET['status'] == 'resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>

            <select name="department">
                <option value="">Filter by Department</option>
                <option value="Maintenance" <?= isset($_GET['department']) && $_GET['department'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                <option value="Drainage" <?= isset($_GET['department']) && $_GET['department'] == 'Drainage' ? 'selected' : '' ?>>Drainage</option>
                <option value="Traffic" <?= isset($_GET['department']) && $_GET['department'] == 'Traffic' ? 'selected' : '' ?>>Traffic</option>
                <option value="Safety" <?= isset($_GET['department']) && $_GET['department'] == 'Safety' ? 'selected' : '' ?>>Safety</option>
            </select>

            <select name="assigned_to">
                <option value="">Filter by Assigned Admin</option>
                <?php foreach ($admins as $admin): ?>
                    <option value="<?= $admin['id'] ?>" <?= (isset($_GET['assigned_to']) && $_GET['assigned_to'] == $admin['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($admin['full_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Filter</button>
        </form>

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
                    <td>
                        <select name="status" required>
                            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="in_progress" <?= $row['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="resolved" <?= $row['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </td>
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
                    <td>
                        <select name="department">
                            <option value="">-- Select Department --</option>
                            <option value="Maintenance" <?= $row['department'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                            <option value="Drainage" <?= $row['department'] == 'Drainage' ? 'selected' : '' ?>>Drainage</option>
                            <option value="Traffic" <?= $row['department'] == 'Traffic' ? 'selected' : '' ?>>Traffic</option>
                            <option value="Safety" <?= $row['department'] == 'Safety' ? 'selected' : '' ?>>Safety</option>
                        </select>
                    </td>
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

    <script>
      setTimeout(() => {
        const msg = document.getElementById('success-msg');
        if (msg) msg.style.display = 'none';
      }, 3000);
    </script>
</body>
</html>
