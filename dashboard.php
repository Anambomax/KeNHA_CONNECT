<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - KeNHA Connect</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Topbar Navigation -->
<div class="topbar">
    <h1>KeNHA Connect</h1>
    <form method="POST" action="logout.php">
        <button class="logout-btn">Logout</button>
    </form>
</div>

<!-- Dashboard Content -->
<div class="dashboard-wrapper">
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['fullname']; ?>!</h2>
        <p>Select an action below:</p>

        <!-- Quick Navigation Buttons -->
        <div class="quick-links">
            <a href="index.php">🏠 Home</a>
            <a href="feedback.php">📝 Submit Feedback</a>
            <a href="my_feedback.php">📋 View My Feedback</a>
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>
</div>
</body>
</html>
