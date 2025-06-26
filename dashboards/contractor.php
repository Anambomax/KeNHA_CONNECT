<?php
include '../protect.php';
$user = $_SESSION['user'];
if ($user['role'] !== 'contractor') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contractor Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="dashboard-page">
    <header>
        <h1>Contractor Dashboard</h1>
        <div class="nav-right">
            <span>Welcome, <?= htmlspecialchars($user['name']) ?></span>
            <a href="../profile.php">Profile</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <main>
        <p>Manage and update the status of road repairs assigned to your team.</p>
    </main>
</body>
</html>
