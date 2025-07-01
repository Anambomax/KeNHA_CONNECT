<?php
session_start();
include '../api/config.php'; // make sure $conn is defined here

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Insert into password_resets table
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expires]);

        // Generate reset link
        $resetLink = "http://localhost/Project.Kenha/KeNHA_CONNECT/admin/reset_password.php?token=$token";

        // (Simulate sending email)
        $success = "✅ Reset link sent! Please check your email.";
        echo "<script>console.log('Reset Link: $resetLink');</script>"; // for testing only
    } else {
        $error = "❌ No admin account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - KeNHA Connect</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .container h2 {
      margin-bottom: 1rem;
      color: #005baa;
    }
    .container form input, .container form button {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    .container form button {
      background-color: #005baa;
      color: white;
      border: none;
      cursor: pointer;
    }
    .container form button:hover {
      background-color: #003e7e;
    }
    .back {
      text-align: center;
      margin-top: 1rem;
    }
    .back a {
      text-decoration: none;
      color: #005baa;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>
    <?php if (!empty($success)): ?>
  <p style="color: green;"><?= $success ?></p>
<?php elseif (!empty($error)): ?>
  <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

    <form method="POST">
      <input type="email" name="email" placeholder="Enter your admin email" required>
      <button type="submit">Send Reset Link</button>
    </form>
    <div class="back">
      <a href="login.php">← Back to Login</a>
    </div>
  </div>
</body>
</html>
