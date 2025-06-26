<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result)) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user;

        switch ($user['role']) {
            case 'kenha_staff': header("Location: dashboards/kenha_staff.php"); break;
            case 'emt': header("Location: dashboards/emt.php"); break;
            case 'traffic_police': header("Location: dashboards/traffic_police.php"); break;
            case 'medics': header("Location: dashboards/medics.php"); break;
            case 'contractor': header("Location: dashboards/contractor.php"); break;
            default: header("Location: dashboards/public.php"); break;
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KeNHA Connect - Login</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="style.css" />
</head>
<body class="auth-page">
    <div class="form-container">
        <h2>Login to KeNHA Connect</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required /><br />
            <input type="password" name="password" placeholder="Password" required /><br />
            <button type="submit" name="login">Login</button>
        </form>
        <p style="margin-top: 10px;">Don’t have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
