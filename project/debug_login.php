<?php
// Simple login test file to debug issues
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./../include/config.php";

echo "<h3>Login Debug Test</h3>";

// Test database connection
if ($conn) {
    echo "✓ Database connection: OK<br>";
} else {
    echo "✗ Database connection: FAILED<br>";
    die("Connection error: " . mysqli_connect_error());
}

// Test if loginverify.php can be included
try {
    require_once("./loginverify.php");
    echo "✓ LoginVerify.php: Included successfully<br>";
} catch (Exception $e) {
    echo "✗ LoginVerify.php: Error - " . $e->getMessage() . "<br>";
}

// Test if UserAuthenticator class exists
if (class_exists('UserAuthenticator')) {
    echo "✓ UserAuthenticator class: Found<br>";
    
    // Test creating authenticator instance
    try {
        $authenticator = new UserAuthenticator($conn);
        echo "✓ UserAuthenticator instance: Created successfully<br>";
    } catch (Exception $e) {
        echo "✗ UserAuthenticator instance: Error - " . $e->getMessage() . "<br>";
    }
} else {
    echo "✗ UserAuthenticator class: NOT FOUND<br>";
}

// Test POST data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<h4>POST Data Received:</h4>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    if (!empty($_POST['logindata'])) {
        echo "<p><strong>Login attempt detected!</strong></p>";
        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';
        echo "Email: " . htmlspecialchars($email) . "<br>";
        echo "Password: " . (empty($password) ? 'Empty' : 'Provided') . "<br>";
        
        // Test authentication
        if (!empty($email) && !empty($password)) {
            echo "<p>Attempting authentication...</p>";
            try {
                if (isset($authenticator)) {
                    $authenticator->authenticateUser($email, $password);
                    echo "Authentication method called successfully<br>";
                } else {
                    echo "Authenticator not available<br>";
                }
            } catch (Exception $e) {
                echo "Authentication error: " . $e->getMessage() . "<br>";
            }
        }
    }
} else {
    echo "<p>No POST data received. Method: " . $_SERVER["REQUEST_METHOD"] . "</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Test</title>
</head>
<body>
    <h3>Test Login Form</h3>
    <form method="POST" action="">
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        <div>
            <input type="submit" name="logindata" value="Test Login">
        </div>
    </form>
</body>
</html>