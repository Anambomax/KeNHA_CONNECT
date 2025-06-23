<!DOCTYPE html>
<html>
<head>
    <title>Login - KeNHA Connect</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register</a>
    </div>
</body>
</html>

<?php
if (isset($_POST['login'])) {
    // This is just a placeholder
    echo "<script>alert('Login clicked! (You can now connect this to your DB)');</script>";
}
?>
