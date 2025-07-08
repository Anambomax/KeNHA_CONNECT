<?php
include 'config.php';
session_start();

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = $_POST['feedback_id'] ?? '';
    $status = $_POST['status'] ?? '';
    $assigned_to = $_POST['assigned_to'] ?? null;
    $department = $_POST['department'] ?? null;
    $comment = trim($_POST['comment'] ?? '');

    // Basic validation
    if (empty($feedback_id) || empty($status)) {
        die("Missing required fields.");
    }

    // Convert empty values to NULL
    $assigned_to = $assigned_to !== '' ? $assigned_to : null;
    $department = $department !== '' ? $department : null;

    try {
        // Update the feedback record
        $stmt = $conn->prepare("
            UPDATE feedback 
            SET status = ?, 
                assigned_to = ?, 
                department = ?, 
                updated_at = NOW() 
            WHERE id = ?
        ");
        $success = $stmt->execute([$status, $assigned_to, $department, $feedback_id]);

        if ($success) {
            // ✅ Log the update action
            $actor_id = $_SESSION['admin_id'] ?? $_SESSION['traffic_admin_id'] ?? null;
            $actor_role = isset($_SESSION['traffic_admin_id']) ? 'traffic_admin' : 'admin';

            $logStmt = $conn->prepare("INSERT INTO feedback_log (feedback_id, updated_by, role, comment, status, updated_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $logStmt->execute([$feedback_id, $actor_id, $actor_role, $comment, $status]);

            // 🔁 Redirect user based on where they came from
            if (isset($_SESSION['traffic_admin_id'])) {
                header("Location: ../traffic/feedback.php?msg=updated");
            } elseif (isset($_SESSION['admin_id'])) {
                header("Location: ../admin/feedback.php?msg=updated");
            } else {
                header("Location: ../dashboard.php?msg=updated"); // fallback
            }
            exit;
        } else {
            echo "❌ Failed to update feedback.";
        }
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
