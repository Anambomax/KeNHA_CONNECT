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
  <style>
    .password-rules {
      font-size: 13px;
      margin-top: 10px;
      text-align: left;
    }

    .password-rules li {
      list-style: none;
      color: red;
    }

    .password-rules li.valid {
      color: green;
    }
  </style>
</head>
<body class="kenha-bg">
  <div class="register-wrapper">
    <div class="register-box">
      <img src="uploads/kenha-logo.png" class="logo" alt="KeNHA Logo">
      <h2 class="subtitle">KENHA CONNECT</h2>

      <form action="../api/register.php" method="POST" onsubmit="return validateForm();">
        <input type="text" name="full_name" placeholder="Full Name" required>

        <input type="email" name="email" id="email" placeholder="Email" required pattern="^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$" title="Enter a valid email address">

        <input type="tel" name="phone" id="phone" placeholder="Phone Number (e.g., 0712345678 or 0112345678)" required pattern="^(07|01)\d{8}$" title="Start with 07 or 01 and must be 10 digits">

        <select name="county" required>
          <option value="">Select County</option>
          <?php
          $counties = [
            "Baringo", "Bomet", "Bungoma", "Busia", "Elgeyo-Marakwet", "Embu", "Garissa",
            "Homa Bay", "Isiolo", "Kajiado", "Kakamega", "Kericho", "Kiambu", "Kilifi",
            "Kirinyaga", "Kisii", "Kisumu", "Kitui", "Kwale", "Laikipia", "Lamu",
            "Machakos", "Makueni", "Mandera", "Marsabit", "Meru", "Migori", "Mombasa",
            "Murang'a", "Nairobi", "Nakuru", "Nandi", "Narok", "Nyamira", "Nyandarua",
            "Nyeri", "Samburu", "Siaya", "Taita Taveta", "Tana River", "Tharaka-Nithi",
            "Trans Nzoia", "Turkana", "Uasin Gishu", "Vihiga", "Wajir", "West Pokot"
          ];
          foreach ($counties as $county) {
            echo "<option value=\"$county\">$county</option>";
          }
          ?>
        </select>

        <input type="password" name="password" id="password" placeholder="Password" required>
        <input type="password" id="confirm_password" placeholder="Confirm Password" required>

        <ul class="password-rules" id="rules">
          <li id="length">At least 8 characters</li>
          <li id="uppercase">At least one uppercase letter</li>
          <li id="lowercase">At least one lowercase letter</li>
          <li id="number">At least one number</li>
        </ul>

        <button class="btn" type="submit">Register</button>
      </form>

      <div class="extra-links">
        <p>Already have an account? <a href="index.php">Login</a></p>
      </div>
    </div>
  </div>

  <script>
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");

    const rules = {
      length: document.getElementById("length"),
      uppercase: document.getElementById("uppercase"),
      lowercase: document.getElementById("lowercase"),
      number: document.getElementById("number")
    };

    passwordInput.addEventListener("input", () => {
      const value = passwordInput.value;
      rules.length.classList.toggle("valid", value.length >= 8);
      rules.uppercase.classList.toggle("valid", /[A-Z]/.test(value));
      rules.lowercase.classList.toggle("valid", /[a-z]/.test(value));
      rules.number.classList.toggle("valid", /\d/.test(value));
    });

    function validateForm() {
      const pass = passwordInput.value;
      const confirm = confirmPasswordInput.value;

      if (pass !== confirm) {
        alert("Passwords do not match.");
        return false;
      }

      if (
        pass.length < 8 ||
        !/[A-Z]/.test(pass) ||
        !/[a-z]/.test(pass) ||
        !/\d/.test(pass)
      ) {
        alert("Password does not meet all requirements.");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>
