<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(["success" => false, "message" => "No data received"]);
    exit();
}

$name = $data->name ?? '';
$email = $data->email ?? '';
$county = $data->county ?? '';
$phone = $data->phone ?? '';
$password = $data->password ?? '';
$confirmPassword = $data->confirmPassword ?? '';

if ($password !== $confirmPassword) {
    echo json_encode(["success" => false, "message" => "Passwords do not match"]);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Connect to DB
$conn = new mysqli("localhost", "root", "", "kenha_connect");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO users (name, email, county, phone, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $county, $phone, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User registered"]);
} else {
    echo json_encode(["success" => false, "message" => "Error registering user"]);
}

$stmt->close();
$conn->close();
?>
