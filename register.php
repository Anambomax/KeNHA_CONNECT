<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | KeNHA Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #1e1f31, #2a2d45);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-card {
      background-color: rgba(0, 0, 0, 0.4);
      padding: 35px;
      border-radius: 16px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 0 25px rgba(0, 255, 255, 0.1);
    }

    h2 {
      text-align: center;
      color: #00e5ff;
      margin-bottom: 25px;
    }

    .form-control, select {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: #fff;
    }

    .form-control::placeholder {
      color: #ccc;
    }

    .btn-primary {
      background-color: #00e5ff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #00bcd4;
    }

    label {
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <form method="POST" action="register_process.php" class="form-card">
    <h2>Register - KeNHA Connect</h2>

    <div class="mb-3">
      <label>Full Name</label>
      <input type="text" name="fullname" class="form-control" placeholder="Your Name" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
    </div>

    <div class="mb-3">
      <label>Phone Number</label>
      <input type="text" name="phone" class="form-control" placeholder="07XXXXXXXX" required>
    </div>

    <div class="mb-3">
      <label>County</label>
      <select name="county" class="form-control" required>
        <option value="">-- Select County --</option>
        <option>Nairobi</option>
        <option>Mombasa</option>
        <option>Kisumu</option>
        <option>Nakuru</option>
        <option>Kiambu</option>
        <option>Machakos</option>
        <option>Uasin Gishu</option>
        <option>Kericho</option>
        <option>Bungoma</option>
        <option>Kakamega</option>
        <!-- Add more counties as needed -->
      </select>
    </div>

    <div class="mb-3">
      <label>Role</label>
      <select name="role" class="form-control" required>
        <option value="">-- Select Role --</option>
        <option>Public</option>
        <option>KeNHA Staff</option>
        <option>EMT</option>
        <option>Traffic Police</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>

    <div class="mb-3">
      <label>Confirm Password</label>
      <input type="password" name="confirm_password" class="form-control" placeholder="Repeat Password" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
    <div class="text-center mt-3">
      <a href="login.php" style="color: #90caf9;">Already have an account? Login</a>
    </div>
  </form>

</body>
</html>
