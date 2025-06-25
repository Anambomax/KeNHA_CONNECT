<?php
session_start();
include("includes/config.php");

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $county = $_POST["county"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, county, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $county, $phone, $password);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $msg = "Registration failed. Email may already exist.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="text-center text-success">Register</h4>
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
              <button class="btn btn-success w-100">Register</button>
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
