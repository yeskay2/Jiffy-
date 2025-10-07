<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $selectedMonth = isset($_POST['selectMonth']) ? $_POST['selectMonth'] : date('m'); 

       $sql = "SELECT tasks.id, tasks.start_time, tasks.end_time, tasks.task_name, tasks.description, tasks.due_date, tasks.created_at,
        employee.full_name AS uploader_name, assigned.full_name AS assigned_name, projects.project_name
        FROM tasks 
        JOIN employee ON tasks.uploaderid = employee.id 
        JOIN employee AS assigned ON tasks.assigned_to = assigned.id
        JOIN projects ON tasks.projectid = projects.id 
        WHERE tasks.assigned_to = $userid 
        AND MONTH(tasks.due_date) = $selectedMonth 
        AND tasks.status = 'Completed' 
        ORDER BY tasks.created_at DESC"; 

        $result = $conn->query($sql);

        $completedTasks = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $task_id = $row["id"];
                $start_date = $row["start_time"];
                $end_date = $row["end_time"];
                

                $startTimestamp = strtotime($start_date);
                $endTimestamp = strtotime($end_date);
                $timeInSeconds = $endTimestamp - $startTimestamp;

                $hours = floor($timeInSeconds / 3600);
                $minutes = floor(($timeInSeconds % 3600) / 60);
                $days = floor($timeInSeconds / 86400);

                $employee_name = $row["assigned_name"];
                $project_name = $row["project_name"];
                $task_name = $row["task_name"];

               
                $formattedTime = null;

                if ($days > 0) {
                    $formattedTime = "$days days";
                } elseif ($hours > 0) {
                    $formattedTime = "$hours hours";
                } elseif ($minutes > 0) {
                    $formattedTime = "$minutes minutes";
                }
                $start_date = substr($start_date, 10, 6);
                $end_date = substr($end_date, 10, 6);

                

                $completedTasks[] = [
                    'task_id' => $task_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'time_spent' => $formattedTime,
                    'employee_name' => $employee_name,
                    'project_name' => $project_name,
                    'task_name' => $task_name,
                    
                ];
            }
        }

        echo json_encode($completedTasks);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>

