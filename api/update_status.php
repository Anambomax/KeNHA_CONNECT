<?php
include 'config.php';
session_start();

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = $_POST['feedback_id'] ?? '';
    $status = $_POST['status'] ?? '';
    $assigned_to = $_POST['assigned_to'] ?? '';

    // Basic validation
    if (!$feedback_id || !$status || !$assigned_to) {
        die("Missing required fields.");
    }

    // Update the feedback
    $stmt = $conn->prepare("UPDATE feedback 
                            SET status = ?, assigned_to = ?, updated_at = NOW() 
                            WHERE id = ?");
    $success = $stmt->execute([$status, $assigned_to, $feedback_id]);

    if ($success) {
        header("Location: ../admin/feedback.php?msg=updated");
        exit;
    } else {
        echo "Failed to update feedback.";
    }
} else {
    echo "Invalid request method.";
}
?>
