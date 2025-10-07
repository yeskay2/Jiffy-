<?php
include "./../include/config.php";



$query = "SELECT t.*, e_assigned.full_name AS assigned_full_name, e_assigned.email AS assigned_email,
          e_uploader.full_name AS uploader_full_name
FROM tasks t
LEFT JOIN employee e_assigned ON t.assigned_to = e_assigned.id
LEFT JOIN employee e_uploader ON t.uploaderid = e_uploader.id
WHERE  status = 'Todo'
ORDER BY t.created_at DESC";

$result = mysqli_query($conn, $query);

$notifications = array();
$notificationCount = 0; 

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notificationCount++;

        $taskId = $row['id'];
        $taskName = $row['task_name'];
        $assignedFullName = $row['assigned_full_name'];
        $assignedEmail = $row['assigned_email'];
        $uploaderFullName = $row['uploader_full_name'];
        $description = $row['description'];
        $due_date   = $row['due_date'];

        $notifications[] = array(
            'taskId' => $taskId,
            'taskName' => $taskName,
            'assignedFullName' => $assignedFullName,
            'assignedEmail' => $assignedEmail,
            'uploaderFullName' => $uploaderFullName,
            'description' => $description,
            'due_Date' => $due_date
        );
    }
}

$response = array(
    'success' => true,
    'count' => $notificationCount,
    'notifications' => $notifications
);

header('Content-Type: application/json');
echo json_encode($response);
?>
