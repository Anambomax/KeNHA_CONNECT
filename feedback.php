<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $user     = $_SESSION['username'];
    $category = $_POST['category'];
    $subject  = $_POST['subject'];
    $message  = $_POST['message'];

    $sqlUser = $conn->query("SELECT id FROM users WHERE username='$user'");
    $userData = $sqlUser->fetch_assoc();
    $user_id = $userData['id'];

    $stmt = $conn->prepare("INSERT INTO feedback (user_id, category, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $category, $subject, $message);
    $stmt->execute();

    echo "<script>alert('Feedback submitted successfully'); window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Submit Feedback</h2>
    <form method="POST">
        <select name="category" required>
            <option value="">Select Category</option>
            <option>Road Maintenance</option>
            <option>Traffic Safety</option>
            <option>Signage Issues</option>
            <option>Other</option>
        </select><br>
        <input type="text" name="subject" placeholder="Subject" required><br>
        <textarea name="message" placeholder="Enter your message..." rows="4" required style="width:90%;border-radius:8px;padding:0.7em;"></textarea><br>
        <button name="submit">Submit</button>
    </form>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>
