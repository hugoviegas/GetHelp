<?php
// ===============================
// logout.php - User Logout Script
// ===============================
// This script logs the user out by destroying their session and redirects them to the home page.

// Include configuration file (for session and settings)
require_once 'includes/config.php';

// Unset all session variables (removes all user data from the session)
$_SESSION = array();

// Destroy the session (completely logs the user out)
session_destroy();

// Redirect to home page after logout
header("Location: index.php");
exit();
?>