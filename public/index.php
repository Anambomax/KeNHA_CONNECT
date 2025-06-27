<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - KENHA CONNECT</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">
  <div class="login-wrapper">
    <form action="../api/login.php" method="POST" class="login-box">
      <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="logo">
      <h2>KENHA CONNECT</h2>
      <p class="subtitle">Login to your account</p>

      <input type="email" name="email" placeholder="Email Address" required>
      <input type="password" name="password" placeholder="Password" required>

      <button type="submit" class="btn">Login</button>

      <div class="extra-links">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
      </div>
    </form>
  </div>
</body>
</html>
