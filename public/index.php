<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
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
    <form action="../api/login.php" method="POST" class="login-box">
      <!-- LOGO -->
      <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="logo">
      
      <h2>KENHA CONNECT</h2>

      <input type="text" name="username" placeholder="User Name" required>
      <input type="password" name="password" placeholder="Password" required>

      <div class="captcha-box">
        <input type="checkbox" required>
        <label>I'm not a robot</label>
      </div>

      <div class="remember-me">
        <input type="checkbox" name="remember">
        <label>Remember Me</label>
      </div>

      <button type="submit" class="btn">Sign In</button>

      <div class="extra-links">
        <a href="#">Forgot password?</a>
        <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
      </div>
    </form>
  </div>
</body>
</html>
