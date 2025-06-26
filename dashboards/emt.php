<?php
include '../protect.php';
$user = $_SESSION['user'];
if ($user['role'] !== 'emt') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>EMT Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="dashboard-page">
    <header>
        <h1>EMT Response Dashboard</h1>
        <div class="nav-right">
            <span>Welcome, <?= htmlspecialchars($user['name']) ?></span>
            <a href="../profile.php">Profile</a> |
            <a href="../logout.php">Logout</a>
        </div>
    </header>
    <main>
        <p>Access emergency cases needing EMT response and updates.</p>
    </main>
</body>
</html>
