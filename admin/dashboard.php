<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<h1>Welcome, <?= $_SESSION['admin_name'] ?></h1>
<ul>
    <li><a href="users.php">Manage Users</a></li>
    <li><a href="incidents.php">View All Incidents</a></li>
    <li><a href="resolved_issues.php">Resolved Issues</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
