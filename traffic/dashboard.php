<?php
session_start();
include '../api/config.php';

// Ensure traffic admin is logged in
if (!isset($_SESSION['traffic_admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch stats
function getCount($conn, $table) {
    try {
        return $conn->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

$citations = getCount($conn, 'traffic_citations');
$accidents = getCount($conn, 'accidents');
$dui_arrests = getCount($conn, 'dui_arrests');
$violations = getCount($conn, 'speed_violations');
$enforcements = getCount($conn, 'enforcement_activities');
$responses = getCount($conn, 'incident_responses'); // if tracking response times

?>

<!DOCTYPE html>
<html>
<head>
    <title>Traffic Dashboard - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <style>
        .kpi-cards { display: flex; flex-wrap: wrap; gap: 20px; margin: 20px 0; }
        .kpi { background: #f4f4f4; padding: 20px; border-radius: 10px; flex: 1 1 200px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        .kpi h3 { margin: 0; font-size: 1.2rem; color: #005baa; }
        .kpi span { font-size: 1.5rem; font-weight: bold; display: block; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="navbar">🚓 Traffic Police Dashboard</div>
    <div class="container">
        <h2>Overview KPIs</h2>
        <div class="kpi-cards">
            <div class="kpi"><h3>🚦 Traffic Citations</h3><span><?= $citations ?></span></div>
            <div class="kpi"><h3>💥 Accidents</h3><span><?= $accidents ?></span></div>
            <div class="kpi"><h3>🍷 DUI Arrests</h3><span><?= $dui_arrests ?></span></div>
            <div class="kpi"><h3>🚗 Speed Violations</h3><span><?= $violations ?></span></div>
            <div class="kpi"><h3>📋 Enforcement Actions</h3><span><?= $enforcements ?></span></div>
            <div class="kpi"><h3>🚑 Incident Responses</h3><span><?= $responses ?></span></div>
        </div>

        <div style="margin-top: 30px;">
            <a href="feedback.php">📄 View Traffic Feedback</a> | 
            <a href="emergency.php">📞 Emergency Contacts</a> | 
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>
</body>
</html>
