<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: index.php");
  exit();
}

require_once '../api/config.php';

// Get user info
$email = $_SESSION['email'];
$full_name = $phone = $county = '';

try {
  $stmt = $conn->prepare("SELECT full_name, email, phone, county FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $full_name = $user['full_name'];
    $email = $user['email'];
    $phone = $user['phone'];
    $county = $user['county'];
  }
} catch (PDOException $e) {
  die("Error fetching user info: " . $e->getMessage());
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f2f4f7;
    }

    .dashboard-container {
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 220px;
      background-color: #012c57;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 20px;
    }

    .sidebar img.logo {
      width: 80px;
      margin-bottom: 10px;
    }

    .sidebar h2 {
      font-size: 18px;
      margin-bottom: 30px;
      text-align: center;
    }

    .nav-menu {
      list-style: none;
      padding: 0;
      width: 100%;
    }

    .nav-menu li {
      width: 100%;
    }

    .nav-menu button {
      width: 100%;
      padding: 15px;
      background: none;
      color: white;
      border: none;
      text-align: left;
      cursor: pointer;
      font-size: 15px;
      transition: background 0.3s;
    }

    .nav-menu button:hover, .nav-menu .active {
      background-color: #03457e;
    }

    .main-content {
      flex: 1;
      padding: 30px;
      overflow-y: auto;
      position: relative;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .section-title {
      font-size: 22px;
      margin-bottom: 10px;
      color: #012c57;
    }

    .info-box {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 25px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .info-box ul {
      padding-left: 20px;
    }

    .feedback-tags span {
      background: #e0f0ff;
      color: #003366;
      padding: 5px 12px;
      border-radius: 20px;
      margin-right: 8px;
      display: inline-block;
      margin-top: 5px;
    }

    .feedback-img {
      margin-top: 10px;
      max-width: 100%;
      border-radius: 8px;
    }

    .floating-button {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background-color: #003366;
      color: white;
      font-size: 28px;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      line-height: 60px;
      text-align: center;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      z-index: 1000;
      text-decoration: none;
    }

    @media (max-width: 768px) {
      .dashboard-container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
      }
      .nav-menu li {
        display: inline-block;
      }
    }
  </style>
</head>
<body>

<div class="dashboard-container">
  <!-- Sidebar -->
  <div class="sidebar">
    <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="logo">
    <h2>KeNHA CONNECT</h2>
    <ul class="nav-menu">
      <li><button class="tab-link active" onclick="openTab(event, 'home')">🏠 Home</button></li>
      <li><button class="tab-link" onclick="openTab(event, 'feed')">🧵 Feed</button></li>
      <li><button class="tab-link" onclick="openTab(event, 'news')">📰 News</button></li>
      <li><button onclick="window.location.href='logout.php'">🚪 Logout</button></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- HOME TAB -->
    <div id="home" class="tab-content active">
      <h2 class="section-title">Welcome, <?= htmlspecialchars($full_name); ?>!</h2>
      <div class="info-box">
        <h3>📄 Your Profile Information</h3>
        <p><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($phone); ?></p>
        <p><strong>County:</strong> <?= htmlspecialchars($county); ?></p>
      </div>

      <div class="info-box">
        <h3>📌 Vision</h3>
        <p>To provide an efficient, transparent, and user-friendly platform for reporting, tracking, and resolving road infrastructure issues across Kenya.</p>
      </div>

      <div class="info-box">
        <h3>📌 Mission</h3>
        <p>To empower citizens and enable real-time communication with KeNHA departments for better road safety and service delivery.</p>
      </div>

      <div class="info-box">
        <h3>📘 How KeNHA Connect Works</h3>
        <ul>
          <li>Citizens register and log in to report road incidents.</li>
          <li>Reports are directed to relevant KeNHA departments.</li>
          <li>Staff respond and update issue statuses.</li>
          <li>The public can view updates, react, and comment on reports.</li>
        </ul>
      </div>
    </div>

    <!-- FEED TAB -->
    <div id="feed" class="tab-content">
      <h2 class="section-title">🧵 Feed</h2>
      <?php if (!empty($feedbacks)): ?>
        <?php foreach ($feedbacks as $row): ?>
          <div class="info-box">
            <strong><?= htmlspecialchars($row['user_name']) ?> (<?= htmlspecialchars($row['location']) ?>)</strong><br>
            <small><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></small>
            <div class="feedback-tags">
              <span><?= ucfirst($row['feedback_category']) ?></span>
              <span><?= ucfirst($row['feedback_subcategory']) ?></span>
              <?php if (!empty($row['details'])): ?>
                <span><?= ucfirst($row['details']) ?></span>
              <?php endif; ?>
            </div>
            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <?php if (!empty($row['photo'])): ?>
              <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" class="feedback-img" alt="Feedback Photo">
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No feedback has been posted yet.</p>
      <?php endif; ?>
    </div>

    <!-- NEWS TAB -->
    <div id="news" class="tab-content">
      <h2 class="section-title">📰 News & Reports</h2>
      <p>Coming soon: View public reports, analytics, and resolved cases.</p>
    </div>
  </div>
</div>

<!-- Floating Add Feedback Button -->
<a href="submit_feedback.php" class="floating-button" title="Submit Feedback">＋</a>

<!-- JS to switch tabs -->
<script>
  function openTab(evt, tabId) {
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(c => c.classList.remove('active'));

    const links = document.querySelectorAll('.tab-link');
    links.forEach(l => l.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    evt.currentTarget.classList.add('active');
  }
</script>

</body>
</html>
