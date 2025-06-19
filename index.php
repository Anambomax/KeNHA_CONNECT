<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KeNHA Connect - Report. Resolve. Improve.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #141e30, #243b55);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            color: #ffffff;
        }

        .landing-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 60px 45px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 90%;
        }

        .landing-card h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .landing-card p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 35px;
            color: #e0e0e0;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1rem;
            margin: 10px;
            transition: all 0.3s ease-in-out;
        }

        .btn-register {
            background-color: #00bcd4;
            color: white;
            border: none;
        }

        .btn-register:hover {
            background-color: #0097a7;
        }

        .btn-login {
            background-color: #673ab7;
            color: white;
            border: none;
        }

        .btn-login:hover {
            background-color: #512da8;
        }

        @media (max-width: 576px) {
            .landing-card {
                padding: 40px 25px;
            }

            .landing-card h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="landing-card">
        <h1>KeNHA Connect</h1>
        <p>
            Empowering citizens to <strong>report</strong> road issues and enabling KeNHA to <strong>resolve</strong> them swiftly. 
            Together, we build a smarter, safer and more efficient national road network across Kenya.
        </p>
        <div>
            <a href="register.php" class="btn btn-custom btn-register">Register</a>
            <a href="login.php" class="btn btn-custom btn-login">Login</a>
        </div>
    </div>
</body>
</html>
