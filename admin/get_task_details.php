<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include config file
include "./../include/config.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    exit(json_encode(["error" => "User not logged in"]));
}

$userid = $_SESSION["user_id"];
$today = date("d-m-Y");

// Notification Query
$notificationQuery = "SELECT 
                        tblleaves.id AS lid, 
                        employee.profile_picture, 
                        employee.full_name, 
                        tblleaves.posting_date, 
                        tblleaves.leave_type,
                        tblleaves.status, 
                        tblleavetype.LeaveType
                    FROM tblleaves 
                    INNER JOIN employee ON tblleaves.empid = employee.id
                    INNER JOIN tblleavetype ON tblleaves.leave_type = tblleavetype.id
                    WHERE is_read = 0 AND tblleaves.Company_id = ?";

$notificationStmt = mysqli_prepare($conn, $notificationQuery);
mysqli_stmt_bind_param($notificationStmt, "s", $companyId);
mysqli_stmt_execute($notificationStmt);
$result = mysqli_stmt_get_result($notificationStmt);

$notifications = array();
$notificationCount = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notificationCount++;
        $leaveId = $row['lid'];
        $name = $row['full_name'];
        $profilePicture = $row['profile_picture'];
        $postingDate = $row['posting_date'];
        $leaveType = $row['LeaveType'];
        $postingLimit = substr($postingDate, 0, 10);

        $notification = array(
            "image" => $profilePicture,
            "message" => "New leave request from $name",
            "date" => $postingLimit,
            "leaveId" => $leaveId,
            "taskName" => $leaveType
        );
        $notifications[] = $notification;
    }
}

// Attendance Query
$attendanceQuery = "SELECT 
                        a.*, 
                        employee.full_name, 
                        employee.status, 
                        employee.profile_picture
                    FROM attendance AS a 
                    INNER JOIN employee ON a.employee_id = employee.email
                    WHERE a.date = ? AND employee.status = 'Offline' AND employee.Company_id = ?";

$attendanceStmt = mysqli_prepare($conn, $attendanceQuery);
mysqli_stmt_bind_param($attendanceStmt, "ss", $today, $companyId);
mysqli_stmt_execute($attendanceStmt);
$attendanceResult = mysqli_stmt_get_result($attendanceStmt);

if (mysqli_num_rows($attendanceResult) > 0) {
    while ($row = mysqli_fetch_assoc($attendanceResult)) {
        $notificationCount++;
        $fullName = $row['full_name'];
        $profilePicture = $row['profile_picture'];

        $notification = array(
            "message" => "$fullName is currently offline. Please review their attendance.",
            "image" => $profilePicture,
            "date" => date("H:i A"),
            "taskName" => ''
        );

        $notifications[] = $notification;
    }
}

$response = array(
    "notifications" => $notifications,
    "count" => $notificationCount
);

echo json_encode($response);

// Close statements and connection
mysqli_stmt_close($notificationStmt);
mysqli_stmt_close($attendanceStmt);
mysqli_close($conn);
?>
