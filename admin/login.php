<?php
session_start();
include '../api/config.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $success = "✅ Login successful. Redirecting to dashboard...";
        echo "<script>
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 2000);
        </script>";
    } else {
        $error = "❌ Email or password mismatch.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Login - KeNHA Connect</title>
  <link rel="stylesheet" href="../public/css/login.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #005baa;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-wrapper {
      background-color: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    input, button {
      width: 100%;
      padding: 0.75rem;
      margin: 0.5rem 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    button {
      background-color: #005baa;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #003e7e;
    }
    .message {
      margin-top: 1rem;
      font-size: 0.95rem;
    }
    .success {
      color: green;
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <h2>Admin Login</h2>
    <form method="POST" autocomplete="off">
      <!-- Fake fields to prevent browser autofill -->
      <input type="text" name="fakeuser" id="fakeuser" style="display:none" autocomplete="off">
      <input type="password" name="fakepass" id="fakepass" style="display:none" autocomplete="off">

      <input type="email" name="email" placeholder="Email" autocomplete="off"
             required oninvalid="this.setCustomValidity('Please enter email')"
             oninput="this.setCustomValidity('')">

      <input type="password" name="password" placeholder="Password" autocomplete="off"
             required oninvalid="this.setCustomValidity('Enter password')"
             oninput="this.setCustomValidity('')">

      <div style="text-align: right; margin-bottom: 10px;">
        <a href="forgot_password.php" style="font-size: 0.9rem; color: #005baa;">Forgot Password?</a>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="message">
      <?php if (!empty($success)): ?>
        <p class="success"><?= $success ?></p>
      <?php elseif (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
