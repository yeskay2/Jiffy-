<?php
session_start();
include "./../include/config.php";

// Set default timezone to Indian Standard Time
date_default_timezone_set('Asia/Kolkata');

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$userid = $_SESSION["user_id"];

$query = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_assigned.profile_picture AS 
    assigned_profile_picture, e_uploader.full_name AS uploader_full_name, e_uploader.profile_picture AS uploader_profile_picture
FROM tasks t 
LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
WHERE (t.assigned_to = ? AND t.uploaderid != t.assigned_to) 
ORDER BY t.created_at DESC";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $userid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $notifications = array();
    $notificationCount = 0;

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $taskId = $row['id'];
            $uploaderProfilePicture = $row['uploader_profile_picture'];
            $assignedProfilePicture = $row['assigned_profile_picture'];
            $taskName = $row['task_name'];
            $dueDate = $row['due_date'];
            $status = $row['status'];
            $dec = $row['description'];
            $limitedDec = date("d F Y", strtotime(substr($dueDate, 0, 10)));
            $createdDate = date("d F Y", strtotime(substr($row['created_at'], 0, 10)));
            $uploaderFullName = $row['uploader_full_name'];
            $assignedBy = "$uploaderFullName";
            $ring = $row['ring'];
            $Actual_start_time = date("Y-m-d H:i", strtotime($row['Actual_start_time']));
            $today = date("Y-m-d H:i");

            // Reset $message for each task
            $message = "";

            if ($status == 'Todo' || ($limitedDec == date("d F Y") && $limitedDec != $createdDate && in_array($status, ['Todo', 'InProgress'])) || ($status == 'Todo' && $Actual_start_time <= $today)) {
                $notificationCount++;
                if ($limitedDec == date("d F Y") && $limitedDec != $createdDate) {
                    $message .= "⚠️ <span class='text-danger' style='font-size:12px;'>Due today</span>";
                } elseif ($status == 'Todo' && $Actual_start_time <= $today) {
                    $message .= "⚠️ <span class='text-danger' style='font-size:12px;'>Need to initiate this task</span>";
                }

                $notifications[] = array(
                    'taskName' => $taskName,
                    'image' => $uploaderProfilePicture,
                    'date' => $limitedDec,
                    'message' => $message, // Append the message here
                    'uploader' => $assignedBy,
                    'dec' => $limitedDec,
                    'taskId' => $taskId,
                    'ring' => $ring
                );
            }
        }
    }

    $response = array(
        'count' => $notificationCount,
        'notifications' => $notifications
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo "Error in prepared statement: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
