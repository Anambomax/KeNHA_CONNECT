<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - KeNHA CONNECT</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="brand">KeNHA CONNECT</div>
        <h2>Create an Account</h2>
        <form id="registerForm">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <select name="county" required>
                <option value="">Select County</option>
                <?php
                $counties = ["Mombasa","Kwale","Kilifi","Tana River","Lamu","Taita-Taveta","Garissa","Wajir",
                "Mandera","Marsabit","Isiolo","Meru","Tharaka-Nithi","Embu","Kitui","Machakos","Makueni",
                "Nyandarua","Nyeri","Kirinyaga","Murang’a","Kiambu","Turkana","West Pokot","Samburu",
                "Trans Nzoia","Uasin Gishu","Elgeyo-Marakwet","Nandi","Baringo","Laikipia","Nakuru",
                "Narok","Kajiado","Kericho","Bomet","Kakamega","Vihiga","Bungoma","Busia","Siaya",
                "Kisumu","Homa Bay","Migori","Kisii","Nyamira","Nairobi"];
                foreach ($counties as $county) {
                    echo "<option value=\"$county\">$county</option>";
                }
                ?>
            </select>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>

    <script>
    document.getElementById("registerForm").addEventListener("submit", function(e){
        e.preventDefault();

        const data = {
            full_name: this.full_name.value,
            email: this.email.value,
            phone: this.phone.value,
            county: this.county.value,
            password: this.password.value,
            confirm_password: this.confirm_password.value
        };

        axios.post('../api/register.php', data)
            .then(response => {
                alert(response.data.success);
                window.location.href = "index.php";
            })
            .catch(error => {
                alert("Error: " + (error.response?.data?.error || "Server error"));
            });
    });
    </script>
</body>
</html>
