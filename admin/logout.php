<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logging Out...</title>
  <link rel="stylesheet" href="../public/css/admin.css">
  <meta http-equiv="refresh" content="2;url=login.php">
</head>
<body>
  <div class="container" style="text-align: center; margin-top: 100px;">
    <h2>You have been logged out.</h2>
    <p>Redirecting to login page...</p>
  </div>
</body>
</html>
