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
        <input type="text" name="fullname" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone" placeholder="Phone Number" required><br>
        
        <select name="county" required>
            <option value="">Select County</option>
            <?php
            $counties = [
                "Baringo", "Bomet", "Bungoma", "Busia", "Elgeyo-Marakwet", "Embu",
                "Garissa", "Homa Bay", "Isiolo", "Kajiado", "Kakamega", "Kericho",
                "Kiambu", "Kilifi", "Kirinyaga", "Kisii", "Kisumu", "Kitui", "Kwale",
                "Laikipia", "Lamu", "Machakos", "Makueni", "Mandera", "Marsabit",
                "Meru", "Migori", "Mombasa", "Murang'a", "Nairobi", "Nakuru", "Nandi",
                "Narok", "Nyamira", "Nyandarua", "Nyeri", "Samburu", "Siaya", "Taita Taveta",
                "Tana River", "Tharaka-Nithi", "Trans Nzoia", "Turkana", "Uasin Gishu",
                "Vihiga", "Wajir", "West Pokot"
            ];
            foreach ($counties as $county) {
                echo "<option value=\"$county\">$county</option>";
            }
            ?>
        </select><br>

        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>

        <button type="submit" name="register">Register</button>
    </form>
    <a href="login.php">Already have an account? Login</a>
</div>
</body>
</html>

<?php
if (isset($_POST['register'])) {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email    = $conn->real_escape_string($_POST['email']);
    $phone    = $conn->real_escape_string($_POST['phone']);
    $county   = $conn->real_escape_string($_POST['county']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Passwords must match
    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check for existing user/email
    $check = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Username or email already exists.');</script>";
    } else {
        // Save the user
        $sql = "INSERT INTO users (fullname, email, phone, county, username, password)
                VALUES ('$fullname', '$email', '$phone', '$county', '$username', '$hashed_password')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
