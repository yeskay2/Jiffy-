<?php
session_start();
include "./../include/config.php";


if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$userid = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] . ' 00:00:00' : date('Y-m-d 00:00:00');
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] . ' 23:59:59' : date('Y-m-d 23:59:59');
        $employeeId = isset($_POST['selectmembers']) ? $_POST['selectmembers'] : $userid;
        $teamid  = !empty($_POST['selectteam']) ? $_POST['selectteam'] : null;

         if ($teamid !== null) {
            $sql = 'SELECT employee FROM team WHERE team_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $teamid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $employeeIds = [];
                while ($row = $result->fetch_assoc()) {
                    $employeeIds = array_merge($employeeIds, explode(',', $row['employee']));
                }               
                $employeeId = implode(',', array_map('intval', $employeeIds));
            }
        }

        $completedTasks = [];


        $sql = "SELECT 
                    tasks.id, 
                    tasks.start_time, 
                    tasks.end_time, 
                    tasks.Pause,
                    tasks.restart,
                    tasks.due_date,
                    tasks.task_name,
                    tasks.perferstart_time,
                    tasks.perferend_time,
                    tasks.Actual_start_time,
                    employee.full_name AS assigned_name, 
                    CASE 
                        WHEN tasks.projectid = 0 THEN 'Others' 
                        ELSE projects.project_name 
                    END AS project_name
                FROM 
                    tasks 
                JOIN 
                    employee ON tasks.assigned_to = employee.id 
                LEFT JOIN 
                    projects ON tasks.projectid = projects.id 
                WHERE 
                    tasks.assigned_to IN ($employeeId) 
                    AND tasks.end_time BETWEEN ? AND ? 
                    AND tasks.status = 'Completed' 
                ORDER BY 
                    tasks.id DESC";
                    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $task_id = $row["id"];
     $start_date = strtotime($row["start_time"]);
     $end_date = strtotime($row["end_time"]);
     $pause = strtotime($row["Pause"]);
     $restart = strtotime($row["restart"]);
     $due_date = strtotime($row["due_date"]);
     $per_start_time  = $row["perferstart_time"];
     $per_end_time  = $row["perferend_time"];
     $time_spent = $end_date - $start_date;
     if ($pause && $restart) {
         $time_spent -= ($restart - $pause);
     }
     $hours = floor($time_spent / 3600);
     $minutes = floor(($time_spent % 3600) / 60);
     $days = floor($time_spent / 86400);
     $employee_name = $row["assigned_name"];
     $project_name = $row["project_name"];
     $task_name = $row["task_name"];
     $end_date = date('d-m-Y', $end_date);
     $due_date = date('d-m-Y', $due_date);            
     $start_date2 = strtotime($row["Actual_start_time"]);
     $due_date2 = strtotime($row["due_date"]);
     $start_date3 = strtotime($row["start_time"]);
     $end_date2 = strtotime($end_date);
     $days_between = round(($due_date2 - $start_date2) / (60 * 60 * 24)) + 1;  
      $per_time = date('h:i A',strtotime($per_start_time)) . '-' . date('h:i A',strtotime($per_end_time));
     $per_start_timestamp = strtotime($per_start_time);
     $per_end_timestamp = strtotime($per_end_time);  

     $hours_between = floor(($per_end_timestamp - $per_start_timestamp) / (60 * 60));

     $minutes_between = round((($per_end_timestamp - $per_start_timestamp) % (60 * 60)) / 60);  

     $total_hours_assigned = round(($hours_between + $minutes_between / 60) * $days_between, 2);
     
     $timestamp1 = strtotime($row['start_time']);
     $timestamp2 = strtotime($row['end_time']);            
     $diffSeconds = abs($timestamp1 - $timestamp2);
     $days_between = floor($diffSeconds / (60 * 60 * 24)) + 1;
     $total_hours = $days_between .'/'.$total_hours_assigned;
     $class = ($end_date <= $due_date) ? "green" : "red";           
     $completedTasks[] = [
         'task_id' => $task_id,
         'due' => $per_time,
         'start_date' => date('d-m-Y', strtotime($row["Actual_start_time"])),
         'end_date' => date('d-m-Y', strtotime($row["due_date"])),
         'total_hours_spent' => $total_hours,
         'employee_name' => $employee_name,
         'project_name' => $project_name,
         'task_name' => $task_name,
         'class' => $class,
         'days_between' => $days_between,
         'team'   =>$teamid
     ];
         }       
        echo json_encode($completedTasks);
    } catch (Exception $e) {       
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {   
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
