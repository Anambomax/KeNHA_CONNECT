<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['full_name'], $data['email'], $data['phone'],
    $data['county'], $data['password'], $data['confirm_password'])
) {
    http_response_code(400);
    echo json_encode(["error" => "All fields are required."]);
    exit;
}

$full_name = trim($data['full_name']);
$email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
$phone = trim($data['phone']);
$county = trim($data['county']);
$password = $data['password'];
$confirm_password = $data['confirm_password'];

if (!$email) {
    echo json_encode(["error" => "Invalid email format."]);
    exit;
}

if ($password !== $confirm_password || strlen($password) < 8) {
    echo json_encode(["error" => "Passwords must match and be at least 8 characters long."]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, county, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $email, $phone, $county, $hashedPassword]);

    echo json_encode(["success" => "Account created successfully."]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Email already exists or server error."]);
}
