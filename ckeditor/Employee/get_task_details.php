<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];

$query = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_assigned.profile_picture AS assigned_profile_picture, e_uploader.full_name AS uploader_full_name, e_uploader.profile_picture AS uploader_profile_picture
FROM tasks t LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
WHERE (t.assigned_to = $userid AND t.status = 'Todo') 
ORDER BY t.created_at DESC";

$result = mysqli_query($conn, $query);

$notifications = array();
$notificationCount = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notificationCount++;

        $taskId = $row['id'];
        $uploaderProfilePicture = $row['uploader_profile_picture'];
        $assigned_profile_picture = $row['assigned_profile_picture'];
        $taskName = $row['task_name'];
        $dueDate = $row['due_date'];
        $status = $row['status'];
        $dec = $row['description'];
        $limitedDec = date("d F Y", strtotime(substr($dueDate, 0, 10))); 
       
        

        if ($status == 'Todo') {
            
            $uploaderFullName = $row['uploader_full_name'];
            
            $notifications[] = array(
                'taskName' => $taskName,
                'image' => $uploaderProfilePicture,
                'date' => $limitedDec,
                'message' => "$uploaderFullName",
                'dec' =>  $limitedDec,
                'taskId' =>  $taskId
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
?>


