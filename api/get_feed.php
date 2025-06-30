<?php
require 'config.php';
header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT id, full_name, email, county, type, category, description, image_path, created_at FROM posts ORDER BY created_at DESC");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $posts
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
