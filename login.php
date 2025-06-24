<?php
// login.php
include('config.php');
session_start();
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "Wrong password.";
        }
    } else {
        $msg = "No account found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f4c75, #00b7c2);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-box {
      background-color: white;
      color: #333;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      max-width: 450px;
      margin: auto;
    }
    .form-control:focus {
      box-shadow: 0 0 10px #00b7c2;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
  <div class="form-box">
    <h3 class="text-center text-primary">Login</h3>
    <?php if ($msg): ?>
      <div class="alert alert-danger"><?= $msg ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" required class="form-control" />
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" required class="form-control" />
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
    </form>
  </div>
</body>
</html>
