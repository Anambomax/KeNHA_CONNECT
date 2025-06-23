<?php
// ── PROTECT ROUTE ───────────────────────────────────
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ── (OPTIONAL) FETCH REAL DATA COUNTS --------------
// For now we’ll hard-code dummy stats. Replace these
// with real SELECT COUNT(*) queries when you add tables.
$totalUsers      = 42;
$totalFeedback   = 17;
$openTickets     = 5;
$departments     = 6;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard • KeNHA Connect</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ── TOP BAR ─────────────────────────────────────── -->
<div class="topbar">
    <h1>KeNHA Connect Dashboard</h1>
    <form action="logout.php" method="post" style="margin:0;">
        <button class="logout-btn">Logout</button>
    </form>
</div>

<!-- ── MAIN DASHBOARD ─────────────────────────────── -->
<div class="container dashboard-wrapper">
    <h2 style="margin-bottom:1.5rem;">
        Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!
    </h2>

    <!-- Summary Cards -->
    <div class="cards">
        <div class="card">
            <h2><?php echo $totalUsers; ?></h2>
            <span>Registered Users</span>
        </div>
        <div class="card">
            <h2><?php echo $totalFeedback; ?></h2>
            <span>Total Feedback</span>
        </div>
        <div class="card">
            <h2><?php echo $openTickets; ?></h2>
            <span>Open Tickets</span>
        </div>
        <div class="card">
            <h2><?php echo $departments; ?></h2>
            <span>Departments</span>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="quick-links">
        <a href="#feedback">View Feedback</a>
        <a href="#profile">My Profile</a>
        <a href="#settings">Settings</a>
        <a href="#reports">Reports</a>
    </div>
</div>

</body>
</html>
