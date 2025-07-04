<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'staff') {
    header("Location: staff_login.php");
    exit();
}

$staffName = $_SESSION['full_name'];
$department = $_SESSION['department'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <script>
    // Fetch feedback on page load
    window.onload = function () {
        fetch('staff_fetch_feedback.php')
            .then(res => res.text())
            .then(data => document.getElementById('feedback-container').innerHTML = data);
    };

    function resolveFeedback(id) {
        fetch('staff_resolve_feedback.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + id
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            location.reload();
        });
    }
    </script>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($staffName) ?> (<?= htmlspecialchars($department) ?> Dept)</h2>
    <a href="staff_logout.php">Logout</a>

    <h3>Your Department's Feedback</h3>
    <div id="feedback-container">Loading...</div>
</body>
</html>
