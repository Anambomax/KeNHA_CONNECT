<?php
include 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $county = $_POST['county'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = md5($_POST['password']);
    $confirm = md5($_POST['confirm']);

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $check = "SELECT * FROM users WHERE email='$email'";
        $res = mysqli_query($conn, $check);

        if (mysqli_num_rows($res)) {
            $error = "Email already exists.";
        } else {
            $sql = "INSERT INTO users (name, county, email, phone, role, password)
                    VALUES ('$name', '$county', '$email', '$phone', '$role', '$password')";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
            } else {
                $error = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>KeNHA Connect - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="form-container">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required><br>

            <select name="county" required>
                <option value="">-- Select County --</option>
                <?php
                $counties = [
                    "Baringo", "Bomet", "Bungoma", "Busia", "Elgeyo Marakwet", "Embu", "Garissa",
                    "Homa Bay", "Isiolo", "Kajiado", "Kakamega", "Kericho", "Kiambu", "Kilifi",
                    "Kirinyaga", "Kisii", "Kisumu", "Kitui", "Kwale", "Laikipia", "Lamu", "Machakos",
                    "Makueni", "Mandera", "Marsabit", "Meru", "Migori", "Mombasa", "Murang'a",
                    "Nairobi", "Nakuru", "Nandi", "Narok", "Nyamira", "Nyandarua", "Nyeri",
                    "Samburu", "Siaya", "Taita Taveta", "Tana River", "Tharaka Nithi", "Trans Nzoia",
                    "Turkana", "Uasin Gishu", "Vihiga", "Wajir", "West Pokot"
                ];
                foreach ($counties as $c) {
                    echo "<option value='$c'>$c</option>";
                }
                ?>
            </select><br>

            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phone" placeholder="Phone" required><br>

            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option value="public">Public</option>
                <option value="kenha_staff">KeNHA Staff</option>
                <option value="emt">EMT</option>
                <option value="traffic_police">Traffic Police</option>
                <option value="medics">Medics</option>
                <option value="contractor">Contractor</option>
            </select><br>

            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm" placeholder="Confirm Password" required><br>

            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
