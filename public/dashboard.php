<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: index.php");
  exit();
}

require_once '../api/config.php';

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
      <h2 class="section-title">Welcome, <?php echo htmlspecialchars($full_name); ?>!</h2>

      <div class="info-box">
        <h3>📄 Your Profile Information</h3>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
        <p><strong>County:</strong> <?php echo htmlspecialchars($county); ?></p>
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
      <p>Coming soon: Post issues and interact with others.</p>
    </div>

    <!-- NEWS TAB -->
    <div id="news" class="tab-content">
      <h2 class="section-title">📰 News & Reports</h2>
      <p>Coming soon: View public reports, analytics, and resolved cases.</p>
    </div>
  </div>
</div>

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
