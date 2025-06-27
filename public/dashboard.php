<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - KENHA CONNECT</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">

  <div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="sidebar-logo">
      <h2>KENHA CONNECT</h2>
      <ul class="sidebar-nav">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="report.php">Submit Report</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="../api/logout.php">Logout</a></li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="dashboard-main">
      <div class="welcome-box">
        <h3>Welcome to KeNHA Connect</h3>
        <p>This dashboard gives you access to submit and track highway-related issues.</p>
      </div>

      <!-- Example future card area -->
      <div class="card-grid">
        <div class="card">
          <h4>Total Reports</h4>
          <p>Coming Soon</p>
        </div>
        <div class="card">
          <h4>Resolved</h4>
          <p>Coming Soon</p>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
