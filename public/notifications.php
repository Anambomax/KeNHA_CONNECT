<?php
session_start();
require_once '../api/config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];
$user_id = 0;
$notifications = [];

// Get user ID
try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $user_id = $user['id'];
    } else {
        die("User not found.");
    }
} catch (PDOException $e) {
    die("Error fetching user ID: " . $e->getMessage());
}

// Mark all as read
try {
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user = ? AND is_read = 0");
    $stmt->execute([$user_id]);
} catch (PDOException $e) {
    // optional: log error
}

// Fetch notifications
try {
    $stmt = $conn->prepare("SELECT * FROM notifications WHERE user = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching notifications: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Notifications - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f8;
      padding: 40px;
    }

    .notification-title {
      font-size: 28px;
      color: #012c57;
      margin-bottom: 25px;
    }

    .info-box {
      background: white;
      padding: 20px 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    .info-box p {
      font-size: 16px;
      margin-bottom: 8px;
    }

    .info-box small {
      color: #888;
    }

    .back-button {
      display: inline-block;
      margin-bottom: 30px;
      text-decoration: none;
      background-color: #012c57;
      color: white;
      padding: 10px 18px;
      border-radius: 6px;
    }

    .delivered {
      color: green;
      font-weight: bold;
    }

    .not-delivered {
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>

<a href="dashboard.php" class="back-button">← Back to Dashboard</a>

<h2 class="notification-title">🔔 My Notifications</h2>

<?php if (!empty($notifications)): ?>
  <?php foreach ($notifications as $n): ?>
    <div class="info-box">
      <p><?= htmlspecialchars($n['message']) ?></p>
      <small>
        <?= date('M d, Y H:i', strtotime($n['created_at'])) ?> |
        <?= $n['notified'] ? '<span class="delivered">✅ Delivered</span>' : '<span class="not-delivered">❌ Not Delivered</span>' ?>
      </small>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>You have no notifications yet.</p>
<?php endif; ?>

</body>
</html>
