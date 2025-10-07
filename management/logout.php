<?php
session_start();
include "./../include/config.php";
date_default_timezone_set('Asia/Kolkata');
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT email FROM employee WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $email = $row["email"];

        $date = date("d-m-Y");
        $lognow = date('H:i:s');
        $logout = date("Y:m:d H:i:s");
        $update_query = "UPDATE attendance SET time_out = '$logout' WHERE employee_id = '$email'";
        $update_result = mysqli_query($conn, $update_query);

        if (!$update_result) {
            echo "Error updating attendance: " . mysqli_error($conn);
        } else {
            $query = "SELECT 
                        TIMESTAMPDIFF(HOUR, time_in, time_out) AS hours_worked,
                        TIMESTAMPDIFF(MINUTE, time_in, time_out) AS minutes_worked
                      FROM attendance WHERE employee_id = '$email' AND date = '$date'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $hours_worked = $row["hours_worked"];
                $minutes_worked = $row["minutes_worked"];

                $total_hours_worked = $hours_worked;

                $update_query = "UPDATE attendance SET num_hr = '$total_hours_worked' WHERE employee_id = '$email' AND date = '$date'";
                $update_result = mysqli_query($conn, $update_query);

                if (!$update_result) {
                    echo "Error updating total hours worked: " . mysqli_error($conn);
                } else {
                    $statusOffline = "Offline";
                    $logoutQuery = "UPDATE `employee` SET status = '{$statusOffline}' WHERE id = '{$_SESSION["user_id"]}'";
                    $runLogoutQuery = mysqli_query($conn, $logoutQuery);
                    mysqli_close($conn);
                    session_unset();
                    session_destroy();
                    setcookie("user_id", "", time() - 3600, "/");
                    $message = "Hours worked today: $hours_worked hours and $minutes_worked minutes.";

                    echo '<script type="text/javascript">';
                    echo 'alert("' . $message . '");';
                    echo 'window.location.href = "index.php";'; 
                    echo '</script>';
                }
            } else {
                echo '<script type="text/javascript">';               
                echo 'window.location.href = "index.php";'; 
                echo '</script>';
            }
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "You are not logged in.";
}
?>
