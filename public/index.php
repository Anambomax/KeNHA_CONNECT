<?php
session_start();

// ✅ Check if user is already logged in
if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
    // Role-based redirect
    switch ($_SESSION['role']) {
        case 'ADMIN':
            header("Location: ../dashboard.php?role=admin");
            break;
        case 'staff':
            header("Location: ../dashboard.php?role=staff");
            break;
        case 'user':
        default:
            header("Location: ../dashboard.php?role=user");
            break;
    }
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
      <h2>Login to KeNHA Connect</h2>

      <?php if (isset($_SESSION['login_error'])): ?>
        <p style="color: red"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
      <?php endif; ?>

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
