<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">
  <div class="register-wrapper">
    <div class="register-box">
      <img src="uploads/kenha-logo.png" class="logo" alt="KeNHA Logo">
      <h2 class="subtitle">Register for KeNHA Connect</h2>

      <?php if (isset($_SESSION['register_error'])): ?>
        <div style="color: red; margin-bottom: 10px;">
          <?= $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
        </div>
      <?php endif; ?>

      <form action="../api/register.php" method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email (Gmail only)" required
               pattern="[a-zA-Z0-9._%+-]+@gmail\.com$"
               title="Only Gmail addresses allowed">

        <input type="text" name="phone" placeholder="Phone Number" required
               pattern="^(07|01|\+2547|\+2541)[0-9]{7}$"
               title="Starts with 07, 01, +2547, or +2541 followed by 7 digits">

        <input type="password" name="password" placeholder="Password (min 8 chars)" required
               pattern=".{8,}" title="Minimum 8 characters required">

        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <select name="county" required>
          <option value="">Select County</option>
          <?php
          $counties = [
            "Baringo", "Bomet", "Bungoma", "Busia", "Elgeyo-Marakwet", "Embu",
            "Garissa", "Homa Bay", "Isiolo", "Kajiado", "Kakamega", "Kericho",
            "Kiambu", "Kilifi", "Kirinyaga", "Kisii", "Kisumu", "Kitui", "Kwale",
            "Laikipia", "Lamu", "Machakos", "Makueni", "Mandera", "Marsabit",
            "Meru", "Migori", "Mombasa", "Murang'a", "Nairobi", "Nakuru",
            "Nandi", "Narok", "Nyamira", "Nyandarua", "Nyeri", "Samburu",
            "Siaya", "Taita-Taveta", "Tana River", "Tharaka-Nithi", "Trans Nzoia",
            "Turkana", "Uasin Gishu", "Vihiga", "Wajir", "West Pokot"
          ];
          foreach ($counties as $county) {
              echo "<option value=\"$county\">$county</option>";
          }
          ?>
        </select>

        <button class="btn" type="submit">Register</button>
      </form>

      <div class="extra-links">
        <p>Already have an account? <a href="index.php">Login</a></p>
      </div>
    </div>
  </div>
</body>
</html>
