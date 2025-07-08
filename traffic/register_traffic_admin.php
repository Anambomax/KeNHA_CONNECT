<?php
include '../api/config.php';
session_start();

// ONLY allow if you're setting up manually
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($full_name) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Hash the password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insert as traffic_admin
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'traffic_admin')");
        $stmt->execute([$full_name, $email, $hashed]);

        echo "✅ Traffic Admin Registered Successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register Traffic Admin</title></head>
<body>
<h2>Register Traffic Police Admin</h2>
<form method="POST">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>
</body>
</html>
