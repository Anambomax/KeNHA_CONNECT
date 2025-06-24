<?php
// register.php
include('config.php');
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm  = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email format!";
    } elseif ($password !== password_hash($confirm, PASSWORD_DEFAULT)) {
        $msg = "Passwords do not match!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Registration failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #064663, #0e7490);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-box {
      background-color: white;
      color: #333;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      max-width: 500px;
      margin: auto;
    }
    .form-control:focus {
      box-shadow: 0 0 10px #0e7490;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
  <div class="form-box">
    <h3 class="text-center text-primary">Register</h3>
    <?php if ($msg): ?>
      <div class="alert alert-warning"><?= $msg ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" required class="form-control" />
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" required class="form-control" />
      </div>
      <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" required class="form-control" />
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" required class="form-control" />
      </div>
      <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required class="form-control" />
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
      <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>
