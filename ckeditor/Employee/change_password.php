<?php
session_start();
include "./../include/config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$userid = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $verifyPassword = $_POST['verify_password'];

    $query = "SELECT password FROM employee WHERE id = $userid";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

       
        if ($currentPassword === $storedPassword) {
           
            $updateQuery = "UPDATE employee SET password = '$newPassword' WHERE id = $userid";
            if (mysqli_query($conn, $updateQuery)) {
                
                echo "<script>alert('Password Changed successfully !!');
                window.location.href = 'dashboard.php';</script>";
                exit;
            } else {
                $_SESSION['error'] = 'Failed,Try again.';
                header('location: dashboard.php');
            }
        } else {
            echo "<script>alert('Incorrect current password !!');
                window.location.href = 'dashboard.php';</script>";
        }
    } else {
        
        echo "User not found";
    }
}
?>
