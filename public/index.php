<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - KeNHA CONNECT</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="brand">KeNHA CONNECT</div>
        <h2>Login</h2>
        <form id="loginForm">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don’t have an account? <a href="register.php">Register</a></p>
    </div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", function(e){
        e.preventDefault();

        const data = {
            email: this.email.value,
            password: this.password.value
        };

        axios.post('../api/login.php', data)
            .then(response => {
                if (response.data.role === 'admin') {
                    window.location.href = "../admin/dashboard.php";
                } else {
                    window.location.href = "dashboard.php";
                }
            })
            .catch(error => {
                alert("Login failed: " + (error.response?.data?.error || "Server error"));
            });
    });
    </script>
</body>
</html>
