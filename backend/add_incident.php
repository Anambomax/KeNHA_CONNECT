<?php
include 'config.php';

$user_id = $_POST['user_id'];
$description = $_POST['description'];
$location = $_POST['location'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$image_path = '';

if (isset($_FILES['image'])) {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    $file_name = time() . '_' . $_FILES['image']['name'];
    $target = $upload_dir . basename($file_name);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $image_path = $target;
    }
}

$stmt = $conn->prepare("INSERT INTO incidents (user_id, description, location, image_path, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssdd", $user_id, $description, $location, $image_path, $latitude, $longitude);

$response = [];
if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
}
echo json_encode($response);
?>
