<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KeNHA Connect – Feed</title>
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
  <div class="dashboard-container">
    <div class="sidebar">
      <div class="nav-menu">
        <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="logo" />
        <a href="dashboard.php">🏠 Home</a>
        <a class="active" href="feed.php">📰 Feed</a>
        <a href="news.php">📊 News</a>
        <a href="logout.php" class="logout">🚪 Logout</a>
      </div>
    </div>

    <div class="main-content">
      <h2>📢 Community Feed</h2>
      <div id="feed"></div>
    </div>

    <!-- Floating Button -->
    <a href="post.php" class="floating-button">＋</a>
  </div>

  <script>
    // Load all posts
    function loadFeed() {
      axios.get('../api/get_feed.php')
        .then(response => {
          const feed = document.getElementById('feed');
          feed.innerHTML = '';
          if (response.data.status === 'success') {
            response.data.data.forEach(post => {
              const postDiv = document.createElement('div');
              postDiv.className = 'post-card';
              postDiv.innerHTML = `
                <h3>${post.full_name} (${post.county})</h3>
                <small>📅 ${new Date(post.created_at).toLocaleString()}</small>
                <p><strong>Type:</strong> ${post.type} – ${post.category}</p>
                <p>${post.description}</p>
                ${post.image_path ? `<img src="${post.image_path}" class="post-image" />` : ''}
                
                <div class="comments-section" id="comments-${post.id}">
                  <div class="existing-comments"></div>
                  <form class="comment-form" data-post-id="${post.id}">
                    <input type="text" name="comment" placeholder="Write a comment..." required />
                    <button type="submit">Post</button>
                  </form>
                </div>
              `;
              feed.appendChild(postDiv);
              loadComments(post.id);
            });
          }
        })
        .catch(err => console.error('Feed load error:', err));
    }

    // Load comments under a post
    function loadComments(postId) {
      axios.get(`../api/get_comments.php?post=${postId}`)
        .then(res => {
          const container = document.querySelector(`#comments-${postId} .existing-comments`);
          container.innerHTML = '';
          if (res.data.status === 'success') {
            res.data.data.forEach(c => {
              const html = `
                <div class="comment">
                  <strong>${c.full_name}</strong>: ${c.comment}<br>
                  <small>${new Date(c.created_at).toLocaleString()}</small>
                </div>`;
              container.innerHTML += html;
            });
          }
        });
    }

    // Handle comment submit
    document.addEventListener('submit', function(e) {
      if (e.target.matches('.comment-form')) {
        e.preventDefault();
        const form = e.target;
        const postId = form.getAttribute('data-post-id');
        const comment = form.comment.value.trim();
        if (!comment) return;

        axios.post('../api/add_comment.php', {
          post: postId,
          comment: comment
        })
        .then(res => {
          if (res.data.status === 'success') {
            form.comment.value = '';
            loadComments(postId);
          } else {
            alert(res.data.message);
          }
        });
      }
    });

    // Initial load
    loadFeed();
  </script>
</body>
</html>
