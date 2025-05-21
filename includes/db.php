<?php
/**
 * ===============================
 * db.php - Database Connection and Utility Functions
 * ===============================
 * This file handles the connection to the MySQL database and provides
 * helper functions for querying, inserting, and updating data.
 * It also ensures the users table exists and creates an admin user if needed.
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'gethelp';

// Create connection without database (so we can create it if needed)
$conn = mysqli_connect($db_host, $db_user, $db_pass);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if database exists, if not create it
$check_db = mysqli_query($conn, "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");

if (mysqli_num_rows($check_db) == 0) {
    // Database doesn't exist, create it
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if (!mysqli_query($conn, $sql)) {
        die("Error creating database: " . mysqli_error($conn));
    }
    
    // Select the new database
    if (!mysqli_select_db($conn, $db_name)) {
        die("Error selecting database: " . mysqli_error($conn));
    }
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','mentor','student') NOT NULL DEFAULT 'student',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if (!mysqli_query($conn, $sql)) {
        die("Error creating users table: " . mysqli_error($conn));
    }
} else {
    // Select the existing database
    if (!mysqli_select_db($conn, $db_name)) {
        die("Error selecting database: " . mysqli_error($conn));
    }
    // Check if 'role' column exists, add if missing
    $check_role = mysqli_query($conn, "SHOW COLUMNS FROM users LIKE 'role'");
    if ($check_role && mysqli_num_rows($check_role) == 0) {
        $alter_sql = "ALTER TABLE users ADD COLUMN role ENUM('admin','mentor','student') NOT NULL DEFAULT 'student' AFTER password";
        if (!mysqli_query($conn, $alter_sql)) {
            error_log("Error adding role column: " . mysqli_error($conn));
        }
    }
}

/**
 * Execute a query and return the result
 * 
 * @param string $sql SQL query to execute
 * @param array $params Parameters to bind to the query
 * @return mixed Query result, true for successful non-SELECT queries, or false on error
 */
function db_query($sql, $params = []) {
    global $conn;
    
    // Make sure we're still connected to the database
    if (!mysqli_ping($conn)) {
        // Try to reconnect if connection was lost
        $GLOBALS['conn'] = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name']);
        if (!$GLOBALS['conn']) {
            error_log("Database connection lost and failed to reconnect");
            return false;
        }
        $conn = $GLOBALS['conn'];
    }
    
    // Make sure we're using the correct database
    mysqli_select_db($conn, $GLOBALS['db_name']);
    
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn) . " for query: " . $sql);
        return false;
    }
    
    if (!empty($params)) {
        // Create type string and references array for bind_param
        $types = '';
        $bind_params = [];
        
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_double($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b';
            }
            $bind_params[] = $param;
        }
        
        // Create array of references
        $bind_refs = [];
        $bind_refs[] = &$types;
        
        for ($i = 0; $i < count($bind_params); $i++) {
            $bind_refs[] = &$bind_params[$i];
        }
        
        // Call bind_param with dynamic arguments
        if (!call_user_func_array([$stmt, 'bind_param'], $bind_refs)) {
            error_log("Binding parameters failed: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return false;
        }
    }
    
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        return false;
    }
    
    // Special handling for INSERT, UPDATE, DELETE statements which don't return a result set
    // This is important for user registration and other write operations
    if (strpos(strtoupper(trim($sql)), "INSERT") === 0 || 
        strpos(strtoupper(trim($sql)), "UPDATE") === 0 || 
        strpos(strtoupper(trim($sql)), "DELETE") === 0) {
        mysqli_stmt_close($stmt);
        return true; // Operation successful
    }
    
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result === false && mysqli_stmt_errno($stmt) != 0) {
        error_log("Getting result set failed: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
    return false;
    }
    
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * Get a single record from the database
 * 
 * @param string $sql SQL query to execute
 * @param array $params Parameters to bind to the query
 * @return array|null Single record or null if not found
 */
function db_get_row($sql, $params = []) {
    $result = db_query($sql, $params);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    
    return null;
}

/**
 * Get multiple records from the database
 * 
 * @param string $sql SQL query to execute
 * @param array $params Parameters to bind to the query
 * @return array Array of records
 */
function db_get_rows($sql, $params = []) {
    $result = db_query($sql, $params);
    $rows = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    
    return $rows;
}

/**
 * Insert a record into the database
 * 
 * @param string $table Table name
 * @param array $data Associative array of column => value
 * @return int|bool Last insert ID or false on error
 */
function db_insert($table, $data) {
    global $conn;
    
    $columns = array_keys($data);
    $values = array_values($data);
    $placeholders = array_fill(0, count($values), '?');
    
    $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
    
    // Execute the query - note: for INSERT statements, db_query returns true on success, not a result set
    $result = db_query($sql, $values);
    
    if ($result === true) { // Query execution was successful
        // Return the ID of the newly inserted record
        return mysqli_insert_id($conn);
    }
    
    return false;
}

/**
 * Update a record in the database
 * 
 * @param string $table Table name
 * @param array $data Associative array of column => value
 * @param string $where Where clause
 * @param array $params Parameters for where clause
 * @return bool True on success, false on error
 */
function db_update($table, $data, $where, $params = []) {
    $set = [];
    $values = [];
    
    foreach ($data as $column => $value) {
        $set[] = "$column = ?";
        $values[] = $value;
    }
    
    $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $where";
    
    // Combine data values and where params
    $all_params = array_merge($values, $params);
    
    return db_query($sql, $all_params) !== false;
}

// Create an admin user if it doesn't exist
$check_admin = "SELECT * FROM users WHERE email = 'admin@gethelp.com'";
$result = mysqli_query($conn, $check_admin);

if ($result && mysqli_num_rows($result) == 0) {
    // Create admin user
    $admin_password = password_hash('Admin123', PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, phone, password, role) 
            VALUES ('Admin', 'admin@gethelp.com', '1234567890', '$admin_password', 'admin')";
    
    if (!mysqli_query($conn, $sql)) {
        // Not critical, so just continue
        error_log("Error creating admin user: " . mysqli_error($conn));
    }
}