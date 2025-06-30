<?php
require_once 'session.php';
require 'config.php';

$user_name = $_SESSION['user_name'];
$location = $_SESSION['location'];

$category = $_POST['feedback_category'] ?? '';
$subcategory = $_POST['feedback_subcategory'] ?? '';
$details = $_POST['details'] ?? null;
$description = $_POST['description'] ?? '';

$photoName = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $photoName = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['photo']['tmp_name'], "../public/uploads/$photoName");
}

try {
    $stmt = $conn->prepare("INSERT INTO feedback (user_name, location, feedback_category, feedback_subcategory, details, description, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_name, $location, $category, $subcategory, $details, $description, $photoName]);

    header("Location: ../public/feed.php");
    exit();
} catch (PDOException $e) {
    echo "Failed to submit feedback: " . $e->getMessage();
}
