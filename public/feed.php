<?php
require_once '../api/session.php';
require_once '../api/config.php';

$user_id = $_SESSION['user_id'] ?? null;

// Fetch feedbacks with comments and reaction counts
$sql = "SELECT f.*, 
            (SELECT COUNT(*) FROM reactions WHERE feedback = f.id AND type = 'like') AS likes,
            (SELECT COUNT(*) FROM reactions WHERE feedback = f.id AND type = 'dislike') AS dislikes
        FROM feedback f ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>KeNHA Connect - Feed</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Styles from earlier are retained */
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f4f4f4;
    }

    .sidebar {
      width: 240px;
      background-color: #003366;
      position: fixed;
      height: 100vh;
      color: white;
      padding-top: 20px;
    }

    .main-content {
      margin-left: 260px;
      padding: 30px;
    }

    .post-card {
      background: white;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .post-tags span {
      background: #e0f0ff;
      border-radius: 20px;
      padding: 5px 10px;
      margin-right: 8px;
      display: inline-block;
      font-size: 12px;
      color: #003366;
    }

    .post-image {
      max-width: 100%;
      margin-top: 10px;
      border-radius: 8px;
    }

    .reaction-bar {
      margin-top: 10px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .reaction-bar span {
      cursor: pointer;
      user-select: none;
    }

    .comments-section {
      margin-top: 15px;
    }

    .comments-section textarea {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
      resize: vertical;
    }

    .comments-section button {
      margin-top: 5px;
      padding: 6px 12px;
      background: #003366;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .comment {
      margin-top: 10px;
      padding-left: 10px;
      border-left: 2px solid #eee;
    }

    .floating-button {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #003366;
      color: white;
      border-radius: 50%;
      font-size: 24px;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
<div class="sidebar">
  <div style="text-align:center">
    <img src="uploads/kenha-logo.png" width="80" alt="Logo" />
    <h3>KeNHA CONNECT</h3>
  </div>
  <ul class="nav-menu" style="list-style:none; padding:0">
    <li><a href="dashboard.php" style="display:block; padding:10px; color:white;">🏠 Home</a></li>
    <li style="background:#0059b3;"><a href="feed.php" style="display:block; padding:10px; color:white;">📰 Feed</a></li>
    <li><a href="news.php" style="display:block; padding:10px; color:white;">📊 News</a></li>
    <li><a href="logout.php" style="display:block; padding:10px; color:white;">🚪 Logout</a></li>
  </ul>
</div>

<div class="main-content">
  <h2>🧵 Feed</h2>

  <?php foreach ($feedbacks as $row): ?>
    <div class="post-card" id="post-<?= $row['id'] ?>">
      <strong><?= htmlspecialchars($row['user_name']) ?> (<?= htmlspecialchars($row['location']) ?>)</strong><br>
      <small><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></small>
      <div class="post-tags">
        <span><?= htmlspecialchars($row['feedback_category']) ?></span>
        <span><?= htmlspecialchars($row['feedback_subcategory']) ?></span>
        <?php if (!empty($row['details'])): ?><span><?= htmlspecialchars($row['details']) ?></span><?php endif; ?>
      </div>
      <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
      <?php if (!empty($row['photo'])): ?>
        <img src="uploads/<?= htmlspecialchars($row['photo']) ?>" class="post-image" />
      <?php endif; ?>

      <!-- Reactions -->
      <div class="reaction-bar">
        <span onclick="react(<?= $row['id'] ?>, 'like')">👍 <b id="like-count-<?= $row['id'] ?>"><?= $row['likes'] ?></b></span>
        <span onclick="react(<?= $row['id'] ?>, 'dislike')">👎 <b id="dislike-count-<?= $row['id'] ?>"><?= $row['dislikes'] ?></b></span>
      </div>

      <!-- Comments -->
      <div class="comments-section" id="comments-<?= $row['id'] ?>">
        <!-- Will be loaded by JS -->
        <div class="comment-list"></div>
        <textarea placeholder="Write a comment..." id="comment-input-<?= $row['id'] ?>"></textarea>
        <button onclick="submitComment(<?= $row['id'] ?>)">Post Comment</button>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<a class="floating-button" href="submit_feedback.php">＋</a>

<script>
function submitComment(feedbackId) {
  const textarea = document.getElementById('comment-input-' + feedbackId);
  const comment = textarea.value.trim();
  if (!comment) return;

  fetch('../api/add_comment.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `feedback_id=${feedbackId}&comment=${encodeURIComponent(comment)}`
  })
  .then(res => res.text())
  .then(() => {
    textarea.value = '';
    loadComments(feedbackId);
  });
}

function react(feedbackId, type) {
  fetch('../api/add_reaction.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `feedback_id=${feedbackId}&type=${type}`
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById('like-count-' + feedbackId).textContent = data.likes;
    document.getElementById('dislike-count-' + feedbackId).textContent = data.dislikes;
  });
}

function loadComments(feedbackId) {
  fetch(`../api/get_comments.php?feedback_id=${feedbackId}`)
  .then(res => res.json())
  .then(data => {
    const container = document.querySelector(`#comments-${feedbackId} .comment-list`);
    container.innerHTML = '';
    data.forEach(c => {
      const div = document.createElement('div');
      div.classList.add('comment');
      div.innerHTML = `<strong>${c.user}</strong><br><small>${c.created_at}</small><br>${c.comment}`;
      container.appendChild(div);
    });
  });
}

// Load all comments initially
<?php foreach ($feedbacks as $row): ?>
  loadComments(<?= $row['id'] ?>);
<?php endforeach; ?>
</script>
</body>
</html>
