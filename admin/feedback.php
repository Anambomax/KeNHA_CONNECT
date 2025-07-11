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

$filterQuery = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

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
$counts = ['total' => count($feedback), 'pending' => 0, 'in_progress' => 0, 'resolved' => 0];
foreach ($feedback as $f) {
    if ($f['status'] === 'pending') $counts['pending']++;
    elseif ($f['status'] === 'in_progress') $counts['in_progress']++;
    elseif ($f['status'] === 'resolved') $counts['resolved']++;
}

// Overall stats
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
            flex-wrap: wrap;
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

        .table-container {
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        select, button {
            padding: 5px;
        }

        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="navbar">KeNHA Connect Admin Panel</div>
    <div class="container">
        <h2>All Feedback</h2>

        <!-- Filter Summary -->
        <?php if (!empty($_GET)): ?>
        <div style="margin: 1rem 0; padding: 10px; background-color: #eef5f9; border-left: 5px solid #005baa;">
            <strong>Filtered Feedback Summary:</strong><br>
            Showing <?= $counts['total'] ?> result(s) —
            Pending: <?= $counts['pending'] ?>,
            In Progress: <?= $counts['in_progress'] ?>,
            Resolved: <?= $counts['resolved'] ?>
        </div>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div id="success-msg" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 1rem;">
            ✅ Feedback updated successfully!
        </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="stats">
            <div class="card">Total: <strong><?= $stats['total'] ?></strong></div>
            <div class="card">Pending: <strong><?= $stats['pending'] ?></strong></div>
            <div class="card">In Progress: <strong><?= $stats['in_progress'] ?></strong></div>
            <div class="card">Resolved: <strong><?= $stats['resolved'] ?></strong></div>
        </div>

        <!-- Filters -->
        <form method="GET" style="margin-bottom: 1rem; display: flex; gap: 10px; flex-wrap: wrap;">
            <select name="status">
                <option value="">Filter by Status</option>
                <option value="pending" <?= $_GET['status'] ?? '' === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="in_progress" <?= $_GET['status'] ?? '' === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="resolved" <?= $_GET['status'] ?? '' === 'resolved' ? 'selected' : '' ?>>Resolved</option>
            </select>

            <select name="department">
                <option value="">Filter by Department</option>
                <?php foreach (['Maintenance', 'Drainage', 'Traffic', 'Safety'] as $dept): ?>
                    <option value="<?= $dept ?>" <?= ($_GET['department'] ?? '') === $dept ? 'selected' : '' ?>><?= $dept ?></option>
                <?php endforeach; ?>
            </select>

            <select name="assigned_to">
                <option value="">Filter by Assigned Admin</option>
                <?php foreach ($admins as $admin): ?>
                    <option value="<?= $admin['id'] ?>" <?= ($_GET['assigned_to'] ?? '') == $admin['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($admin['full_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Filter</button>
            <a href="feedback.php" style="text-decoration:none; padding:6px 12px; background:#ccc; border-radius:4px; color:black;">Clear</a>
        </form>

        <!-- Table -->
        <?php if (count($feedback) > 0): ?>
        <div class="table-container">
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
                            <?php foreach (['pending', 'in_progress', 'resolved'] as $s): ?>
                                <option value="<?= $s ?>" <?= $row['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="assigned_to">
                            <option value="">-- Select Admin --</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?= $admin['id'] ?>" <?= $admin['id'] == $row['assigned_to'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($admin['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="department">
                            <option value="">-- Select Department --</option>
                            <?php foreach (['Maintenance', 'Drainage', 'Traffic', 'Safety'] as $dept): ?>
                                <option value="<?= $dept ?>" <?= $row['department'] == $dept ? 'selected' : '' ?>><?= $dept ?></option>
                            <?php endforeach; ?>
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
        </div>
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
