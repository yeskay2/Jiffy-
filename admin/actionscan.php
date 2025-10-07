<?php
session_start();
include "./../include/config.php";
date_default_timezone_set("Asia/Kolkata");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["data"])) {
    $email = $_POST["data"];
    $date = date("Y-m-d H:i:s");
    $login_date = date("d-m-Y");

    $sql_employee = "SELECT full_name, empid FROM employee WHERE email = ?";
    $stmt_employee = mysqli_prepare($conn, $sql_employee);
    mysqli_stmt_bind_param($stmt_employee, "s", $email);
    mysqli_stmt_execute($stmt_employee);
    $result_employee = mysqli_stmt_get_result($stmt_employee);

    if ($result_employee && mysqli_num_rows($result_employee) > 0) {
        $row_employee = mysqli_fetch_assoc($result_employee);
        $name = $row_employee['full_name'];
        $employeeId = $row_employee['empid'];

        $sql_check_login = "SELECT id FROM attendance WHERE employee_id = ? AND date = ?";
        $stmt_check_login = mysqli_prepare($conn, $sql_check_login);
        mysqli_stmt_bind_param($stmt_check_login, "ss", $email, $login_date);
        mysqli_stmt_execute($stmt_check_login);
        $result_check_login = mysqli_stmt_get_result($stmt_check_login);

        if (mysqli_num_rows($result_check_login) > 0) {
            $sql_check_logout = "SELECT id FROM attendance WHERE employee_id = ? AND date = ? AND status = '0'";
            $stmt_check_logout = mysqli_prepare($conn, $sql_check_logout);
            mysqli_stmt_bind_param($stmt_check_logout, "ss", $email, $login_date);
            mysqli_stmt_execute($stmt_check_logout);
            $result_check_logout = mysqli_stmt_get_result($stmt_check_logout);

            if (mysqli_num_rows($result_check_logout) > 0) {
                $goodbyeMessage = "Goodbye, $name! You have already logged out for today. Have a great day!";
                echo $goodbyeMessage;
            } else {
                $logout = date('H:i');
                $sql = "SELECT * FROM `attendance` WHERE employee_id = ? AND date = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $email, $login_date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    $logintime = $row['time_in'];
                    $logouttime = $logout;
                    $logout = date("Y-m-d H:i:s");
                    $login_timestamp = strtotime($logintime);
                    $logout_timestamp = strtotime($logouttime);
                    $seconds_worked = $logout_timestamp - $login_timestamp;
                    $hours_worked = floor($seconds_worked / 3600);
                    $minutes_worked = floor(($seconds_worked % 3600) / 60);
                    $total_hours_worked = $hours_worked . '.' . $minutes_worked;
                    $sql_update_logout = "UPDATE attendance SET time_out = ?, num_hr = $total_hours_worked, status = 0 WHERE employee_id = ? AND time_out IS NULL";
                    $stmt_update_logout = mysqli_prepare($conn, $sql_update_logout);
                    mysqli_stmt_bind_param($stmt_update_logout, "ss", $logout, $email);
                    mysqli_stmt_execute($stmt_update_logout);
                    $goodbyeMessage = "Goodbye, $name! Have a great day! Your total working hours today: $total_hours_worked hours.";
                    echo $goodbyeMessage;
                }
            }
        } else {
            $timeIn = date("H:i:s");
            $status = "1";
            $formattedTime = date("H:i");
            $sql = "SELECT time_in FROM schedules WHERE Company_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $companyId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $intime = $row['time_in'];
                if ($formattedTime < $intime) {
                    $send = 0;
                } else {
                    $send = 3;
                }
                $timeIn = date("H:i:s");
                $sql_insert_login = "INSERT INTO `attendance`(`employee_id`, `date`, `time_in`, `status`, `Company_id`,`send`) VALUES (?, ?, ?, ?, ?,?)";
                $stmt_insert_login = mysqli_prepare($conn, $sql_insert_login);
                $status = '1'; // Assuming '1' is for 'Logged In'
                mysqli_stmt_bind_param($stmt_insert_login, "sssssi", $email, $login_date, $timeIn, $status, $companyId, $send);
                mysqli_stmt_execute($stmt_insert_login);

                $welcomeMessage = "Welcome, $name!-$employeeId  Have a great day!";
                echo $welcomeMessage;
            }
        }
    } else {
        echo "No employee found for the provided email.";
    }
} else {
    http_response_code(400);
    echo "Error: Data not received via POST.";
}
?>
