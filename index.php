<?php
// === index.php === (Login Page)
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KeNHA Connect - Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="theme">
  <div class="container">
    <h1>🚧 KeNHA Connect</h1>
    <p class="subtitle">Login to Report & View Road Incidents</p>
    <form action="backend/login.php" method="POST" class="form">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p class="form-footer">Don't have an account? <a href="register.php">Register</a></p>
  </div>
</body>
</html>

<?php
// === register.php ===
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - KeNHA Connect</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="theme">
  <div class="container">
    <h1>Create Account</h1>
    <form action="backend/register.php" method="POST" class="form">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <select name="county" required>
        <option value="">Select County</option>
        <option value="Nairobi">Nairobi</option>
        <option value="Mombasa">Mombasa</option>
        <option value="Kisumu">Kisumu</option>
        <!-- Add other counties -->
      </select>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit">Register</button>
    </form>
    <p class="form-footer">Already have an account? <a href="index.php">Login</a></p>
  </div>
</body>
</html>

<?php
// === dashboard.php ===
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - KeNHA Connect</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="theme">
  <header class="header">
    <h2>KeNHA Dashboard</h2>
    <div class="header-actions">
      <a href="add_incident.php" class="report-btn">+ Report</a>
      <a href="profile.php" class="profile-btn">Profile</a>
    </div>
  </header>
  <main class="feed">
    <!-- Dynamically load incidents here -->
    <div class="incident-card">
      <img src="uploads/images/sample.jpg" alt="Incident Image">
      <p><strong>Description:</strong> Pothole near Highway Bypass</p>
      <div class="reactions">👍 12 👎 2 💬 3</div>
    </div>
    <!-- More incidents -->
  </main>
</body>
</html>

<?php
// === add_incident.php ===
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Incident - KeNHA Connect</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="theme">
  <div class="container">
    <h1>Report Road Incident</h1>
    <form action="backend/add_incident.php" method="POST" enctype="multipart/form-data" class="form">
      <input type="file" name="image" accept="image/*" required>
      <textarea name="description" placeholder="Describe the incident..." required></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>

<?php
// === profile.php ===
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - KeNHA Connect</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="theme">
  <div class="container">
    <h1>My Profile</h1>
    <p>Name: John Doe</p>
    <p>Email: johndoe@example.com</p>
    <p>County: Nairobi</p>
    <a href="backend/logout.php" class="report-btn">Logout</a>
  </div>
</body>
</html>

<?php
// === public_channel.php ===
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Public Channel - KeNHA Connect</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="theme">
  <div class="container">
    <h1>Resolved Road Issues</h1>
    <div class="incident-card">
      <img src="uploads/images/fixed.jpg" alt="Resolved">
      <p><strong>Issue:</strong> Fixed pothole near Roundabout</p>
      <p><em>Resolved by KeNHA Team on 2025-06-20</em></p>
    </div>
  </div>
</body>
</html>

<?php
// === style.css (append more styles for layout) ===
?>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #000;
  color: #fff;
  padding: 1rem 2rem;
  border-bottom: 2px solid #f1c40f;
}
.header-actions a {
  color: #000;
  background: #f1c40f;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  margin-left: 1rem;
  text-decoration: none;
  font-weight: bold;
}
.feed {
  padding: 2rem;
}
.incident-card {
  background: #111;
  border: 1px solid #f1c40f;
  border-radius: 0.5rem;
  padding: 1rem;
  margin-bottom: 1rem;
  color: #fff;
}
.incident-card img {
  max-width: 100%;
  border-radius: 0.5rem;
  margin-bottom: 0.5rem;
}
textarea {
  width: 100%;
  height: 100px;
  background: #222;
  color: white;
  border: none;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
  padding: 1rem;
  resize: none;
}
