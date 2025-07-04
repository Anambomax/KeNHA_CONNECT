<?php
session_start();
require_once "../db/db.php";

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'staff') {
    http_response_code(403);
    exit("Unauthorized");
}

$dept = $_SESSION['department'];
$stmt = $conn->prepare("SELECT * FROM feedback WHERE department = ? AND status != 'resolved' ORDER BY created_at DESC");
$stmt->execute([$dept]);
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($feedbacks as $f) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px'>";
    echo "<strong>Type:</strong> " . htmlspecialchars($f['feedback_category']) . " – " . htmlspecialchars($f['feedback_subcategory']) . "<br>";
    echo "<strong>Description:</strong> " . htmlspecialchars($f['description']) . "<br>";
    echo "<strong>Status:</strong> " . htmlspecialchars($f['status']) . "<br>";
    echo "<button onclick='resolveFeedback(" . $f['id'] . ")'>Mark as Resolved</button>";
    echo "</div>";
}
