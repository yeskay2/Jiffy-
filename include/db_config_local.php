<?php
/**
 * Local Database Configuration for Jiffy HR System
 * Replace the remote database with local XAMPP MySQL
 */

// Database configuration for local development
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');          // XAMPP default username
define('DB_PASSWORD', '');              // XAMPP default password (empty)
define('DB_NAME', 'jiffy_local');       // Local database name

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create database connection
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Utility functions
if (!function_exists('sanitize_input')) {
    function sanitize_input($data) {
        return htmlspecialchars(trim($data));
    }
}

// Company ID from cookie (keeping original logic)
if (!empty($_COOKIE['Company_id'])) {
    $companyId = base64_decode($_COOKIE['Company_id']);
} else {
    $companyId = 0;
}
?>