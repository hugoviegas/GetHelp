<?php
/**
 * Diagnostic Tool for GetHelp Website
 * 
 * This file runs various diagnostics to check system configuration,
 * database connectivity, and other critical components.
 */

// Show all errors for diagnostic purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>PHP & System Diagnostics</h2>";

// PHP Version
echo "<h3>PHP Info</h3>";
echo "PHP Version: " . phpversion() . "<br>";

// GD Extension (for image captcha)
echo "<h3>GD Extension</h3>";
if (extension_loaded('gd')) {
    echo "GD extension is <span style='color:green'>LOADED</span><br>";
    echo "GD Version: " . gd_info()['GD Version'] . "<br>";
} else {
    echo "GD extension is <span style='color:red'>NOT LOADED</span><br>";
    echo "This explains why captcha_image.php was failing.<br>";
}

// Session Test
echo "<h3>Session Test</h3>";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['test'] = 'Working';
echo "Session set value: " . $_SESSION['test'] . "<br>";

// Database Connection
echo "<h3>Database Connection</h3>";
try {
    require_once 'includes/db.php';
    echo "Database connection is <span style='color:green'>WORKING</span><br>";
    
    // Check if users table exists
    $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
    if (mysqli_num_rows($result) > 0) {
        echo "Users table exists.<br>";
        
        // Count users
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
        $count = mysqli_fetch_assoc($result)['count'];
        echo "Number of users in database: " . $count . "<br>";
    } else {
        echo "Users table does <span style='color:red'>NOT EXIST</span>.<br>";
    }
} catch (Exception $e) {
    echo "Database connection <span style='color:red'>FAILED</span>: " . $e->getMessage() . "<br>";
}

// CAPTCHA test
echo "<h3>CAPTCHA Test</h3>";
if (function_exists('generateCaptcha')) {
    echo "generateCaptcha function is <span style='color:green'>AVAILABLE</span><br>";
    include_once 'captcha.php';
    echo "Current CAPTCHA code: " . $_SESSION['captcha'] . "<br>";
} else {
    echo "generateCaptcha function is <span style='color:red'>NOT AVAILABLE</span> in this context.<br>";
}

// File permissions
echo "<h3>File Permissions</h3>";
$files = [
    'register.php',
    'login.php',
    'captcha.php',
    'includes/db.php',
    'includes/config.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $perms = fileperms($file);
        $perms_str = sprintf("%o", $perms);
        echo "$file permissions: $perms_str<br>";
    } else {
        echo "$file <span style='color:red'>DOES NOT EXIST</span><br>";
    }
}

echo "<h3>Register.php Redirection Test</h3>";
echo "The register.php file now redirects to index.php after successful registration.<br>";
echo "Check for any JavaScript that might be interfering with this redirect.<br>";

echo "<h3>Error Reporting Settings</h3>";
echo "display_errors: " . ini_get('display_errors') . "<br>";
echo "error_reporting: " . ini_get('error_reporting') . "<br>";

echo "<h3>Recommendations</h3>";
echo "1. Remove references to captcha_image.php or enable GD extension<br>";
echo "2. Add proper error handling in db.php<br>";
echo "3. Ensure proper redirection after registration<br>";
?> 