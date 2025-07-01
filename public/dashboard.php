<?php
session_start();
require_once '../api/config.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

// Get user info
$email = $_SESSION['email'];
$full_name = $phone = $county = '';

try {
    $stmt = $conn->prepare("SELECT full_name, email, phone, county FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $full_name = $user['full_name'];
        $phone = $user['phone'];
        $county = $user['county'];
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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
      font-family: 'Poppins', sans-serif;
      background-color: #f2f4f7;
    }

    .dashboard-container {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 260px;
      background-color: #012c57;
      color: white;
      padding: 30px 20px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .sidebar img {
      width: 120px;
      margin-bottom: 10px;
    }

    .sidebar h2 {
      font-size: 24px;
      margin-bottom: 30px;
      text-align: center;
      color: white;
    }

    .sidebar button {
      display: block;
      width: 100%;
      margin-bottom: 15px;
      padding: 14px;
      font-size: 17px;
      background: none;
      color: white;
      border: none;
      text-align: left;
      cursor: pointer;
      transition: background 0.3s;
    }

    .sidebar button:hover,
    .sidebar .active {
      background-color: #03457e;
    }

    .main-content {
      flex: 1;
      padding: 40px;
      overflow-y: auto;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .section-title {
      font-size: 26px;
      margin-bottom: 20px;
      color: #012c57;
    }

    .info-box {
      background: white;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 25px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .info-box p {
      font-size: 16px;
      line-height: 1.6;
    }

    .feedback-tags span {
      display: inline-block;
      background: #d9ebff;
      color: #012c57;
      padding: 6px 12px;
      border-radius: 20px;
      margin-right: 8px;
      font-size: 13px;
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
      background-color: #012c57;
      color: white;
      font-size: 28px;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      line-height: 60px;
      text-align: center;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      z-index: 1000;
    }

    .reaction-bar {
      margin-top: 10px;
      font-size: 16px;
      color: #333;
    }

    .reaction-bar span {
      margin-right: 15px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .dashboard-container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        padding: 10px;
      }

      .sidebar h2 {
        display: none;
      }

      .sidebar button {
        font-size: 14px;
        margin: 5px;
      }
    }
  </style>
</head>
<body>

<div class="dashboard-container">

  <!-- Sidebar -->
  <div class="sidebar">
    <img src="uploads/kenha-logo.png" alt="KeNHA Logo">
    <h2>KeNHA CONNECT</h2>
    <button class="tab-link active" onclick="openTab(event, 'home')">🏠 Home</button>
    <button class="tab-link" onclick="openTab(event, 'feed')">🧵 Feed</button>
    <button class="tab-link" onclick="openTab(event, 'news')">📰 News</button>
    <button onclick="window.location.href='logout.php'">🚪 Logout</button>
  </div>

  <!-- Main Content -->
  <div class="main-content">

    <!-- HOME -->
    <div id="home" class="tab-content active">
      <h2 class="section-title">👋 Welcome, <?= htmlspecialchars($full_name); ?></h2>

      <div class="info-box">
        <h3>📄 Your Profile</h3>
        <p><strong>Email:</strong> <?= htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($phone); ?></p>
        <p><strong>County:</strong> <?= htmlspecialchars($county); ?></p>
      </div>

      <div class="info-box">
        <h3>📌 About KeNHA Connect</h3>
        <p>
          <strong>KeNHA Connect</strong> is a feedback system that enables real-time communication between KeNHA and its stakeholders.
          Citizens can report road issues, provide feedback, and stay updated on infrastructure progress directly from KeNHA departments.
        </p>
      </div>

      <div class="info-box">
        <h3>📘 How It Works</h3>
        <ul>
          <li>Register and log in with your email and county information.</li>
          <li>Click the <strong>＋</strong> button to submit feedback or road incidents.</li>
          <li>View updates and reports from other users and KeNHA staff on the Feed tab.</li>
          <li>Stay connected through timely updates and resolved issue reports.</li>
        </ul>
      </div>

      <div class="info-box">
        <h3>🎯 Our Commitment</h3>
        <p>
          KeNHA is committed to maintaining safe, reliable roads across Kenya through inclusive and transparent engagement with all road users.
        </p>
      </div>
    </div>

    <!-- FEED -->
    <div id="feed" class="tab-content">
      <h2 class="section-title">🧵 Latest Feedback</h2>
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

    <!-- NEWS -->
    <div id="news" class="tab-content">
      <h2 class="section-title">📰 News & Reports</h2>
      <p>Coming soon: updates on resolved issues, road projects, and public announcements.</p>
    </div>

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
