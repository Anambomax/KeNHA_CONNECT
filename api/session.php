<?php
// Ensure session is shared across all paths
ini_set('session.cookie_path', '/');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not authenticated
if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_name']) ||
    !isset($_SESSION['location'])
) {
    header("Location: ../public/index.php");
    exit();
}
