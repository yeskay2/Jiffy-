<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = mysqli_connect("localhost", "root", "", "pms");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($data) {
        return htmlspecialchars(trim($data));
    }
}
if (!empty($_COOKIE['Company_id'])) {
    $companyId = base64_decode($_COOKIE['Company_id']);
}else{
    $companyId = 0;
}
?>
