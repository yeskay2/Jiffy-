<?php
session_start();
include "./../include/config.php";

function calculateProgress($projectId) {
    global $conn;

    $query_completed = "SELECT COUNT(*) AS completed_count FROM tasks WHERE projectid = ? AND status = 'completed'";
    $stmt_completed = mysqli_prepare($conn, $query_completed);
    mysqli_stmt_bind_param($stmt_completed, "i", $projectId);
    mysqli_stmt_execute($stmt_completed);
    $result_completed = mysqli_stmt_get_result($stmt_completed);
    $row_completed = mysqli_fetch_assoc($result_completed);
    $completedCount = $row_completed['completed_count'];

    $query_total = "SELECT COUNT(*) AS total_count FROM tasks WHERE projectid = ?";
    $stmt_total = mysqli_prepare($conn, $query_total);
    mysqli_stmt_bind_param($stmt_total, "i", $projectId);
    mysqli_stmt_execute($stmt_total);
    $result_total = mysqli_stmt_get_result($stmt_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $totalCount = $row_total['total_count'];

    if ($totalCount === 0) {
        return 0;
    }

    $progress = ($completedCount / $totalCount) * 100;
    return $progress;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $taskId = $_POST['taskId'];
        $status = $_POST['status'];

        date_default_timezone_set('Asia/Kolkata'); 

        $currentTime = date('Y-m-d H:i:s'); 

        if ($status === 'InProgress') {
            $query = "UPDATE tasks SET status = ?, start_time = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $status, $currentTime, $taskId);
            mysqli_stmt_execute($stmt);
        } elseif ($status === 'Completed') {
            $query = "UPDATE tasks SET status = ?, end_time = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $status, $currentTime, $taskId);
            mysqli_stmt_execute($stmt);
        }elseif($status === 'Pause'){
            $query = "UPDATE tasks SET status = ?, Pause = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $status, $currentTime, $taskId);
            mysqli_stmt_execute($stmt);
        }elseif($status === 'Continue'){
            $start1 = 'InProgress';
            $query = "UPDATE tasks SET status = ?, restart = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $start1, $currentTime, $taskId);
            mysqli_stmt_execute($stmt);
        }elseif($status =='Approved'){
            $query = "UPDATE tasks SET  Approval = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $status,$taskId);
            mysqli_stmt_execute($stmt);
        }elseif($status =='Rejected'){
            $query = "UPDATE tasks SET  Approval = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "si", $status,$taskId);
            mysqli_stmt_execute($stmt);
        }
        

        
        $projectId = $_POST['projectId'];
        $progress = calculateProgress($projectId);

        $query = "UPDATE objectives SET progress = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "di", $progress, $projectId);
        mysqli_stmt_execute($stmt);

        echo json_encode(['success' => true, 'progress' => $progress]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
