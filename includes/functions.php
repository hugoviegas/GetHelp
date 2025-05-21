<?php
/**
 * ===============================
 * functions.php - Utility Functions
 * ===============================
 * This file contains helper functions used throughout the GetHelp site.
 * Functions include formatting dates, truncating text, generating slugs,
 * validating emails, and navigation highlighting.
 */

/**
 * Format a date for display
 * 
 * @param string $date Date in YYYY-MM-DD format
 * @param string $format Desired output format
 * @return string Formatted date
 */
function format_date($date, $format = 'd/m/Y') {
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

/**
 * Truncate text to the specified length
 * 
 * @param string $text Text to be truncated
 * @param int $length Maximum length
 * @param string $append String to be added at the end if the text is truncated
 * @return string Truncated text
 */
function truncate_text($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Generate a URL-friendly string from text
 * 
 * @param string $text Text to be converted to slug
 * @return string URL-friendly string (slug)
 */
function slugify($text) {
    // Remove accents
    $text = remove_accents($text);
    
    // Convert to lowercase
    $text = strtolower($text);
    
    // Remove special characters
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    
    // Convert spaces to hyphens
    $text = preg_replace('/[\s-]+/', '-', $text);
    
    // Remove hyphens from start and end
    $text = trim($text, '-');
    
    return $text;
}

/**
 * Remove accents from text
 * 
 * @param string $text Text with accents
 * @return string Text without accents
 */
function remove_accents($text) {
    $map = [
        'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c', 'ñ' => 'n'
    ];
    
    return strtr($text, $map);
}

/**
 * Checks if a string is a valid email
 * 
 * @param string $email Email to be verified
 * @return bool true if it's a valid email, false otherwise
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Checks if the user is on a specific page
 * 
 * @param string $page Page name (without .php extension)
 * @return bool true if the user is on the page, false otherwise
 */
function is_current_page($page) {
    $current_file = basename($_SERVER['PHP_SELF']);
    return $current_file === $page . '.php';
}

/**
 * Adds the 'active' class if it's the current page
 * 
 * @param string $page Page name (without .php extension)
 * @return string String with 'active' class or empty string
 */
function active_class($page) {
    return is_current_page($page) ? ' class="active"' : '';
}
?>