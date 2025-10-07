<?php
session_start();
include "./../include/config.php";
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT email FROM employee WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $email = $row["email"];
        
        $currentDate = date('Y-m-d'); 
        
        $update_query = "UPDATE attendance SET time_out = NOW() WHERE employee_id = '$email'";
        $update_result = mysqli_query($conn, $update_query);
        if (!$update_result) {
            echo "Error updating attendance: " . mysqli_error($conn);
        } else {
            $query = "SELECT 
                        TIMESTAMPDIFF(HOUR, time_in, time_out) AS hours_worked,
                        TIMESTAMPDIFF(MINUTE, time_in, time_out) AS minutes_worked
                      FROM attendance WHERE employee_id = '$email' AND DATE(date) = '$currentDate'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $hours_worked = $row["hours_worked"];
                $minutes_worked = $row["minutes_worked"];

                $total_hours_worked = $hours_worked;

                $update_query = "UPDATE attendance SET num_hr = 34 WHERE employee_id = '$email' AND date = '$currentDate'";
                $update_result = mysqli_query($conn, $update_query);

                if (!$update_result) {
                    echo "Error updating total hours worked: " . mysqli_error($conn);
                } else {
                    mysqli_close($conn);

                    $message = "Hours worked today: $hours_worked hours and $minutes_worked minutes.";

                    unset($_SESSION["user_id"]);

                    echo '<script type="text/javascript">';
                    echo 'alert("' . $message . '");';
                    echo 'window.location.href = "index.php";'; 
                    echo '</script>';
                }
            } else {
                echo "Error calculating hours worked: " . mysqli_error($conn);
            }
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "You are not logged in.";
}
?>
