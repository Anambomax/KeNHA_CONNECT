<?php
session_start();
include '../api/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $success = "Login successful! Redirecting to dashboard...";
        echo "<script>
                setTimeout(() => window.location = 'dashboard.php', 2000);
              </script>";
    } else {
        $error = "Wrong email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - KeNHA Connect</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        .login-container h2 {
            color: #005baa;
            margin-bottom: 1.5rem;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .login-container input {
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .login-container button {
            background-color: #005baa;
            color: white;
            padding: 0.75rem;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #003e7e;
        }

        .error {
            color: red;
            margin-top: 1rem;
        }

        .success {
            color: green;
            margin-top: 1rem;
        }

        .footer {
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Admin Login</h2>
    <form method="POST" novalidate>
    <input
        type="email"
        name="email"
        placeholder="Email"
        required
        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
        title="Please enter a valid email address (e.g. admin@example.com)"
        autocomplete="off"
    >
    <input
        type="password"
        name="password"
        placeholder="Password"
        required
        pattern="(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}"
        title="Password must be at least 8 characters, contain letters, numbers, and a special character"
        autocomplete="new-password"
    >
    
    <!-- Forgot Password link -->
    <a href="forgot_password.php" style="font-size: 0.9rem; color: #005baa; text-decoration: none; margin-top: -0.5rem;">Forgot Password?</a>

    <button type="submit">Login</button>
</form>

    <?php if (!empty($error)): ?>
        <p id="error-message" class="error"><?= $error ?></p>
    <?php elseif (!empty($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <div class="footer">© <?= date('Y') ?> KeNHA Connect</div>
</div>

<script>
    setTimeout(() => {
        const msg = document.getElementById('error-message');
        if (msg) msg.style.display = 'none';
    }, 2000);
</script>
</body>
</html>
