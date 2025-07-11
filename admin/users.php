<?php
session_start();
include '../api/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$currentAdminId = $_SESSION['admin_id'];

// Handle Add User form
if (isset($_POST['add_user'])) {
    $full_name  = $_POST['full_name'];
    $email      = $_POST['email'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role       = $_POST['role'];
    $department = $_POST['department'];
    $status     = $_POST['status'];

    try {
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, department, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $password, $role, $department, $status]);
        header("Location: users.php?msg=add_success");
        exit();
    } catch (PDOException $e) {
        header("Location: users.php?msg=add_fail");
        exit();
    }
}

// Fetch all users
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Users - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            min-width: 800px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f4f6f9;
        }
        a.button, button.button {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
        a.button.red { background-color: #dc3545; }
        a.button.gray { background-color: #6c757d; }
        .navbar {
            background-color: #005baa;
            color: white;
            padding: 10px 20px;
            font-size: 20px;
        }
        .container {
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
        }
        #addUserForm {
            display: none;
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #f9f9f9;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
        }
        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
    </style>
</head>
<body>

<div class="navbar">Admin Panel | Manage Users</div>
<div class="container">

    <h2>All Users</h2>

    <!-- Alert Messages -->
    <?php
    $alerts = [
        'add_success'         => '✅ New user added.',
        'add_fail'            => '❌ Failed to add user.',
        'status_ok'           => '✅ User status updated.',
        'status_fail'         => '❌ Failed to update status.',
        'delete_ok'           => '✅ User deleted.',
        'delete_fail'         => '❌ Failed to delete user.',
        'self_delete_blocked' => '❌ You cannot delete your own account.',
        'bad_request'         => '❌ Bad request.',
        'password_reset_ok'   => '✅ Password reset to default.',
'password_reset_fail' => '❌ Failed to reset password.'

    ];
    if (isset($_GET['msg']) && isset($alerts[$_GET['msg']])) {
        echo "<div style='margin:10px 0; padding:10px; background:#e9f6ff; border-left:5px solid #005baa;'>" . $alerts[$_GET['msg']] . "</div>";
    }
    ?>

    <!-- Toggle Add User Form Button -->
    <button class="button" onclick="toggleAddUserForm()">➕ Add New User</button>

    <!-- Add User Form -->
    <div id="addUserForm">
        <form method="POST" action="">
            <h3>Add New User</h3>
            <label>Full Name:</label>
            <input type="text" name="full_name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

            <label>Department:</label>
            <select name="department" required>
                <option value="Maintenance">Maintenance</option>
                <option value="Drainage">Drainage</option>
                <option value="Traffic">Traffic</option>
                <option value="Safety">Safety</option>
            </select>

            <label>Status:</label>
            <select name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="disable">Disable</option>
            </select>

            <button type="submit" name="add_user" class="button">Save User</button>
        </form>
    </div>

    <!-- User table -->
    <table>
        <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Department</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= htmlspecialchars($user['department']) ?></td>
            <td><?= htmlspecialchars($user['status'] ?? 'active') ?></td>
            <td>
                <div class="button-group">
                    <a href="edit_user.php?id=<?= $user['id'] ?>" class="button">Edit</a>

<?php if ($user['id'] != $currentAdminId): ?>
    <?php $status = $user['status'] ?? 'active'; ?>
    <?php if ($status === 'inactive' || $status === 'disable'): ?>
        <a href="../api/toggle_user_status.php?id=<?= $user['id'] ?>&status=active" class="button">Activate</a>
    <?php else: ?>
        <a href="../api/toggle_user_status.php?id=<?= $user['id'] ?>&status=inactive" class="button gray">Deactivate</a>
    <?php endif; ?>

    <a href="../api/delete_user.php?id=<?= $user['id'] ?>" class="button red" onclick="return confirm('Delete this user?');">Delete</a>
    <!-- ✅ Reset Password button -->
    <a href="../api/reset_password.php?id=<?= $user['id'] ?>" class="button" onclick="return confirm('Reset this user\'s password to default?');">Reset Password</a>
<?php else: ?>
    <span style="color: gray;">(You)</span>
<?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="footer">
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</div>

<script>
function toggleAddUserForm() {
    const form = document.getElementById("addUserForm");
    form.style.display = form.style.display === "none" ? "block" : "none";
}
</script>

</body>
</html>
