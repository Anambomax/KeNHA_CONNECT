<?php
session_start();
include '../api/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        echo "<script>
            alert('Login successful');
            window.location.href = 'dashboard.php';
        </script>";
        exit();
    } else {
        $error = "Wrong email or password.";
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
  </style>
</head>
<body>
  <div class="login-wrapper">
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  </div>
</body>
</html>
