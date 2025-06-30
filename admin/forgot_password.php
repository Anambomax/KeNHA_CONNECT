<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - KeNHA Connect</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    .container h2 {
      margin-bottom: 1rem;
      color: #005baa;
    }
    .container form input, .container form button {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }
    .container form button {
      background-color: #005baa;
      color: white;
      border: none;
      cursor: pointer;
    }
    .container form button:hover {
      background-color: #003e7e;
    }
    .back {
      text-align: center;
      margin-top: 1rem;
    }
    .back a {
      text-decoration: none;
      color: #005baa;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Enter your admin email" required>
      <button type="submit">Send Reset Link</button>
    </form>
    <div class="back">
      <a href="login.php">← Back to Login</a>
    </div>
  </div>
</body>
</html>
