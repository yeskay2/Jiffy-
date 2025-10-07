<?php
include "./../include/config.php";

$userid = $_GET['userid'];

$query = "SELECT COUNT(*) as total_project FROM tasks WHERE status = 'Todo' AND assigned_to = '$userid'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalprojects = $row['total_project'];
} else {
    $totalprojects = 0;
}
$query = "SELECT COUNT(*) as total_projects FROM tasks WHERE status = 'InProgress' AND assigned_to = '$userid' ";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalinprogress = $row['total_projects'];
} else {
    $totalinprogress = 0;
}

$query = "SELECT COUNT(*) as total_project FROM tasks WHERE  status = 'Completed' AND assigned_to = '$userid'  ";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalcompleted = $row['total_project'];
} else {
    $totalcompleted = 0;
}


$response = array(
    'newTasks' => $totalprojects,
    'newTask' => $totalprojects,
    'inProgressTasks' => $totalinprogress,
    'completedTasks' => $totalcompleted
);

echo json_encode($response);
