<?php
session_start();
include("includes/config.php");

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            header("Location: dashboard.php");
            exit;
        } else {
            $msg = "Invalid password.";
        }
    } else {
        $msg = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login | KeNHA Connect</title>
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
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="text-center mb-4" style="color:#ffc107;">KeNHA Connect Login</h4>
            <?php if ($msg): ?><div class="alert alert-danger"><?= $msg ?></div><?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button class="btn btn-yellow w-100">Login</button>
            </form>
            <div class="text-center mt-3">
              <a href="register.php">Don't have an account? Register</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
