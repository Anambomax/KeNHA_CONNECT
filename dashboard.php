<?php
session_start();
require_once 'api/config.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = strtolower($_SESSION['role']);
$email = $_SESSION['email'];
$full_name = $phone = $county = '';
$unread_count = 0;

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

try {
    $stmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $unread_count = $result ? $result['unread_count'] : 0;
} catch (PDOException $e) {}

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
  <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<?php if (isset($_SESSION['flash'])): ?>
  <div class="toast"><?= $_SESSION['flash']; ?></div>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="dashboard-container">
  <div class="sidebar">
    <img src="public/uploads/kenha-logo.png" alt="KeNHA Logo" class="kenha-logo">
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
    <button onclick="toggleDarkMode()">🌓 Dark Mode</button>
  </div>

  <div class="main-content">
    <div id="home" class="tab-content active">
      <h2 class="section-title">👋 Welcome, <?= htmlspecialchars($full_name); ?> </h2>

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

    <div id="feed" class="tab-content">
      <h2 class="section-title">🧵 Feed</h2>
      <?php if (!empty($feedbacks)): ?>
        <?php foreach ($feedbacks as $f): ?>
          <div class="info-box" data-feedback-id="<?= $f['id'] ?>">
            <strong><?= htmlspecialchars($f['user_name'] ?? 'Anonymous') ?></strong><br>
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
              <img src="public/uploads/<?= htmlspecialchars($f['photo']) ?>" class="feedback-img" alt="Feedback Photo">
            <?php endif; ?>

            <div class="reactions" data-feedback-id="<?= $f['id'] ?>">
              <span class="reaction" data-type="like" data-feedback="<?= $f['id'] ?>">👍 <span id="like-count-<?= $f['id'] ?>">0</span></span>
              <span class="reaction" data-type="dislike" data-feedback="<?= $f['id'] ?>">👎 <span id="dislike-count-<?= $f['id'] ?>">0</span></span>
              <span class="reaction" data-type="star" data-feedback="<?= $f['id'] ?>">⭐ <span id="star-count-<?= $f['id'] ?>">0</span></span>
              <span class="reaction comment-toggle" data-feedback="<?= $f['id'] ?>">💬 <span id="comment-count-<?= $f['id'] ?>">0</span></span>
            </div>

            <div class="comments-thread" style="display:none; margin-top:10px;">
              <div class="comment-list"></div>
              <textarea class="new-comment" placeholder="Write a comment..."></textarea>
              <button class="btn post-comment">Post</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No feedback available yet.</p>
      <?php endif; ?>
    </div>

    <div id="news" class="tab-content">
      <h2 class="section-title">📰 News & Reports</h2>
      <p>Coming soon: updates on resolved issues, road projects, and public announcements.</p>
    </div>

    <?php if ($role === 'staff'): ?>
      <div id="staff" class="tab-content">
        <h2 class="section-title">🛠 Staff Tools</h2>
        <div class="info-box">
          <p><a href="staff/view_assigned.php">📌 View Assigned Feedback</a></p>
          <p><a href="staff/resolve_feedback.php">✅ Mark Feedback as Resolved</a></p>
        </div>
      </div>
    <?php endif; ?>

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

<a href="public/submit_feedback.php" class="floating-button">＋</a>

<script>
function openTab(evt, tabId) {
  document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
  document.querySelectorAll('.tab-link').forEach(btn => btn.classList.remove('active'));
  document.getElementById(tabId).classList.add('active');
  if (evt) evt.currentTarget.classList.add('active');
}

window.onload = function () {
  const hash = window.location.hash;
  if (hash === "#feed") {
    document.querySelector('.tab-link[onclick*="feed"]').click();
  }
};

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.info-box').forEach(post => {
    const feedbackId = post.getAttribute('data-feedback-id');
    if (!feedbackId) return;

    // Load comment count
    fetch(`api/get_comments.php?feedback_id=${feedbackId}`)
      .then(res => res.json())
      .then(data => {
        const countSpan = document.getElementById(`comment-count-${feedbackId}`);
        if (countSpan) countSpan.textContent = data.count || 0;
      });

    // Load reaction counts immediately
    loadReactions(feedbackId);

    const toggle = post.querySelector('.comment-toggle');
    const thread = post.querySelector('.comments-thread');
    const list = post.querySelector('.comment-list');
    const textarea = post.querySelector('.new-comment');

    toggle.addEventListener('click', () => {
      thread.style.display = thread.style.display === 'none' ? 'block' : 'none';
      list.innerHTML = 'Loading...';
      fetch(`api/get_comments.php?feedback_id=${feedbackId}`)
        .then(res => res.json())
        .then(data => {
          list.innerHTML = '';
          data.comments.forEach(c => {
            const div = document.createElement('div');
            div.innerHTML = `<strong>${c.full_name}</strong><br><small>${new Date(c.created_at).toLocaleString()}</small><p>${c.comment}</p><hr>`;
            list.appendChild(div);
          });
        });
    });

    post.querySelector('.post-comment').addEventListener('click', () => {
      const text = textarea.value.trim();
      if (!text) return;
      fetch('api/add_comment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `feedback_id=${feedbackId}&comment=${encodeURIComponent(text)}`
      }).then(res => res.text()).then(response => {
        if (response === 'success') {
          textarea.value = '';
          toggle.click(); toggle.click();
        }
      });
    });

    post.querySelectorAll('.reaction[data-type]').forEach(btn => {
      btn.addEventListener('click', () => {
        const type = btn.getAttribute('data-type');
        fetch('api/add_reaction.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `feedback_id=${feedbackId}&type=${type}`
        }).then(res => res.json()).then(response => {
          if (response.success) loadReactions(feedbackId);
        });
      });
    });
  });
});

function loadReactions(feedbackId) {
  fetch(`api/get_reactions.php?feedback_id=${feedbackId}`)
    .then(res => res.json())
    .then(data => {
      document.getElementById(`like-count-${feedbackId}`).textContent = data.counts.like;
      document.getElementById(`dislike-count-${feedbackId}`).textContent = data.counts.dislike;
      document.getElementById(`star-count-${feedbackId}`).textContent = data.counts.star;

      document.querySelectorAll(`.reactions[data-feedback-id="${feedbackId}"] .reaction`).forEach(span => {
        span.classList.remove('active-reaction');
      });

      if (data.user_reaction) {
        const activeSpan = document.querySelector(`.reaction[data-feedback="${feedbackId}"][data-type="${data.user_reaction}"]`);
        if (activeSpan) activeSpan.classList.add('active-reaction');
      }
    });
}

function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');
  localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'on' : 'off');
}

document.addEventListener('DOMContentLoaded', () => {
  if (localStorage.getItem('darkMode') === 'on') {
    document.body.classList.add('dark-mode');
  }
});
</script>

</body>
</html>
