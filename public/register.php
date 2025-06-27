<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - KENHA CONNECT</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">
  <div class="login-wrapper">
    <form action="../api/register.php" method="POST" class="login-box" onsubmit="return validateForm()">
      <img src="uploads/kenha-logo.png" alt="KeNHA Logo" class="logo">
      <h2>KENHA CONNECT</h2>
      <p class="subtitle">Create Your Account</p>

      <input type="text" name="full_name" placeholder="Full Name" required>
      <input type="email" name="email" id="email" placeholder="Email Address" required>
      <input type="text" name="phone" id="phone" placeholder="Phone Number (07xxxxxxxx)" required>

      <select name="county" required>
        <option value="">Select Your County</option>
        <?php
        $counties = [
          "Mombasa", "Kwale", "Kilifi", "Tana River", "Lamu", "Taita Taveta",
          "Garissa", "Wajir", "Mandera", "Marsabit", "Isiolo", "Meru", "Tharaka Nithi",
          "Embu", "Kitui", "Machakos", "Makueni", "Nyandarua", "Nyeri", "Kirinyaga",
          "Murang'a", "Kiambu", "Turkana", "West Pokot", "Samburu", "Trans Nzoia",
          "Uasin Gishu", "Elgeyo Marakwet", "Nandi", "Baringo", "Laikipia", "Nakuru",
          "Narok", "Kajiado", "Kericho", "Bomet", "Kakamega", "Vihiga", "Bungoma",
          "Busia", "Siaya", "Kisumu", "Homa Bay", "Migori", "Kisii", "Nyamira", "Nairobi"
        ];
        foreach ($counties as $county) {
            echo "<option value=\"$county\">$county</option>";
        }
        ?>
      </select>

      <input type="password" name="password" id="password" placeholder="Password" required>
      <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>

      <button type="submit" class="btn">Register</button>

      <div class="extra-links">
        <p>Already have an account? <a href="index.php">Login here</a></p>
      </div>
    </form>
  </div>

  <script>
    function validateForm() {
      const phone = document.getElementById('phone').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm_password').value;

      const phoneRegex = /^07\d{8}$/;
      if (!phoneRegex.test(phone)) {
        alert("Phone number must start with 07 and be 10 digits.");
        return false;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters.");
        return false;
      }

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>
