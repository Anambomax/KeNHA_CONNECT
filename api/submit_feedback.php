<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(403);
    echo "Unauthorized access.";
    exit();
}

$user_email = $_SESSION['email'];
$user_name = $_SESSION['user_name'] ?? '';
$user_id = $_SESSION['user_id'] ?? '';
$location = $_SESSION['location'] ?? '';

// Get posted data
$description = trim($_POST['description'] ?? '');
$feedback_category = $_POST['feedback_category'] ?? '';
$subcategory = '';
$details = null;

// Determine feedback structure
if ($feedback_category === 'incident') {
    $subcategory = $_POST['feedback_subcategory_incident'] ?? '';
    if ($subcategory === 'accident') {
        $details = $_POST['details'] ?? null;
    }
} elseif ($feedback_category === 'general feedback') {
    $subcategory = $_POST['feedback_subcategory_general'] ?? '';
}

if (!$description || !$feedback_category || !$subcategory) {
    $_SESSION['flash'] = "❌ Missing required fields.";
    header("Location: ../public/dashboard.php");
    exit();
}

// Handle photo upload
$photoName = null;
if (!empty($_FILES['photo']['name'])) {
    $uploadDir = '../public/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photoName = uniqid('fb_', true) . '.' . $ext;
    $uploadPath = $uploadDir . $photoName;

    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
        $_SESSION['flash'] = "❌ Failed to upload photo.";
        header("Location: ../public/dashboard.php");
        exit();
    }
}

// Insert into feedback table
$stmt = $conn->prepare("INSERT INTO feedback (
    user_name, location, feedback_category, feedback_subcategory, details, description, photo, created_at, user_id
) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

$success = $stmt->execute([
    $user_name,
    $location,
    $feedback_category,
    $subcategory,
    $details,
    $description,
    $photoName,
    $user_id,
]);

if ($success) {
    // ✅ Insert notification
    $notifMsg = "Thank you, $user_name. Your feedback has been received and is under review.";
    $notif = $conn->prepare("INSERT INTO notifications (user, message, notified) VALUES (?, ?, 1)");
    $notif->execute([$user_id, $notifMsg]);

    $_SESSION['flash'] = "✅ Feedback submitted successfully!";
} else {
    $_SESSION['flash'] = "❌ Failed to submit feedback.";
}

header("Location: ../public/dashboard.php");
exit();
