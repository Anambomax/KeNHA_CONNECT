<?php include 'db.php'; ?>
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
        <input type="text" name="full_name" placeholder="Full Name" required><br>

        <input type="email" name="email" placeholder="you@example.com" 
            title="Please enter a valid email (e.g. someone@gmail.com)" required><br>

        <input type="text" name="phone" placeholder="+254700000000 or 0700000000" 
            title="Enter phone like +254712345678 or 0712345678" required pattern="^(\+254|0)\d{9}$"><br>

        <select name="county" required title="Please select your county">
            <option value="">-- Select County --</option>
            <?php
            $counties = ["Mombasa", "Kwale", "Kilifi", "Tana River", "Lamu", "Taita Taveta", "Garissa", "Wajir", "Mandera",
                         "Marsabit", "Isiolo", "Meru", "Tharaka Nithi", "Embu", "Kitui", "Machakos", "Makueni", "Nyandarua",
                         "Nyeri", "Kirinyaga", "Murang'a", "Kiambu", "Turkana", "West Pokot", "Samburu", "Trans Nzoia",
                         "Uasin Gishu", "Elgeyo Marakwet", "Nandi", "Baringo", "Laikipia", "Nakuru", "Narok", "Kajiado",
                         "Kericho", "Bomet", "Kakamega", "Vihiga", "Bungoma", "Busia", "Siaya", "Kisumu", "Homa Bay",
                         "Migori", "Kisii", "Nyamira", "Nairobi"];
            foreach ($counties as $c) {
                echo "<option value=\"$c\">$c</option>";
            }
            ?>
        </select><br>

        <select name="role" required title="Choose your role in the system">
            <option value="">-- Select Role --</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="stakeholder">Stakeholder</option>
        </select><br>

        <input type="password" name="password" placeholder="Password" 
            title="Password must be at least 8 characters, include numbers, letters, and a symbol"
            pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
            required><br>

        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>

        <button type="submit" name="register">Register</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>
</body>
</html>

<?php
if (isset($_POST['register'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email     = $conn->real_escape_string($_POST['email']);
    $phone     = $conn->real_escape_string($_POST['phone']);
    $county    = $conn->real_escape_string($_POST['county']);
    $role      = $conn->real_escape_string($_POST['role']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit;
    }

    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $password)) {
        echo "<script>alert('Password must be at least 8 characters, include letters, numbers, and a symbol.');</script>";
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check for duplicates
    $check = $conn->query("SELECT * FROM users WHERE email='$email' OR phone='$phone'");
    if ($check->num_rows > 0) {
        echo "<script>alert('User with that email or phone already exists.');</script>";
    } else {
        $sql = "INSERT INTO users (full_name, email, phone, county, role, password)
                VALUES ('$full_name', '$email', '$phone', '$county', '$role', '$hashed')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
