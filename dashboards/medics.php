<?php
include '../protect.php';
$user = $_SESSION['user'];
if ($user['role'] !== 'medics') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medics Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="dashboard-page">
    <header>
        <h1>Medics Emergency Panel</h1>
        <div class="nav-right">
            <span>Welcome, <?= htmlspecialchars($user['name']) ?></span>
            <a href="../profile.php">Profile</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <main>
        <p>Respond to injury-related road reports and coordinate with EMTs.</p>
    </main>
</body>
</html>
