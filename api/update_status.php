<?php
include 'config.php';
session_start();

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_id = $_POST['feedback_id'] ?? '';
    $status = $_POST['status'] ?? '';
    $assigned_to = $_POST['assigned_to'] ?? null;
    $department = $_POST['department'] ?? null;

    // Basic validation
    if (empty($feedback_id) || empty($status)) {
        die("Missing required fields.");
    }

    // Optional Debugging - Uncomment to check values
    /*
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
    */

    try {
        // Update feedback record
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
            header("Location: ../admin/feedback.php?msg=updated");
            exit;
        } else {
            echo "Failed to update feedback.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
