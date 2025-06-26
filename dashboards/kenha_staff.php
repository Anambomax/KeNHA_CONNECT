<?php
include '../protect.php';
$user = $_SESSION['user'];
if ($user['role'] !== 'kenha_staff') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KeNHA Staff Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="dashboard-page">
    <header>
        <h1>KeNHA Staff Panel</h1>
        <div class="nav-right">
            <span>Welcome, <?= htmlspecialchars($user['name']) ?></span>
            <a href="../profile.php">Profile</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <main>
        <p>Review and manage all reported road issues from the public.</p>
    </main>
</body>
</html>
