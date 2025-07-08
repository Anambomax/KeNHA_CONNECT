<?php
session_start();
include '../api/config.php';

// 🔐 Restrict access to traffic admins only
if (!isset($_SESSION['traffic_admin_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ Fetch all emergency contacts
try {
    $stmt = $conn->query("SELECT * FROM traffic_emergency_contacts");
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching emergency contacts: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Emergency Contacts - Traffic Dashboard</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #005baa;
            color: white;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">🚓 Traffic Admin Panel</div>
    <div class="container">
        <h2>📞 Emergency Contacts</h2>

        <?php if (count($contacts) > 0): ?>
            <table>
                <tr>
                    <th>Contact Name</th>
                    <th>Phone Number</th>
                    <th>Location</th>
                </tr>
                <?php foreach ($contacts as $row): ?>
                <tr>
                
                    <td><?= htmlspecialchars($row['contact_name']) ?></td>
                    <td><?= htmlspecialchars($row['phone_number']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p style="color: gray;">No emergency contacts available.</p>
        <?php endif; ?>

        <div class="footer">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
