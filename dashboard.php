<?php
session_start();
require_once 'api/config.php';

// ✅ General login check only
if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = strtolower($_SESSION['role']);
$email = $_SESSION['email'];
$full_name = $phone = $county = '';
$unread_count = 0;

// Get user info
try {
    $stmt = $conn->prepare("SELECT id, full_name, email, phone, county FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $user_id = $user['id'];
        $full_name = $user['full_name'];
        $phone = $user['phone'];
        $county = $user['county'];
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Get unread notification count
try {
    $stmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $unread_count = $result['unread_count'];
    }
} catch (PDOException $e) {
    // Log error if needed
}

// Fetch feedback posts
try {
    $stmt = $conn->prepare("SELECT * FROM feedback ORDER BY created_at DESC");
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $feedbacks = [];
}
?>

<!-- HTML Begins -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - KeNHA Connect</title>
  <link rel="stylesheet" href="public/css/style.css">
  <style>
    /* No style changes needed — already good */
  </style>
</head>
<body>

<?php if (isset($_SESSION['flash'])): ?>
  <div class="toast"><?= $_SESSION['flash']; ?></div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="dashboard-container">

  <!-- Sidebar -->
  <div class="sidebar">
    <img src="uploads/kenha-logo.png" alt="KeNHA Logo">
    <h2>KeNHA CONNECT</h2>
    <button class="tab-link active" onclick="openTab(event, 'home')">🏠 Home</button>
    <button class="tab-link" onclick="openTab(event, 'feed')">🧵 Feed</button>
    <button class="tab-link" onclick="openTab(event, 'news')">📰 News</button>

    <?php if ($role === 'staff'): ?>
      <button class="tab-link" onclick="openTab(event, 'staff')">🛠 Staff Tools</button>
    <?php endif; ?>

    <?php if ($role === 'admin'): ?>
      <button class="tab-link" onclick="openTab(event, 'admin')">⚙️ Admin Panel</button>
    <?php endif; ?>

    <button onclick="window.location.href='notifications.php'">
      🔔 Notifications
      <?php if ($unread_count > 0): ?>
        <span style="background:red;color:white;border-radius:50%;padding:2px 8px;font-size:12px;margin-left:5px;">
          <?= $unread_count ?>
        </span>
      <?php endif; ?>
    </button>

    <button onclick="window.location.href='api/logout.php'">🚪 Logout</button>
  </div>

  <!-- Main Content -->
  <div class="main-content">

    <!-- HOME TAB -->
    <div id="home" class="tab-content active">
      <h2 class="section-title">👋 Welcome, <?= htmlspecialchars($full_name); ?> (<?= strtoupper($role); ?>)</h2>

      <div class="info-box">
        <h3>📄 Your Profile</h3>
        <p><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($phone); ?></p>
        <p><strong>County:</strong> <?= htmlspecialchars($county); ?></p>
      </div>

      <div class="info-box">
        <h3>📘 About KeNHA Connect</h3>
        <p>KeNHA Connect is a feedback system that enables real-time communication between KeNHA and its stakeholders.</p>
      </div>
    </div>

    <!-- FEED TAB -->
    <div id="feed" class="tab-content">
      <h2 class="section-title">🧵 Feed</h2>
      <?php if (!empty($feedbacks)): ?>
        <?php foreach ($feedbacks as $f): ?>
          <div class="info-box">
            <strong><?= htmlspecialchars($f['user_name'] ?? 'Anonymous') ?> – <?= htmlspecialchars($f['location'] ?? 'Unknown') ?></strong><br>
            <small><?= date('M d, Y H:i', strtotime($f['created_at'])) ?></small>
            <div class="feedback-tags">
              <span><?= ucfirst($f['feedback_category']) ?></span>
              <span><?= ucfirst($f['feedback_subcategory']) ?></span>
              <?php if (!empty($f['details'])): ?>
                <span><?= ucfirst($f['details']) ?></span>
              <?php endif; ?>
            </div>
            <p><?= nl2br(htmlspecialchars($f['description'])) ?></p>
            <?php if (!empty($f['photo'])): ?>
              <img src="uploads/<?= htmlspecialchars($f['photo']) ?>" class="feedback-img" alt="Feedback Photo">
            <?php endif; ?>
            <div class="reaction-bar">
              <span>👍 0</span>
              <span>💬 0</span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No feedback available yet.</p>
      <?php endif; ?>
    </div>

    <!-- NEWS TAB -->
    <div id="news" class="tab-content">
      <h2 class="section-title">📰 News & Reports</h2>
      <p>Coming soon: updates on resolved issues, road projects, and public announcements.</p>
    </div>

    <!-- STAFF TAB -->
    <?php if ($role === 'staff'): ?>
      <div id="staff" class="tab-content">
        <h2 class="section-title">🛠 Staff Tools</h2>
        <div class="info-box">
          <p><a href="staff/view_assigned.php">📌 View Assigned Feedback</a></p>
          <p><a href="staff/resolve_feedback.php">✅ Mark Feedback as Resolved</a></p>
        </div>
      </div>
    <?php endif; ?>

    <!-- ADMIN TAB -->
    <?php if ($role === 'admin'): ?>
      <div id="admin" class="tab-content">
        <h2 class="section-title">⚙️ Admin Panel</h2>
        <div class="info-box">
          <p><a href="admin/manage_users.php">👥 Manage Users</a></p>
          <p><a href="admin/view_all_feedback.php">🧾 Moderate Feedback</a></p>
          <p><a href="admin/reports.php">📊 View Reports</a></p>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>

<!-- Floating Add Feedback Button -->
<a href="submit_feedback.php" class="floating-button">＋</a>

<script>
function openTab(evt, tabId) {
  document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab-link').forEach(btn => btn.classList.remove('active'));
  document.getElementById(tabId).classList.add('active');
  evt.currentTarget.classList.add('active');
}
</script>

</body>
</html>
