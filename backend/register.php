<?php
include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$county = $data['county'];

$stmt = $conn->prepare("INSERT INTO users (name, email, password, county) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $county);

$response = [];

if ($stmt->execute()) {
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Email already registered or server error';
}
echo json_encode($response);
?>
