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
    // Placeholder logic
    echo "<script>alert('Registration clicked! (You can now save this to a DB)');</script>";
}
?>
