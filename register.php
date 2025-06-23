<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - KeNHA Connect</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>
</body>
</html>

<?php
if (isset($_POST['register'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $email    = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user already exists
    $check = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Username or email already exists.');</script>";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
