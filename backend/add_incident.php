<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

include 'config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['description'], $_POST['user_id']) && isset($_FILES['image'])) {
        $description = $_POST['description'];
        $user_id = $_POST['user_id'];
        $image = $_FILES['image'];

        $targetDir = "../uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $imageName = uniqid() . '_' . basename($image["name"]);
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $stmt = $conn->prepare("INSERT INTO incidents (user_id, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $description, $imageName);

            if ($stmt->execute()) {
                $response = [
                    "success" => true,
                    "message" => "Incident submitted successfully"
                ];
            } else {
                $response = [
                    "success" => false,
                    "message" => "Database error: " . $conn->error
                ];
            }
        } else {
            $response = [
                "success" => false,
                "message" => "Failed to upload image"
            ];
        }
    } else {
        $response = [
            "success" => false,
            "message" => "Missing required data"
        ];
    }
} else {
    $response = [
        "success" => false,
        "message" => "Invalid request method"
    ];
}

echo json_encode($response);
?>
