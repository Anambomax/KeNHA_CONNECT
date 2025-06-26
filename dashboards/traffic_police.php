<?php
include '../protect.php';
$user = $_SESSION['user'];
if ($user['role'] !== 'traffic_police') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Traffic Police Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="dashboard-page">
    <header>
        <h1>Traffic Police Dashboard</h1>
        <div class="nav-right">
            <span>Welcome, <?= htmlspecialchars($user['name']) ?></span>
            <a href="../profile.php">Profile</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <main>
        <p>Handle traffic incident reports and manage road safety alerts.</p>
    </main>
</body>
</html>
