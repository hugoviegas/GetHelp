<?php
// Basic config settings for the site
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include utility functions
require_once 'includes/functions.php';

// Site configuration
$config = [
    'site_name' => 'GetHelp',
    'site_description' => 'Your college module companion',
    'site_email' => '2024319@student.cct.ie',
    'site_phone' => '+123 456 7890'
];

// Define useful functions
function get_page_title($title = '') {
    global $config;
    if (!empty($title)) {
        return $title . ' - ' . $config['site_name'];
    }
    return $config['site_name'] . ' - ' . $config['site_description'];
}

// Function to sanitize user inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>