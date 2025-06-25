<?php
session_start();
include("includes/config.php");

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $county = trim($_POST["county"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm"]);

    if ($password !== $confirm) {
        $msg = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, county, phone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $county, $phone, $hashed);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            $msg = "Registration failed. Try a different email.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; color: #000; }
    .card { border-left: 5px solid #ffc107; }
    .btn-yellow { background-color: #ffc107; border: none; color: black; }
    .btn-yellow:hover { background-color: #e0a800; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="text-center mb-4" style="color:#ffc107;">Create Your Account</h4>
            <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>County</label>
                <input type="text" name="county" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm" class="form-control" required>
              </div>
              <button class="btn btn-yellow w-100">Register</button>
            </form>
            <div class="text-center mt-3">
              <a href="index.php">Already have an account? Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
