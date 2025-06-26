<?php
include '../protect.php';
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Public Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="dashboard-page">
    <header>
        <h1>KeNHA Connect - Public</h1>
        <div class="nav-right">
            <span>Welcome, <?= htmlspecialchars($user['name']) ?></span>
            <a href="../profile.php">Profile</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <main>
        <p>You can report road issues and view your submissions here.</p>
        <a href="../add_incident.php" class="report-button">+ Report Incident</a>
    </main>
</body>
</html>
