<?php
// kenha-connect/api/add_post.php
session_start();
require_once 'config.php';

if (!isset($_SESSION['email'])) {
  http_response_code(401);
  echo json_encode(["error" => "Unauthorized"]);
  exit();
}

$user_email = $_SESSION['email'];
$type = $_POST['type'] ?? '';
$category = $_POST['category'] ?? '';
$description = $_POST['description'] ?? '';

if (empty($type) || empty($category) || empty($description)) {
  http_response_code(400);
  echo json_encode(["error" => "All fields are required"]);
  exit();
}

// Fetch user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$user_email]);
$user = $stmt->fetch();

if (!$user) {
  http_response_code(404);
  echo json_encode(["error" => "User not found"]);
  exit();
}

$user_id = $user['id'];

// Handle image upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $upload_dir = '../public/uploads/';
  $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
  $target_path = $upload_dir . $image_name;

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
    $image_path = 'uploads/' . $image_name; // Relative path for public access
  }
}

// Determine if post is actionable
$is_actionable = ($type === 'incident') ? 1 : 0;

// Insert into posts table
$stmt = $conn->prepare("INSERT INTO posts (user_id, type, category, description, image_path, is_actionable) VALUES (?, ?, ?, ?, ?, ?)");
$success = $stmt->execute([$user_id, $type, $category, $description, $image_path, $is_actionable]);

if ($success) {
  header("Location: ../public/feed.php");
  exit();
} else {
  http_response_code(500);
  echo json_encode(["error" => "Failed to create post"]);
  exit();
}
