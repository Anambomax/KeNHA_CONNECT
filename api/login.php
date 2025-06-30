<?php
session_start();
include '../api/config.php'; // config.php defines $conn (PDO)

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $success = "Login successful! Redirecting to dashboard...";
        echo "<script>setTimeout(() => window.location = 'dashboard.php', 2000);</script>";
    } else {
        $error = "❌ Wrong email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - KeNHA Connect</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #005baa;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      background-color: white;
      padding: 2.5rem 2rem;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 400px;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #005baa;
    }

    .login-box form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .login-box input[type="email"],
    .login-box input[type="password"] {
      padding: 0.8rem;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      outline: none;
      transition: border-color 0.3s;
    }

    .login-box input:focus {
      border-color: #005baa;
    }

    .login-box button {
      background-color: #005baa;
      color: white;
      padding: 0.8rem;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .login-box button:hover {
      background-color: #003e7e;
    }

    .login-box .footer {
      margin-top: 1.5rem;
      font-size: 0.85rem;
      text-align: center;
      color: #777;
    }

    .error {
      color: red;
      text-align: center;
      margin-top: 1rem;
    }

    .success {
      color: green;
      text-align: center;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Admin Login</h2>

  <form method="POST">
    <input type="email" name="email" placeholder="ahmed@gmail.com" required>
    <input type="password" name="password" placeholder="•••••••••••" required>
    <button type="submit">Login</button>
  </form>

  <?php if (!empty($error)): ?>
    <p class="error"><?= $error ?></p>
  <?php elseif (!empty($success)): ?>
    <p class="success"><?= $success ?></p>
  <?php endif; ?>

  <div class="footer">© <?= date('Y') ?> KeNHA Connect</div>
</div>

</body>
</html>
