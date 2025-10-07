<?php
session_start();
include "./../include/config.php";
date_default_timezone_set('Asia/Kolkata');

$hours_worked = 0;
$minutes_worked = 0;
$date = date("d-m-Y");
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$user_id = $_SESSION['user_id'];

$query = "SELECT email FROM employee WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) === 1)
     {
        $row = mysqli_fetch_assoc($result);
        $email = $row["email"];
    }
if (isset($_GET["userid"])) {
    $user_id = $_GET["userid"];        
    $logout = date('H:i');
    $email = mysqli_real_escape_string($conn, $email);
    $date = date("d-m-Y");

     $sql = "SELECT * FROM `attendance` WHERE employee_id = '$email' AND date = '$date'";
     $result = mysqli_query($conn, $sql);

     if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $logintime = $row['time_in'];
        $logouttime = $logout;
        $logout = date("Y:m:d H:i:s");
        $login_timestamp = strtotime($logintime);
        $logout_timestamp = strtotime($logouttime);
        $seconds_worked = $logout_timestamp - $login_timestamp;
        $hours_worked = floor($seconds_worked / 3600);
        $minutes_worked = floor(($seconds_worked % 3600) / 60);
        $total_hours_worked = $hours_worked .'.'.$minutes_worked ;

        $update_total_query = "UPDATE attendance SET num_hr = '$total_hours_worked',time_out = '$logout' WHERE employee_id = '$email' AND date = '$date'";
        $update_total_result = mysqli_query($conn, $update_total_query);

        $statusOffline = "Offline";
        $logoutQuery = "UPDATE `employee` SET status = '$statusOffline' WHERE id = '$user_id'";
        $runLogoutQuery = mysqli_query($conn, $logoutQuery);

        session_unset();
        session_destroy();

        setcookie("user_id", "", time() - 3600, "/");

        header("Location:./index.php");
        exit;
    } else {
        echo "Attendance record not found for today.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">
    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <link rel="stylesheet" href="./chat/chat.css"
</head>

<body>
<?php
    $logout = date('H:i');

    $email = mysqli_real_escape_string($conn, $email);
    $date = date("d-m-Y");

     $sql = "SELECT * FROM `attendance` WHERE employee_id = '$email' AND date = '$date'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $logintime = $row['time_in'];
        $logouttime = $logout;

        $login_timestamp = strtotime($logintime);
        $logout_timestamp = strtotime($logouttime);
        $seconds_worked = $logout_timestamp - $login_timestamp;
        $hours_worked = floor($seconds_worked / 3600);
        $minutes_worked = floor(($seconds_worked % 3600) / 60);
    }
?>

<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Logout</h5>          
        </div>
        <div class="modal-body text-center">
            <h5 class="mb-2">Today's Working Hours</h5>
            <h6><b>
                <?php 
                    if (isset($hours_worked) && isset($minutes_worked)) {
                        echo "{$hours_worked} hours and {$minutes_worked} minutes";
                    } else {
                        echo "No attendance data found.";
                    }
                ?>
            </b></h6>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-yes" data-dismiss="modal" onclick="cancel()">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="confirmLogout()">Ok</button>
        </div>
    </div>
</div>


    <script>
        function confirmLogout() {
            window.location.href = 'logout.php?userid=<?php echo $_SESSION['user_id']; ?>';
        }
        function cancel() {
            window.location.href = 'dashboard.php';
        }
    </script>
</body>

</html>
