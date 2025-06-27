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
  <meta charset="UTF-8">
  <title>Dashboard - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">
  <div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="logo-container">
        <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="kenha-logo">
        <h3 class="kenha-title">KENHA CONNECT</h3>
      </div>
      <div class="nav-menu">
        <ul>
          <li class="active"><a href="dashboard.php">Home</a></li>
          <li><a href="feed.php">Feed</a></li>
          <li><a href="news.php">News</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="user-profile">
        <h2>Welcome, <?php echo $_SESSION['email']; ?> 👋</h2>
        <p>Welcome to the KeNHA Connect dashboard. Engage, report, and stay updated with Kenya’s national highway network.</p>
      </div>

      <div class="info-section">
        <h2>Message from KeNHA</h2>
        <p>
          The Kenya National Highways Authority (KeNHA) is responsible for the development, maintenance, management, and operation of all national trunk roads. We are committed to delivering a safe and efficient road network that promotes economic growth and public safety.
        </p>

        <h3>How the System Works</h3>
        <ul>
          <li><strong>Feed:</strong> A public channel where users can post, react, and comment on national road-related updates, challenges, and initiatives.</li>
          <li><strong>News:</strong> View reports on resolved issues, recurring challenges, and key infrastructure insights.</li>
          <li><strong>Profile:</strong> Access and manage your personal account details and past interactions.</li>
        </ul>

        <h3>Our Vision</h3>
        <p>To be a leading Highways Authority committed to quality highways for prosperity.</p>

        <h3>Our Mission</h3>
        <p>To develop and manage national roads using modern technology, innovation, and a highly motivated workforce.</p>
      </div>
    </div>

  </div>
</body>
</html>
