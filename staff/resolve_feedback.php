<?php
session_start();
require_once '../api/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../index.php");
    exit();
}

$feedback_id = $_GET['id'] ?? null;
$resolved = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['resolution_note'] ?? '';
    $id = $_POST['feedback_id'];

    $stmt = $conn->prepare("UPDATE feedback SET status = 'Resolved', resolution_note = ?, resolved_at = NOW() WHERE id = ?");
    $stmt->execute([$note, $id]);
    $resolved = true;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Resolve Feedback - KeNHA Connect</title>
  <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
  <h2>✅ Resolve Feedback</h2>

  <?php if ($resolved): ?>
    <p style="color:green;">Feedback marked as resolved.</p>
    <a href="view_assigned.php">← Back to Assigned Feedback</a>
  <?php elseif ($feedback_id): ?>
    <form method="POST" action="resolve_feedback.php">
      <input type="hidden" name="feedback_id" value="<?= $feedback_id ?>">
      <label>Resolution Note:</label><br>
      <textarea name="resolution_note" rows="5" cols="50" required></textarea><br><br>
      <button type="submit">Mark as Resolved</button>
    </form>
  <?php else: ?>
    <p>No feedback selected.</p>
  <?php endif; ?>
</body>
</html>
