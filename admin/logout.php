<link rel="stylesheet" href="../public/css/admin.css">
<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
