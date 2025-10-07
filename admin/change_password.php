<?php
session_start();
include "./../include/config.php";

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; 
}

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

      
        $currentPasswordHash = md5($currentPassword);

        if ($currentPasswordHash === $storedPassword) {
           
            // Hash the new password before updating it
            $newPasswordHash = md5($newPassword);
            $updateQuery = "UPDATE employee SET password = '$newPasswordHash' WHERE id = $userid";
            if (mysqli_query($conn, $updateQuery)) {
                
                echo "<script>alert('Password Changed successfully !!');
                window.location.href = 'dashboard.php';</script>";
                exit;
            } else {
                $_SESSION['error'] = 'Failed, Try again.';
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

