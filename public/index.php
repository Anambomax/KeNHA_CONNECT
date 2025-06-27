<?php
session_start();
if (isset($_SESSION['email'])) {
  header("Location: dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">
  <div class="login-wrapper">
    <div class="login-box">
      <img src="uploads/kenha-logo.png" class="logo" alt="KeNHA Logo">
      <h2 class="subtitle">KENHA CONNECT</h2>
      <form action="../api/login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="btn" type="submit">Login</button>
      </form>
      <div class="extra-links">
        <p>Don't have an account? <a href="register.php">Register</a></p>
      </div>
    </div>
  </div>
</body>
</html>
