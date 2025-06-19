<?php
session_start();
include 'db_connect.php'; // Make sure this file exists and connects correctly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, fullname, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $fullname, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["fullname"] = $fullname;
                $_SESSION["email"] = $email;
                $_SESSION["role"] = $role;

                // Redirect based on role
                switch (strtolower($role)) {
                    case "public":
                        header("Location: dashboards/public_dashboard.php");
                        break;
                    case "kenha staff":
                        header("Location: dashboards/kenha_staff_dashboard.php");
                        break;
                    case "emt":
                        header("Location: dashboards/emt_dashboard.php");
                        break;
                    case "traffic police":
                        header("Location: dashboards/traffic_dashboard.php");
                        break;
                    default:
                        $error = "Unknown role.";
                }
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | KeNHA Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #1e1f31, #2a2d45);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        .form-card {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 16px;
            padding: 35px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.1);
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #00e5ff;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .btn-primary {
            background-color: #00e5ff;
            border: none;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #00bcd4;
        }

        .text-center a {
            color: #90caf9;
            text-decoration: none;
            display: block;
            margin-top: 15px;
        }

        .error-message {
            color: #ff7373;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <form method="POST" class="form-card">
        <h2>KeNHA Connect Login</h2>

        <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

        <input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
        <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>

        <button type="submit" class="btn btn-primary">Login</button>

        <div class="text-center">
            <a href="register.php">Don't have an account? Register</a>
        </div>
    </form>

</body>
</html>
