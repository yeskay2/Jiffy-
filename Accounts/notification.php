<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "./../include/config.php";

if (!isset($_SESSION["user_id"])) {
    exit(json_encode(["error" => "User not logged in"]));
}

$userid = $_SESSION["user_id"];

// Query to fetch notifications related to attendance with 'Pending' status
$attendanceQuery = "SELECT teamrequried.*, employee.full_name, employee.profile_picture 
                    FROM teamrequried 
                    JOIN employee ON teamrequried.TeamLead = employee.id
                    WHERE (teamrequried.to = ? OR teamrequried.forward = ?) AND teamrequried.status = ? AND teamrequried.type !='hiring'";
                    
$attendanceStmt = mysqli_prepare($conn, $attendanceQuery);

if ($attendanceStmt === false) {
    exit(json_encode(["error" => "Failed to prepare attendance statement"]));
}

// Bind parameters to the prepared statement
$status = 'Pending';
mysqli_stmt_bind_param($attendanceStmt, "iis", $userid, $userid, $status);

// Execute the prepared statement
mysqli_stmt_execute($attendanceStmt);

// Get result set from the executed statement
$attendanceResult = mysqli_stmt_get_result($attendanceStmt);

$notifications = [];
$notificationCount = 0;

if ($attendanceResult) {
    while ($row = mysqli_fetch_assoc($attendanceResult)) {
        $notificationCount++;
        $fullName = $row['full_name'];
        $profilePicture = $row['profile_picture'];

        $notification = [
            "message" => "$fullName sent a new request to you",
            "image" => $profilePicture,
            "date" => date("H:i A"),
            "taskName" => '' 
        ];

        $notifications[] = $notification;
    }
} else {
    exit(json_encode(["error" => "Failed to retrieve attendance notifications"]));
}

$response = [
    "notifications" => $notifications,
    "count" => $notificationCount
];

echo json_encode($response);

// Close statement and connection
mysqli_stmt_close($attendanceStmt);
mysqli_close($conn);
?>
