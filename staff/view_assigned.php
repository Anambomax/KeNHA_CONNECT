<?php
session_start();
require_once '../api/config.php';

// Ensure staff only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../index.php");
    exit();
}

$staff_email = $_SESSION['email'];
$staff_id = $_SESSION['user_id'];
$department = $_SESSION['department'] ?? 'General'; // Assuming department is in session

try {
    $stmt = $conn->prepare("SELECT * FROM feedback WHERE assigned_department = ? ORDER BY created_at DESC");
    $stmt->execute([$department]);
    $assigned_feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error loading assigned feedback: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Assigned Feedback - KeNHA Connect</title>
  <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
  <h2>📌 Assigned Feedback (<?= htmlspecialchars($department) ?> Department)</h2>
  <?php if (!empty($assigned_feedbacks)): ?>
    <?php foreach ($assigned_feedbacks as $f): ?>
      <div class="info-box">
        <p><strong><?= htmlspecialchars($f['user_name'] ?? 'Anonymous') ?></strong> - <?= $f['created_at'] ?></p>
        <p><?= nl2br(htmlspecialchars($f['description'])) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($f['status'] ?? 'Pending') ?></p>
        <?php if (!empty($f['photo'])): ?>
          <img src="../uploads/<?= $f['photo'] ?>" style="max-width: 300px;">
        <?php endif; ?>
        <a href="resolve_feedback.php?id=<?= $f['id'] ?>">✅ Resolve</a>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No feedback assigned to your department.</p>
  <?php endif; ?>
</body>
</html>
