<?php
require_once '../api/session.php';
require_once '../api/config.php';

// Fetch feedbacks from DB
$stmt = $conn->prepare("SELECT * FROM feedback ORDER BY created_at DESC");
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KeNHA Connect - Feed</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f2f2;
    }

    .sidebar {
      width: 240px;
      background-color: #003366;
      color: white;
      position: fixed;
      height: 100vh;
      padding-top: 20px;
    }

    .sidebar .logo-container {
      text-align: center;
      margin-bottom: 30px;
    }

    .kenha-logo {
      width: 80px;
      height: auto;
      margin-bottom: 10px;
    }

    .nav-menu ul {
      list-style-type: none;
      padding: 0;
    }

    .nav-menu li {
      margin: 10px 20px;
      background-color: #004080;
      border-radius: 8px;
      padding: 10px;
      text-align: center;
      transition: background-color 0.3s;
    }

    .nav-menu li:hover,
    .nav-menu .active {
      background-color: #0059b3;
    }

    .nav-menu a {
      color: white;
      text-decoration: none;
      display: block;
    }

    .main-content {
      margin-left: 260px;
      padding: 30px;
    }

    .post-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .post-tags span {
      background: #e0f0ff;
      padding: 5px 12px;
      border-radius: 20px;
      margin-right: 8px;
      color: #003366;
      font-weight: 500;
    }

    .post-image {
      max-width: 100%;
      border-radius: 8px;
      margin-top: 10px;
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
    }

    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 15px;
      }

      .sidebar {
        display: none;
      }

      .floating-button {
        right: 20px;
        bottom: 20px;
      }
    }
  </style>
</head>
<body>
<div class="dashboard-container">
  <div class="sidebar">
    <div class="logo-container">
      <img src="uploads/kenha-logo.png" class="kenha-logo" alt="KeNHA Logo">
      <h3>KeNHA CONNECT</h3>
    </div>
    <div class="nav-menu">
      <ul>
        <li><a href="dashboard.php">🏠 Home</a></li>
        <li class="active"><a href="feed.php">📰 Feed</a></li>
        <li><a href="news.php">📈 News</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <h2>📰 Feed</h2>
    <?php if (!empty($feedbacks)): ?>
      <?php foreach ($feedbacks as $row): ?>
        <div class="post-card">
          <strong><?= htmlspecialchars($row['user_name']) ?> (<?= htmlspecialchars($row['location']) ?>)</strong><br>
          <small><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></small>
          <div class="post-tags">
            <span><?= ucfirst($row['feedback_category']) ?></span>
            <span><?= ucfirst($row['feedback_subcategory']) ?></span>
            <?php if ($row['details']) echo "<span>" . ucfirst($row['details']) . "</span>"; ?>
          </div>
          <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
          <?php if ($row['photo']): ?>
            <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" class="post-image" alt="Photo">
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No feedback has been posted yet.</p>
    <?php endif; ?>
  </div>

  <a href="submit_feedback.php" class="floating-button" title="Submit Feedback">＋</a>
</div>
</body>
</html>
