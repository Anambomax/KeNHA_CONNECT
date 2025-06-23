<?php
// Allow cross-origin requests (from React frontend)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Read and decode JSON input
$input = file_get_contents("php://input");
$data = json_decode($input);

if (!$data) {
    echo json_encode(["success" => false, "message" => "No data received"]);
    exit();
}

// Get fields
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

// Hash password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// DB connection
$conn = new mysqli("localhost", "root", "", "kenha_connect"); // ✅ Ensure database exists

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO users (name, email, county, phone, password) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "DB prepare failed: " . $conn->error]);
    exit();
}

$stmt->bind_param("sssss", $name, $email, $county, $phone, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User registered"]);
} else {
    echo json_encode(["success" => false, "message" => "Insert failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
