<?php
// Try alternate port if default isn't working
$conn = mysqli_connect("127.0.0.1:3306", "root", "", "pms");
if (!$conn) {
    // Try socket connection
    $conn = mysqli_connect("localhost", "root", "", "pms", 3306);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
}

// Rest of your config file...
?>