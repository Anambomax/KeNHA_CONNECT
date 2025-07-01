<?php
include '../api/config.php'; // Make sure $conn is defined in this file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name  = $_POST['full_name'] ?? '';
    $email      = $_POST['email'] ?? '';
    $phone      = $_POST['phone'] ?? '';
    $county     = $_POST['county'] ?? '';
    $department = $_POST['department'] ?? '';
    $password   = $_POST['password'] ?? '';
    $role       = 'admin';

    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/", $password)) {
        $error = "Password must be at least 8 characters and include a letter, a number, and a special character.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use $conn instead of undefined $pdo
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, county, password, role, department) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $executed = $stmt->execute([$full_name, $email, $phone, $county, $hashed_password, $role, $department]);

        if ($executed) {
            echo "<script>alert('✅ Admin registered successfully. Redirecting to login...'); 
                  window.location='login.php';</script>";
            exit;
        } else {
            $error = "❌ Failed to register admin.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>
    <style>
        body {
            background: #e0f2f1;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1.2rem;
            color: #00796b;
        }
        input, select {
            width: 100%;
            padding: 0.7rem;
            margin: 0.6rem 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            padding: 0.8rem;
            background: #00796b;
            color: white;
            border: none;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #004d40;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<form method="POST">
    <h2>Add New Admin</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email (e.g. admin@kenha.go.ke)" required>
    <input type="text" name="phone" placeholder="Phone (e.g. 0722334455)" required>

    <select name="county" required>
        <option value="">-- Select County --</option>
        <?php
        $counties = [
            "Baringo","Bomet","Bungoma","Busia","Elgeyo Marakwet","Embu","Garissa","Homa Bay",
            "Isiolo","Kajiado","Kakamega","Kericho","Kiambu","Kilifi","Kirinyaga","Kisii",
            "Kisumu","Kitui","Kwale","Laikipia","Lamu","Machakos","Makueni","Mandera",
            "Marsabit","Meru","Migori","Mombasa","Murang'a","Nairobi","Nakuru","Nandi",
            "Narok","Nyamira","Nyandarua","Nyeri","Samburu","Siaya","Taita Taveta",
            "Tana River","Tharaka Nithi","Trans Nzoia","Turkana","Uasin Gishu","Vihiga",
            "Wajir","West Pokot"
        ];
        foreach ($counties as $countyName) {
            echo "<option value=\"$countyName\">$countyName</option>";
        }
        ?>
    </select>

    <select name="department" required>
        <option value="">-- Select Department --</option>
        <option value="ICT">ICT</option>
        <option value="Finance">Finance</option>
        <option value="HR">Human Resources</option>
        <option value="Maintenance">Maintenance</option>
    </select>

    <input type="password" name="password" placeholder="Password (Min 8 chars, letter, number, special char)" required>
    <button type="submit">Register Admin</button>
</form>
</body>
</html>
