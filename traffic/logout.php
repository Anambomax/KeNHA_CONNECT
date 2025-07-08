<?php
session_start();

// Unset all traffic-specific session variables
unset($_SESSION['traffic_admin_id']);
unset($_SESSION['traffic_admin_name']);

// Destroy session
session_destroy();

// Redirect to traffic login
header("Location: login.php");
exit();
?>
