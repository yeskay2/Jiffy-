<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];

$query = "SELECT tblleaves.id as lid, employee.profile_picture, employee.full_name, tblleaves.posting_date, employee.id, tblleaves.leave_type,
    tblleaves.posting_date, tblleaves.status, tblleavetype.LeaveType
    FROM tblleaves 
    JOIN employee ON tblleaves.empid = employee.id
    JOIN tblleavetype ON tblleaves.leave_type = tblleavetype.id
    WHERE is_read = 0;";
$result = mysqli_query($conn, $query);
$notifications = array();
$notificationCount = 0;

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notificationCount++;
        $leave = $row['lid'];
        $name = $row['full_name'];
        $uploaderProfilePicture = $row['profile_picture'];
        $posting_date = $row['posting_date'];
        $leavetype =$row['LeaveType'];
        $postinglmt = substr($posting_date, 0, 10);

        
        $notification = array(
            "image" => $uploaderProfilePicture,
            "message" => "New leave request from $name",
            "date" => $postinglmt, 
            "leaveId" => $leave ,
            "taskName"=> $leavetype
               );
        $notifications[] = $notification;
    }
}
$response = array(
    "notifications" => $notifications,
    "count" => $notificationCount
);


echo json_encode($response);
?>
